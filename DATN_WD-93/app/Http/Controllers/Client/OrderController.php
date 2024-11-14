<?php

namespace App\Http\Controllers\Client;

use App\Models\Bill;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use App\Mail\OrderConfirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $status = null)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $Bills = Auth::user()->bill()->orderBy('created_at', 'desc')->get(); // Lấy tất cả các đơn hàng

        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }

        $statusBill = Bill::status_bill;
        $type_cho_xac_nhan = Bill::CHO_XAC_NHAN;
        $type_dang_van_chuyen = Bill::DANG_VAN_CHUYEN;
        $type_da_giao_hang = Bill::DA_GIAO_HANG;
        $type_da_huy = Bill::DA_HUY;
        $type_khach_hang_tu_choi = Bill::KHACH_HANG_TU_CHOI;

        // Lấy trạng thái từ tham số URL (nếu có)
        $status = $status ?? $request->get('status');

        // Tìm kiếm theo mã đơn hàng hoặc tên sản phẩm
        $searchTerm = $request->get('search');

        // Lọc đơn hàng theo trạng thái và tìm kiếm (nếu có)
        $billsQuery = Auth::user()->bill()->orderBy('created_at', 'desc');

        // Lọc theo trạng thái bill nếu có
        if ($status) {
            $billsQuery->where('status_bill', $status);
        }

        // Nếu có từ khóa tìm kiếm, lọc theo mã đơn hàng hoặc tên sản phẩm
        if ($searchTerm) {
            $billsQuery->where(function ($query) use ($searchTerm) {
                $query->where('billCode', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('order_detail', function ($query) use ($searchTerm) {
                        $query->whereHas('product', function ($query) use ($searchTerm) {
                            $query->where('name', 'like', '%' . $searchTerm . '%');
                        });
                    });
            });
        }

        // Lấy kết quả tìm kiếm và trạng thái
        $bills = $billsQuery->get();

        $allStatusBill = Bill::status_bill;

        return view('client.orders.index', compact(
            'orderCount',
            'categories',
            'Bills',
            'statusBill',
            'type_cho_xac_nhan',
            'type_dang_van_chuyen',
            'allStatusBill',
            'bills',
            'type_da_giao_hang',
            'type_da_huy',
            'type_khach_hang_tu_choi'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        $carts = Cart::where('user_id', Auth::id())->with("items.product", "items.variant")->first();
        if ($carts && $carts->items->count() > 0) {
            $total = 0;
            $subTotal = 0;
            $shipping = 50;
            foreach ($carts->items as  $item) {
                $price = is_numeric($item['price']) ? $item['price'] : 0;
                $quantity = is_numeric($item['quantity']) ? $item['quantity'] : 0;
                // Kiểm tra nếu các khóa cần thiết tồn tại trong mục giỏ hàng
                // Tính toán tổng phụ
                $subTotal += $price * $quantity;
            }
            $total = $subTotal + $shipping;
            return view('client.orders.create', compact('orderCount', 'categories', 'carts', 'total', 'shipping', 'subTotal'));
        }
        return redirect()->route('cart.listCart');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        if ($request->isMethod('POST')) {
            DB::beginTransaction(); //bat dau thao tac vs csdl
            try {
                // Lấy dữ liệu từ request
                $params = $request->except('_token');
                $params['billCode'] = $this->generateUniqueOrderCode();
                $bill = Bill::query()->create($params);
                $billId = $bill->id;

                // $carts = session()->get('cart', []);
                // Lấy cart của người dùng từ database
                $carts = Cart::where('user_id', Auth::id())->with('items')->first();
                if (!$carts || $carts->items->isEmpty()) {
                    return redirect()->route('cart.listCart')->with('error', 'Your cart is empty');
                }

                foreach ($carts->items as $item) {
                    // Kiểm tra số lượng tồn kho trước khi tạo đơn hàng
                    $product = Product::findOrFail($item->product_id);
                    if ($product->quantity < $item['quantity']) {
                        DB::rollBack();
                        return redirect()->route('cart.listCart')->with('error', 'Not enough stock for product ' . $product->name);
                    }
                    // Tạo chi tiết đơn hàng
                    $tt = $item['price'] * $item['quantity'];
                    $bill->order_detail()->create([
                        'bill_id' => $billId,
                        'product_id' => $item->product_id,
                        'unitPrice' => $item['price'],
                        'quantity' => $item['quantity'],
                        'totalMoney' => $tt
                    ]);
                    // Giảm số lượng sản phẩm trong kho
                    $product->quantity -= $item['quantity'];
                    $product->save();
                }
                DB::commit();

                //khi add thanh cong se thuc hien cac cv ben duoi
                //tru di so luong cua san pham khi add thanh cong

                //gui mail khi dat hang tc
                Mail::to($bill->emailUser)->queue(new OrderConfirm($bill));

                $carts->items()->delete();
                return redirect()->route('orders.index')->with('success', 'Bill have created successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('cart.listCart')->with('error', 'Order failed');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        $bill = Bill::query()->findOrFail($id);
        $statusBill = Bill::status_bill;
        $status_payment_method = Bill::status_payment_method;
        $type_da_giao_hang = Bill::DA_GIAO_HANG;
        return view('client.orders.show', compact('orderCount', 'bill', 'statusBill', 'status_payment_method', 'categories', 'type_da_giao_hang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bill = Bill::query()->findOrFail($id);
        DB::beginTransaction();

        try {
            if ($request->has('da_huy')) {
                $bill->update(['status_bill' => Bill::DA_HUY]);
                // Hoàn lại số lượng sản phẩm về kho
                foreach ($bill->order_detail as $orderDetail) {
                    $product = Product::findOrFail($orderDetail->product_id);
                    $product->quantity += $orderDetail->quantity;
                    $product->save();
                }
            } elseif ($request->has('da_giao_hang')) {
                $bill->update(['status_bill' => Bill::DA_GIAO_HANG]);

                // Cập nhật trạng thái thanh toán thành ĐÃ THANH TOÁN nếu đã giao hàng
                $bill->update(['status_payment_method' => Bill::DA_THANH_TOAN]);
            }
            //Sử dụng DB::commit() để xác nhận thay đổi nếu mọi thứ thành công.
            //Nếu có lỗi, sử dụng DB::rollBack() để hoàn tác tất cả các thay đổi.
            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Bill updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('orders.index')->with('error', 'Bill update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    function generateUniqueOrderCode()
    {
        do {
            $orderCode = 'ORD-' . Auth::id() . '-' . now()->timestamp;
        } while (Bill::where('billCode', $orderCode)->exists());
        return $orderCode;  //tra ve unique code cho don hang
    }
    public function reorder($id)
    {
        // Tìm đơn hàng theo ID
        $order = Bill::findOrFail($id);

        // Kiểm tra nếu trạng thái đơn hàng là 'Đã giao hàng' hoặc 'Đã hủy'
        if ($order->status_bill == Bill::DA_GIAO_HANG || $order->status_bill == Bill::DA_HUY || $order->status_bill == Bill::KHACH_HANG_TU_CHOI) {
            // Lặp qua tất cả sản phẩm trong đơn hàng
            foreach ($order->products as $product) {
                // Thêm từng sản phẩm vào giỏ hàng của người dùng
                CartItem::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'product_id' => $product->id
                    ],
                    [
                        'quantity' => DB::raw('quantity + ' . $product->pivot->quantity)
                    ]
                );
            }

            // Thông báo thành công
            return redirect()->route('cart.index')->with('success', 'Đã thêm các sản phẩm vào giỏ hàng.');
        } else {
            return redirect()->back()->with('error', 'Không thể mua lại đơn hàng này.');
        }
    }
}
