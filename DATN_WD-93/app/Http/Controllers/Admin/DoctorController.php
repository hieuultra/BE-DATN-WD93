<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Models\AvailableTimeslot;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Support\Facades\File;
use App\Models\doctorAchievement;
use App\Models\MedicalPackage;
use App\Models\Package;

class DoctorController extends Controller
{
    public function viewDoctorAdd()
    {
        $specialty = Specialty::orderBy('id')->get();
        $existingUserIds = Doctor::pluck('user_id')->toArray();
        $user = User::whereNotIn('id', $existingUserIds)
            ->orderBy('id')
            ->get();
        return view('admin.specialtyDoctors.doctor.viewDoctorAdd', compact('specialty', 'user'));
    }

    public function filterSpecialty(Request $request)
    {
        $classification = $request->get('classification');
        $specialtyQuery = Specialty::query();

        if ($classification) {
            $specialtyQuery->where('classification', $classification);
        }

        $specialty = $specialtyQuery->get();

        return response()->json($specialty);
    }


    public function doctorAdd(Request $request)
    {
        if ($request->classification == 'chuyen_khoa') {
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

                'clinic_name' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'address' => 'required|string|max:255',
            ]);

            $doctor = Doctor::create($validatedData);

            $clinic = new Clinic();
            $clinic->doctor_id = $doctor->id;
            $clinic->clinic_name = $request->clinic_name;
            $clinic->city = $request->city;
            $clinic->address = $request->address;
            $clinic->save();

            $user = User::where('id', $request->user_id)->first();
            $user->role = 'Doctor';
            $user->save();


