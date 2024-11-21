<?php

namespace App\Http\Controllers\Client;

use Log;
use App\Models\Bill;
use App\Models\Cart;
use App\Models\Review;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\VariantPackage;
use App\Models\VariantProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function index()
    {
        $newProducts = Product::newProducts(4)->withCount('review')->withAvg('review', 'rating')->get();
        $newProducts1 = Product::limit(4)->withCount('review')->withAvg('review', 'rating')->get();
        $bestsellerProducts = Product::bestsellerProducts(6)->withCount('review')->withAvg('review', 'rating')->get();
        $instockProducts = Product::instockProducts(8)->withCount('review')->withAvg('review', 'rating')->get();

        $mostViewedProducts = Product::orderBy('view', 'desc')->take(8)->withCount('review')->withAvg('review', 'rating')->get();
        $highestDiscountProducts = Product::orderBy('discount', 'desc')->take(8)->withCount('review')->withAvg('review', 'rating')->get();
        // Kết hợp danh mục và số lượng sản phẩm
        $categories = Category::withCount('products')->orderBy('name', 'asc')->get();

        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }

        return view('client.home.home', compact('orderCount', 'categories', 'newProducts', 'newProducts1', 'bestsellerProducts', 'instockProducts', 'mostViewedProducts', 'highestDiscountProducts'));
    }
    function products(Request $request)
    {
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        $kyw = $request->input('query');
        $category_id = $request->input('category_id');

        $categories = Category::orderBy('name', 'ASC')->get();
        if ($request->category_id) {
            $products = Product::where('category_id', $request->category_id)
                ->withCount('review') // Đếm số lượt đánh giá
                ->withAvg('review', 'rating') // Tính trung bình số sao
                ->orderBy('id', 'desc')
                ->paginate(12);
        } else {
            $products = Product::withCount('review') // Đếm số lượt đánh giá
                ->withAvg('review', 'rating') // Tính trung bình số sao
                ->orderBy('id', 'desc')
                ->paginate(12);
            //phan trang 9sp/1page
        }
        return view('client.home.products', compact('orderCount', 'categories', 'products', 'kyw', 'category_id'));
    }
    function detail(Request $request, $productId) //truyen id o route vao phai co request
    {
        if ($request->product_id) {
            // Lấy sản phẩm
            $sp = Product::where('id', $request->product_id)
                ->withAvg('review', 'rating')  // Lấy trung bình số sao
                ->withCount('review')          // Đếm số lượt đánh giá
                ->first();  // Dùng first() để lấy một sản phẩm duy nhất

            if (!$sp) {
                return redirect()->route('products')->with('error', 'Sản phẩm không tồn tại.');
            }
            // Tính tổng số lượng đã bán
            $soldQuantity = $sp->orderDetail()->sum('quantity'); // Lấy tổng số lượng từ bảng order_details

            // Lấy sản phẩm liên quan
            $splq = Product::where('category_id', $sp->category_id)
                ->where('id', '<>', $sp->id)
                ->withAvg('review', 'rating') // Lấy trung bình số sao
                ->withCount('review')         // Đếm số lượt đánh giá
                ->get();

            $sp->view += 1; // tăng lượt xem sản phẩm
            $sp->save(); // lưu lại số lượt xem sản phẩm

            $categories = Category::orderBy('name', 'asc')->get();

            // Kiểm tra số lượng đơn hàng của người dùng nếu đã đăng nhập
            $orderCount = 0;
            $billId = null; // Khởi tạo billId với giá trị mặc định null
            $canReview = false; // Mặc định là không thể đánh giá
            if (Auth::check()) {
                $user = Auth::user();
                $orderCount = $user->bill()->count();

                // Lấy tất cả các đơn hàng của người dùng đã mua sản phẩm này với trạng thái "ĐÃ GIAO HÀNG"
                $bills = Bill::where('user_id', $user->id)
                    ->whereHas('order_detail', function ($query) use ($productId) {
                        $query->where('product_id', $productId);
                    })
                    ->where('status_bill', Bill::DA_GIAO_HANG) // Trạng thái "ĐÃ GIAO HÀNG"
                    ->get(); // Lấy tất cả các đơn hàng

                // Kiểm tra nếu có ít nhất một đơn hàng đủ điều kiện đánh giá
                foreach ($bills as $bill) {
                    if ($this->canReviewProduct($productId, $bill->id)) {
                        $canReview = true;
                        break; // Nếu tìm thấy một đơn hàng đủ điều kiện thì thoát khỏi vòng lặp
                    }
                }

                // Lấy thông tin đơn hàng đã giao gần nhất (nếu có)
                $billId = $bills->isNotEmpty() ? $bills->first()->id : null;
            }


            // Lấy thông tin đánh giá sản phẩm
            $product = Product::with('review.user')->findOrFail($productId);

            // Trả về view với các thông tin cần thiết
            return view('client.home.detail', compact('orderCount', 'sp', 'splq', 'categories', 'canReview', 'product', 'billId', 'soldQuantity'));
        }

        return redirect()->route('products')->with('error', 'Không tìm thấy sản phẩm.');
    }
    private function canReviewProduct($productId, $billId)
    {
        $userId = auth()->id();

        // Kiểm tra đơn hàng đã giao
        $purchasedAndDelivered = Bill::where('user_id', $userId)
            ->where('id', $billId)
            ->whereHas('order_detail', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->where('status_bill', Bill::DA_GIAO_HANG)
            ->exists();

        // Kiểm tra đơn hàng đã hủy
        $canceled = Bill::where('user_id', $userId)
            ->where('id', $billId)
            ->whereHas('order_detail', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->where('status_bill', Bill::DA_HUY)
            ->exists();

        // Kiểm tra đơn hàng đang chờ xác nhận
        $purchasedAndPending = Bill::where('user_id', $userId)
            ->where('id', $billId)
            ->whereHas('order_detail', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->where('status_bill', Bill::CHO_XAC_NHAN)
            ->exists();

        // Kiểm tra đơn hàng đang vận chuyển
        $purchasedAndInTransit = Bill::where('user_id', $userId)
            ->where('id', $billId)
            ->whereHas('order_detail', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->where('status_bill', Bill::DANG_VAN_CHUYEN)
            ->exists();

        // Chỉ cho phép đánh giá nếu đã giao hàng và không có trạng thái "ĐÃ HỦY", "CHỜ XÁC NHẬN", "ĐANG VẬN CHUYỂN"
        return $purchasedAndDelivered && !$canceled && !$purchasedAndPending && !$purchasedAndInTransit;
    }

    function search(Request $request)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        $kyw = $request->input('query');
        $category_id = $request->input('category_id');

        // $products = Product::where('name', 'LIKE', "%$kyw%")->orWhere('description', 'LIKE', "%$kyw%")->orderBy('id', 'DESC')->paginate(9);
        $products = Product::where('name', 'LIKE', "%$kyw%")->withCount('review')
            ->withAvg('review', 'rating')->orderBy('id', 'DESC')->paginate(9);
        // echo var_dump($dssp);
        return view('client.home.proSearch', compact('orderCount', 'categories', 'products', 'kyw', 'category_id'));
    }
    // 
    function getProductInfo (Request $request){
        $id_product = $request->input('id');
        //Lấy thông tin variant product
        $variants = VariantProduct::where('id_product', $id_product)->select('id', 'id_variant')->get();
         //Lấy id của variant
         $variant = VariantProduct::where('id_product', $id_product)->pluck('id_variant');
         //Lấy thông tin packages
         $packages = VariantPackage::whereIn('id', $variant)->get();
        // Lấy thông tin product từ db
        $in4Products = Product::find($id_product);
        if ($in4Products) {
            return response()->json([
                'name'=>$in4Products->name,
                'img'=>$in4Products->img, 
                'packages'=>$packages,
                'variants'=>$variants,
            ]);
        }
        // not found
        return response()->json(['error' => 'Sản Phẩm Không Tồn Tại!!'], 404);
    }
    function getPriceQuantiVariant(Request $request){
        $id = $request->input('id');
        //Lấy price và quantity variant_products
        $variantProduct = VariantProduct::where('id', $id)->select('price', 'quantity', 'id')->first();
        if ($variantProduct) {
            $formattedPrice = number_format($variantProduct->price, 0, ',', '.') . 'VNĐ';
            return response()->json([
                'price'=>$formattedPrice,
                'quantity'=>$variantProduct->quantity,
                'id'=>$variantProduct->id,
            ]);
        }
        //not found
        return response()->json(['error'=>'Có lỗi đã xảy ra!!!'], 404);
    }
    function addToCartHome(Request $request){
        $id_product = $request->input('id_product'); //id sản phẩm
        $quantity = $request->input('quantity'); //số lượng
        $price = $request->input('price'); // giá thành
        $totalPrice = $quantity * $price; // tổng giá 
        $variant_id = $request->input('packageId'); // variant_id
        $name = $request->input('name'); // name
        $img = $request->input('img'); // img
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        // if ($request->input('packageId')) {
            // $variantProduct = VariantProduct::query()
            //     ->where('id_product', $id_product)
            //     ->where('id_variant', $variant_id)
            //     ->firstOrFail();
            // if (!$variantProduct) {
            //     return redirect()->back()->with('error', "Sản phẩm không tồn tại");
            // }
            // // Tính toán giá sản phẩm sau khi áp dụng giảm giácod
            // $totalPrice = $variantProduct->price - (($variantProduct->price * $variantProduct->product->discount) / 100);
            // $cartItem = CartItem::where('cart_id', $cart->id)
            //     ->where('variant_id', $variant_id)
            //     ->first();
            // if ($cartItem) {
            //     $cartItem->quantity += $request->quantity; 
            //     $cartItem->total = $totalPrice * $cartItem->quantity; 
            //     $cartItem->save(); // 
            // } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $id_product,
                    'variant_id' => $variant_id,
                    'name' => $name, 
                    'image' => $img, 
                    'price' => $price , 
                    'quantity' => $quantity, 
                    'total' => $totalPrice 
                ]);
            // }
            return redirect()->back();
        // }
    }
}
