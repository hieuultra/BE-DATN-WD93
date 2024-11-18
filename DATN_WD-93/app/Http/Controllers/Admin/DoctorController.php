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
use App\Models\doctorAchievement;

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
                'min_age' => 'required|numeric',
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
                'min_age' => 'required|numeric',
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
                'min_age' => 'required|numeric',
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
                'min_age' => 'required|numeric',
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
        $schedules = AvailableTimeslot::where('doctor_id', $doctorId)->get();
        $doctor = Doctor::with('user', 'specialty')->findOrFail($doctorId);
        return view('admin.specialtyDoctors.timeslot.schedule', compact('schedules', 'doctor'));
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
        $schedule->update($validatedData);
        return response()->json(['success' => true, 'schedule' => $schedule]);
        $existingSchedule = AvailableTimeslot::where('date', $validated['date'])
            ->where('startTime', $validated['startTime'])
            ->where('id', '!=', $schedule->id)
            ->first();

        if ($existingSchedule) {
            return response()->json([
                'message' => 'Lịch làm việc bị trùng. Đã có lịch với ngày và thời gian bắt đầu này.',
            ], 422);
        }

        $schedule->update([
            'dayOfWeek' => $validated['dayOfWeek'],
            'startTime' => $validated['startTime'],
            'endTime' => $validated['endTime'],
            'date' => $validated['date'],
            'isAvailable' => $validated['isAvailable'],
        ]);

        return response()->json([
            'message' => 'Lịch làm việc đã được cập nhật thành công.',
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
}
