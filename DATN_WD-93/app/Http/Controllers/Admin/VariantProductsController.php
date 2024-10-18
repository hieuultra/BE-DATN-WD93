<?php

namespace App\Http\Controllers\Admin;

use App\Models\VariantProducts;
use App\Models\VariantPackageProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VariantProductsController extends Controller
{
    public function viewProductVariantAdd()
    {
        $variantPackages = VariantPackageProduct::orderBy('id')->get();
        $products = Product::orderBy('id')->get();
        return view('admin.variantProducts.productVariant.productVariantAdd', compact('variantPackages', 'products'));
    }
    public function variantProductAdd(Request $request)
    {
        $validatedData = $request->validate([
            'id_Product' => 'required|integer|max:255',
            'id_variant' => 'required|integer|max:255',
            'quantity' => 'required|integer|max:255',
            'price' => 'required|string',
        ]);
        $variantProduct = VariantProducts::create($validatedData); 

        return redirect()->route('admin.variantPros.variantProList')->with('success', 'Thêm biến thể thành công'); //Chuyển hướng người dùng đến route productList và kèm theo thông báo thành công.
    }
    //Update Form
    public function VariantProductUpdateForm($id)
    {
        $variantPackages = VariantPackageProduct::orderBy('id')->get();
        $products = Product::orderBy('id')->get();
        $variantPros = VariantProducts::orderBy('id')->get();
        $variantPro = VariantProducts::find($id); //tim id
        return view('admin.variantProducts.productVariant.productVariantUpdateFrom', compact('variantPros', 'variantPro', 'variantPackages', 'products'));
    }
    //Update
    public function VariantProductUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'id_Product' => 'required|integer|max:255',
            'id_variant' => 'required|integer|max:255',
            'quantity' => 'required|integer|max:255',
            'price' => 'required|string',
        ]);

        $id = $request->id;
        $variantPro = VariantProducts::findOrFail($id);

        $variantPro->update($validatedData);

        return redirect()->route('admin.variantPros.variantProList')->with('success', 'Cập nhật variant thành công.');
    }
    //Destroy
    public function VariantProductDestroy($id)
    {
        $package = VariantProducts::findOrFail($id); //// Tìm sản phẩm với ID được cung cấp. Nếu không tìm thấy, sẽ ném ra một ngoại lệ ModelNotFoundException.
    
        $package->delete();
        return redirect()->route('admin.variantPros.variantProList')->with('success', 'Variant đã được xóa thành công.');
    }
    
}   
