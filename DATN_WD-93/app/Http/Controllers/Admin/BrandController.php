<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // Kiểm tra file hình ảnh
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('brands', 'public') : null;

        Brand::create([
            'name' => $request->name,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu được tạo thành công.');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);
        $brand = Brand::findOrFail($request->id);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brands', 'public');
            $brand->update(['image' => $imagePath]);
        }

        $brand->update($request->only('name'));

        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu được cập nhật.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete(); // Xóa mềm
        return redirect()->route('admin.brands.index')->with('success', 'Xóa thương hiệu thành công');
    }
}
