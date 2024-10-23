<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
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

        // Kết hợp danh mục và số lượng sản phẩm
        $categories = Category::withCount('products')->orderBy('name', 'asc')->get();

        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }

        return view('client.home.home', compact('orderCount', 'categories', 'newProducts', 'newProducts1', 'bestsellerProducts', 'instockProducts'));
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
    function detail(Request $request) //truyen id o route vao phai co request
    {
        // if ($request->product_id) {
        //     $sp = Product::find($request->product_id);
        //     $splq = Product::where('category_id', $sp->category_id)->where('id', '<>', $sp->id)->get(); //lay sp co cung id vs sp hien tai va khac id vs spht
        //     $categories = Category::orderBy('name', 'asc')->get();
        //     return view('client.detailSearch.detail', compact('sp', 'splq','categories'));
        // }
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

            $categories = Category::orderBy('name', 'asc')->get();
            $orderCount = 0; // Mặc định nếu chưa đăng nhập
            if (Auth::check()) {
                $user = Auth::user();
                $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
            }

            return view('client.home.detail', compact('orderCount', 'sp', 'splq', 'categories'));
        }

        return redirect()->route('products')->with('error', 'Không tìm thấy sản phẩm.');
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
