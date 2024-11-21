<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::orderBy('updated_at', 'desc')->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $coupons = Coupon::orderBy('updated_at', 'desc')->get();
        return view('admin.coupons.create', compact('coupons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu nhập vào
        $request->validate([
            'code' => 'required|unique:coupons,code',  // Kiểm tra tính duy nhất của mã giảm giá
            'value' => 'required|numeric|min:0',      // Giá trị giảm giá không âm
            'min_order_value' => 'required|numeric|min:0',  // Giá trị đơn hàng tối thiểu không âm
            'expiry_date' => 'required|date|after:today',  // Ngày hết hạn phải sau ngày hôm nay
            'usage_limit' => 'required|numeric|min:1',   // Số lần sử dụng phải lớn hơn hoặc bằng 1
            'is_active' => 'required|boolean',           // Trạng thái hoạt động (0 hoặc 1)
        ]);

        // Lưu mã giảm giá vào cơ sở dữ liệu
        Coupon::create([
            'code' => $request->code,
            'value' => $request->value,
            'min_order_value' => $request->min_order_value,
            'expiry_date' => $request->expiry_date,
            'usage_limit' => $request->usage_limit,
            'is_active' => $request->is_active,
        ]);

        // Trả về thông báo thành công và chuyển hướng
        return redirect()->route('admin.coupons.index')->with('success', 'Mã giảm giá đã được thêm thành công!');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate dữ liệu nhập vào
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $id,  // Kiểm tra tính duy nhất, bỏ qua mã giảm giá đang sửa
            'value' => 'required|numeric|min:0',      // Giá trị giảm giá không âm
            'min_order_value' => 'required|numeric|min:0',  // Giá trị đơn hàng tối thiểu không âm
            'expiry_date' => 'required|date|after:today',  // Ngày hết hạn phải sau ngày hôm nay
            'usage_limit' => 'required|numeric|min:1',   // Số lần sử dụng phải lớn hơn hoặc bằng 1
            'is_active' => 'required|boolean',           // Trạng thái hoạt động (0 hoặc 1)
        ]);

        // Cập nhật mã giảm giá vào cơ sở dữ liệu
        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'code' => $request->code,
            'value' => $request->value,
            'min_order_value' => $request->min_order_value,
            'expiry_date' => $request->expiry_date,
            'usage_limit' => $request->usage_limit,
            'is_active' => $request->is_active,
        ]);

        // Trả về thông báo thành công và chuyển hướng
        return redirect()->route('admin.coupons.index')->with('success', 'Mã giảm giá đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Mã giảm giá đã được xóa!');
    }
}