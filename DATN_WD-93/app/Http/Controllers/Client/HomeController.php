<?php

namespace App\Http\Controllers\Client;

use Log;
use App\Models\Bill;
use App\Models\Blog;
use App\Models\Cart;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Models\VariantPackage;
use App\Models\VariantProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function index()
    {
        $newProducts = Product::with(['variantProduct', 'orderDetail']) // Nạp quan hệ cần thiết
            ->withCount('review')
            ->withAvg('review', 'rating')
            ->get()
            ->sortByDesc(function ($product) {
                // Tính tổng số lượng đã bán
                return $product->orderDetail()->sum('quantity');
            })
            ->take(4); // Lấy 4 sản phẩm có tổng số lượng bán cao nhất
        $newProducts1 = Product::with(['variantProduct', 'orderDetail']) // Nạp quan hệ cần thiết
            ->withCount('review')
            ->withAvg('review', 'rating')
            ->get()
            ->sortByDesc(function ($product) {
                return $product->orderDetail()->sum('quantity'); // Tính tổng số lượng đã bán
            })
            ->skip(4) // Bỏ qua 4 sản phẩm đầu tiên
            ->take(4); // Lấy 4 sản phẩm tiếp theo
        $bestsellerProducts = Product::bestsellerProducts(6)
            ->with(['variantProduct'])
            ->withCount('review')->withAvg('review', 'rating')->get();
        $instockProducts = Product::instockProducts(8)
            ->with(['variantProduct'])
            ->withCount('review')->withAvg('review', 'rating')->get();

        $mostViewedProducts = Product::orderBy('view', 'desc')->take(8)
            ->with(['variantProduct'])
            ->withCount('review')->withAvg('review', 'rating')->get();
        $highestDiscountProducts = Product::orderBy('discount', 'desc')->take(8)
            ->with(['variantProduct'])
            ->withCount('review')->withAvg('review', 'rating')->get();
        // Kết hợp danh mục và số lượng sản phẩm
        $categories = Category::withCount('products')->orderBy('name', 'asc')->get();
        $spe =  Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();
        $brands = Brand::withCount('products')->orderBy('name', 'asc')->get();
        $blogs = Blog::latest()->take(5)->get(); // Lấy 5 bài viết mới nhất

        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }

        return view('client.home.home', compact(
            'orderCount',
            'categories',
            'brands',
            'newProducts',
            'newProducts1',
            'bestsellerProducts',
            'instockProducts',
            'mostViewedProducts',
            'highestDiscountProducts',
            'blogs',
            'spe'
        ));
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
        $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();
        if ($request->category_id) {
            $products = Product::where('category_id', $request->category_id)
                ->withCount('review') // Đếm số lượt đánh giá
                ->withAvg('review', 'rating') // Tính trung bình số sao
                ->orderBy('id', 'desc')
                ->paginate(12);
            // Lọc thương hiệu liên quan đến danh mục
            $brand_ids = Product::where('category_id', $request->category_id)
                ->pluck('brand_id') // Lấy danh sách `brand_id`
                ->unique(); // Loại bỏ các ID trùng lặp

            $brands = Brand::whereIn('id', $brand_ids)
                ->withCount('products')
                ->orderBy('name', 'asc')
                ->get();
        } else {
            $products = Product::withCount('review') // Đếm số lượt đánh giá
                ->withAvg('review', 'rating') // Tính trung bình số sao
                ->orderBy('id', 'desc')
                ->paginate(12);

            // Hiển thị tất cả thương hiệu
            $brands = Brand::withCount('products')
                ->orderBy('name', 'asc')
                ->get();
        }

        return view('client.home.products', compact('orderCount', 'categories', 'products', 'kyw', 'category_id', 'brands', 'spe'));
    }
    function productsByBrandId(Request $request)
    {
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }

        $brand_id = $request->brand_id; // Lấy ID thương hiệu từ request
        $categories = Category::orderBy('name', 'ASC')->get();
        $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();

        // Lọc sản phẩm theo thương hiệu
        if ($brand_id) {
            $products = Product::where('brand_id', $brand_id)
                ->withCount('review') // Đếm số lượt đánh giá
                ->withAvg('review', 'rating') // Tính trung bình số sao
                ->orderBy('id', 'desc')
                ->paginate(12); // Phân trang 12 sản phẩm mỗi trang
        } else {
            $products = Product::withCount('review') // Đếm số lượt đánh giá
                ->withAvg('review', 'rating') // Tính trung bình số sao
                ->orderBy('id', 'desc')
                ->paginate(12); // Phân trang 12 sản phẩm mỗi trang
        }
        $brands = Brand::withCount('products')
            ->orderBy('name', 'asc')
            ->get();

        return view('client.home.products', compact('orderCount', 'categories', 'products', 'brand_id', 'brands', 'spe'));
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
            $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
                ->orderBy('name', 'asc')
                ->get();

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
            $product = Product::with(['review' => function ($query) {
                $query->orderBy('created_at', 'desc'); // Sắp xếp review mới nhất trước
            }, 'review.user'])->findOrFail($productId);


            // Trả về view với các thông tin cần thiết
            return view('client.home.detail', compact('orderCount', 'sp', 'splq', 'categories', 'canReview', 'product', 'billId', 'soldQuantity', 'spe'));
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
        $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();
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
        return view('client.home.proSearch', compact('orderCount', 'categories', 'products', 'kyw', 'category_id', 'spe'));
    }
    //
    function getProductInfo(Request $request)
    {
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
                'name' => $in4Products->name,
                'img' => $in4Products->img,
                'packages' => $packages,
                'variants' => $variants,
            ]);
        }
        // not found
        return response()->json(['error' => 'Sản Phẩm Không Tồn Tại!!'], 404);
    }
    function getPriceQuantiVariant(Request $request)
    {

        $id = $request->input('id');
        //Lấy price và quantity variant_products
        $variantProduct = VariantProduct::where('id', $id)->select('price', 'quantity', 'id', 'id_product')->first();
        $product = $variantProduct->id_product;
        $proDis = Product::where('id', $product)->select('discount')->first();
        $total = $variantProduct->price - (($variantProduct->price  * $proDis->discount) / 100);
        if ($variantProduct) {
            $formattedPrice = number_format($variantProduct->price, 0, ',', '.') . 'VNĐ';
            return response()->json([
                'price' => $formattedPrice,
                'quantity' => $variantProduct->quantity,
                'id' => $variantProduct->id,
                'total' =>  number_format($total, 0, ',', '.'),
                'dis' => $proDis->discount,
            ]);
        }
        //not found
        return response()->json(['error' => 'Có lỗi đã xảy ra!!!'], 404);
    }
    function addToCartHome(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $id_product = $request->input('id_product'); //id sản phẩm
        $id_variantProduct = $request->input('id_variantProduct');
        $quantity = $request->input('quantity'); //số lượng
        $price = $request->input('price'); // giá thành
        $totalPrice = $quantity * $price; // tổng giá
        // $variant_id = $request->input('packageId'); // variant_id
        $name = $request->input('name'); // name
        $img = $request->input('img'); // img
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('variant_id', $id_variantProduct)
            ->first();
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->total = $totalPrice;
            $cartItem->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm sản phẩm vào giỏ hàng thành công!',
            ]);
        } else {
            $updateStatus = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $id_product,
                'variant_id' => $id_variantProduct,
                'name' => $name,
                'image' => $img,
                'price' => $price,
                'quantity' => $quantity,
                'total' => $totalPrice
            ]);
            if ($updateStatus) {
                $listCartItem = CartItem::where('cart_id', $cart->id)
                    ->get();
                return response()->json([
                    'count' => count($listCartItem),
                    'status' => 'success',
                    'message' => 'Thêm sản phẩm vào giỏ hàng thành công!',
                ]);
            }
        }
        // }
    }
    public function filter(Request $request)
    {
        $category_id = $request->input('category_id');
        $categories = Category::orderBy('name', 'ASC')->get();
        $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();
        if ($request->category_id) {
            $products = Product::where('category_id', $request->category_id)
                ->withCount('review') // Đếm số lượt đánh giá
                ->withAvg('review', 'rating') // Tính trung bình số sao
                ->orderBy('id', 'desc')
                ->paginate(12);
            // Lọc thương hiệu liên quan đến danh mục
            $brand_ids = Product::where('category_id', $request->category_id)
                ->pluck('brand_id') // Lấy danh sách `brand_id`
                ->unique(); // Loại bỏ các ID trùng lặp

            $brands = Brand::whereIn('id', $brand_ids)
                ->withCount('products')
                ->orderBy('name', 'asc')
                ->get();
        } else {
            $products = Product::withCount('review') // Đếm số lượt đánh giá
                ->withAvg('review', 'rating') // Tính trung bình số sao
                ->orderBy('id', 'desc')
                ->paginate(12);
            //phan trang 9sp/1page
            // Hiển thị tất cả thương hiệu
            $brands = Brand::withCount('products')
                ->orderBy('name', 'asc')
                ->get();
        }
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        // Lấy danh sách khoảng giá
        $priceRanges = $request->get('price', []);

        // Nếu không có giá trị lọc, trả về tất cả sản phẩm
        if (empty($priceRanges)) {
            $filteredVariants = VariantProduct::all();
        } else {
            // Tạo query
            $query = VariantProduct::query(); //tạo một đối tượng query builder để bắt đầu xây dựng truy vấn.

            // Lọc theo khoảng giá
            $query->where(function ($q) use ($priceRanges) {
                foreach ($priceRanges as $range) {
                    [$min, $max] = explode('-', $range); //chia chuỗi khoảng giá (như '0-100000') thành mảng ['0', '100000'].
                    $q->orWhereBetween('price', [(int)$min, (int)$max]);
                }
            });

            // Lấy danh sách sản phẩm đã lọc
            $filteredVariants = $query->get();
        }

        // Trả về view
        return view('client.home.filtered', compact('filteredVariants', 'categories', 'orderCount', 'products', 'category_id', 'brands', 'spe'));
    }
}
