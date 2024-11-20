<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withTrashed()->get(); 
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // Kiểm tra file hình ảnh
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('brands') : null;

        Brand::create([
            'name' => $request->name,
            'image' => $imagePath,
        ]);

        return redirect()->route('brands.index')->with('success', 'Thương hiệu được tạo thành công.');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brands');
            $brand->update(['image' => $imagePath]);
        }

        $brand->update($request->only('name'));

        return redirect()->route('brands.index')->with('success', 'Thương hiệu được cập nhật.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được xóa.');
    }

    public function restore($id)
    {
        $brand = Brand::withTrashed()->findOrFail($id);
        $brand->restore();
        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được khôi phục.');
    }

    public function forceDelete($id)
    {
        $brand = Brand::withTrashed()->findOrFail($id);
        $brand->forceDelete();
        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã bị xóa vĩnh viễn.');
    }
}