            return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Thêm doctor thành công');
        } elseif ($request->classification == 'kham_tu_xa') {
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

            $user = User::where('id', $request->user_id)->first();
            $user->role = 'Doctor';
            $user->save();
            return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Thêm doctor thành công');
        }
    }

    public function doctorUpdateForm($id)
    {
        $specialty = Specialty::orderBy('id')->get();
        $user = User::orderBy('id')->get();
        $doctors = Doctor::orderBy('id')->get();
        $doctor = Doctor::find($id);
        $clinic = Clinic::where('doctor_id', $doctor->id)->first();
        return view('admin.specialtyDoctors.doctor.doctorUpdateForm', compact('specialty', 'user', 'doctors', 'doctor', 'clinic'));
    }

    public function doctorUpdate(Request $request)
    {
        $specialty = Specialty::where('id', $request->specialty_id)->first();
        $doctor = Doctor::where('id', $request->id)->first();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Không tìm thấy bác sĩ.');
        }

        $clinic = Clinic::where('doctor_id', $doctor->id)->first();

        if ($specialty->classification == 'chuyen_khoa' && !empty($clinic)) {
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

            $doctor->update($validatedData);

            $clinic->clinic_name = $request->clinic_name;
            $clinic->city = $request->city;
            $clinic->address = $request->address;
            $clinic->save();

            return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Cập nhật variant thành công.');
        } elseif ($specialty->classification == 'chuyen_khoa' && empty($clinic)) {
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

            $doctor->update($validatedData);

            $clinic = new Clinic();
            $clinic->doctor_id = $doctor->id;
            $clinic->clinic_name = $request->clinic_name;
            $clinic->city = $request->city;
            $clinic->address = $request->address;
            $clinic->save();

            return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Cập nhật variant thành công.');
        } elseif ($specialty->classification == 'kham_tu_xa' && empty($clinic)) {
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

            $doctor->update($validatedData);

            return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Cập nhật variant thành công.');
        } elseif ($specialty->classification == 'kham_tu_xa' && !empty($clinic)) {
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

            $doctor->update($validatedData);

            $clinic->delete();
            return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Cập nhật variant thành công.');
        }
    }


    public function doctorDestroy($id)
    {
        $package = Doctor::findOrFail($id);

        $package->delete();
        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Variant đã được xóa thành công.');
    }

    // lịch làm việc
    public function showSchedule($doctorId)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $expiredSchedules = AvailableTimeslot::where('date', '<', $now->toDateString())
            ->orWhere(function ($query) use ($now) {
                $query->where('date', '=', $now->toDateString())
                    ->where('endTime', '<', $now->toTimeString());
            })
            ->get();
        foreach ($expiredSchedules as $schedule) {
            $schedule->isAvailable = 0;
            $schedule->save();
        }
        $schedules = AvailableTimeslot::where('doctor_id', $doctorId)->get();
        $doctor = Doctor::with('user', 'specialty')->findOrFail($doctorId);
        return view('admin.specialtyDoctors.timeslot.schedule', compact('schedules', 'doctor'));
    }

    public function showPackages($packageId)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $expiredSchedules = AvailableTimeslot::where('date', '<', $now->toDateString())
            ->orWhere(function ($query) use ($now) {
                $query->where('date', '=', $now->toDateString())
                    ->where('endTime', '<', $now->toTimeString());
            })
            ->get();
        foreach ($expiredSchedules as $schedule) {
            $schedule->isAvailable = 0;
            $schedule->save();
        }
        $schedules = AvailableTimeslot::where('package_id', $packageId)->get();
        $package = Package::with('specialty')->findOrFail($packageId);
        return view('admin.specialtyDoctors.timeslot.showPackages', compact('schedules', 'package'));
    }

    public function scheduleAdd(Request $request)
    {
        $doctorId = $request->doctor_id;
        $days = $request->days;
        $shifts = $request->shifts;
        $isAvailable = $request->isAvailable;

        foreach ($days as $day) {
            if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $day, $matches)) {
                $dateString = $matches[0];
                try {
                    $date = Carbon::createFromFormat('d/m/Y', $dateString);
                } catch (\Exception $e) {
                    return back()->with('error', 'Ngày không hợp lệ: ' . $dateString);
                }

                $dayOfWeek = $date->dayOfWeekIso;

                if (isset($shifts[$day])) {
                    foreach ($shifts[$day] as $timeSlot) {
                        list($startTime, $endTime) = explode('-', $timeSlot);

                        $existingSchedule = AvailableTimeslot::where('doctor_id', $doctorId)
                            ->where('date', $date->format('Y-m-d'))
                            ->where('startTime', $startTime)
                            ->where('endTime', $endTime)
                            ->exists();

                        if ($existingSchedule) {
                            return back()->with('error', 'Lịch làm việc đã tồn tại vào ngày ' . $dateString . ' từ ' . $startTime . ' đến ' . $endTime . '.');
                        } else {
                            $availableTimeslot = new AvailableTimeslot();
                            $availableTimeslot->doctor_id = $doctorId;
                            $availableTimeslot->dayOfWeek = $dayOfWeek;
                            $availableTimeslot->startTime = $startTime;
                            $availableTimeslot->endTime = $endTime;
                            $availableTimeslot->date = $date;
                            $availableTimeslot->isAvailable = $isAvailable;
                            $availableTimeslot->save();
                        }
                    }
                }
            } else {
                return back()->with('error', 'Định dạng ngày không đúng trong chuỗi: ' . $day);
            }
        }
        return back()->with('success', 'Lịch làm việc được thêm thành công.');
    }

    public function schedulePackageAdd(Request $request)
    {
        $packageId = $request->package_id;
        $days = $request->days;
        $shifts = $request->shifts;
        $isAvailable = $request->isAvailable;

        foreach ($days as $day) {
            if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $day, $matches)) {
                $dateString = $matches[0];
                try {
                    $date = Carbon::createFromFormat('d/m/Y', $dateString);
                } catch (\Exception $e) {
                    return back()->with('error', 'Ngày không hợp lệ: ' . $dateString);
                }

                $dayOfWeek = $date->dayOfWeekIso;

                if (isset($shifts[$day])) {
                    foreach ($shifts[$day] as $timeSlot) {
                        list($startTime, $endTime) = explode('-', $timeSlot);

                        $existingSchedule = AvailableTimeslot::where('package_id', $packageId)
                            ->where('date', $date->format('Y-m-d'))
                            ->where('startTime', $startTime)
                            ->where('endTime', $endTime)
                            ->exists();

                        if ($existingSchedule) {
                            return back()->with('error', 'Lịch làm việc đã tồn tại vào ngày ' . $dateString . ' từ ' . $startTime . ' đến ' . $endTime . '.');
                        } else {
                            $availableTimeslot = new AvailableTimeslot();
                            $availableTimeslot->dayOfWeek = $dayOfWeek;
                            $availableTimeslot->startTime = $startTime;
                            $availableTimeslot->endTime = $endTime;
                            $availableTimeslot->date = $date;
                            $availableTimeslot->isAvailable = $isAvailable;
                            $availableTimeslot->package_id = $packageId;
                            $availableTimeslot->save();
                        }
                    }
                }
            } else {
                return back()->with('error', 'Định dạng ngày không đúng trong chuỗi: ' . $day);
            }
        }
        return back()->with('success', 'Lịch làm việc được thêm thành công.');
    }


    public function scheduleEdit($id)
    {
        $schedule = AvailableTimeslot::findOrFail($id);
        return response()->json([
            'success' => true,
            'schedule' => $schedule
        ]);
    }

    public function scheduleUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'dayOfWeek' => 'required|string',
            'startTime' => 'required|string',
            'endTime' => 'required|string',
            'date' => 'required|date',
            'isAvailable' => 'required|boolean',
        ]);

        $schedule = AvailableTimeslot::findOrFail($id);

        // Check if there's an existing schedule with the same date and startTime but a different ID
        $existingSchedule = AvailableTimeslot::where('date', $validatedData['date'])
            ->where('startTime', $validatedData['startTime'])
            ->where('id', '!=', $schedule->id)
            ->first();

        if ($existingSchedule) {
            return response()->json([
                'message' => 'Lịch làm việc bị trùng. Đã có lịch với ngày và thời gian bắt đầu này.',
            ], 422);
        }

        // Update the schedule if no conflict is found
        $schedule->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Lịch làm việc đã được cập nhật thành công.',
            'schedule' => $schedule,
        ]);
    }


    public function scheduleDestroy($id)
    {
        $schedule = AvailableTimeslot::findOrFail($id);
        $schedule->delete();
        return response()->json(['success' => true]);
    }

    //Thành tựu bác sĩ
    public function showAchievements($id)
    {
        $doctor = Doctor::with('user')->where('id', $id)->first();
        $achievements = doctorAchievement::where('doctor_id', $id)->get();
        return view('admin.specialtyDoctors.achievements.view', compact('doctor', 'achievements'));
    }

    public function achievementsAdd(Request $request)
    {
        $achievements = new doctorAchievement();
        $achievements->doctor_id = $request->doctor_id;
        $achievements->type = $request->type;
        $achievements->description = $request->description;
        $achievements->year = $request->year;
        $achievements->save();
        return redirect()->back()->with('success', 'thêm thành công');
    }

    public function achievementsUpdate(Request $request)
    {
        $achievementId = $request->achievement_id;
        $achievements = doctorAchievement::find($achievementId);
        $achievements->type = $request->type;
        $achievements->description = $request->description;
        $achievements->year = $request->year;
        $achievements->save();
        return redirect()->back()->with('success', 'sửa thành công');
    }

    public function destroy($id)
    {
        $achievement = doctorAchievement::find($id);

        if ($achievement) {
            $achievement->delete();
            return response()->json(['message' => 'Xóa thành công!'], 200);
        }

        return response()->json(['message' => 'Không tìm thấy thành tựu'], 404);
    }

    // dịch vụ khám tông quát
    public function viewPackagesAdd()
    {
        $specialty = Specialty::where('classification', 'tong_quat')->orderBy('id')->get();
        return view('admin.specialtyDoctors.package.viewPackagesAdd', compact('specialty'));
    }

    public function PackageAdd(Request $request)
    {
        $validatedData = $request->validate([
            'specialty_id' => 'required|exists:specialties,id',
            'hospital_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $package = new Package();
        $package->specialty_id = $validatedData['specialty_id'];
        $package->hospital_name = $validatedData['hospital_name'];
        $package->description = $validatedData['description'];
        $package->address = $validatedData['address'];
        $package->price = $validatedData['price'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $imageName);
            $package->image = $imageName;
        }

        $package->save();

        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Thêm package thành công');
    }

    public function packageUpdateForm($id)
    {
        $specialty = Specialty::where('classification', 'tong_quat')->orderBy('id')->get();
        $package = Package::where('id', $id)->first();
        return view('admin.specialtyDoctors.package.packageUpdateForm', compact('specialty', 'package'));
    }

    public function packageUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'specialty_id' => 'exists:specialties,id',
            'hospital_name' => 'string|max:255',
            'description' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'string|max:255',
            'price' => 'numeric|min:0',
        ]);

        $package = Package::find($id);
        $package->specialty_id = $request->specialty_id;
        $package->hospital_name = $request->hospital_name;
        $package->description = $request->description;
        $package->address = $request->address;
        $package->price = $request->price;

        if ($request->hasFile('image')) {

            if ($package->image && File::exists(public_path('upload/' . $package->image))) {
                File::delete(public_path('uploads/' . $package->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $imageName);

            $package->image = $imageName;
        }

        $package->save();

        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Cập nhật package thành công');
    }

    public function packageDestroy($id)
    {
        $package = Package::find($id);

        if ($package) {

            if ($package->image && File::exists(public_path('upload/' . $package->image))) {

                File::delete(public_path('upload/' . $package->image));
            }

            $package->delete();

            return redirect()->back()->with('success', 'package đã được xóa thành công');
        }

        return redirect()->back()->with('error', 'Không tìm thấy package');
    }


    // danh mục gói khám
    public function medicalPackages($id)
    {
        $package = Package::where('id', $id)->first();
        $achievements = MedicalPackage::where('package_id', $id)->get();
        return view('admin.specialtyDoctors.medicalPackages.view', compact('package', 'achievements'));
    }

    public function viewmedicalPackagesAdd(Request $request)
    {
        $medicalPackage = new MedicalPackage();
        $medicalPackage->package_id = $request->package_id;
        $medicalPackage->category = $request->category;
        $medicalPackage->name = $request->name;
        $medicalPackage->description = $request->description;
        $medicalPackage->save();

        return redirect()->back();
    }

    public function medicalPackagesUpdate(Request $request)
    {
        $medicalPackage = MedicalPackage::find($request->achievement_id);

        if (!$medicalPackage) {
            return redirect()->back()->withErrors(['error' => 'Medical package not found.']);
        }

        $medicalPackage->category = $request->category;
        $medicalPackage->name = $request->name;
        $medicalPackage->description = $request->description;

        $medicalPackage->save();

        return redirect()->back()->with('success', 'Medical package updated successfully.');
    }


    public function medicalPackagesDestroy($id)
    {
        $medicalPackage = MedicalPackage::find($id);

        $medicalPackage->delete();
        return redirect()->back()->with('success', 'Medical package delete successfully.');
    }
}
