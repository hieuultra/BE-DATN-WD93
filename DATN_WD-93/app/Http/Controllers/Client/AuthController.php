<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Category;
use App\Models\Specialty;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function viewLogin()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        return view('client.auth_backup.viewLogin', compact('orderCount', 'categories', 'spe'));
    }
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
        // return redirect()->back()->withErrors([
        //     'email' => 'Thông tin tài khoản chưa chính xác'
        // ]);
        return back()->with('error', 'Thông tin tài khoản chưa chính xác!');
    }
    public function loginSuccess()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        return view('client.auth_backup.loginSuccess', compact('orderCount', 'categories', 'spe'));
    }
    public function account()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        return view('client.auth_backup.account', compact('orderCount', 'categories', 'spe'));
    }
    public function viewEditAcc()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        return view('client.auth_backup.editAcc', compact('orderCount', 'categories', 'spe'));
    }
    public function editAcc(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|string|min:5',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255',
        ]);

        $id = $request->id;
        $user = User::findOrFail($id);
        // $user = Auth::user();
        // Kiểm tra xem email đã tồn tại và không phải của tài khoản hiện tại
        $emailExists = User::where('email', $request->email)->where('id', '!=', $id)->exists();
        if ($emailExists) {
            return redirect()->back()->withErrors(['email' => 'Email đã tồn tại trong hệ thống.']);
        }


        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload'), $imageName);
            $validatedData['image'] = $imageName;
            // kiểm tra hình củ và xóa
            $oldImagePath = public_path('upload/' . $user->image);
            if (!empty($user->image) && file_exists($oldImagePath)) {
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
        $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        return view('client.auth_backup.register', compact('orderCount', 'categories', 'spe'));
    }
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:5',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Xử lý việc upload ảnh
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload'), $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = null;
        }

        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
        // $data['password'] = bcrypt($data['password']);

        // Tạo người dùng mới
        $user = User::query()->create($data);


        // Tạo mã giảm giá cho người dùng mới
        // $discountCode = DiscountCode::create([
        //     'code' => strtoupper(uniqid('DISCOUNT_')), // Tạo mã unique
        //     'discount_amount' => 100000, // Số tiền giảm giá (ví dụ: 100,000 VND)
        //     'expires_at' => now()->addDays(30), // Hết hạn sau 30 ngày
        //     'user_id' => $user->id,
        // ]);
        // if (!$discountCode) {
        //     return redirect()->back()->with('error', 'Lỗi khi tạo mã giảm giá.');
        // }

        // Đăng nhập người dùng sau khi đăng ký
        Auth::login($user);

        return redirect()->route('viewRegister'); //->with('success', 'Đăng ký thành công! Mã giảm giá của bạn là: ' . $discountCode->code);
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('viewLogin');
    }
}
