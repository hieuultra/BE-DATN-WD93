<?php

namespace App\Http\Controllers\Admin;

<<<<<<< Updated upstream
use App\Models\User;
=======
use App\Http\Controllers\Controller;
use App\Models\Appoinment;
use App\Models\AppoinmentHistory;
use App\Models\AvailableTimeslot;
>>>>>>> Stashed changes
use App\Models\Doctor;
use App\Models\Review;
use Illuminate\Support\Facades\Log;
use App\Models\Specialty;
<<<<<<< Updated upstream
=======
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
>>>>>>> Stashed changes
use Illuminate\Http\Request;
use App\Models\AvailableTimeslot;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    public function viewDoctorAdd()
    {
<<<<<<< Updated upstream
        $specialty = Specialty::orderBy('id')->get();
        $user = User::orderBy('id')->get();
        return view('admin.specialtyDoctors.doctor.viewDoctorAdd', compact('specialty', 'user'));
    }
    public function doctorAdd(Request $request)
=======
        $doctors = Doctor::with('user', 'specialty')->paginate(5);
        $specialties = Specialty::withCount('doctor')->get();
        return view('admin.doctors.view', compact('doctors', 'specialties'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'specialty_id' => 'required|exists:specialties,id',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8',
            'price' => 'required',
        ], [
            'name.required' => 'Tên chuyên ngành là bắt buộc.',
            'name.string' => 'Tên chuyên ngành phải là chuỗi ký tự.',
            'name.max' => 'Tên chuyên ngành không được dài quá 255 ký tự.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.regex' => 'Số điện thoại không đúng định dạng.',
            'email.required' => 'Email là bắt buộc.',
            'email.string' => 'Email phải là chuỗi ký tự.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'specialty_id.required' => 'Bro quên chọn kìa.',
            'specialty_id.exists' => 'Nó không tồn tại.',
            'bio.nullable' => 'Quên mô tả kìa sikibidi.',
            'bio.string' => 'Mô tả phải là chuỗi ký tự.',
            'image.nullable' => 'Quên ảnh rồi sikibidi.',
            'image.image' => 'Có phải ảnh đâu ku.',
            'image.mimes' => 'Ảnh sai định dạng rồi con zai.',
            'address.nullable' => 'Chưa nhập địa chỉ đâu con.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
        ]);
        $user = new User();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $imageName);
            $user->image = $imageName;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->role = 'doctor';
        $user->save();

        $doctor = Doctor::create([
            'user_id' => $user->id,
            'specialty_id' => $validated['specialty_id'],
            'price' => $validated['price'],
            'bio' => $validated['bio'],
        ]);

        $doctor->load('user', 'specialty');
        return response()->json([
            'success' => true,
            'doctor' => $doctor
        ]);
    }


    public function showDetails($id)
    {
        $doctor = Doctor::with('user', 'specialty')->find($id);
        return response()->json([
            'success' => true,
            'data' => $doctor
        ]);
    }


    public function show($id)
    {
        $doctor = Doctor::with('user', 'specialty')->find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        return response()->json(['data' => $doctor], 200);
    }


    public function update(Request $request, $id)
    {
        $doctor = Doctor::with('user')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|string|email|unique:users,email,' . $doctor->user->id,
            'specialty_id' => 'required|exists:specialties,id',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'price' => 'required',
        ]);


        $doctor = Doctor::with('user')->findOrFail($id);

        if ($request->hasFile('image')) {

            if ($doctor->user->image && File::exists(public_path('uploads/' . $doctor->user->image))) {
                File::delete(public_path('upload/' . $doctor->user->image));
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $imageName);
            $doctor->user->image = $imageName;
        }
        $doctor->user->name = $request->name;
        $doctor->user->email = $request->email;
        $doctor->user->phone = $request->phone;
        if ($request->filled('password')) {
            $doctor->user->password = Hash::make($request->password);
        }
        $doctor->user->address = $request->address;
        $doctor->user->role = 'admin';
        $doctor->user->save();


        $doctor->update([
            'specialty_id' => $validated['specialty_id'],
            'price' => $validated['price'],
            'bio' => $validated['bio'],
        ]);

        $doctor->load('user', 'specialty');
        return response()->json([
            'success' => true,
            'doctor' => $doctor
        ]);
    }


    public function destroy($id)
    {
        $doctor = Doctor::with('user')->findOrFail($id);

        if ($doctor->user->image && File::exists(public_path('upload/' . $doctor->user->image))) {
            File::delete(public_path('upload/' . $doctor->user->image));
        }
        $doctor->delete();

        $doctor->user->delete();
        return response()->json(['success' => true]);
    }


    public function filterBySpecialty(Request $request)
    {
        $specialtyId = $request->get('specialty_id');

        if ($specialtyId) {
            $doctors = Doctor::with('user', 'specialty')
                ->where('specialty_id', $specialtyId)
                ->get();
        } else {
            $doctors = Doctor::with('user', 'specialty')->get();
        }

        return response()->json($doctors);
    }







    public function showSchedule($doctorId)
    {
        $schedules = AvailableTimeslot::where('doctor_id', $doctorId)->get();
        $doctor = Doctor::with('user', 'specialty')->findOrFail($doctorId);

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

        return view('admin.doctors.schedule', compact('schedules', 'doctor'));
    }


    public function scheduleAdd(Request $request)
