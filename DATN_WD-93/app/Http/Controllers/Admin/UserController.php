<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function userList()
    {
        $users = User::orderBy('id', 'DESC')->get();
        return view('admin.users.userList', compact('users'));
    }
    public function viewUserAdd()
    {
        $users = User::orderBy('name', 'asc')->get();
        return view('admin.users.viewUserAdd', compact('users'));
    }
    public function userAdd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension(); //Tạo tên tệp tin duy nhất dựa trên thời gian hiện tại.
            //$request->img->extension() sẽ trả về jpg,..., là phần mở rộng của tệp tin.
            $request->image->move(public_path('upload'), $imageName); //Di chuyển tệp tin đến thư mục public/upload.
            $validatedData['image'] = $imageName; //Cập nhật dữ liệu đã xác thực với tên tệp tin hình ảnh.
        }

        $user = User::create($validatedData); // tạo một bản ghi mới trong bảng products.

        return redirect()->route('admin.users.userList')->with('success', 'Thêm account thành công'); //Chuyển hướng người dùng đến route productList và kèm theo thông báo thành công.
    }
    public function userUpdateForm($id)
    {
        $users = User::orderBy('id', 'DESC')->get();
        $acc = User::find($id); //tim id
        return view('admin.users.userUpdateForm', compact('users', 'acc'));
    }
    //update data
    public function userUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $id = $request->id;
        $acc = User::findOrFail($id);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload'), $imageName);
            $validatedData['image'] = $imageName;
            // kiểm tra hình cũ và xóa
            if (!empty($acc->image)) {
                $oldImagePath = public_path('upload/' . $acc->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $acc->update($validatedData);

        return redirect()->route('admin.users.userList')->with('success', 'Cập nhật account thành công.');
    }
    public function userDestroy($id)
    {
        $acc = User::findOrFail($id); //// Tìm sản phẩm với ID được cung cấp. Nếu không tìm thấy, sẽ ném ra một ngoại lệ ModelNotFoundException.
        if (!empty($acc->image)) {
            $imgpath = "upload/" . $acc->image; //duong dan
            if (file_exists($imgpath)) {
                unlink($imgpath); //xoa
            }
        }
        $acc->delete();
        return redirect()->route('admin.users.userList')->with('success', 'account đã được xóa thành công.');
    }
}
