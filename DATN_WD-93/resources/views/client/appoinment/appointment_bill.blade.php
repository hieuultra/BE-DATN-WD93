@extends('layout')
@section('content')
<div class="container mt-5">
    <h2>Hóa Đơn Đặt Lịch Khám</h2>
    <div class="card p-4">
        <h4>Thông Tin Khách Hàng</h4>
        <p><strong>Tên:</strong> {{ $appointment->name ?? $appointment->user->name }}</p>
        <p><strong>Số điện thoại:</strong> {{ $appointment->phone ?? $appointment->user->phone }}</p>
        <p><strong>Địa chỉ:</strong> {{ $appointment->address ?? $appointment->user->address }}</p>

        <h4>Thông Tin Lịch Khám</h4>
        <p><strong>Bác sĩ:</strong> {{ $appointment->doctor->user->name }}</p>
        <p><strong>Khoa Khám:</strong> {{ $appointment->doctor->specialty->name }}</p>
        <p><strong>Số tiền:</strong> {{ number_format($appointment->doctor->examination_fee, 0, ',', '.') }} VND</p>
        <p><strong>Ngày hẹn:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</p>
        @if($appointment->meet_link)
            <li><strong>Link meet:</strong> {{ $appointment->meet_link }}</li>
        @else
            <li><strong>Link meet:</strong> Không có link meet nào</li>
        @endif
    </div>
</div>
<a href="/appoinment/">Quay trở về</a>
@endsection