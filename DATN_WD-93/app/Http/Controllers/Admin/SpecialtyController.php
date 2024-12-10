<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailableTimeslot;
use App\Models\Doctor;
use App\Models\Package;
use App\Models\Specialty;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function specialtyDoctorList(Request $request)
    {
        $classification = $request->get('classification');

        $specialtyQuery = Specialty::query();
        if ($classification) {
            $specialtyQuery->where('classification', $classification);
        }
        $specialty = $specialtyQuery->orderBy('updated_at', 'desc')->get();

        $doctorQuery = Doctor::query();
        if ($classification) {
            $doctorQuery->whereHas('specialty', function ($query) use ($classification) {
                $query->where('classification', $classification);
            });
        }
        $doctor = $doctorQuery->orderBy('updated_at', 'desc')->get();

        $packageQuery = Package::query();
        if ($classification) {
            $packageQuery->whereHas('specialty', function ($query) use ($classification) {
                $query->where('classification', $classification);
            });
        }
        $package = $packageQuery->orderBy('updated_at', 'desc')->paginate(3);
        return view('admin.specialtyDoctors.specialtyDoctorList', compact('specialty', 'doctor', 'package'));
    }
    public function viewSpecialtyAdd()
    {
        return view('admin.specialtyDoctors.specialty.viewSpecialtyAdd',);
    }
    public function specialtyAdd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'classification' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload'), $imageName);
            $validatedData['image'] = $imageName;
        } else {
            return redirect()->back()->withInput()->withErrors(['image' => 'Vui lòng chọn ảnh specialty ']);
        }
        $specialty = Specialty::create($validatedData);

        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Thêm specialty thành công');
    }
    //Update Form
    public function specialtyUpdateForm($id)
    {
        $specialties = Specialty::orderBy('id', 'DESC')->get();
        $specialty = Specialty::find($id);
        return view('admin.specialtyDoctors.specialty.specialtyUpdateForm', compact('specialties', 'specialty'));
    }
    //Update
    public function specialtyUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $id = $request->id;
        $specialty = Specialty::find($id);
        $specialty->name = $request->name;
        $specialty->description = $request->description;
        if ($request->hasFile('image')) {

            if ($specialty->image && File::exists(public_path('uploads/' . $specialty->image))) {
                File::delete(public_path('upload/' . $specialty->image));
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $imageName);
            $specialty->image = $imageName;
        }
        $specialty->classification = $request->classification;
        $specialty->save();

        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Cập nhật specialty thành công.');
    }
    //Destroy
    public function specialtyDestroy($id)
    {
        $specialty = Specialty::findOrFail($id);
        $specialty->classification = 0;
        $specialty->save();
        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Specialty đã được cho dừng hoạt động.');
    }

    public function timdoctorlist()
    {
        $currentMonth = Carbon::now()->month; 
        $currentYear = Carbon::now()->year;  
    
        $leastAvailableDoctors = Doctor::with(['user', 'specialty'])
            ->withCount([
                'timeSlot as available_times_count' => function ($query) {
                    $query->where('isAvailable', 1);
                },
                'appoinment as booked_appointments_count' => function ($query) use ($currentMonth, $currentYear) {
                    $query->whereMonth('appointment_date', $currentMonth)
                          ->whereYear('appointment_date', $currentYear);
                }
            ])
            ->orderBy('available_times_count', 'asc')
            ->get();

        return view('admin.specialtyDoctors.timeslot.listTime', compact('leastAvailableDoctors', 'currentMonth', 'currentYear'));
    }

    public function timeslotList($doctorId)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');

        $expiredSchedules = AvailableTimeslot::where('date', '<', $now->toDateString())
            ->orWhere(function ($query) use ($now) {
                $query->where('date', '=', $now->toDateString())
                    ->where('startTime', '<', $now->toTimeString());
            })
            ->get();
        foreach ($expiredSchedules as $schedule) {
            $schedule->isAvailable = 0;
            $schedule->save();
        }

        $schedules = AvailableTimeslot::where('doctor_id', $doctorId)
            ->where('date', '>=', $now->toDateString())
            ->orderBy('date', 'asc')
            ->orderBy('startTime', 'asc')
            ->get();

        $schedules->map(function ($schedule) use ($now) {
            $schedule->isExpired = ($schedule->date === $now->toDateString() && $schedule->endTime < $now->toTimeString());
            $date = Carbon::createFromFormat('Y-m-d', $schedule->date);
            $schedule->dayOfWeek = $date->locale('vi')->dayName;
            $schedule->formattedDate = $date->format('d/m/Y');
            return $schedule;
        });

        $doctor = Doctor::with('user', 'specialty')->findOrFail($doctorId);
        return view('admin.specialtyDoctors.timeslot.timeslotList', compact('schedules', 'doctor'));
    }
}
