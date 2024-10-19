<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailableTimeslot;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user', 'specialty')->get();
        $specialties = Specialty::withCount('doctor')->get();
        return view('admin.doctors.view', compact('doctors', 'specialties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^(0[3|5|7|8|9]|01[2|6|8|9])[0-9]{8}$/',
            'email' => 'required|string|email|unique:users',
            'specialty_id' => 'required|exists:specialties,id',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8',
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

        try {
            $user = new User();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
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
                'bio' => $validated['bio'],
            ]);

            $doctor->load('user', 'specialty'); // Tải lại thông tin user và specialty của bác sĩ

            return response()->json([
                'success' => true,
                'doctor' => $doctor, // Trả về đối tượng bác sĩ đã được tạo
                'message' => 'Thêm bác sĩ thành công!' // Thêm thông báo thành công
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình thêm bác sĩ: ' . $e->getMessage(),
            ], 500);
        }
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
            'bio' => $validated['bio'],
        ]);

        $doctor->load('user', 'specialty'); // Tải lại thông tin bác sĩ và specialty
        return response()->json([
            'success' => true,
            'doctor' => $doctor // Đây là đối tượng bác sĩ đã cập nhật
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







    // lịch làm việc
    public function showSchedule($doctorId)
    {
        $schedules = AvailableTimeslot::where('doctor_id', $doctorId)->get();
        $doctor = Doctor::with('user', 'specialty')->findOrFail($doctorId);
        return view('admin.doctors.schedule', compact('schedules', 'doctor'));
    }

    public function scheduleAdd(Request $request)
    {
        $validatedData = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'dayOfWeek' => 'required|string',
            'startTime' => 'required|string',
            'endTime' => 'required|string',
            'date' => 'required|date',
            'isAvailable' => 'required|boolean',
        ]);

        $schedule = AvailableTimeslot::create($validatedData);
        return response()->json(['success' => true, 'schedule' => $schedule]);
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
    }

    public function scheduleDestroy($id)
    {
        $schedule = AvailableTimeslot::findOrFail($id);
        $schedule->delete();
        return response()->json(['success' => true]);
    }
}
