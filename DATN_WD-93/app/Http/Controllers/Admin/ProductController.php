<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function productList()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        // $products = Product::orderBy('id', 'desc')->paginate(10);
        $products = Product::orderBy('id', 'desc')->paginate(10);
        return view('admin.products.productList', compact('categories', 'products'));
    }
    public function viewProAdd()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.products.viewProAdd', compact('categories'));
    }
    public function productAdd(Request $request)
    {
        $validatedData = $request->validate([
            'idProduct' => 'required|max:10|unique:products,idProduct,' . $request->route('id'),
            'name' => 'required|string|max:255',
            'img' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric',
            'discount' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'is_type' => 'required|boolean',
        ]);
        //chuyen doi gia tri checkbox thanh boolean
        $validatedData['is_new'] = $request->has('is_new') ? 1 : 0;
        $validatedData['is_hot'] = $request->has('is_hot') ? 1 : 0;
        $validatedData['is_hot_deal'] = $request->has('is_hot_deal') ? 1 : 0;
        $validatedData['is_show_home'] = $request->has('is_show_home') ? 1 : 0;

        // Xử lý ảnh chính của sản phẩm
        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->img->extension(); //Tạo tên tệp tin duy nhất dựa trên thời gian hiện tại.
            //$request->img->extension() sẽ trả về jpg,..., là phần mở rộng của tệp tin.
            $request->img->move(public_path('upload'), $imageName); //Di chuyển tệp tin đến thư mục public/upload.
            $validatedData['img'] = $imageName; //Cập nhật dữ liệu đã xác thực với tên tệp tin hình ảnh.
        } else {
            return redirect()->back()->withInput()->withErrors(['img' => 'Vui lòng chọn ảnh sản phẩm']);
        }

        $product = Product::create($validatedData); // tạo một bản ghi mới trong bảng products.


        //lay id pro vua add de them dc album
        $productId = $product->id;

        //xu ly them album
        if ($request->hasFile('list_img')) {
            $list_img = $request->file('list_img');
            foreach ($list_img as $img) {
                if ($img) {
                    $path = $img->store('upload/imageProduct/id_' . $productId, 'public');
                    $product->imageProduct()->create([
                        'product_id' => $productId,
                        'image' => $path,
                    ]);
                }
            }
        }
        return redirect()->route('admin.products.productList')->with('success', 'Thêm sản phẩm thành công'); //Chuyển hướng người dùng đến route productList và kèm theo thông báo thành công.
    }
    //hien thi formUpdate
    public function productUpdateForm($id)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $products = Product::orderBy('id', 'DESC')->paginate(10);
        $product = Product::find($id); //tim id
        return view('admin.products.productUpdateForm', compact('categories', 'products', 'product'));
    }
    //update data
    public function productUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'idProduct' => 'required|max:10|unique:products,idProduct,' . $request->route('id'),
            'name' => 'required|string|max:255',
            'img' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'nullable|numeric',
            'discount' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'is_type' => 'required|boolean',
        ]);

        //chuyen doi gia tri checkbox thanh boolean
        $validatedData['is_new'] = $request->has('is_new') ? 1 : 0;
        $validatedData['is_hot'] = $request->has('is_hot') ? 1 : 0;
        $validatedData['is_hot_deal'] = $request->has('is_hot_deal') ? 1 : 0;
        $validatedData['is_show_home'] = $request->has('is_show_home') ? 1 : 0;

        $id = $request->id;
        $product = Product::findOrFail($id);

        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('upload'), $imageName);
            $validatedData['img'] = $imageName;
            // kiểm tra hình củ và xóa
            $oldImagePath = public_path('upload/' . $product->img);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        //xu ly album
        if($request->has('list_img')){
            $currentImage = $product->imageProduct->pluck('id')->toArray();
            $arrayCombine = array_combine($currentImage, $currentImage);
        }

        $product->update($validatedData);

        return redirect()->route('admin.products.productList')->with('success', 'Cập nhật sản phẩm thành công.');
    }
    // Phương thức để xóa sản phẩm
    public function productDestroy($id)
    {
        $product = Product::findOrFail($id); //// Tìm sản phẩm với ID được cung cấp. Nếu không tìm thấy, sẽ ném ra một ngoại lệ ModelNotFoundException.
        $imgpath = "upload/" . $product->img; //duong dan
        if (file_exists($imgpath)) {
            unlink($imgpath); //xoa
        }
        //xoa album
        $product->imageProduct()->delete();

        //xoa toan bo image trong folder
        $path = 'upload/imageProduct/id_' . $id;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->deleteDirectory($path); //xoa thu muc
        }
        //xoa product
        $product->delete();
        return redirect()->route('admin.products.productList')->with('success', 'Sản phẩm đã được xóa thành công.');
    }
}
