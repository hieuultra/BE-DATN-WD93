<?php

namespace App\Http\Controllers\Admin;

use App\Models\VariantPackageProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\VariantProducts;
use App\Models\Category;

class VariantProPackageController extends Controller
{
    public function variantProList()
    {
        $packages = VariantPackageProduct::orderBy('id', 'asc')->get();
        $product = Product::orderBy('id')->get();
        $variantPro = VariantProducts::orderBy('id')->get();
        $cates = Category::orderBy('id')->get();
        return view('admin.variantProducts.variantProList', compact('packages', 'product', 'variantPro', 'cates') );
    }
    public function variantProAdd()
    {
        // $packages = VariantPackageProduct::orderBy('name', 'asc')->get();
        return view('admin.variantProducts.package.packageAdd', );
    }
    public function packageAdd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $packages = VariantPackageProduct::create($validatedData); 

        return redirect()->route('admin.variantPros.variantProList')->with('success', 'Thêm biến thể thành công'); //Chuyển hướng người dùng đến route productList và kèm theo thông báo thành công.
    }
    //Update Form
    public function packegeUpdate($id)
    {
        $packages = VariantPackageProduct::orderBy('id', 'DESC')->get();
        $package = VariantPackageProduct::find($id); //tim id
        return view('admin.variantProducts.package.packageUpdateForm', compact('packages', 'package'));
    }
    //Update
    public function packageUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $id = $request->id;
        $package = VariantPackageProduct::findOrFail($id);

        $package->update($validatedData);

        return redirect()->route('admin.variantPros.variantProList')->with('success', 'Cập nhật variant thành công.');
    }
    //Destroy
    public function packageDestroy($id)
    {
        $package = VariantPackageProduct::findOrFail($id); //// Tìm sản phẩm với ID được cung cấp. Nếu không tìm thấy, sẽ ném ra một ngoại lệ ModelNotFoundException.
    
        $package->delete();
        return redirect()->route('admin.variantPros.variantProList')->with('success', 'Variant đã được xóa thành công.');
    }
}   
