<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function categoriesList()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.categories.cateList', compact('categories'));
    }

    public function viewCateAdd()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.categories.viewCateAdd', compact('categories'));
    }
    public function cateAdd(CategoryRequest $request)
    {
        if ($request->isMethod("POST")) {
            $validatedData = $request->except('_token');
            if ($request->hasFile('img')) {
                $imageName = time() . '.' . $request->img->extension(); //Tạo tên tệp tin duy nhất dựa trên thời gian hiện tại.
                //$request->img->extension() sẽ trả về jpg,..., là phần mở rộng của tệp tin.
                $request->img->move(public_path('upload'), $imageName); //Di chuyển tệp tin đến thư mục public/upload.
                $validatedData['img'] = $imageName; //Cập nhật dữ liệu đã xác thực với tên tệp tin hình ảnh.
            } else {
                return redirect()->back()->withInput()->withErrors(['img' => 'Vui lòng chọn ảnh category']);
            }
    
            Category::create($validatedData); // tạo một bản ghi mới trong bảng products.
    
            return redirect()->route('admin.categories.categoriesList')->with('success', 'Thêm category thành công'); //Chuyển hướng người dùng đến route productList và kèm theo thông báo thành công.
        }
    }
    //hien thi formUpdate
    public function cateUpdateForm($id)
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        $cate = Category::find($id); //tim id
        return view('admin.categories.cateUpdateForm', compact('categories', 'cate'));
    }
    //update data
    public function cateUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'img' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',  // Đảm bảo trạng thái là boolean
        ]);

        $id = $request->id;
        $category = Category::findOrFail($id);

        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('upload'), $imageName);
            $validatedData['img'] = $imageName;
            // kiểm tra hình cũ và xóa
            if (!empty($category->img)) {
                $oldImagePath = public_path('upload/' . $category->img);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $category->update($validatedData);

        return redirect()->route('admin.categories.categoriesList')->with('success', 'Cập nhật category thành công.');
    }
    public function cateDestroy($id)
    {
        $category = Category::findOrFail($id); //// Tìm sản phẩm với ID được cung cấp. Nếu không tìm thấy, sẽ ném ra một ngoại lệ ModelNotFoundException.
        if (!empty($category->img)) {
            $imgpath = "upload/" . $category->img; //duong dan
            if (file_exists($imgpath)) {
                unlink($imgpath); //xoa
            }
        }
        $category->delete();
        return redirect()->route('admin.categories.categoriesList')->with('success', 'Category đã được xóa thành công.');
    }
}
