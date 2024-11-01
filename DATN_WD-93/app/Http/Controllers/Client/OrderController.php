<?php

namespace App\Http\Controllers\Client;

use App\Models\Bill;
use App\Models\Product;
use App\Models\Category;
use App\Mail\OrderConfirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $Bills = Auth::user()->bill()->orderBy('created_at', 'desc')->get();  //tro den class bill ben model user
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }

        $statusBill = Bill::status_bill;

        $type_cho_xac_nhan = Bill::CHO_XAC_NHAN;
        $type_dang_van_chuyen = Bill::DANG_VAN_CHUYEN;

        return view('client.orders.index', compact('orderCount', 'categories', 'Bills', 'statusBill', 'type_cho_xac_nhan', 'type_dang_van_chuyen'));
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
        // if (!empty($carts->items->count() > 0)) {
        //     $total = 0;
        //     $subtotal = 0;
        //     foreach ($carts as $item) {
        //         $subtotal += $item['quantity'] * $item['price'];
        //     }
        //     $shipping = 50;
        //     $total = $subtotal + $shipping;
        //     return view('client.orders.create', compact('orderCount', 'categories', 'carts', 'total', 'shipping', 'subtotal'));
        // }
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

                $carts = session()->get('cart', []);

                foreach ($carts as $key => $item) {
                    // Kiểm tra số lượng tồn kho trước khi tạo đơn hàng
                    $product = Product::findOrFail($key);
                    if ($product->quantity < $item['quantity']) {
                        DB::rollBack();
                        return redirect()->route('cart.listCart')->with('error', 'Not enough stock for product ' . $product->name);
                    }
                    // Tạo chi tiết đơn hàng
                    $tt = $item['price'] * $item['quantity'];
                    $bill->order_detail()->create([
                        'bill_id' => $billId,
                        'product_id' => $key,
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

                session()->put('cart', []);
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
        return view('client.orders.show', compact('orderCount', 'bill', 'statusBill', 'status_payment_method', 'categories'));
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
}
