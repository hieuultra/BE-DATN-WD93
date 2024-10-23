<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function viewLogin()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $user = Auth::user();
        $orderCount = $user->bill()->count();
        return view('client.auth_backup.viewLogin', compact('orderCount','categories'));
    }
    // public function viewLogin()
    // {
    //     $categories = Category::orderBy('name', 'asc')->get();
    //     return view('auth.login', compact('categories'));
    // }
    public function login(Request $request)
    {
        $users = $request->validate([
            'email' => ['required' => 'string', 'email', 'max:255'],
            'password' => ['required' => 'string']
        ]);
        //   dd($users);
        if (Auth::attempt($users)) { //kiem tra in user_table co trung ko
            return redirect()->route('loginSuccess');
        }
        return redirect()->back()->withErrors([
            'email' => 'Infor account not found'
        ]);
    }
    public function loginSuccess()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $user = Auth::user();
        $orderCount = $user->bill()->count();
        return view('client.auth_backup.loginSuccess', compact('orderCount','categories'));
    }
    public function account()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $user = Auth::user();
        $orderCount = $user->bill()->count();
        return view('client.auth_backup.account', compact('orderCount','categories'));
    }
    public function viewEditAcc()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $user = Auth::user();
        $orderCount = $user->bill()->count();
        return view('client.auth_backup.editAcc', compact('orderCount','categories'));
    }
    public function editAcc(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|string|min:8',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255',
        ]);

        $id = $request->id;
        $user = User::findOrFail($id);
        // $user = Auth::user();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload'), $imageName);
            $validatedData['image'] = $imageName;
            // kiểm tra hình củ và xóa
            $oldImagePath = public_path('upload/' . $user->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        // Mã hóa mật khẩu nếu có
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            // Nếu không có mật khẩu mới, loại bỏ trường mật khẩu khỏi dữ liệu cập nhật
            unset($validatedData['password']);
        }

        // $user->update($validatedData);
        $user->update($validatedData);

        return redirect()->route('viewEditAcc')->with('success', 'Update acc successfully');
    }
    public function viewRegister()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $user = Auth::user();
        $orderCount = $user->bill()->count();
        return view('client.auth_backup.register', compact('orderCount','categories'));
    }
    public function register(Request $request)
    {
        //     $data= $request->all();
        //     dd($data);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Xử lý việc upload ảnh
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload'), $imageName);
            $data['image'] = $imageName;
        }

        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
        // $data['password'] = bcrypt($data['password']);

        // Tạo người dùng mới
        $user = User::query()->create($data);

        // Đăng nhập người dùng sau khi đăng ký
        Auth::login($user);

        return redirect()->route('viewRegister');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('viewLogin');
    }
}
