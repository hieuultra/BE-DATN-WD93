<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\Appoinment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\DashboradRequest;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function user()
    {
        $totalOrders = Bill::count();
        $totalCanceledOrders = Bill::where('status_bill', 'da_huy')->count();
        $totalRemainingOrders = Bill::whereNotIn('status_bill', ['da_huy', 'da_giao_hang'])->count();
        $totalSuccessfulOrders = Bill::where('status_bill', 'da_giao_hang')->count();

        $cancelRate = $totalOrders > 0 ? round(($totalCanceledOrders / $totalOrders) * 100, 2) : 0;
        $ongoingRate = $totalOrders > 0 ? round(($totalRemainingOrders / $totalOrders) * 100, 2) : 0;
        $successRate = $totalOrders > 0 ? round(($totalSuccessfulOrders / $totalOrders) * 100, 2) : 0;

        $totalAppointments = Appoinment::count();
        $totalCanceledAppointments = Appoinment::where('status_appoinment', 'huy_lich_hen')->count();
        $totalSuccessfulAppointments = Appoinment::where('status_appoinment', 'kham_hoan_thanh')->count();
        $totalRemainingAppointments = Appoinment::whereNotIn('status_appoinment', ['kham_hoan_thanh', 'huy_lich_hen'])->count();



        $appointmentCancelRate = $totalAppointments > 0 ? round(($totalCanceledAppointments / $totalAppointments) * 100, 2) : 0;
        $appointmentOngoingRate = $totalAppointments > 0 ? round(($totalRemainingAppointments / $totalAppointments) * 100, 2) : 0;
        $appointmentSuccessRate = $totalAppointments > 0 ? round(($totalSuccessfulAppointments / $totalAppointments) * 100, 2) : 0;

        $topUsersByOrders = Bill::select('user_id', DB::raw('COUNT(*) as total_orders'))
            ->groupBy('user_id')
            ->orderByDesc('total_orders')
            ->take(5)
            ->with('user')
            ->get();
        // dd($topUsersByOrders);
        $topUsersByCanceledOrders = Bill::select('user_id', DB::raw('COUNT(*) as total_canceled'))
            ->where('status_bill', 'da_huy')
            ->groupBy('user_id')
            ->orderByDesc('total_canceled')
            ->take(5)
            ->with('user')
            ->get();
        $topUsersByAppointments = Appoinment::select('user_id', DB::raw('COUNT(*) as total_appointments'))
            ->groupBy('user_id')
            ->orderByDesc('total_appointments')
            ->take(5)
            ->with('user')
            ->get();
        $topUsersByCanceledAppointments = Appoinment::select('user_id', DB::raw('COUNT(*) as total_canceled'))
            ->where('status_appoinment', 'huy_lich_hen')  // Lọc theo trạng thái hủy lịch
            ->groupBy('user_id')
            ->orderByDesc('total_canceled')
            ->take(5)
            ->with('user')
            ->get();
        // dd($topUsersByCanceledOrders);
        return view('admin.dashboradUser', compact(
            'topUsersByOrders',
            "topUsersByCanceledOrders",
            'cancelRate',
            'successRate',
            'appointmentCancelRate',
            'appointmentSuccessRate',
            'totalRemainingOrders',
            'totalRemainingAppointments',
            'totalCanceledOrders',
            'totalSuccessfulOrders',
            'totalCanceledAppointments',
            'totalSuccessfulAppointments',
            'topUsersByAppointments',
            'topUsersByCanceledAppointments',
            'ongoingRate',
            'appointmentOngoingRate'
        ));
    }
    public function loc(DashboradRequest $request)
    {
        // Lấy tham số ngày bắt đầu và ngày kết thúc từ request
        $startDate = Carbon::parse($request->input('start_date'))->format('Y-m-d');
        $endDate = Carbon::parse($request->input('end_date'))->format('Y-m-d');

        // dd($startDate, $endDate);
        // Xây dựng query với điều kiện lọc theo ngày nếu tồn tại
        $billQuery = Bill::query();
        $appointmentQuery = Appoinment::query();

        if ($startDate && $endDate) {
            $billQuery->whereBetween('created_at', ["$startDate 00:00:00", "$endDate 23:59:59"]);
            $appointmentQuery->whereBetween('created_at', ["$startDate 00:00:00", "$endDate 23:59:59"]);
        }


        // Tính toán các số liệu thống kê
        $totalOrders = $billQuery->count();
        $totalCanceledOrders = (clone $billQuery)->where('status_bill', 'da_huy')->count();
        $totalSuccessfulOrders = (clone $billQuery)->where('status_bill', 'da_giao_hang')->count();
        $totalRemainingOrders = (clone $billQuery)->whereNotIn('status_bill', ['da_huy', 'da_giao_hang'])->count();


        $cancelRate = $totalOrders > 0 ? round(($totalCanceledOrders / $totalOrders) * 100, 2) : 0;
        $ongoingRate = $totalOrders > 0 ? round(($totalRemainingOrders / $totalOrders) * 100, 2) : 0;
        $successRate = $totalOrders > 0 ? round(($totalSuccessfulOrders / $totalOrders) * 100, 2) : 0;

        $totalAppointments = $appointmentQuery->count();
        $totalCanceledAppointments = (clone $appointmentQuery)->where('status_appoinment', 'huy_lich_hen')->count();
        $totalSuccessfulAppointments = (clone $appointmentQuery)->where('status_appoinment', 'kham_hoan_thanh')->count();
        $totalRemainingAppointments = (clone $appointmentQuery)->whereNotIn('status_appoinment', ['kham_hoan_thanh', 'huy_lich_hen'])->count();
        
        $appointmentCancelRate = $totalAppointments > 0 ? round(($totalCanceledAppointments / $totalAppointments) * 100, 2) : 0;
        $appointmentOngoingRate = $totalAppointments > 0 ? round(($totalRemainingAppointments / $totalAppointments) * 100, 2) : 0;
        $appointmentSuccessRate = $totalAppointments > 0 ? round(($totalSuccessfulAppointments / $totalAppointments) * 100, 2) : 0;

        // Lấy danh sách người dùng top theo các tiêu chí
        // Top người dùng có nhiều đơn hàng nhất
        $topUsersByOrders = $billQuery
            ->select('user_id', DB::raw('COUNT(*) as total_orders'))
            ->groupBy('user_id')
            ->orderBy(DB::raw('COUNT(*)')) // Sắp xếp trực tiếp bằng COUNT(*)
            ->with('user') // Tải thông tin người dùng
            ->take(5)
            ->get();

        // Top người dùng có nhiều đơn hàng bị hủy nhất
        $topUsersByCanceledOrders = $billQuery
            ->select('user_id', DB::raw('COUNT(*) as total_canceled'))
            ->where('status_bill', 'da_huy') // Chỉ lấy đơn hàng bị hủy
            ->groupBy('user_id')
            ->orderBy(DB::raw('COUNT(*)')) // Sắp xếp trực tiếp bằng COUNT(*)
            ->with('user') // Tải thông tin người dùng
            ->take(5)
            ->get();

        // Top người dùng có nhiều lịch hẹn nhất
        $topUsersByAppointments = $appointmentQuery
            ->select('user_id', DB::raw('COUNT(*) as total_appointments'))
            ->groupBy('user_id')
            ->orderBy(DB::raw('COUNT(*)')) // Sắp xếp trực tiếp bằng COUNT(*)
            ->with('user') // Tải thông tin người dùng
            ->take(5)
            ->get();

        // Top người dùng có nhiều lịch hẹn bị hủy nhất
        $topUsersByCanceledAppointments = $appointmentQuery
            ->select('user_id', DB::raw('COUNT(*) as total_canceled'))
            ->where('status_appoinment', 'huy_lich_hen') // Chỉ lấy lịch hẹn bị hủy
            ->groupBy('user_id')
            ->orderBy(DB::raw('COUNT(*)')) // Sắp xếp trực tiếp bằng COUNT(*)
            ->with('user') // Tải thông tin người dùng
            ->take(5)
            ->get();

        // dd($topUsersByAppointments,$topUsersByCanceledAppointments,$topUsersByCanceledOrders,$topUsersByOrders);

        // Trả về view với dữ liệu
        return view('admin.dashboradUser', compact(
            'topUsersByOrders',
            "topUsersByCanceledOrders",
            'cancelRate',
            'successRate',
            'appointmentCancelRate',
            'appointmentSuccessRate',
            'totalRemainingOrders',
            'totalRemainingAppointments',
            'totalCanceledOrders',
            'totalSuccessfulOrders',
            'totalCanceledAppointments',
            'totalSuccessfulAppointments',
            'topUsersByAppointments',
            'topUsersByCanceledAppointments',
            'ongoingRate',
            'appointmentOngoingRate'
        ));
    }
}
