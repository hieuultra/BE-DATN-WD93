<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appoinment;
use App\Models\AvailableTimeslot;
use App\Models\Doctor;
use App\Mail\AppointmentConfirmationMail;
use App\Models\AppointmentFamily;
use App\Models\Review;
use Illuminate\Support\Facades\Mail;
use App\Models\Specialty;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Services\MedicalChatService;
use App\Models\User;

class BookingDoctorController extends Controller
{

    public function viewBookingDoctor()
    {
        $specialty = Specialty::where('faculty', 'chuyên khoa')->get();
        $specialtyktx = Specialty::where('faculty', 'khám từ xa')->get();
        $specialtytq = Specialty::where('faculty', 'khám tổng quát')->get();
        $specialtyxnyh = Specialty::where('faculty', 'xét nghiệm ý học')->get();
        return view('client.bookingdoctor.viewbooking', compact('specialty', 'specialtyktx', 'specialtytq', 'specialtyxnyh'));
    }

    public function booKingCare($id)
    {
        $doctors = Doctor::with(['user', 'specialty', 'timeSlot']) // Loại bỏ điều kiện với appointment
            ->whereHas('specialty', function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->get();

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

        $specialty = Specialty::where('id', $id)->first();
        return view('client.bookingdoctor.doctorbooking', compact('doctors', 'specialty'));
    }

    public function formbookingdt($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để tiếp tục.');
        }

        $doctor = Doctor::with('user', 'specialty', 'timeSlot')
            ->whereHas('timeSlot', function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->first();

        $timeSlot = AvailableTimeslot::where('id', $id)->first();

        return view('client.bookingdoctor.formbookingdt', compact('doctor', 'timeSlot'));
    }


    public function bookAnAppointment(Request $request)
    {
        $dc = $request->tinh_thanh . '-' . $request->quan_huyen . '-' . $request->dia_chi;
        $messages = [
            'notes.nullable' => 'Ghi chú có thể để trống',
            'notes.string' => 'Ghi chú phải là chuỗi ký tự',
            'notes.max' => 'Ghi chú không được vượt quá 500 ký tự',
            'name.required' => 'Tên là bắt buộc',
            'name.string' => 'Tên phải là chuỗi ký tự',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'gender.required' => 'Giới tính là bắt buộc',
            'gender.in' => 'Giới tính không hợp lệ',
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.max' => 'Email không được vượt quá 255 ký tự',
            'year_of_birth.required' => 'Năm sinh là bắt buộc',
            'year_of_birth.date_format' => 'Năm sinh không hợp lệ',
            'tinh_thanh.required' => 'Tỉnh/Thành là bắt buộc',
            'tinh_thanh.string' => 'Tỉnh/Thành phải là chuỗi ký tự',
            'tinh_thanh.max' => 'Tỉnh/Thành không được vượt quá 255 ký tự',
            'quan_huyen.required' => 'Quận/Huyện là bắt buộc',
            'quan_huyen.string' => 'Quận/Huyện phải là chuỗi ký tự',
            'quan_huyen.max' => 'Quận/Huyện không được vượt quá 255 ký tự',
            'dia_chi.required' => 'Địa chỉ là bắt buộc',
            'dia_chi.string' => 'Địa chỉ phải là chuỗi ký tự',
            'dia_chi.max' => 'Địa chỉ không được vượt quá 255 ký tự',
        ];

        $validatedData = $request->validate([
            'notes' => 'nullable|string|max:500',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:nam,Nữ',
            'phone' => 'required',
            'email' => 'required|email|max:255',
            'year_of_birth' => 'required|date_format:Y',
            'tinh_thanh' => 'required|string|max:255',
            'quan_huyen' => 'required|string|max:255',
            'dia_chi' => 'required|string|max:255'
        ], $messages);


        $timeSlotId = AvailableTimeslot::where('id', $request->available_timeslot_id)->first();

        if ($timeSlotId->isAvailable == 0) {
            return redirect()->back()->with('error', 'Thời gian hẹn đã có người đặt. Vui lòng chọn thời gian khác.');
        } else {
            if ($request->lua_chon == "cho_nguoi_than") {
                $appoinment = new Appoinment();
                $appoinment->user_id = $request->user_id;
                $appoinment->doctor_id = $request->doctor_id;
                $appoinment->available_timeslot_id = $request->available_timeslot_id;
                $appoinment->notes = $request->notes;
                $appoinment->status_payment_method = $request->status_payment_method;
                $appoinment->gender = $request->gender;
                $appoinment->year_of_birth = $request->year_of_birth;
                $appoinment->classify = 'cho_gia_dinh';
                $appoinment->name = $request->name;
                $appoinment->email = $request->email;
                $appoinment->phone = $request->phone;
                $appoinment->save();

                $available = AvailableTimeslot::where('id', $request->available_timeslot_id)->first();
                $user = $request->name;
                Mail::to($request->email)->send(new AppointmentConfirmationMail($user, $appoinment, $available));

                $available = AvailableTimeslot::find($request->available_timeslot_id);
                $available->isAvailable = 0;
                $available->save();
                return redirect()->route('viewBookingDoctor')->with('success', 'Đặt lịch thành công vu lòng kiểm tra email để biết thêm');
            } else {
                $appoinment = new Appoinment();
                $appoinment->user_id = $request->user_id;
                $appoinment->doctor_id = $request->doctor_id;
                $appoinment->available_timeslot_id = $request->available_timeslot_id;
                $appoinment->notes = $request->notes;
                $appoinment->status_payment_method = $request->status_payment_method;
                $appoinment->gender = $request->gender;
                $appoinment->year_of_birth = $request->year_of_birth;
                $appoinment->classify = 'ban_than';
                $appoinment->save();

                $available = AvailableTimeslot::where('id', $request->available_timeslot_id)->first();
                $user = $request->name;
                Mail::to($request->email)->send(new AppointmentConfirmationMail($user, $appoinment, $available));

                $available = AvailableTimeslot::find($request->available_timeslot_id);
                $available->isAvailable = 0;
                $available->save();
                return redirect()->route('viewBookingDoctor')->with('success', 'Đặt lịch thành công vu lòng kiểm tra email để biết thêm');
            }
        }
    }

    public function doctorDetails($id)
    {
        $doctor = Doctor::with(['user', 'specialty', 'timeSlot' => function ($query) {
            $query->whereDoesntHave('appoinment');
        }])
            ->where('id', $id)
            ->first();

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

        $doctorrv = Doctor::with('review')->findOrFail($doctor->id);
        $specialty = Specialty::where('id', $doctor->specialty_id)->first();
        return view('client.bookingdoctor.doctorDetails', compact('doctor', 'specialty', 'doctorrv'));
    }

    public function appointmentHistory($id)
    {
        $appoinments = Appoinment::with('user', 'doctor')->where('user_id', $id)->orderBy('created_at', 'desc')->get();
        $available = AvailableTimeslot::all();
        $reviewDortor = Review::where('user_id', $id)->get();
        return view('client.bookingdoctor.appointmentHistory', compact('appoinments', 'available', 'reviewDortor'));
    }

    public function autocompleteSearch(Request $request)
    {
        $query = $request->input('query');
        $clinics = Specialty::where('name', 'LIKE', '%' . $query . '%')->get();
        return response()->json($clinics);
    }

    public function cancel(Request $request, $id)
    {
        $appointment = Appoinment::findOrFail($id);
        $appointment->status_appoinment = 'yeu_cau_huy';
        $appointment->notes = $request->notes;
        $appointment->save();

        $time = AvailableTimeslot::where('id', $appointment->available_timeslot_id)->first();
        $time->isAvailable = 0;
        $time->save();

        return response()->json(['success' => true]);
    }

    public function generalExamination()
    {
        $specialtytq = Specialty::where('faculty', 'khám tổng quát')->get();
        return view('client.bookingdoctor.generalExamination', compact('specialtytq'));
    }

    public function statistics(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $pricePerAppointment = $doctor->price;
        $date = $request->input('date', Carbon::now()->format('Y-m-d'));
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $year = $request->input('year', Carbon::now()->year);
        $completedAppointments = Appoinment::where('doctor_id', $id)
            ->whereIn('status_appoinment', ['kham_hoan_thanh', 'can_tai_kham'])
            ->when($request->filled('date'), fn($q) => $q->whereDate('created_at', $date))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', Carbon::parse($month)->month))
            ->when($request->filled('year'), fn($q) => $q->whereYear('created_at', $year))
            ->count();

        $totalRevenue = $completedAppointments * $pricePerAppointment;

        $totalComments = Review::where('doctor_id', $id)
            ->when($request->filled('date'), fn($q) => $q->whereDate('created_at', $date))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', Carbon::parse($month)->month))
            ->when($request->filled('year'), fn($q) => $q->whereYear('created_at', $year))
            ->count();

        $cancelledAppointments = Appoinment::where('doctor_id', $id)
            ->where('status_appoinment', 'huy_lich_hen')
            ->when($request->filled('date'), fn($q) => $q->whereDate('created_at', $date))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', Carbon::parse($month)->month))
            ->when($request->filled('year'), fn($q) => $q->whereYear('created_at', $year))
            ->count();

        $noShowAppointments = Appoinment::where('doctor_id', $id)
            ->whereIn('status_appoinment', ['huy_lich_hen', 'benh_nhan_khong_den'])
            ->when($request->filled('date'), fn($q) => $q->whereDate('created_at', $date))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', Carbon::parse($month)->month))
            ->when($request->filled('year'), fn($q) => $q->whereYear('created_at', $year))
            ->count();

        
        $lostRevenue = $noShowAppointments * $pricePerAppointment;

        
        $averageRating = Review::where('doctor_id', $id)
            ->when($request->filled('date'), fn($q) => $q->whereDate('created_at', $date))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', Carbon::parse($month)->month))
            ->when($request->filled('year'), fn($q) => $q->whereYear('created_at', $year))
            ->avg('rating'); 

        return view('client.bookingdoctor.statistics', compact('doctor', 'averageRating', 'totalRevenue', 'totalComments', 'completedAppointments', 'cancelledAppointments', 'date', 'month', 'year', 'lostRevenue'));
    }
}
