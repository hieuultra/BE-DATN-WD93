<?php

namespace App\Http\Controllers\Admin;

use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;

class DoctorController extends Controller
{
    public function viewDoctorAdd()
    {
        $specialty = Specialty::orderBy('id')->get();
        $user = User::orderBy('id')->get();
        return view('admin.specialtyDoctors.doctor.viewDoctorAdd', compact('specialty', 'user'));
    }
    public function doctorAdd(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'specialty_id' => 'required|integer|exists:specialties,id',
            'title' => 'required|string|max:255',
            'experience_years' => 'required|numeric',
            'position' => 'required|string|max:255',
            'workplace' => 'required|string|max:255',
            'min_age' => 'nullable|numeric',
            'examination_fee' => 'required|numeric',
            'bio' => 'nullable|string',
        ]);

        $doctor = Doctor::create($validatedData);


        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Thêm doctor thành công'); //Chuyển hướng người dùng đến route productList và kèm theo thông báo thành công.
    }
    //Update Form
    public function doctorUpdateForm($id)
    {
        $specialty = Specialty::orderBy('id')->get();
        $user = User::orderBy('id')->get();
        $doctors = Doctor::orderBy('id')->get();
        $doctor = Doctor::find($id); //tim id
        return view('admin.specialtyDoctors.doctor.doctorUpdateForm', compact('specialty', 'user', 'doctors', 'doctor'));
    }
    //Update
    public function doctorUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'specialty_id' => 'required|integer|exists:specialties,id',
            'title' => 'required|string|max:255',
            'experience_years' => 'required|numeric',
            'position' => 'required|string|max:255',
            'workplace' => 'required|string|max:255',
            'min_age' => 'required|numeric',
            'examination_fee' => 'required|numeric',
            'bio' => 'nullable|string',
        ]);

        $id = $request->id;
        $doctor = Doctor::findOrFail($id);

        $doctor->update($validatedData);

        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Cập nhật variant thành công.');
    }
    //Destroy
    public function doctorDestroy($id)
    {
        $package = Doctor::findOrFail($id); //// Tìm sản phẩm với ID được cung cấp. Nếu không tìm thấy, sẽ ném ra một ngoại lệ ModelNotFoundException.

        $package->delete();
        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Variant đã được xóa thành công.');
    }
}
