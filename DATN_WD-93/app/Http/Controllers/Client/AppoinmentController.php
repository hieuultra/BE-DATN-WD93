<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\AppointmentConfirmationMail;
use App\Models\Appoinment;
use App\Models\AppoinmentHistory;
use App\Models\AvailableTimeslot;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\doctorAchievement;
use App\Models\Review;
use App\Models\Specialty;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AppoinmentController extends Controller
{
    function appoinment()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $specialties = Specialty::orderBy('name', 'asc')->get();
        $doctors = Doctor::orderBy('updated_at', 'desc')->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        return view('client.appoinment.index', compact('orderCount', 'categories', 'specialties', 'doctors'));
    }

    public function booKingCare($id)
    {
        $doctors = Doctor::with(['user', 'specialty', 'timeSlot'])
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
        $orderCount = 0;
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count();
        }
        $categories = Category::orderBy('name', 'asc')->get();
        $specialty = Specialty::where('id', $id)->first();
        $clinics = Clinic::all();
        return view('client.appoinment.doctorbooking', compact('doctors', 'specialty', 'categories', 'orderCount', 'clinics'));
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
        $orderCount = 0;
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count();
        }
        $categories = Category::orderBy('name', 'asc')->get();
        $doctorrv = Doctor::with('review')->findOrFail($doctor->id);
        $specialty = Specialty::where('id', $doctor->specialty_id)->first();
        $clinics = Clinic::where('doctor_id', $id)->first();
        $achievements = doctorAchievement::where('doctor_id', $id)->get();
        return view('client.appoinment.doctorDetails', compact('doctor', 'specialty', 'doctorrv', 'orderCount', 'categories', 'clinics', 'achievements'));
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
        $orderCount = 0;
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count();
        }
        $categories = Category::orderBy('name', 'asc')->get();
        return view('client.appoinment.formbookingdt', compact('doctor', 'timeSlot', 'orderCount', 'categories'));
    }

    public function bookAnAppointment(Request $request)
    {
        $dc = $request->tinh_thanh . '-' . $request->quan_huyen . '-' . $request->dia_chi;
        $timeSlotId = AvailableTimeslot::where('id', $request->available_timeslot_id)->first();

        if ($timeSlotId->isAvailable == 0) {
            return redirect()->back()->with('error', 'Thời gian hẹn đã có người đặt. Vui lòng chọn thời gian khác.');
        } else {
            if ($request->lua_chon == "cho_nguoi_than") {
                $appoinment = new Appoinment();
                $appoinment->user_id = $request->user_id;
                $appoinment->doctor_id = $request->doctor_id;
                $appoinment->available_timeslot_id = $request->available_timeslot_id;
                $appoinment->appointment_date = $request->appointment_date;
                $appoinment->notes = $request->notes;
                $appoinment->status_payment_method = $request->status_payment_method;
                $appoinment->classify = 'cho_gia_dinh';
                $appoinment->name = $request->name;
                $appoinment->phone = $request->phone;
                $appoinment->address = $dc;
                $appoinment->save();

                $available = AvailableTimeslot::where('id', $request->available_timeslot_id)->first();
                $user = $request->name;
                Mail::to($request->email)->send(new AppointmentConfirmationMail($user, $appoinment, $available));

                $available = AvailableTimeslot::find($request->available_timeslot_id);
                $available->isAvailable = 0;
                $available->save();

                $orderCount = 0;
                if (Auth::check()) {
                    $user = Auth::user();
                    $orderCount = $user->bill()->count();
                }
                $categories = Category::orderBy('name', 'asc')->get();
                $appointment = Appoinment::with(['doctor', 'user', 'availabelTimeslot'])->findOrFail($appoinment->id);
                return view('client.appoinment.appointment_bill', compact('appointment', 'orderCount', 'categories'));
            } else {
                $appoinment = new Appoinment();
                $appoinment->user_id = $request->user_id;
                $appoinment->doctor_id = $request->doctor_id;
                $appoinment->available_timeslot_id = $request->available_timeslot_id;
                $appoinment->appointment_date = $request->appointment_date;
                $appoinment->notes = $request->notes;
                $appoinment->status_payment_method = $request->status_payment_method;
                $appoinment->classify = 'ban_than';
                $appoinment->save();

                $available = AvailableTimeslot::where('id', $request->available_timeslot_id)->first();
                $user = $request->name;
                Mail::to($request->email)->send(new AppointmentConfirmationMail($user, $appoinment, $available));

                $available = AvailableTimeslot::find($request->available_timeslot_id);
                $available->isAvailable = 0;
                $available->save();

                $orderCount = 1;
                if (Auth::check()) {
                    $user = Auth::user();
                    $orderCount = $user->bill()->count();
                }
                $categories = Category::orderBy('name', 'asc')->get();
                $appointment = Appoinment::with(['doctor', 'user', 'availabelTimeslot'])->findOrFail($appoinment->id);
                return view('client.appoinment.appointment_bill', compact('appointment', 'orderCount', 'categories'));
            }
        }
    }

    public function autocompleteSearch(Request $request)
    {
        $query = $request->input('query');
        $clinics = Specialty::where('name', 'LIKE', '%' . $query . '%')->get();
        return response()->json($clinics);
    }

    public function appointmentHistory($id)
    {
        $orderCount = 1;
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count();
        }
        $categories = Category::orderBy('name', 'asc')->get();
        $appoinments = Appoinment::with('user', 'doctor')->where('user_id', $id)->orderBy('created_at', 'desc')->get();
        $available = AvailableTimeslot::all();
        $reviewDortor = Review::where('user_id', $id)->get();
        $clinics = Clinic::All();
        return view('client.appoinment.appointmentHistory', compact('appoinments', 'available', 'reviewDortor', 'orderCount', 'categories', 'clinics'));
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
                    })
                    ->with(['appoinment.user']);
            }])->findOrFail($doctor->id);

            $doctorrv = Doctor::with('review')->findOrFail($doctor->id);
            $orderCount = 1;
            if (Auth::check()) {
                $user = Auth::user();
                $orderCount = $user->bill()->count();
            }
            $categories = Category::orderBy('name', 'asc')->get();
            $clinic = Clinic::where('doctor_id', $id)->first();
            return view('client.physicianmanagement.view', compact('doctor', 'doctorhtr', 'doctors', 'doctorrv', 'orderCount', 'categories', 'clinic'));
        } else {
            return redirect()->route('viewBookingDoctor')->with('error', 'Bạn không được cấp quyền truy cập.');
        }
    }

    public function confirmAppointmentHistories(Request $request)
    {
        $appoinmentHistories = new AppoinmentHistory();
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

    public function confirmAppointmentkoden(Request $request)
    {
        $appointment = Appoinment::where('id', $request->appointment_id)->first();
        $appointment->status_appoinment = 'benh_nhan_khong_den';
        $appointment->save();

        return redirect()->back();
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

    public function updateReview(Request $request, $id)
    {
        $data = $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = Review::findOrFail($id);
        $review->update($data);

        return response()->json(['message' => 'Đánh giá đã được cập nhật thành công!']);
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

    public function getPendingAppointments(Request $request)
    {
        $doctorId = $request->doctor_id;

        $doctor = Doctor::with(['timeSlot.appoinment' => function ($query) {
            $query->where('status_appoinment', 'cho_xac_nhan');
        }, 'timeSlot.appoinment.user'])
            ->findOrFail($doctorId);

        $doctorhuy = Doctor::with(['timeSlot.appoinment' => function ($query) {
            $query->where('status_appoinment', 'yeu_cau_huy');
        }])->findOrFail($doctorId);

        if ($request->ajax()) {
            return view('client.physicianmanagement.pending', compact('doctor', 'doctorhuy'))->render();
        }

        return view('client.physicianmanagement.pending', compact('doctor', 'doctorhuy'));
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

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return response()->json($review);
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

    public function statistics(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $pricePerAppointment = $doctor->examination_fee;
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

        // Count Positive and Negative Reviews
        $positiveReviewsCount = Review::where('doctor_id', $id)
            ->whereIn('rating', [4, 5])
            ->when($request->filled('date'), fn($q) => $q->whereDate('created_at', $date))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', Carbon::parse($month)->month))
            ->when($request->filled('year'), fn($q) => $q->whereYear('created_at', $year))
            ->count();

        $negativeReviewsCount = Review::where('doctor_id', $id)
            ->whereIn('rating', [1, 2])
            ->when($request->filled('date'), fn($q) => $q->whereDate('created_at', $date))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', Carbon::parse($month)->month))
            ->when($request->filled('year'), fn($q) => $q->whereYear('created_at', $year))
            ->count();

        $neutralReviewsCount = Review::where('doctor_id', $id)
            ->where('rating', 3)
            ->when($request->filled('date'), fn($q) => $q->whereDate('created_at', $date))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', Carbon::parse($month)->month))
            ->when($request->filled('year'), fn($q) => $q->whereYear('created_at', $year))
            ->count();

        $doctorrv = Doctor::with('review')->findOrFail($doctor->id);
        $orderCount = 1;
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count();
        }
        $categories = Category::orderBy('name', 'asc')->get();

        return view('client.appoinment.statistics', compact('doctor', 'averageRating', 'totalRevenue', 'totalComments', 
        'completedAppointments', 'cancelledAppointments', 
        'date', 'month', 'year', 'lostRevenue', 'orderCount', 'categories', 'positiveReviewsCount', 'negativeReviewsCount', 'neutralReviewsCount'));
    }

    public function specialistExamination()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        // Lấy 4 bản ghi đầu tiên
        $firstBatch = Specialty::orderBy('name', 'asc')->take(4)->get();

        // Lấy 4 bản ghi tiếp theo (sau 4 bản ghi đầu tiên)
        $secondBatch = Specialty::orderBy('name', 'asc')->skip(4)->take(4)->get();

        // Lấy 4 bản ghi tiếp sau 8 bản ghi đầu tiên
        $thirdBatch = Specialty::orderBy('name', 'asc')->skip(8)->take(4)->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        return view('client.appoinment.specialist', compact('orderCount', 'categories', 'firstBatch', 'secondBatch', 'thirdBatch'));
    }

    function doctors(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        $specialty_id = $request->input('specialty_id');

        $specialty = Specialty::find($request->specialty_id);
        if ($request->specialty_id) {
            $doctors = Doctor::where('specialty_id', $request->specialty_id)->orderBy('id', 'desc')->paginate(12);
        } else {
            $doctors = Doctor::orderBy('id', 'desc')->paginate(12); //phan trang 9sp/1page
        }
        return view('client.appoinment.doctors', compact('orderCount', 'specialty', 'doctors', 'specialty_id', 'categories'));
    }
}
