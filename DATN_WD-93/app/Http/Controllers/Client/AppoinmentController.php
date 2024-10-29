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
        $specialties = Specialty::orderBy('name', 'asc')->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        return view('client.appoinment.specialist', compact('orderCount', 'categories', 'specialties'));
    }
}
