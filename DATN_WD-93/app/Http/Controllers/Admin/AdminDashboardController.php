<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Review;
use App\Models\Specialty;
use App\Models\Appoinment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function appointment()
    {

        // Lấy ngày, tháng, năm và tuần hiện tại
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $startOfWeek = Carbon::now()->startOfWeek();
        // Nhóm trạng thái
        $statuses = [
            'chua_kham' => [
                Appoinment::CHO_XAC_NHAN,
                Appoinment::DA_XAC_NHAN,
                Appoinment::DANG_KHAM,
            ],
            'kham_hoan_thanh' => [
                Appoinment::KHAM_HOAN_THANH,
                Appoinment::CAN_TAI_KHAM,
            ],
            'khong_thanh_cong' => [
                Appoinment::BENH_NHAN_KHONG_DEN,
                Appoinment::HUY_LICH_HEN,
                Appoinment::YEU_CAU_HUY,
            ],
        ];

        // Tính số lượng cho từng nhóm trạng thái
        $stats = [
            'today' => [
                'chua_kham' => Appoinment::whereDate('appointment_date', $today)
                    ->whereIn('status_appoinment', $statuses['chua_kham'])->count(),
                'kham_hoan_thanh' => Appoinment::whereDate('appointment_date', $today)
                    ->whereIn('status_appoinment', $statuses['kham_hoan_thanh'])->count(),
                'khong_thanh_cong' => Appoinment::whereDate('appointment_date', $today)
                    ->whereIn('status_appoinment', $statuses['khong_thanh_cong'])->count(),
            ],
            'week' => [
                'chua_kham' => Appoinment::whereBetween('appointment_date', [$startOfWeek, $today])
                    ->whereIn('status_appoinment', $statuses['chua_kham'])->count(),
                'kham_hoan_thanh' => Appoinment::whereBetween('appointment_date', [$startOfWeek, $today])
                    ->whereIn('status_appoinment', $statuses['kham_hoan_thanh'])->count(),
                'khong_thanh_cong' => Appoinment::whereBetween('appointment_date', [$startOfWeek, $today])
                    ->whereIn('status_appoinment', $statuses['khong_thanh_cong'])->count(),
            ],
            'month' => [
                'chua_kham' => Appoinment::whereMonth('appointment_date', $currentMonth)
                    ->whereYear('appointment_date', $currentYear)
                    ->whereIn('status_appoinment', $statuses['chua_kham'])->count(),
                'kham_hoan_thanh' => Appoinment::whereMonth('appointment_date', $currentMonth)
                    ->whereYear('appointment_date', $currentYear)
                    ->whereIn('status_appoinment', $statuses['kham_hoan_thanh'])->count(),
                'khong_thanh_cong' => Appoinment::whereMonth('appointment_date', $currentMonth)
                    ->whereYear('appointment_date', $currentYear)
                    ->whereIn('status_appoinment', $statuses['khong_thanh_cong'])->count(),
            ],
            'year' => [
                'chua_kham' => Appoinment::whereYear('appointment_date', $currentYear)
                    ->whereIn('status_appoinment', $statuses['chua_kham'])->count(),
                'kham_hoan_thanh' => Appoinment::whereYear('appointment_date', $currentYear)
                    ->whereIn('status_appoinment', $statuses['kham_hoan_thanh'])->count(),
                'khong_thanh_cong' => Appoinment::whereYear('appointment_date', $currentYear)
                    ->whereIn('status_appoinment', $statuses['khong_thanh_cong'])->count(),
            ],
        ];
        $pricePerAppointment = 500000; // Giá trị của mỗi đơn "khám hoàn thành" (500k)

        // Doanh thu tính theo tuần, tháng, năm
        $revenue = [
            'week' => [],
            'month' => [],
            'year' => [],
        ];

        // Doanh thu theo tuần (7 ngày)
        for ($i = 0; $i < 7; $i++) {
            $startOfWeekDay = Carbon::now()->startOfWeek()->addDays($i);
            $endOfWeekDay = $startOfWeekDay->copy()->endOfDay();
            $count = Appoinment::whereBetween('appointment_date', [$startOfWeekDay, $endOfWeekDay])
                ->whereIn('status_appoinment', $statuses['kham_hoan_thanh'])->count();
            $revenue['week'][] = $count * $pricePerAppointment; // Tính doanh thu
        }

        // Doanh thu theo tháng
        for ($i = 1; $i <= 12; $i++) {
            $count = Appoinment::whereMonth('appointment_date', $i)
                ->whereYear('appointment_date', $currentYear)
                ->whereIn('status_appoinment', $statuses['kham_hoan_thanh'])->count();
            $revenue['month'][] = $count * $pricePerAppointment; // Tính doanh thu
        }

        // Doanh thu theo năm (5 năm)
        for ($i = 0; $i < 5; $i++) {
            $year = $currentYear - $i;
            $count = Appoinment::whereYear('appointment_date', $year)
                ->whereIn('status_appoinment', $statuses['kham_hoan_thanh'])->count();
            $revenue['year'][] = $count * $pricePerAppointment; // Tính doanh thu
        }

        // Lấy theo chuyên khoa
        $getAllApponment = Appoinment::with('doctor.specialty')->get();

        // Nhóm các cuộc hẹn theo ID chuyên khoa của bác sĩ
        $groupedAppointments = $getAllApponment->groupBy(function ($appointment) {
            // Kiểm tra xem bác sĩ và chuyên khoa có tồn tại không
            return $appointment->doctor && $appointment->doctor->specialty ? $appointment->doctor->specialty->id : null;
        });

        $appointmentsData = [];

        foreach ($groupedAppointments as $specialtyId => $appointments) {
            // Nếu không có specialtyId (nghĩa là không có bác sĩ hoặc bác sĩ không có chuyên khoa), thì bỏ qua nhóm này
            if ($specialtyId === null) {
                continue;
            }

            // Kiểm tra xem chuyên khoa có tồn tại không
            $specialty = Specialty::find($specialtyId);
            if ($specialty) {
                $specialtyName = $specialty->name;
                $specialtyImage = $specialty->image; // Giả sử bạn có trường 'image' trong bảng Specialty
            } else {
                // Nếu không có chuyên khoa, có thể gán tên và ảnh mặc định
                $specialtyName = 'Chưa xác định';
                $specialtyImage = 'default_image.png'; // Tên ảnh mặc định
            }

            // Đếm số lượng cuộc hẹn trong nhóm này
            $appointmentsCount = $appointments->count();

            // Đếm số lượng cuộc hẹn có trạng thái 'kham_hoan_thanh'
            $completedAppointmentsCount = $appointments->filter(function ($appointment) {
                return $appointment->status_appoinment === Appoinment::KHAM_HOAN_THANH;
            })->count();

            // Thêm thông tin vào mảng
            $appointmentsData[] = [
                'specialty_name' => $specialtyName,
                'specialty_image' => $specialtyImage, // Thêm ảnh vào mảng
                'appointments_count' => $appointmentsCount,
                'completed_appointments_count' => $completedAppointmentsCount, // Thêm số lượng 'kham_hoan_thanh'
                'appointments' => $appointments // Thêm các cuộc hẹn của chuyên khoa này vào mảng
            ];
        }

        // Sắp xếp các chuyên khoa theo số lượt đặt giảm dần
        $appointmentsData = collect($appointmentsData)->sortByDesc('appointments_count');


        // Lấy bác sỹ
        $topDoctorsData = Appoinment::with('doctor.user') // Lấy thông tin bác sĩ
            ->selectRaw('doctor_id, COUNT(*) as appointments_count,
                     SUM(CASE WHEN status_appoinment = "kham_hoan_thanh" THEN 1 ELSE 0 END) as completed_appointments_count')
            ->groupBy('doctor_id')
            ->orderByDesc('appointments_count') // Sắp xếp theo số lượt khám
            ->limit(5) // Giới hạn 5 bác sĩ có lượt khám nhiều nhất
            ->get();
        $dataDoctors = [];
        for ($i = 0; $i < 5; $i++) {
            if (isset($topDoctorsData[$i])) {
                $dataDoctors[] = [
                    'doctor_name' => $topDoctorsData[$i]->doctor->title ?? 'chưa có',
                    'doctor_image' => $topDoctorsData[$i]->doctor->user->image ?? 'chưa có',
                    'appointments_count' => $topDoctorsData[$i]->appointments_count ?? 0,
                    'completed_appointments_count' => $topDoctorsData[$i]->completed_appointments_count ?? 0,
                ];
            }
        }
        $reviews = [
            'today' => [
                1 => Review::whereDate('created_at', $today)
                    ->whereNotNull('doctor_id') // Kiểm tra xem doctor_id có tồn tại
                    ->where('rating', 1)
                    ->count(),
                2 => Review::whereDate('created_at', $today)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 2)
                    ->count(),
                3 => Review::whereDate('created_at', $today)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 3)
                    ->count(),
                4 => Review::whereDate('created_at', $today)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 4)
                    ->count(),
                5 => Review::whereDate('created_at', $today)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 5)
                    ->count(),
            ],
            'week' => [
                1 => Review::whereBetween('created_at', [$startOfWeek, $today])
                    ->whereNotNull('doctor_id')
                    ->where('rating', 1)
                    ->count(),
                2 => Review::whereBetween('created_at', [$startOfWeek, $today])
                    ->whereNotNull('doctor_id')
                    ->where('rating', 2)
                    ->count(),
                3 => Review::whereBetween('created_at', [$startOfWeek, $today])
                    ->whereNotNull('doctor_id')
                    ->where('rating', 3)
                    ->count(),
                4 => Review::whereBetween('created_at', [$startOfWeek, $today])
                    ->whereNotNull('doctor_id')
                    ->where('rating', 4)
                    ->count(),
                5 => Review::whereBetween('created_at', [$startOfWeek, $today])
                    ->whereNotNull('doctor_id')
                    ->where('rating', 5)
                    ->count(),
            ],
            'month' => [
                1 => Review::whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 1)
                    ->count(),
                2 => Review::whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 2)
                    ->count(),
                3 => Review::whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 3)
                    ->count(),
                4 => Review::whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 4)
                    ->count(),
                5 => Review::whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 5)
                    ->count(),
            ],
            'year' => [
                1 => Review::whereYear('created_at', $currentYear)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 1)
                    ->count(),
                2 => Review::whereYear('created_at', $currentYear)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 2)
                    ->count(),
                3 => Review::whereYear('created_at', $currentYear)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 3)
                    ->count(),
                4 => Review::whereYear('created_at', $currentYear)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 4)
                    ->count(),
                5 => Review::whereYear('created_at', $currentYear)
                    ->whereNotNull('doctor_id')
                    ->where('rating', 5)
                    ->count(),
            ],
        ];

        // Đánh giá mới nhất
        $latestReviews = Review::whereNotNull('doctor_id')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->with('user')
            ->get();

        // In ra mảng kết quả (hoặc bạn có thể sử dụng nó trong view)
        // Truyền dữ liệu sang view
        return view('admin.dashboard.appoinment', [
            'statsToday' => $stats['today'],
            'statsWeek' => $stats['week'],
            'statsMonth' => $stats['month'],
            'statsYear' => $stats['year'],
            'revenueWeek' => $revenue['week'],
            'revenueMonth' => $revenue['month'],
            'revenueYear' => $revenue['year'],
            'appointmentsData' => $appointmentsData,
            'dataDoctors' => $dataDoctors,
            'reviewsToday' => $reviews['today'],
            'reviewsWeek' => $reviews['week'],
            'reviewsMonth' => $reviews['month'],
            'reviewsYear' => $reviews['year'],
            'latestReviews' => $latestReviews
        ]);
    }
}
