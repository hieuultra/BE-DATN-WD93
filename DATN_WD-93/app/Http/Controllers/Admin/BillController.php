<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listBills = Bill::query()->orderByDesc('id')->get();
        $statusBill = Bill::status_bill;

        $type_da_huy = Bill::DA_HUY;
        return view('admin.bills.index', compact('listBills', 'statusBill', 'type_da_huy'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bill = Bill::query()->findOrFail($id);
        $statusBill = Bill::status_bill;
        $statusPaymentMethod = Bill::status_payment_method;
        return view('admin.bills.show', compact('bill', 'statusBill', 'statusPaymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bill = Bill::query()->findOrFail($id);

        $currentStatus = $bill->status_bill;

        $newStatus = $request->input('status_bill');

        $status = array_keys(Bill::status_bill);

        //kiem tra neu bill da huy thi ko dc change status
        if ($currentStatus === Bill::DA_HUY || $currentStatus === Bill::KHACH_HANG_TU_CHOI) {
            return redirect()->route('admin.bills.index')->with('error', 'Cannot change the status of a canceled or refused bill');
        }
        //kiem tra neu status moi ko dc nam sau status hien tai
        if (array_search($newStatus, $status) < array_search($currentStatus, $status)) {
            return redirect()->route('admin.bills.index')->with('error', 'New Status must be after current status');
        }
        //     // Cập nhật trạng thái thanh toán thành ĐÃ THANH TOÁN nếu đã giao hàng
        if ($newStatus === Bill::DA_GIAO_HANG) {
            $bill->status_payment_method = Bill::DA_THANH_TOAN;
        }

        $bill->status_bill = $newStatus;
        $bill->save();
        return redirect()->route('admin.bills.index')->with('success', 'Status bill has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bill = Bill::query()->findOrFail($id);

        if ($bill->status_bill == Bill::DA_HUY) {
            return redirect()->back()->with('error', 'Bill has already been canceled');
        }

        // Cập nhật trạng thái thành 'DA_HUY' thay vì xóa
        $bill->status_bill = Bill::DA_HUY;
        $bill->save();

        return redirect()->back()->with('success', 'Bill has been canceled successfully');
    }
}
