<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\AppointmentConfirmationMail;
use App\Models\Appoinment;
use App\Models\AppoinmentHistory;
use App\Models\AvailableTimeslot;
use App\Models\Bill;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\doctorAchievement;
use App\Models\OrderDetail;
use App\Models\Package;
use App\Models\Review;
use App\Models\Specialty;
use App\Models\User;
use App\Models\VariantProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppoinmentController extends Controller
{
    public function appoinment()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $specialties = Specialty::where('classification', 'chuyen_khoa')->orderBy('name', 'asc')->get();
        $specialtiestx = Specialty::where('classification', 'kham_tu_xa')->orderBy('name', 'asc')->get();
        $specialtiestq = Specialty::where('classification', 'tong_quat')->orderBy('name', 'asc')->get();
        $doctors = Doctor::with('user', 'specialty')
            ->withCount('appoinment')
            ->orderBy('appoinment_count', 'desc')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        $orderCount = 0; // Biến kiểm tra số đơn hợp lệ
        $notification = null;

        if (Auth::check()) {
            $user = Auth::user();

            // Đếm số lịch hẹn hợp lệ của người dùng
            $orderCount = DB::table('appoinments')
                ->where('user_id', $user->id)
                ->whereIn('status_appoinment', ['kham_hoan_thanh', 'can_tai_kham', 'huy_lich_hen', 'benh_nhan_khong_den'])
                ->count();

            // Thống kê tỷ lệ hoàn thành của người dùng
            $completionStats = DB::table('appoinments')
                ->where('user_id', $user->id)
                ->select(
                    'user_id',
                    DB::raw('COUNT(*) as total_appointments'),
                    DB::raw('SUM(CASE WHEN status_appoinment IN ("kham_hoan_thanh", "can_tai_kham") THEN 1 ELSE 0 END) as completed'),
                    DB::raw('SUM(CASE WHEN status_appoinment IN ("huy_lich_hen", "benh_nhan_khong_den") THEN 1 ELSE 0 END) as cancelled_or_missed'),
                    DB::raw('ROUND(
                    SUM(CASE WHEN status_appoinment IN ("kham_hoan_thanh", "can_tai_kham") THEN 1 ELSE 0 END) / 
                    NULLIF(SUM(CASE WHEN status_appoinment IN ("huy_lich_hen", "benh_nhan_khong_den", "kham_hoan_thanh", "can_tai_kham") THEN 1 ELSE 0 END), 0) * 100, 2
                ) as completion_rate')
                )
                ->groupBy('user_id')
                ->first();

            // Kiểm tra nếu người dùng là người dùng mới hay cũ
            if ($orderCount < 3) {
                $notification = 'Bạn là người mới chỉ được đặt lịch khám tối đa 3 lần với 1 bác sĩ trong một ngày.';
            } else if ($completionStats) {
                if ($completionStats->completion_rate < 50) {
                    $notification = 'Uy tín của bạn quá thấp, chỉ được đặt tối đa mỗi bác sĩ 1 lịch khám trong 1 ngày và phải thanh toán qua VNPay.';
                } elseif ($completionStats->completion_rate >= 50 && $completionStats->completion_rate < 70) {
                    $notification = 'Uy tín của bạn đang ở mức trung bình, chỉ được đặt tối đa mỗi bác sĩ 3 lịch khám trong 1 ngày.';
                } else {
                    $notification = 'Bạn có độ uy tín cao, không có giới hạn đặt lịch.';
                }
            }

            // **Kiểm tra xem thông báo đã được hiển thị hay chưa**
            if (!session()->has('has_seen_appoinment_notification') && !empty($notification)) {
                // Lưu thông báo và đánh dấu rằng thông báo đã được xem
                session()->put('has_seen_appoinment_notification', $notification);
            }

            return view('client.appoinment.index', compact(
                'completionStats',
                'orderCount',
                'categories',
                'specialties',
                'doctors',
                'specialtiestx',
                'specialtiestq',
                'notification'
            ));
        } else {
            return view('client.appoinment.index', compact(
                'orderCount',
                'categories',
                'specialties',
                'doctors',
                'specialtiestx',
                'specialtiestq'
            ));
        }
    }





    public function searchap(Request $request)
    {
        $query = $request->get('query');

        $results = Doctor::with(['specialty', 'user'])
            ->whereHas('user', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('specialty', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->get();


        $data = $results->map(function ($item) {
            return [
                'id' => $item->id,
                'doctor_name' => $item->user->name,
                'specialty_name' => $item->specialty->name,
                'specialty_id' => $item->specialty->id,
            ];
        });

        return response()->json($data);
    }

    public function booKingCare($id)
    {
        $doctors = Doctor::with(['user', 'specialty', 'timeSlot'])
            ->whereHas('specialty', function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->whereHas('timeSlot', function ($query) {
                $query->where('isAvailable', 1);
            })
            ->get();

        $now = Carbon::now('Asia/Ho_Chi_Minh');

        AvailableTimeslot::where('date', '<', $now->toDateString())
            ->orWhere(function ($query) use ($now) {
                $query->where('date', '=', $now->toDateString())
                    ->where('startTime', '<', $now->toTimeString());
            })
            ->update(['isAvailable' => 0]);

        $orderCount = Auth::check() ? Auth::user()->bill()->count() : 0;
        $categories = Category::orderBy('name', 'asc')->get();
        $specialty = Specialty::findOrFail($id);
        $clinics = Clinic::all();

        return view('client.appoinment.doctorbooking', compact('doctors', 'specialty', 'categories', 'orderCount', 'clinics'));
    }


    public function booKingCarePackage($id)
    {
        $packages = Package::with(['specialty', 'timeSlot'])
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
        return view('client.appoinment.booKingCarePackage', compact('packages', 'specialty', 'categories', 'orderCount'));
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

    public function packaceDetails($id)
    {
        $package = Package::with(['specialty', 'timeSlot' => function ($query) {
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
        $packagerv = Package::with('review')->findOrFail($package->id);
        $specialty = Specialty::where('id', $package->specialty_id)->first();
        return view('client.appoinment.packaceDetails', compact('package', 'packagerv', 'specialty', 'orderCount', 'categories'));
    }

    public function formbookingdt($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để tiếp tục.');
        }

        $timeSlot = AvailableTimeslot::where('id', $id)->first();

        if (!$timeSlot) {
            return redirect()->back()->with('error', 'Khung giờ không hợp lệ.');
        }

        $user = auth()->user();
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $todayStart = $now->copy()->startOfDay();
        $todayEnd = $now->copy()->endOfDay();
        $orderCount = 0;
        if (Auth::check()) {
            $orderCount = $user->bill()->count();
        }

        $categories = Category::orderBy('name', 'asc')->get();

        $existingAppointment = Appoinment::where('user_id', $user->id)
            ->whereHas('timeSlot', function ($query) use ($timeSlot) {
                $query->where('startTime', $timeSlot->startTime)
                    ->where('date', $timeSlot->date);
            })
            ->where('doctor_id', '!=', $timeSlot->doctor_id)
            ->first();

        $doctor = Doctor::with('user', 'specialty', 'timeSlot')
            ->whereHas('timeSlot', function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->first();

        $totalAppointments = DB::table('appoinments')
            ->where('user_id', $user->id)
            ->whereIn('status_appoinment', ['kham_hoan_thanh', 'can_tai_kham', 'huy_lich_hen', 'benh_nhan_khong_den'])
            ->count();

        $isNewUser = $totalAppointments < 3;
        $appointmentsToday = Appoinment::where('user_id', $user->id)
            ->where('doctor_id', $timeSlot->doctor_id)
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->count();

        if ($isNewUser) {
            $remainingAppointments = 3 - $appointmentsToday;

            if ($appointmentsToday >= 3) {
                return redirect()->back()->with('jsError', 'Bạn đã đạt giới hạn 3 lần đặt lịch với bác sĩ này hôm nay.');
            } else {
                $notification = 'Bạn có thể đặt thêm ' . $remainingAppointments . ' lần nữa với bác sĩ này hôm nay.';
                return view('client.appoinment.formbookingdt', compact('doctor', 'timeSlot', 'orderCount', 'categories', 'notification'))
                    ->with('existingAppointment', $existingAppointment)
                    ->with('jsError', 'Bạn đã đặt lịch khám với bác sĩ khác vào thời điểm này.');
            }
        }

        $completionStats = DB::table('appoinments')
            ->where('user_id', $user->id)
            ->select(
                'user_id',
                DB::raw('COUNT(*) as total_appointments'),
                DB::raw('SUM(CASE WHEN status_appoinment IN ("kham_hoan_thanh", "can_tai_kham") THEN 1 ELSE 0 END) as completed'),
                DB::raw('SUM(CASE WHEN status_appoinment IN ("huy_lich_hen", "benh_nhan_khong_den") THEN 1 ELSE 0 END) as cancelled_or_missed'),
                DB::raw('ROUND(
                SUM(CASE WHEN status_appoinment IN ("kham_hoan_thanh", "can_tai_kham") THEN 1 ELSE 0 END) /
                NULLIF(SUM(CASE WHEN status_appoinment IN ("huy_lich_hen", "benh_nhan_khong_den", "kham_hoan_thanh", "can_tai_kham") THEN 1 ELSE 0 END), 0) * 100, 2
            ) as completion_rate')
            )
            ->groupBy('user_id')
            ->first();

        $completionRate = $completionStats->completion_rate ?? 0;

        $appointmentsToday = Appoinment::where('user_id', $user->id)
            ->where('doctor_id', $timeSlot->doctor_id)
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->count();

        if (!$completionStats) {
            if ($appointmentsToday >= 3) {
                return redirect()->back()->with('jsError', 'Bạn đã đạt giới hạn đặt lịch với bác sĩ này hôm nay (tối đa 3 lần).');
            }
        } else {
            if ($completionRate >= 70) {
            } elseif ($completionRate >= 50) {
                if ($appointmentsToday >= 3) {
                    return redirect()->back()->with('jsError', 'Bạn đã đạt giới hạn đặt lịch với bác sĩ này hôm nay (tối đa 3 lần).');
                }
            } else {
                if ($appointmentsToday >= 1) {
                    return redirect()->back()->with('jsError', 'Bạn đã đạt giới hạn đặt lịch với bác sĩ này hôm nay (tối đa 1 lần).');
                }
            }
        }

        return view('client.appoinment.formbookingdt', compact('doctor', 'timeSlot', 'orderCount', 'categories'))
            ->with('existingAppointment', $existingAppointment)
            ->with('jsError', 'Bạn đã đặt lịch khám với bác sĩ khác vào thời điểm này.');
    }




    public function formbookingPackage($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để tiếp tục.');
        }

        $package = Package::with('specialty', 'timeSlot')
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
        return view('client.appoinment.formbookingPackage', compact('package', 'timeSlot', 'orderCount', 'categories'));
    }

    public function bookAnAppointment(Request $request)
    {
        $dc = $request->tinh_thanh . '-' . $request->quan_huyen . '-' . $request->dia_chi;
        $timeSlotId = AvailableTimeslot::where('id', $request->available_timeslot_id)->first();
        $doctor = Doctor::where('id', $request->doctor_id)->first();
        $specialtie = Specialty::where('id', $doctor->specialty_id)->first();

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
                $appoinment->status_payment_method = $request->status_payment_method_nn;
                $appoinment->classify = 'cho_gia_dinh';
                $appoinment->name = $request->name;
                $appoinment->phone = $request->phone;
                $appoinment->address = $dc;
                if ($specialtie->classification == 'kham_tu_xa') {
                    $meetLink = 'https://meet.jit.si/' . uniqid();
                    $appoinment->meet_link = $meetLink;
                }
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
                $appointment = Appoinment::with(['doctor', 'user', 'timeSlot'])->findOrFail($appoinment->id);
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
                if ($specialtie->classification == 'kham_tu_xa') {
                    $meetLink = 'https://meet.jit.si/' . uniqid();
                    $appoinment->meet_link = $meetLink;
                }
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
                $appointment = Appoinment::with(['doctor', 'user', 'timeSlot'])->findOrFail($appoinment->id);
                return view('client.appoinment.appointment_bill', compact('appointment', 'orderCount', 'categories'));
            }
        }
    }

    public function bookAnAppointmentPackage(Request $request)
    {
        $dc = $request->tinh_thanh . '-' . $request->quan_huyen . '-' . $request->dia_chi;
        $timeSlotId = AvailableTimeslot::where('id', $request->available_timeslot_id)->first();
        $package = Package::where('id', $request->package_id)->first();
        $specialtie = Specialty::where('id', $package->specialty_id)->first();

        if ($timeSlotId->isAvailable == 0) {
            return redirect()->back()->with('error', 'Thời gian hẹn đã có người đặt. Vui lòng chọn thời gian khác.');
        } else {
            if ($request->lua_chon == "cho_nguoi_than") {
                $appoinment = new Appoinment();
                $appoinment->user_id = $request->user_id;
                $appoinment->available_timeslot_id = $request->available_timeslot_id;
                $appoinment->appointment_date = $request->appointment_date;
                $appoinment->notes = $request->notes;
                $appoinment->status_payment_method = $request->status_payment_method;
                $appoinment->classify = 'cho_gia_dinh';
                $appoinment->name = $request->name;
                $appoinment->phone = $request->phone;
                $appoinment->address = $dc;
                if ($specialtie->classification == 'kham_tu_xa') {
                    $meetLink = 'https://meet.jit.si/' . uniqid();
                    $appoinment->meet_link = $meetLink;
                }
                $appoinment->package_id = $request->package_id;
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
                $appointment = Appoinment::with(['doctor', 'user', 'timeSlot'])->findOrFail($appoinment->id);
                return view('client.appoinment.appointment_bill', compact('appointment', 'orderCount', 'categories'));
            } else {
                $appoinment = new Appoinment();
                $appoinment->user_id = $request->user_id;
                $appoinment->available_timeslot_id = $request->available_timeslot_id;
                $appoinment->appointment_date = $request->appointment_date;
                $appoinment->notes = $request->notes;
                $appoinment->status_payment_method = $request->status_payment_method;
                $appoinment->classify = 'ban_than';
                if ($specialtie->classification == 'kham_tu_xa') {
                    $meetLink = 'https://meet.jit.si/' . uniqid();
                    $appoinment->meet_link = $meetLink;
                }
                $appoinment->package_id = $request->package_id;
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
                $appointment = Appoinment::with(['doctor', 'user', 'timeSlot'])->findOrFail($appoinment->id);
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

    public function doctorDetailsall()
    {
        $orderCount = 1;
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count();
        }
        $categories = Category::orderBy('name', 'asc')->get();

        $doctors = Doctor::with(['specialty', 'user'])->get();
        $specialties = Specialty::whereIn('classification', ['chuyen_khoa', 'tong_quat', 'kham_tu_xa'])->get();
        return view('client.appoinment.allDoctor', compact('orderCount', 'categories', 'doctors', 'specialties'));
    }

    public function fetchHistory($appointmentId)
    {
        $histories = AppoinmentHistory::where('appoinment_id', $appointmentId)->get();
        if ($histories->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No history found.']);
        }
        return response()->json(['success' => true, 'histories' => $histories]);
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

        $doctor = Doctor::where('user_id', $id)->first();

        $latestAppointments = DB::table('appoinments')
            ->where('doctor_id', $doctor->id)
            ->select('user_id', DB::raw('MAX(created_at) as latest_appointment'))
            ->groupBy('user_id');


        $users = DB::table('users')
            ->joinSub($latestAppointments, 'latest', function ($join) {
                $join->on('users.id', '=', 'latest.user_id');
            })
            ->select('users.*', 'latest.latest_appointment')
            ->orderBy('latest.latest_appointment', 'desc')
            ->get();

        $completionStats = DB::table('appoinments')
            ->select(
                'user_id',
                DB::raw('COUNT(*) as total_appointments'),
                DB::raw('SUM(CASE WHEN status_appoinment IN ("kham_hoan_thanh", "can_tai_kham") THEN 1 ELSE 0 END) as completed'),
                DB::raw('SUM(CASE WHEN status_appoinment IN ("huy_lich_hen", "benh_nhan_khong_den") THEN 1 ELSE 0 END) as cancelled_or_missed'),
                DB::raw('ROUND(
                    SUM(CASE WHEN status_appoinment IN ("kham_hoan_thanh", "can_tai_kham") THEN 1 ELSE 0 END) /
                    NULLIF(SUM(CASE WHEN status_appoinment IN ("huy_lich_hen", "benh_nhan_khong_den", "kham_hoan_thanh", "can_tai_kham") THEN 1 ELSE 0 END), 0) * 100, 2
                ) as completion_rate')
            )
            ->groupBy('user_id')
            ->get();

        foreach ($expiredSchedules as $schedule) {
            $schedule->isAvailable = 0;
            $schedule->save();
        }
        if ($user->role == 'Doctor') {
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


            $yesterday = Carbon::yesterday('Asia/Ho_Chi_Minh')->format('Y-m-d');

            $doctorlt = Doctor::with(['timeSlot' => function ($query) use ($yesterday) {
                $query->whereDate('date', '<=', $yesterday)
                    ->whereHas('appoinment', function ($subQuery) {
                        $subQuery->where('status_appoinment', 'da_xac_nhan'); 
                    })
                    ->with(['appoinment' => function ($appQuery) {
                        $appQuery->where('status_appoinment', 'da_xac_nhan') 
                            ->with('user');
                    }]);
            }])->findOrFail($doctor->id);

            $doctorrv = Doctor::with('review')->findOrFail($doctor->id);
            $orderCount = 1;
            if (Auth::check()) {
                $user = Auth::user();
                $orderCount = $user->bill()->count();
            }
            $categories = Category::orderBy('name', 'asc')->get();
            $clinic = Clinic::where('doctor_id', $doctors->id)->first();
            return view('client.physicianmanagement.view', compact('completionStats', 'doctor', 'users', 'doctorhtr', 'doctors', 'doctorrv', 'orderCount', 'categories', 'clinic', 'doctorlt'));
        } else {
            return redirect()->route('appoinment.index')->with('error', 'Bạn không được cấp quyền truy cập.');
        }
    }


    public function loadTodayAppointments(Request $request)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $doctors = Doctor::with(['timeSlot' => function ($query) use ($today) {
            $query->whereDate('date', $today)
                ->whereHas('appoinment', function ($subQuery) {
                    $subQuery->whereNotNull('status_appoinment');
                })
                ->with(['appoinment.user']);
        }])->findOrFail($request->doctor_id);

        return view('client.physicianmanagement.today-appointments', compact('doctors'))->render();
    }


    public function physicianManagementdoctor($id1, $id2)
    {
        $orderCount = 1;
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count();
        }
        $categories = Category::orderBy('name', 'asc')->get();

        $user = User::where('id', $id1)->first();

        $appoinments = Appoinment::where('user_id', $id1)->where('doctor_id', $id2)
            ->with(['doctor', 'timeSlot'])
            ->get();

        $appoinmentsStats = Appoinment::selectRaw('status_appoinment, COUNT(*) as count')
            ->where('user_id', $id1)
            ->where('doctor_id', $id2)
            ->groupBy('status_appoinment')
            ->get();


        $timeSlot = DB::table('available_timeslots')->get();

        return view('client.physicianmanagement.viewdoctor', compact('timeSlot', 'orderCount', 'categories', 'user', 'appoinments', 'appoinmentsStats'));
    }

    public function cancelAppointment($id)
    {
        $appointment = Appoinment::where('id', $id)->first();
        $timeSlot = AvailableTimeslot::where('id', $appointment->available_timeslot_id)->first();
        $timeSlot->isAvailable = 1;
        $timeSlot->save();
        try {
            $appointment = Appoinment::findOrFail($id);
            $appointment->status_appoinment = 'huy_lich_hen';
            $appointment->save();

            return response()->json(['success' => true, 'message' => 'Lịch hẹn đã được hủy.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra khi hủy lịch hẹn.']);
        }
    }

    function generateUniqueOrderCode()
    {
        do {
            $orderCode = 'ORD-' . Auth::id() . '-' . now()->timestamp;
        } while (Bill::where('billCode', $orderCode)->exists());
        return $orderCode;
    }


    public function confirmAppointmentHistories(Request $request)
    {
        if (!$request->has(['user_id', 'doctor_id', 'appoinment_id', 'total_price', 'order_details'])) {
            return back()->withErrors('Thiếu dữ liệu yêu cầu.');
        }

        $user = User::find($request->user_id);
        if (!$user) {
            return back()->withErrors('Không tìm thấy người dùng.');
        }
            
        $appointment = Appoinment::where('id', $request->appoinment_id)->first();
        try {
            $bill = new Bill();
            $bill->billCode = $this->generateUniqueOrderCode();
            $bill->user_id = $user->id;
            $bill->addressUser = $user->address;
            $bill->phoneUser = $user->phone;
            $bill->nameUser = $user->name;
            $bill->emailUser = $user->email;
            $bill->totalPrice = $request->total_price;
        
           
            if ($appointment->meet_link) {
                $bill->status_bill = 'cho_xac_nhan';  
                $bill->status_payment_method = 'chua_thanh_toan';  
            } else {
                $bill->status_bill = 'da_giao_hang';  
                $bill->status_payment_method = 'da_thanh_toan';  
            }
        
            $bill->moneyProduct = $request->total_price;
            $bill->moneyShip = '0';  
            $bill->save();
        
            return back()->with('success', 'Hóa đơn đã được tạo thành công.');
        } catch (\Exception $e) {
            // Xử lý khi có lỗi
            return back()->withErrors('Lỗi khi tạo hóa đơn: ' . $e->getMessage());
        }
        

        $orderDetails = $request->input('order_details');
        $formattedOrderDetails = [];


        $tempOrder = [];
        foreach ($orderDetails as $item) {
            $key = array_key_first($item);
            $tempOrder[$key] = $item[$key];

            if (count($tempOrder) === 5) {
                $formattedOrderDetails[] = $tempOrder;
                $tempOrder = [];
            }
        }

        foreach ($formattedOrderDetails as $detail) {
            OrderDetail::create([
                'bill_id' => $bill->id,
                'product_id' => $detail['product_id'],
                'unitPrice' => $detail['unit_price'],
                'quantity' => $detail['quantity'],
                'totalMoney' => $detail['total_money'],
                'variant_id' => $detail['variant_id'],
            ]);

            $variantProduct = VariantProduct::find($detail['variant_id']);

            if ($variantProduct) {
                $variantProduct->quantity -= $detail['quantity'];
                $variantProduct->save();
            }
        }


        try {
            $appoinmentHistories = new AppoinmentHistory();
            $appoinmentHistories->user_id = $request->user_id;
            $appoinmentHistories->doctor_id = $request->doctor_id;
            $appoinmentHistories->appoinment_id = $request->appoinment_id;
            $appoinmentHistories->diagnosis = $request->diagnosis;
            $appoinmentHistories->prescription = $bill->id;
            $appoinmentHistories->follow_up_date = $request->selected_date;
            $appoinmentHistories->notes = $request->notes;
            $appoinmentHistories->save();
        } catch (\Exception $e) {
            return back()->withErrors('Lỗi khi lưu lịch sử cuộc hẹn: ' . $e->getMessage());
        }



        if (!empty($request->selected_time_slot_id)) {
            $appointment = Appoinment::where('id', $request->appoinment_id)->first();
            $appointment->status_appoinment = 'can_tai_kham';
            $appointment->save();

            if ($appointment->classify == 'ban_than') {
                $appoinments = new Appoinment();
                $appoinments->user_id = $request->user_id;
                $appoinments->doctor_id = $request->doctor_id;
                $appoinments->available_timeslot_id = $request->selected_time_slot_id;
                $appoinments->appointment_date = $request->selected_date;
                $appoinments->notes = 'Cần tái khám';
                $appoinments->status_appoinment = 'da_xac_nhan';
                $appoinments->status_payment_method = 'thanh_toan_tai_benh_vien';
                $appoinments->classify = 'ban_than';
                $appoinments->save();

                $timeSlot = AvailableTimeslot::where('id', $request->selected_time_slot_id)->first();
                $timeSlot->isAvailable = 0;
                $timeSlot->save();
            } else {
                $appoinments = new Appoinment();
                $appoinments->user_id = $request->user_id;
                $appoinments->doctor_id = $request->doctor_id;
                $appoinments->available_timeslot_id = $request->selected_time_slot_id;
                $appoinments->appointment_date = $request->selected_date;
                $appoinments->notes = 'Cần tái khám';
                $appoinments->status_appoinment = 'da_xac_nhan';
                $appoinments->status_payment_method = 'thanh_toan_tai_benh_vien';
                $appoinments->classify = 'cho_gia_dinh';

                $appoinments->name = $appointment->name;
                $appoinments->phone = $appointment->phone;
                $appoinments->address = $appointment->address;
                $appoinments->save();

                $timeSlot = AvailableTimeslot::where('id', $request->selected_time_slot_id)->first();
                $timeSlot->isAvailable = 0;
                $timeSlot->save();
            }
        } else {
            $appointment = Appoinment::where('id', $request->appoinment_id)->first();
            $appointment->status_appoinment = 'kham_hoan_thanh';
            $appointment->save();
        }

        return redirect()->back()->with('success', 'Xác nhận thành công.');
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
            'user_name' => $user->name,
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

        return redirect()->back()->with('success', 'Lịch hẹn đã được xác nhận thành công.');
    }

    public function confirmAppointmenthuy($id)
    {
        $appointment = Appoinment::findOrFail($id);
        $appointment->status_appoinment = 'huy_lich_hen';
        $appointment->save();

        $time = AvailableTimeslot::where('id', $appointment->available_timeslot_id)->first();
        $time->isAvailable = 1;
        $time->save();

        return redirect()->back()->with('success', 'Lịch hẹn đã được xác nhận hủy.');
    }

    public function getAppointmentHistory($appointment_id)
    {
        $appointmentHistory = AppoinmentHistory::where('appoinment_id', $appointment_id)->first();

        if (!$appointmentHistory) {
            return response()->json(['error' => 'Không tìm thấy thông tin lịch hẹn.'], 404);
        }

        $bill = Bill::where('id', $appointmentHistory->prescription)->first();

        if (!$bill) {
            return response()->json(['error' => 'Không tìm thấy hóa đơn liên quan.'], 404);
        }

        $orderDetails = OrderDetail::with('product')
            ->where('bill_id', $bill->id)
            ->get();


        $formattedOrderDetails = $orderDetails->map(function ($order) {
            return [
                'product_id' => $order->product_id,
                'product_name' => $order->product->name,
                'variant_id' => $order->variant_id,
                'unit_price' => $order->unitPrice,
                'quantity' => $order->quantity,
                'total_money' => $order->totalMoney,
            ];
        });

        return response()->json([
            'appoinment_id' => $appointmentHistory->appoinment_id,
            'diagnosis' => $appointmentHistory->diagnosis,
            'prescription' => $appointmentHistory->prescription,
            'follow_up_date' => $appointmentHistory->follow_up_date,
            'notes' => $appointmentHistory->notes,
            'order_details' => $formattedOrderDetails,
        ]);
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
        $existingReview = Review::where('user_id', $request->user_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('appoinment_id', $request->appoinment_id)
            ->first();
        if ($existingReview) {
            return redirect()->back()->with('error', 'Bạn đã bình luận bác sĩ này rồi!');
        }

        $reviewDt = new Review();
        $reviewDt->user_id = $request->user_id;
        $reviewDt->doctor_id = $request->doctor_id;
        $reviewDt->appoinment_id = $request->appoinment_id;
        $reviewDt->rating = $request->rating;
        $reviewDt->comment = $request->comment;
        $reviewDt->save();

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được ghi nhận.');
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

        return view('client.appoinment.statistics', compact(
            'doctor',
            'averageRating',
            'totalRevenue',
            'totalComments',
            'completedAppointments',
            'cancelledAppointments',
            'date',
            'month',
            'year',
            'lostRevenue',
            'orderCount',
            'categories',
            'positiveReviewsCount',
            'negativeReviewsCount',
            'neutralReviewsCount'
        ));
    }

    public function getPrescriptions($appointmentId)
    {
        $appointmentHistory = AppoinmentHistory::where('appoinment_id', $appointmentId)->first();

        if (!$appointmentHistory) {
            return response()->json(['error' => 'Không tìm thấy thông tin lịch hẹn.'], 404);
        }

        $bill = Bill::where('id', $appointmentHistory->prescription)->first();

        if (!$bill) {
            return response()->json(['error' => 'Không tìm thấy hóa đơn liên quan.'], 404);
        }

        $orderDetails = OrderDetail::with('product')
            ->where('bill_id', $bill->id)
            ->get();


        $formattedOrderDetails = $orderDetails->map(function ($order) {
            return [
                'product_id' => $order->product_id,
                'product_name' => $order->product->name,
                'variant_id' => $order->variant_id,
                'unit_price' => $order->unitPrice,
                'quantity' => $order->quantity,
                'total_money' => $order->totalMoney,
            ];
        });

        return response()->json([
            'appoinment_id' => $appointmentHistory->appoinment_id,
            'diagnosis' => $appointmentHistory->diagnosis,
            'prescription' => $appointmentHistory->prescription,
            'follow_up_date' => $appointmentHistory->follow_up_date,
            'notes' => $appointmentHistory->notes,
            'order_details' => $formattedOrderDetails,
        ]);
    }



    public function specialistExamination()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $firstBatch = Specialty::orderBy('name', 'asc')->take(4)->get();
        $secondBatch = Specialty::orderBy('name', 'asc')->skip(4)->take(4)->get();
        $thirdBatch = Specialty::orderBy('name', 'asc')->skip(8)->take(4)->get();
        $orderCount = 0;
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count();
        }
        return view('client.appoinment.specialist', compact('orderCount', 'categories', 'firstBatch', 'secondBatch', 'thirdBatch'));
    }

    function doctors(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $orderCount = 0;
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count();
        }
        $specialty_id = $request->input('specialty_id');

        $specialty = Specialty::find($request->specialty_id);
        if ($request->specialty_id) {
            $doctors = Doctor::where('specialty_id', $request->specialty_id)->orderBy('id', 'desc')->paginate(12);
        } else {
            $doctors = Doctor::orderBy('id', 'desc')->paginate(12);
        }
        return view('client.appoinment.doctors', compact('orderCount', 'specialty', 'doctors', 'specialty_id', 'categories'));
    }


    // vnpay
    public function createPayment(Request $request)
    {
        $total = $request->input('amount', 0);
        if (!$total || !is_numeric($total)) {
            return back()->with('error', 'Amount is required and must be a valid number.');
        }

        session([
            'user_id' => $request->input('user_id', null),
            'doctor_id' => $request->input('doctor_id', null),
            'available_timeslot_id' => $request->input('available_timeslot_id', null),
            'appointment_date' => $request->input('appointment_date', null),
            'name' => $request->input('name', ''),
            'phone' => $request->input('phone', ''),
            'email' => $request->input('email', ''),
            'address' => $request->input('dia_chi', ''),
            'notes' => $request->input('notes', ''),
            'status_payment_method' => $request->input('status_payment_method', ''),
            'lua_chon' => $request->input('lua_chon', ''),
        ]);

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('appoinment.vnpay.return');
        $vnp_TmnCode = "K40TZFB2";
        $vnp_HashSecret = "O1S887RUKCIODDINIWXN3QHF8I1OTVKQ";

        $vnp_TxnRef = uniqid('ORDER_');
        $vnp_OrderInfo = "Thanh toán đơn hàng: " . $vnp_TxnRef;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $total * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            $hashdata .= ($hashdata ? '&' : '') . urlencode($key) . "=" . urlencode($value);
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (!empty($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }



    public function returnPayment(Request $request)
    {
        $vnp_HashSecret = "O1S887RUKCIODDINIWXN3QHF8I1OTVKQ";
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);

        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
        }
        $hashData = ltrim($hashData, '&');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                $user_id = session('user_id', null);
                $doctor_id = session('doctor_id', null);
                $available_timeslot_id = session('available_timeslot_id', null);

                if (!$user_id || !$doctor_id || !$available_timeslot_id) {
                    return redirect()->route('appoinment')->with('error', 'Session data is missing.');
                }

                $appointment_date = session('appointment_date');
                $name = session('name');
                $phone = session('phone');
                $email = session('email');
                $address = session('address');
                $notes = session('notes');
                $status_payment_method = session('status_payment_method');
                $lua_chon = session('lua_chon');

                $timeSlotId = AvailableTimeslot::where('id', $available_timeslot_id)->first();
                $doctor = Doctor::where('id', $doctor_id)->first();
                $specialtie = Specialty::where('id', $doctor->specialty_id)->first();

                $timeSlotId = AvailableTimeslot::find($available_timeslot_id);
                if (!$timeSlotId) {
                    return redirect()->route('orders.index')->with('error', 'Invalid timeslot.');
                }

                $doctor = Doctor::find($doctor_id);
                if (!$doctor) {
                    return redirect()->route('orders.index')->with('error', 'Doctor not found.');
                }

                $specialtie = Specialty::find($doctor->specialty_id);
                if (!$specialtie) {
                    return redirect()->route('orders.index')->with('error', 'Specialty not found.');
                }



                if ($timeSlotId->isAvailable == 0) {
                    return redirect()->back()->with('error', 'Thời gian hẹn đã có người đặt. Vui lòng chọn thời gian khác.');
                } else {
                    if ($lua_chon == "cho_nguoi_than") {
                        $appoinment = new Appoinment();
                        $appoinment->user_id = $user_id;
                        $appoinment->doctor_id = $doctor_id;
                        $appoinment->available_timeslot_id = $available_timeslot_id;
                        $appoinment->appointment_date = $appointment_date;
                        $appoinment->notes = $notes;
                        $appoinment->status_payment_method = 'da_thanh_toan';
                        $appoinment->classify = 'cho_gia_dinh';
                        $appoinment->name = $name;
                        $appoinment->phone = $phone;
                        $appoinment->address = $address;
                        if ($specialtie->classification == 'kham_tu_xa') {
                            $meetLink = 'https://meet.jit.si/' . uniqid();
                            $appoinment->meet_link = $meetLink;
                        }
                        $appoinment->save();

                        $available = AvailableTimeslot::where('id', $available_timeslot_id)->first();
                        $user = $name;
                        Mail::to($email)->send(new AppointmentConfirmationMail($user, $appoinment, $available));

                        $available = AvailableTimeslot::find($available_timeslot_id);
                        $available->isAvailable = 0;
                        $available->save();

                        $orderCount = 0;
                        if (Auth::check()) {
                            $user = Auth::user();
                            $orderCount = $user->bill()->count();
                        }
                        $categories = Category::orderBy('name', 'asc')->get();
                        $appointment = Appoinment::with(['doctor', 'user', 'timeSlot'])->findOrFail($appoinment->id);
                        return view('client.appoinment.appointment_bill', compact('appointment', 'orderCount', 'categories'));
                    } else {
                        $appoinment = new Appoinment();
                        $appoinment->user_id = $user_id;
                        $appoinment->doctor_id = $doctor_id;
                        $appoinment->available_timeslot_id = $available_timeslot_id;
                        $appoinment->appointment_date = $appointment_date;
                        $appoinment->notes = $notes;
                        $appoinment->status_payment_method = 'da_thanh_toan';
                        $appoinment->classify = $lua_chon;
                        if ($specialtie->classification == 'kham_tu_xa') {
                            $meetLink = 'https://meet.jit.si/' . uniqid();
                            $appoinment->meet_link = $meetLink;
                        }
                        $appoinment->save();

                        $available = AvailableTimeslot::where('id', $available_timeslot_id)->first();
                        $user = $name;
                        Mail::to($email)->send(new AppointmentConfirmationMail($user, $appoinment, $available));

                        $available = AvailableTimeslot::find($available_timeslot_id);
                        $available->isAvailable = 0;
                        $available->save();

                        $orderCount = 1;
                        if (Auth::check()) {
                            $user = Auth::user();
                            $orderCount = $user->bill()->count();
                        }
                        $categories = Category::orderBy('name', 'asc')->get();
                        $appointment = Appoinment::with(['doctor', 'user', 'timeSlot'])->findOrFail($appoinment->id);
                        return view('client.appoinment.appointment_bill', compact('appointment', 'orderCount', 'categories'));
                    }
                }
            }
        }

        return redirect()->route('appoinment.index')->with('error', 'Payment failed or invalid data.');
    }
}
