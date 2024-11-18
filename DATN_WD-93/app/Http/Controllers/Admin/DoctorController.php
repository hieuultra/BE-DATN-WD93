<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Models\AvailableTimeslot;
use App\Http\Controllers\Controller;

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
    //timeslot
    public function viewTimeslotAdd($id)
    {
        $doctors = Doctor::orderBy('id')->get();
        $doctor = Doctor::find($id); //tim id
        return view('admin.specialtyDoctors.timeslot.viewTimeslotAdd', compact('doctor'));
    }
    public function timeslotAdd(Request $request, $doctorId)
    {
    //     $data = $request->validate([
    //         'dayOfWeek' => 'required|string',
    //         'date' => 'required|array',
    //         'date.*.date' => 'required|date',
    //         'date.*.timeslots' => 'required|array',
    //         'date.*.timeslots.*.startTime' => 'required|date_format:H:i',
    //         'date.*.timeslots.*.endTime' => 'required|date_format:H:i',
    //     ]);

    //     foreach ($data['date'] as $dateData) {
    //         // Save the date
    //         $date = new TimeslotDate();
    //         $date->doctor_id = $doctorId;
    //         $date->date = $dateData['date'];
    //         $date->save();

    //         // Save each time slot for this date
    //         foreach ($dateData['timeslots'] as $slot) {
    //             $timeslot = new Timeslot();
    //             $timeslot->timeslot_date_id = $date->id;
    //             $timeslot->start_time = $slot['startTime'];
    //             $timeslot->end_time = $slot['endTime'];
    //             $timeslot->save();
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Time slots added successfully');
    // }

}
}
