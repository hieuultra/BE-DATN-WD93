<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Support\Facades\Auth;

class AppoinmentController extends Controller
{
    function appoinment()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $specialties = Specialty::orderBy('name', 'asc')->get();
        $doctors = Doctor::orderBy('updated_at', 'desc')->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        return view('client.appoinment.index', compact('orderCount', 'categories', 'specialties', 'doctors'));
    }
    public function specialistExamination()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        // Lấy 4 bản ghi đầu tiên
        $firstBatch = Specialty::orderBy('name', 'asc')->take(4)->get();

        // Lấy 4 bản ghi tiếp theo (sau 4 bản ghi đầu tiên)
        $secondBatch = Specialty::orderBy('name', 'asc')->skip(4)->take(4)->get();

        // Lấy 4 bản ghi tiếp sau 8 bản ghi đầu tiên
        $thirdBatch = Specialty::orderBy('name', 'asc')->skip(8)->take(4)->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        return view('client.appoinment.specialist', compact('orderCount', 'categories', 'firstBatch', 'secondBatch', 'thirdBatch'));
    }
    function doctors(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        $specialty_id = $request->input('specialty_id');

        $specialty = Specialty::find($request->specialty_id);
        if ($request->specialty_id) {
            $doctors = Doctor::where('specialty_id', $request->specialty_id)->orderBy('id', 'desc')->paginate(12);
        } else {
            $doctors = Doctor::orderBy('id', 'desc')->paginate(12); //phan trang 9sp/1page
        }
        return view('client.appoinment.doctors', compact('orderCount', 'specialty', 'doctors', 'specialty_id', 'categories'));
    }
}
