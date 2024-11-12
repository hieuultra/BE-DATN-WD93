<?php

namespace App\Http\Controllers\Client;

use Log;
use App\Models\Bill;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\VariantPackage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function index()
    {
        $newProducts = Product::newProducts(4)->get();
        $newProducts1 = Product::limit(4)->get();

        $bestsellerProducts = Product::bestsellerProducts(6)->get();

        $instockProducts = Product::instockProducts(8)->get();
        // Lấy 8 sản phẩm có lượt xem nhiều nhất
        $mostViewedProducts = Product::orderBy('view', 'desc')->take(8)->get();

        // Kết hợp danh mục và số lượng sản phẩm
        $categories = Category::withCount('products')->orderBy('name', 'asc')->get();

        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }

        return view('client.home.home', compact('orderCount', 'categories', 'newProducts', 'newProducts1', 'bestsellerProducts', 'instockProducts', 'mostViewedProducts'));
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
            $products = Product::where('category_id', $request->category_id)->orderBy('id', 'desc')->paginate(12);
        } else {
            $products = Product::orderBy('id', 'desc')->paginate(12); //phan trang 9sp/1page
        }
        return view('client.home.products', compact('orderCount', 'categories', 'products', 'kyw', 'category_id'));
    }
    function detail(Request $request, $productId) //truyen id o route vao phai co request
    {
        if ($request->product_id) {
            // Lấy sản phẩm
            $sp = Product::find($request->product_id);
            if (!$sp) {
                return redirect()->route('products')->with('error', 'Sản phẩm không tồn tại.');
            }

            // Lấy sản phẩm liên quan
            $splq = Product::where('category_id', $sp->category_id)
                ->where('id', '<>', $sp->id)
                ->get();

            // Lấy danh sách các biến thể của sản phẩm
            $variants = $sp->variantProduct;

            // // Tạo mảng chứa tên các biến thể
            $nameVariants = [];
            foreach ($variants as $variant) {
                // Lấy tên biến thể từ variantPackage
                $nameVariants[] = $variant->variantPackage ? $variant->variantPackage->name : 'Chưa có tên biến thể'; // Kiểm tra nếu variantPackage tồn tại
            }

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
            return view('client.home.detail', compact('orderCount', 'sp', 'splq', 'categories', 'nameVariants', 'canReview', 'product', 'billId'));
        }

        return redirect()->route('products')->with('error', 'Không tìm thấy sản phẩm.');
    }private function canReviewProduct($productId, $billId)
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
        $products = Product::where('name', 'LIKE', "%$kyw%")->orderBy('id', 'DESC')->paginate(9);
        // echo var_dump($dssp);
        return view('client.home.proSearch', compact('orderCount', 'categories', 'products', 'kyw', 'category_id'));
    }
}
