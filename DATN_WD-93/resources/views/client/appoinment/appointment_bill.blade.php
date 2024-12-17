@extends('layout')
@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="text-primary">Hóa Đơn Đặt Lịch Khám</h2>
    </div>
    <div class="card p-4 shadow-lg">
        <div class="mb-4">
            <h4 class="text-primary">Thông Tin Khách Hàng</h4>
            <table class="table table-bordered table-striped">
                <tr>
                    <td><strong>Tên</strong></td>
                    <td>{{ $appointment->name ?? $appointment->user->name }}</td>
                </tr>
                <tr>
                    <td><strong>Số điện thoại</strong></td>
                    <td>{{ $appointment->phone ?? $appointment->user->phone }}</td>
                </tr>
                <tr>
                    <td><strong>Địa chỉ</strong></td>
                    <td>{{ $appointment->address ?? $appointment->user->address }}</td>
                </tr>
            </table>
        </div>

        <div class="mb-4">
            <h4 class="text-primary">Thông Tin Lịch Khám</h4>
            @if($appointment->doctor)
            <table class="table table-bordered table-striped">
                <tr>
                    <td><strong>Bác sĩ</strong></td>
                    <td>{{ $appointment->doctor->user->name }}</td>
                </tr>
                <tr>
                    <td><strong>Khoa Khám</strong></td>
                    <td>{{ $appointment->doctor->specialty->name }}</td>
                </tr>
                <tr>
                    <td><strong>Thời gian bắt đầu khám</strong></td>
                    <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->timeSlot->startTime)->format('H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Thời gian kết thúc</strong></td>
                    <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->timeSlot->endTime)->format('H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Số tiền</strong></td>
                    <td>{{ number_format($appointment->doctor->examination_fee, 0, ',', '.') }} VND</td>
                </tr>
            </table>
            @else
            <table class="table table-bordered table-striped">
                <tr>
                    <td><strong>Tên khám tổng hợp</strong></td>
                    <td>{{ $appointment->package->hospital_name }}</td>
                </tr>
                <tr>
                    <td><strong>Khoa Khám</strong></td>
                    <td>{{ $appointment->package->specialty->name }}</td>
                </tr>
                <tr>
                    <td><strong>Số tiền</strong></td>
                    <td>{{ number_format($appointment->package->price, 0, ',', '.') }} VND</td>
                </tr>
            </table>
            @endif
        </div>

        <div class="mb-4">
            <p><strong>Ngày hẹn:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</p>
            @if($appointment->meet_link)
            <p><strong>Link meet:</strong> <a href="{{ $appointment->meet_link }}" target="_blank">{{ $appointment->meet_link }}</a></p>
            @else
            <p><strong>Link meet:</strong> Không có link meet nào</p>
            @endif
        </div>
    </div>
    @if($appointment->doctor)
    <div class="text-center mt-4">
        <a href="{{route('appoinment.booKingCare', $appointment->doctor->specialty_id)}}" class="btn btn-primary px-5">Quay trở về</a>
    </div>
    @endif
</div>

<style>
    body {
        background-color: rgb(255, 255, 255);
    }

    .card {
        border-radius: 12px;
    }

    .table {
        width: 100%;
        font-size: 1rem;
    }

    .btn {
        font-size: 1.1rem;
    }
</style>
@endsection