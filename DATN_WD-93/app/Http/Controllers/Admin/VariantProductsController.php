<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\VariantPackage;
use App\Models\VariantProduct;
use App\Http\Controllers\Controller;

class VariantProductsController extends Controller
{
    public function viewProductVariantAdd()
    {
        $variantPackages = VariantPackage::orderBy('id')->get();
        $products = Product::orderBy('id')->get();
        return view('admin.variantProducts.productVariant.productVariantAdd', compact('variantPackages', 'products'));
    }
    public function variantProductAdd(Request $request)
    {
        $validatedData = $request->validate([
            'id_product' => 'required|integer|exists:products,id',
            'id_variant' => 'required|integer|exists:variant_packages,id',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric|min:0',
        ]);

        $variantProduct = VariantProduct::create($validatedData);


        return redirect()->route('admin.variantPros.variantProList')->with('success', 'Thêm biến thể thành công'); //Chuyển hướng người dùng đến route productList và kèm theo thông báo thành công.
    }
    //Update Form
    public function VariantProductUpdateForm($id)
    {
        $variantPackages = VariantPackage::orderBy('id')->get();
        $products = Product::orderBy('id')->get();
        $variantPros = VariantProduct::orderBy('id')->get();
        $variantPro = VariantProduct::find($id); //tim id
        return view('admin.variantProducts.productVariant.productVariantUpdateForm', compact('variantPros', 'variantPro', 'variantPackages', 'products'));
    }
    //Update
    public function VariantProductUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'id_product' => 'required|integer|exists:products,id',
            'id_variant' => 'required|integer|exists:variant_packages,id',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric|min:0',
        ]);

        $id = $request->id;
        $variantPro = VariantProduct::findOrFail($id);

        $variantPro->update($validatedData);

        return redirect()->route('admin.variantPros.variantProList')->with('success', 'Cập nhật variant thành công.');
    }
    //Destroy
    public function VariantProductDestroy($id)
    {
        $package = VariantProduct::findOrFail($id); //// Tìm sản phẩm với ID được cung cấp. Nếu không tìm thấy, sẽ ném ra một ngoại lệ ModelNotFoundException.

        $package->delete();
        return redirect()->route('admin.variantPros.variantProList')->with('success', 'Variant đã được xóa thành công.');
    }
}
