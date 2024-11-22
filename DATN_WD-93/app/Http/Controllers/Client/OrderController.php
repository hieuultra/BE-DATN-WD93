<?php

namespace App\Http\Controllers\Client;

use App\Models\Bill;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use App\Mail\OrderConfirm;
use Illuminate\Http\Request;
use App\Models\VariantProduct;
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
            $shipping = 40000;
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
                    return redirect()->route('cart.listCart')->with('error', 'Giỏ hàng của bạn trống');
                }

                foreach ($carts->items as $item) {
                    // Kiểm tra số lượng tồn kho của sản phẩm biến thể
                    $productVariant = VariantProduct::findOrFail($item->variant_id);
                    if ($productVariant->quantity < $item['quantity']) {
                        DB::rollBack();
                        return redirect()->route('cart.listCart')->with('error', 'Không đủ số lượng tồn kho cho ' .  $productVariant->product->name);
                    }
                    // Tạo chi tiết đơn hàng
                    $tt = $item['price'] * $item['quantity'];
                    $bill->order_detail()->create([
                        'bill_id' => $billId,
                        'product_id' => $productVariant->id_product, // Liên kết tới sản phẩm chính
                        'variant_id' => $productVariant->id,         // Liên kết tới sản phẩm biến thể
                        'unitPrice' => $item['price'],
                        'quantity' => $item['quantity'],
                        'totalMoney' => $tt
                    ]);
                    // Giảm số lượng sản phẩm biến thể trong kho
                    $productVariant->quantity -= $item['quantity'];
                    $productVariant->save();
                }
                DB::commit();

                //khi add thanh cong se thuc hien cac cv ben duoi
                //tru di so luong cua san pham khi add thanh cong

                //gui mail khi dat hang tc
                Mail::to($bill->emailUser)->queue(new OrderConfirm($bill));

                $carts->items()->delete();
                return redirect()->route('orders.index')->with('success', 'Tạo đơn hàng thành công');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('cart.listCart')->with('error', 'Tạo đơn hàng thất bại');
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
                    $productVariant = VariantProduct::findOrFail($orderDetail->variant_id); // Truy vấn sản phẩm biến thể
                    $productVariant->quantity += $orderDetail->quantity; // Hoàn lại số lượng
                    $productVariant->save();
                }
            } elseif ($request->has('da_giao_hang')) {
                $bill->update(['status_bill' => Bill::DA_GIAO_HANG]);

                // Cập nhật trạng thái thanh toán thành ĐÃ THANH TOÁN nếu đã giao hàng
                $bill->update(['status_payment_method' => Bill::DA_THANH_TOAN]);
            }
            //Sử dụng DB::commit() để xác nhận thay đổi nếu mọi thứ thành công.
            //Nếu có lỗi, sử dụng DB::rollBack() để hoàn tác tất cả các thay đổi.
            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Hủy đơn hàng thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('orders.index')->with('error', 'Cập nhập đơn hàng thất bại');
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
