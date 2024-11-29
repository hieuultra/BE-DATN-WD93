<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appoinment;
use Illuminate\Http\Request;

class AdminAppoinmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listAppoinment = Appoinment::query()->orderBy('updated_at', 'desc')->get();
        $statusAppoinment = Appoinment::status_appoinment;
        $statusPayment = Appoinment::status_payment_method;
        return view('admin.appoinments.index', compact('listAppoinment', 'statusAppoinment', 'statusPayment'));
    }
    public function show(string $id)
    {
        $appoinmentDetail = Appoinment::query()->findOrFail($id);
        $statusAppoinment = Appoinment::status_appoinment;
        $statusPayment = Appoinment::status_payment_method;
        return view('admin.appoinments.show', compact('appoinmentDetail', 'statusAppoinment', 'statusPayment'));
    }
    public function update(Request $request, string $id)
    {
        $appoinment = Appoinment::query()->findOrFail($id);

        $currentStatus = $appoinment->status_appoinment;

        $newStatus = $request->input('status_appoinment');
        // dd($appoinment,$currentStatus,$newStatus);
        $status = array_keys(Appoinment::status_appoinment);
        // dd($appoinment->status_appoinment);
        if ($currentStatus === Appoinment::DA_HUY || $currentStatus === Appoinment::BENH_NHAN_KHONG_DEN) {
            return redirect()->route('admin.appoinments.index')->with('error', 'Không thể thay đổi');
        }
        if (array_search($newStatus, $status) < array_search($currentStatus, $status)) {
            return redirect()->route('admin.appoinments.index')->with('error', 'Không thể quay ngược trạng thái');
        }
        if ($newStatus === Appoinment::KHAM_HOAN_THANH) {
            $appoinment->status_payment_method = Appoinment::DA_THANH_TOAN;
        }
        $appoinment->status_appoinment = $newStatus;
        $appoinment->save();
        return redirect()->route('admin.appoinments.index')->with('success', 'Thay đổi trạng thái thành công');
    }
}
