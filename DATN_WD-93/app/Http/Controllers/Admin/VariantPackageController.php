<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\VariantPackage;
use App\Models\VariantProduct;
use App\Http\Controllers\Controller;

class VariantPackageController extends Controller
{
    public function variantPackageList()
    {
        $packages = VariantPackage::orderBy('id', 'asc')->get();
        $product = Product::orderBy('id')->get();
        $variantPro = VariantProduct::orderBy('id')->get();
        $cates = Category::orderBy('id')->get();
        return view('admin.variantPackages.variantPackageList', compact('packages', 'product', 'variantPro', 'cates'));
    }
    public function viewVariantPackageAdd()
    {
        // $packages = VariantPackageProduct::orderBy('name', 'asc')->get();
        return view('admin.variantPackages.viewVariantPackageAdd',);
    }
    public function variantPackageAdd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $packages = VariantPackage::create($validatedData);

        return redirect()->route('admin.variantPackages.variantPackageList')->with('success', 'Thêm biến thể thành công'); //Chuyển hướng người dùng đến route productList và kèm theo thông báo thành công.
    }
    //Update Form
    public function packageUpdateForm($id)
    {
        $packages = VariantPackage::orderBy('id', 'DESC')->get();
        $package = VariantPackage::find($id); //tim id
        return view('admin.variantPackages.packageUpdateForm', compact('packages', 'package'));
    }
    //Update
    public function packageUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $id = $request->id;
        $package = VariantPackage::findOrFail($id);

        $package->update($validatedData);

        return redirect()->route('admin.variantPackages.variantPackageList')->with('success', 'Cập nhật variant thành công.');
    }
    //Destroy
    public function packageDestroy($id)
    {
        $package = VariantPackage::findOrFail($id); //// Tìm sản phẩm với ID được cung cấp. Nếu không tìm thấy, sẽ ném ra một ngoại lệ ModelNotFoundException.

        $package->delete();
        return redirect()->route('admin.variantPackages.variantPackageList')->with('success', 'Variant đã được xóa thành công.');
    }
}
