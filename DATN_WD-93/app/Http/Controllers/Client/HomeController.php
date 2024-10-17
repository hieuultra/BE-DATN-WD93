<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    function index()
    {
        $newProducts = Product::newProducts(8)->get();

        $bestsellerProducts = Product::bestsellerProducts(6)->get();

        $instockProducts = Product::instockProducts(3)->get();

        // Kết hợp danh mục và số lượng sản phẩm
        $categories = Category::withCount('products')->orderBy('name', 'asc')->get();

        return view('client.home.home', compact('categories', 'newProducts', 'bestsellerProducts', 'instockProducts'));
    }
    function products(Request $request)
    {
        $kyw = $request->input('query');
        $category_id = $request->input('category_id');

        $categories = Category::orderBy('name', 'ASC')->get();
        if ($request->category_id) {
            $products = Product::where('category_id', $request->category_id)->orderBy('id', 'desc')->paginate(12);
        } else {
            $products = Product::orderBy('id', 'desc')->paginate(12); //phan trang 9sp/1page
        }
        return view('client.home.products', compact('categories', 'products', 'kyw', 'category_id'));
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
            $sp = Product::with('productVariants')->find($request->product_id);
            if (!$sp) {
                return redirect()->route('products')->with('error', 'Sản phẩm không tồn tại.');
            }

            // Lấy sản phẩm liên quan
            $splq = Product::where('category_id', $sp->category_id)
                ->where('id', '<>', $sp->id)
                ->get();

            $categories = Category::orderBy('name', 'asc')->get();

            // Lấy các giá trị độc nhất cho size và color
            $sizes = $sp->productVariants->pluck('size')->unique();
            $colors = $sp->productVariants->pluck('color')->unique();

            return view('client.detailSearch.detail', compact('sp', 'splq', 'categories', 'sizes', 'colors'));
        }

        return redirect()->route('products')->with('error', 'Không tìm thấy sản phẩm.');
    }
}
