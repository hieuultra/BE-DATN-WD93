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

        $variantProduct = VariantProduct::where('id_product', $validatedData['id_product'])
            ->where('id_variant', $validatedData['id_variant'])
            ->first();
        if ($variantProduct) {
            // Nếu bản ghi đã tồn tại, cập nhật quantity
            $variantProduct->quantity += $validatedData['quantity'];
            $variantProduct->save(); // Lưu thay đổi vào cơ sở dữ liệu
            $message = 'Cập nhật thành công số lượng biến thể.';
        } else {
            // Nếu không tồn tại, tạo bản ghi mới
            $variantProduct = VariantProduct::create($validatedData);
        }
        return back()->with('success', 'Thêm Biến Thể Thành Công!!!');
        // return redirect()->route('admin.variantPros.variantProList')->with('success', 'Thêm biến thể thành công'); //Chuyển hướng người dùng đến route productList và kèm theo thông báo thành công.
    }
    //Update Form
    // public function VariantProductUpdateForm($id)
    // {
    //     $variantPackages = VariantPackage::orderBy('id')->get();
    //     $products = Product::orderBy('id')->get();
    //     $variantPros = VariantProduct::orderBy('id')->get();
    //     $variantPro = VariantProduct::find($id); //tim id
    //     return view('admin.variantProducts.productVariant.productVariantUpdateForm', compact('variantPros', 'variantPro', 'variantPackages', 'products'));
    // }
    //Update
    public function variantProductUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'variantId' => 'required|integer',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric|min:0',
        ]);
        // Lấy giá trị đã xác thực
        $quantity = $validatedData['quantity'];
        $price = $validatedData['price'];
        $variantId = $validatedData['variantId'];

        // Tìm bản ghi cần cập nhật
        $variantProduct = VariantProduct::find($variantId);

        if ($variantProduct) {
            // Cập nhật các trường
            $variantProduct->quantity = $quantity;
            $variantProduct->price = $price;
            // Lưu thay đổi
            $variantProduct->save();
            return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
        } else {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
        }
        // return redirect()->route('admin.variantPros.variantProList')->with('success', 'Cập nhật variant thành công.');
    }
    public function VariantProductDestroy(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:variant_products,id'
        ]);
        $id = $validatedData['id'];
        $variantProduct = VariantProduct::findOrFail($id);
        $variantProduct->delete();
        if ($variantProduct) {
            return response()->json(['success' => true, 'message' => 'Xóa thành công']);
        } else {
            return response()->json(['success' => false, 'message' => 'Xóa không thành công']);
        }
    }
}