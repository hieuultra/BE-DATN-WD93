<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Review;
use App\Models\Specialty;
use App\Models\Appoinment;
use App\Models\Bill;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
                $specialtyName = 'khám tổng quát';
                $specialtyImage = 'khám tổng quát'; // Tên ảnh mặc định
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
        // ->whereNotNull('doctor_id') // Loại bỏ các bản ghi không có doctor_id
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
                    'doctor_name' => $topDoctorsData[$i]->doctor->user->name ?? 'khám tổng quát',
                    'doctor_image' => $topDoctorsData[$i]->doctor->user->image ?? 'khám tổng quát',
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
    public function revenues(Request $request)
    {
        $currentTimeInTimezone = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $currentMonth = Carbon::now()->month; // tháng hiện tại
        $lastMonth = Carbon::now()->subMonth(); // tháng trước

        //doanh thu
        $moneyProducts = Bill::whereMonth('created_at', $currentMonth)->where('status_bill', 'da_giao_hang')
            ->sum('totalPrice'); //doanh thu tháng này
        $moneyProductsLastMonth = Bill::whereMonth('created_at', $lastMonth)->where('status_bill', 'da_giao_hang')
            ->sum('totalPrice'); //doanh thu tháng trước
        if ($moneyProductsLastMonth != 0 && $moneyProductsLastMonth !== null) {
            if ($moneyProducts > $moneyProductsLastMonth) {
                $message = "Tăng " . round((($moneyProducts - $moneyProductsLastMonth) / $moneyProductsLastMonth) * 100, 2) . "% .";
                $color = 'green';
            } elseif ($moneyProducts < $moneyProductsLastMonth) {
                $message = "Giảm " . round((($moneyProductsLastMonth - $moneyProducts) / $moneyProductsLastMonth) * 100, 2) . "% .";
                $color = 'red';
            } else {
                $message = "Doanh thu không thay đổi .";
                $color = 'gray';
            }
        } else {
            $message = "Doanh thu không thay đổi .";
            $color = 'gray';
        }
        //sl khách mua
        //tháng này
        $uniqueUserIds = Bill::whereMonth('created_at', $currentMonth)
            ->where('status_bill', 'da_giao_hang')
            ->distinct()
            ->count('user_id');
        //tháng trước
        $uniqueUserIdsLastMonth = Bill::whereMonth('created_at', $currentMonth)
            ->where('status_bill', 'da_giao_hang')
            ->distinct()
            ->count('user_id');
        if ($uniqueUserIds > $uniqueUserIdsLastMonth) {
            $message2 = "Tăng " . round((($uniqueUserIds - $uniqueUserIdsLastMonth) / $uniqueUserIdsLastMonth) * 100, 2) . "% .";
            $color2 = 'green';
        } elseif ($uniqueUserIds < $uniqueUserIdsLastMonth) {
            $message2 = "Giảm" . round((($uniqueUserIdsLastMonth - $uniqueUserIds) / $uniqueUserIdsLastMonth) * 100, 2) . "% .";
            $color2 = 'red';
        } else {
            $message2 = "SL người mua không thay đổi .";
            $color2 = 'gray';
        }
        // Thống kê doanh thu theo ngày
        $start_date = $request->input('startDate');
        $end_date = $request->input('endDate');
        if ($start_date && $end_date) {
            //lấy doanh thu
            $moneyProductsPopup = Bill::whereBetween('created_at', [$start_date, $end_date])
                ->where('status_bill', 'da_giao_hang')
                ->sum('moneyProduct');
            $formattedMoney = number_format($moneyProductsPopup, 0, ',', '.');
            $formattedMoney .= ' VNĐ';
            //lấy số lượng đơn thành công
            $orderCountSuccess = Bill::whereBetween('created_at', [$start_date, $end_date])
                ->where('status_bill', 'da_giao_hang')
                ->count();
            //số lượng đơn hàng thất bại
            $orderCountFail = Bill::whereBetween('created_at', [$start_date, $end_date])
                ->where('status_bill', 'da_huy')
                ->count();
            //tính tỉ lệ thành công / tổng đơn
            $totalOrders = Bill::whereBetween('created_at', [$start_date, $end_date])->count(); //tổng đơn hàng

            // Tính phần trăm đơn hàng thành công
            if ($totalOrders > 0) {
                $successRate = ($orderCountSuccess / $totalOrders) * 100;
            } else {
                $successRate = 0;
            }
            $percentSuccess = round($successRate, 2);
            if ($totalOrders > 0) {
                $failRate = ($orderCountFail / $totalOrders) * 100;
            } else {
                $failRate = 0;
            }
            $percentFail = round($failRate, 2);
            // phần trăm đơn hàng thất bại
            return response()->json([
                'start_date' => $start_date,
                'end_date' => $end_date,
                'moneyProductsPopup' => $formattedMoney,
                'orderCountSuccess' => $orderCountSuccess,
                'orderCountFail' => $orderCountFail,
                'percentSuccess' => $percentSuccess,
                'percentFail' => $percentFail,
            ]);
        }
        return view('admin.dashboard.revenue', compact(
            'currentTimeInTimezone',
            'currentMonth',
            'moneyProducts',
            'message',
            'color',
            'color2',
            'message2',
            'uniqueUserIds',

        ));
    }
    public function revenuesProductSale(Request $request)
    {
        $start_date = Carbon::parse($request->input('startDate'))->startOfDay();
        $end_date = Carbon::parse($request->input('endDate'))->endOfDay();
        if ($start_date && $end_date) {
            $orderIds = Bill::whereBetween('created_at', [$start_date, $end_date])
                ->where('status_bill', 'da_giao_hang')  // Lọc theo trạng thái
                ->pluck('id');
            if ($orderIds->isEmpty()) {
                return response()->json([
                    'orderIds' => [],
                    'topProducts' => [],
                    'message' => 'No orders found for the given date range.'
                ]);
            }
            // Truy vấn bảng 'order_details' để lấy 'product_id' và 'variant_id' từ các đơn hàng
            $orderDetails = OrderDetail::whereIn('bill_id', $orderIds)
                ->join('products', 'order_details.product_id', '=', 'products.id') // Kết nối với bảng products
                ->select(
                    'order_details.product_id',
                    'products.name as product_name',
                    'products.img as product_img',
                    DB::raw('SUM(order_details.quantity) as total_quantity')
                )
                ->groupBy('order_details.product_id', 'products.name', 'products.img') // Nhóm theo product_id và thông tin sản phẩm
                ->orderByDesc('total_quantity') // Sắp xếp theo tổng quantity giảm dần
                ->get();
            return response()->json([
                'orderIds' => $orderIds,
                'topProducts' => $orderDetails,
            ]);
        }
        // return view('admin.dashboard.revenue', compact('orderDetails'));
    }
    public function revenuesProductSaleNone(Request $request)
    {
        $start_date = $request->input('startDate');
        $end_date = $request->input('endDate');
        if ($start_date && $end_date) {
            $allProductIds = Product::pluck('id')->toArray(); // Lấy tất cả id từ bảng products
            $orderIds = Bill::whereBetween('created_at', [$start_date, $end_date])
                ->pluck('id');
            $productIdsFromOrderDetails = OrderDetail::whereIn('bill_id', $orderIds) // Lọc theo danh sách bill_id
                ->distinct('product_id')
                ->pluck('product_id')->toArray();
            $uniqueProductIds = array_diff($allProductIds, $productIdsFromOrderDetails);
            $uniqueProducts = Product::whereIn('id', $uniqueProductIds) // Lọc theo danh sách product_id
                ->select('id', 'name', 'img') // Chọn các cột cần thiết
                ->get(); // Trả về tất cả các sản phẩm thỏa mãn điều kiện
            return response()->json([
                'uniqueProducts' => $uniqueProducts,
            ]);
        }
    }
}