>>>>>>> Stashed changes
    {
        $messages = [
            'doctor_id.required' => 'Bác sĩ là bắt buộc.',
            'doctor_id.exists' => 'Bác sĩ không tồn tại.',
            'days.required' => 'Ngày làm việc là bắt buộc.',
            'days.array' => 'Ngày làm việc phải là một mảng.',
            'shifts.required' => 'Ca làm việc là bắt buộc.',
            'shifts.array' => 'Ca làm việc phải là một mảng.',
            'isAvailable.boolean' => 'Giá trị Có sẵn phải là true hoặc false.',
        ];

        $validatedData = $request->validate([
<<<<<<< Updated upstream
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
    public function doctorUpdateForm($id)
    {
        $specialty = Specialty::orderBy('id')->get();
        $user = User::orderBy('id')->get();
        $doctors = Doctor::orderBy('id')->get();
        $doctor = Doctor::find($id); 
        return view('admin.specialtyDoctors.doctor.doctorUpdateForm', compact('specialty', 'user', 'doctors', 'doctor'));
    }
    
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
=======
            'doctor_id' => 'required|exists:doctors,id',
            'days' => 'required|array',
            'shifts' => 'required|array',
            'isAvailable' => 'boolean',
        ], $messages);

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
                            ->where('date', $date)
                            ->where('startTime', $startTime)
                            ->where('endTime', $endTime)
                            ->exists(); 

                        if ($existingSchedule) {
                            return back()->with('error', 'Lịch làm việc đã tồn tại vào ngày ' . $dateString . ' từ ' . $startTime . ' đến ' . $endTime . '.');
                        }
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
            } else {
                return back()->with('error', 'Định dạng ngày không đúng trong chuỗi: ' . $day);
            }
        }
        return back()->with('success', 'Lịch làm việc được thêm thành công.');
    }



    public function scheduleUpdate(Request $request, $id)
    {

        $validated = $request->validate([
            'dayOfWeek' => 'string',
            'date' => 'date',
            'startTime' => 'date_format:H:i:s',
            'endTime' => 'date_format:H:i:s',
            'isAvailable' => 'boolean',
        ]);

        $schedule = AvailableTimeslot::findOrFail($id);

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
>>>>>>> Stashed changes
    }
    
    public function doctorDestroy($id)
    {
<<<<<<< Updated upstream
        $package = Doctor::findOrFail($id); 

        $package->delete();
        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Variant đã được xóa thành công.');
=======
        $schedule = AvailableTimeslot::findOrFail($id);
        $schedule->delete();
        return response()->json(['message' => 'Lịch làm việc đã được xóa thành công.']);
    }


    // bác sỹ view
    public function physicianManagement($id)
    {
        $user = User::where('id', $id)->first();
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
        if ($user->role == 'Doctor' || $user->role == 'Admin') {
            $doctor = $user->doctor()->with(['timeSlot', 'appoinment'])->first();

            $doctorhtr = $user->doctor()
                ->with([
                    'timeSlot' => function ($query) {
                        $query->whereHas('appoinment');
                    },
                    'appoinment'
                ])->first();

            $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

            $doctors = Doctor::with(['timeSlot' => function ($query) use ($today) {
                $query->whereDate('date', $today)
                    ->whereHas('appoinment', function ($subQuery) {
                        $subQuery->whereNotNull('status_appoinment');
                    });
            }])->findOrFail($doctor->id);

            $doctorrv = Doctor::with('review')->findOrFail($doctor->id);

            return view('client.physicianmanagement.view', compact('doctor', 'doctorhtr', 'doctors', 'doctorrv'));
        } else {
            return redirect()->route('viewBookingDoctor')->with('error', 'Bạn không được cấp quyền truy cập.');
        }
    }

    public function getDetails(Request $request)
    {
        $appointmentId = $request->appointment_id;
        $appointment = Appoinment::with('user', 'doctor')->findOrFail($appointmentId);
        $user = User::where('id', $appointment->user_id)->first();
        $doctor = Doctor::where('id', $appointment->doctor_id)->first();

        return response()->json([
            'user_id' => $user->id,
            'appointment_id' => $appointment->id,
            'doctor_id' => $doctor->id,
        ]);
    }

    public function getPatientInfo(Request $request)
    {
        $appointmentId = $request->input('appointment_id');
        $appointment = Appoinment::where('id', $appointmentId)->first();
        $patient = User::where('id', $appointment->user_id)->first();


        return response()->json([
            'patient' => [
                'name' => $patient->name,
                'phone' => $patient->phone,
                'email' => $patient->email,
            ],
            'appointment' => [
                'reason' => $appointment->reason,
            ],
        ]);
    }


    public function confirmAppointmentHistories(Request $request)
    {
        $appoinmentHistories = new AppoinmentHistory;
        $appoinmentHistories->user_id = $request->user_id;
        $appoinmentHistories->doctor_id = $request->doctor_id;
        $appoinmentHistories->appoinment_id = $request->appoinment_id;
        $appoinmentHistories->diagnosis = $request->diagnosis;
        $appoinmentHistories->prescription = $request->prescription;
        $appoinmentHistories->follow_up_date = $request->follow_up_date;
        $appoinmentHistories->notes = $request->notes;
        $appoinmentHistories->save();

        if (!empty($request->follow_up_date)) {
            $appointment = Appoinment::where('id', $request->appoinment_id)->first();
            $appointment->status_appoinment = 'can_tai_kham';
            $appointment->save();
        } else {
            $appointment = Appoinment::where('id', $request->appoinment_id)->first();
            $appointment->status_appoinment = 'kham_hoan_thanh';
            $appointment->save();
        }

        return redirect()->back();
    }



    public function getPendingAppointments(Request $request)
    {
        $doctorId = $request->doctor_id;

        $doctor = Doctor::with(['timeSlot.appoinment' => function ($query) {
            $query->where('status_appoinment', 'cho_xac_nhan');
        }])->findOrFail($doctorId);

        $doctorhuy = Doctor::with(['timeSlot.appoinment' => function ($query) {
            $query->where('status_appoinment', 'yeu_cau_huy');
        }])->findOrFail($doctorId);

        if ($request->ajax()) {
            return view('client.physicianmanagement.pending', compact('doctor', 'doctorhuy'))->render();
        }

        return view('client.physicianmanagement.index', compact('doctor', 'doctorhuy'));
    }

    public function confirmAppointmentkoden(Request $request)
    {
        $appointment = Appoinment::where('id', $request->appointment_id)->first();
        $appointment->status_appoinment = 'benh_nhan_khong_den';
        $appointment->save();

        return redirect()->back();
    }


    public function confirmAppointment($id)
    {
        $appointment = Appoinment::findOrFail($id);
        $appointment->status_appoinment = 'da_xac_nhan';
        $appointment->save();

        return response()->json(['success' => 'Appointment confirmed successfully.']);
    }

    public function confirmAppointmenthuy($id)
    {
        $appointment = Appoinment::findOrFail($id);
        $appointment->status_appoinment = 'huy_lich_hen';
        $appointment->save();

        $time = AvailableTimeslot::where('id', $appointment->available_timeslot_id)->first();
        $time->isAvailable = 1;
        $time->save();

        return response()->json(['success' => 'Appointment confirmed successfully.']);
    }

    public function getReviewData(Request $request)
    {
        $appointmentId = $request->appointment_id;

        $appointment = Appoinment::with('doctor.user')->findOrFail($appointmentId);

        return response()->json([
            'user_id' => $appointment->user_id,
            'doctor_id' => $appointment->doctor->id,
            'appoinment_id' => $appointment->id,
        ]);
    }

    public function reviewDortor(Request $request)
    {
        $reviewDt = new Review();
        $reviewDt->user_id = $request->user_id;
        $reviewDt->doctor_id = $request->doctor_id;
        $reviewDt->appoinment_id = $request->appoinment_id;
        $reviewDt->rating = $request->rating;
        $reviewDt->comment = $request->comment;
        $reviewDt->save();

        return redirect()->back();
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return response()->json($review);
    }

    public function updateReview(Request $request, $id)
    {
        $data = $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = Review::findOrFail($id);
        $review->update($data);

        return response()->json(['message' => 'Đánh giá đã được cập nhật thành công!']);
>>>>>>> Stashed changes
    }
    
    public function viewTimeslotAdd($id)
    {
        $doctors = Doctor::orderBy('id')->get();
        $doctor = Doctor::find($id);
        return view('admin.specialtyDoctors.timeslot.viewTimeslotAdd', compact('doctor'));
    }
    public function timeslotAdd(Request $request, $doctorId)
{
    $request->validate([
        'dayOfWeek' => 'required|string',
        'startTime' => 'required|date_format:H:i',
        'endTime' => 'required|date_format:H:i|after:startTime',
        'date' => 'nullable|date',
    ]);

    AvailableTimeslot::create([
        'doctor_id' => $doctorId,
        'dayOfWeek' => $request->dayOfWeek,
        'startTime' => $request->startTime,
        'endTime' => $request->endTime,
        'date' => $request->date,
        'isAvailable' => true,
    ]);

    return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Thêm khung giờ thành công.');
}
}
