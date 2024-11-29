@extends('admin.layout')
@section('titlepage', '')

@section('content')
    <style>
        .appointment-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .appointment-card .card-header {
            background-color: #007bff;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        .appointment-card .card-body {
            padding: 15px;
        }

        .appointment-card .card-body .info-item {
            margin-bottom: 10px;
        }

        .appointment-card .card-body .info-item label {
            font-weight: bold;
        }

        .column {
            height: 100%;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
    <main>
        <div class="container-lg px-4">
            <a href="{{ route('admin.appoinments.index') }}">
                <input type="button" class="btn btn-primary mt-3" value="Quay lại">
            </a>
            <div class="appointment-card mt-3">
                <div class="card-header text-center">
                    <h3 class="p-2">Thông Tin Cuộc Hẹn Khám Bệnh</h3>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="column border border-primary">
                                <div class="info-item mt-2">
                                    <h4 class="text-center">Thông tin nơi khám</h4>
                                </div>
                                <hr>
                                <div class="info-item">
                                    <label for="hospital-name">Tên Bệnh Viện:</label>
                                    <p id="hospital-name">
                                        {{ $appoinmentDetail->doctor->clinic->first()->clinic_name ?? '' }}</p>
                                </div>
                                <div class="info-item">
                                    <label for="hospital-address">Địa Chỉ:</label>
                                    <p id="hospital-address">{{ $appoinmentDetail->doctor->clinic->first()->address ?? '' }}
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label for="hospital-address">Khoa:</label>
                                    <p id="hospital-address">{{ $appoinmentDetail->doctor->specialty->first()->name ?? '' }}
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label for="patient-name">Người Đặt Khám:</label>
                                    <p id="patient-name">{{ $appoinmentDetail->user->name ?? '' }}
                                        ({{ $appoinmentDetail->classify == 'ban_than' ? 'Cho bản thân' : 'Cho người thân' }})
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label for="appointment-package">Gói Khám:</label>
                                    <p id="appointment-package">
                                        {{ $appoinmentDetail->package->name ?? 'Không chọn gói khám' }}</p>
                                </div>
                                <div class="info-item">
                                    <label for="appointment-price">Giá Tiền:</label>
                                    <p id="appointment-price">
                                        {{ number_format($appoinmentDetail->doctor->examination_fee, 0, ',', '.') ?? '0' }}
                                        VND</p>
                                </div>
                                <div class="info-item">
                                    <label for="appointment-time">Thời Gian Hẹn:</label>
                                    <p id="appointment-time">Ca: {{ $appoinmentDetail->timeSlot->startTime }}h ->
                                        {{ $appoinmentDetail->timeSlot->endTime }}h</p>
                                    <p id="appointment-time">Thứ: {{ $appoinmentDetail->timeSlot->dayOfWeek }}</p>
                                    <p id="appointment-time">Ca: {{ $appoinmentDetail->appointment_date }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="column border border-primary">
                                <div class="info-item mt-2">
                                    <h4 class="text-center">Thông tin bác sĩ</h4>
                                </div>
                                <hr>
                                <div class="info-item">
                                    <label for="hospital-name">Tên bác sĩ:</label>
                                    <p id="hospital-name">{{ $appoinmentDetail->doctor->user->name ?? '' }}</p>
                                </div>
                                <div class="info-item">
                                    <label for="hospital-address">Số điện thoại:</label>
                                    <p id="hospital-address">{{ $appoinmentDetail->doctor->user->phone ?? '' }}</p>
                                </div>
                                <div class="info-item">
                                    <label for="patient-name">Email:</label>
                                    <p id="patient-name">{{ $appoinmentDetail->doctor->user->email ?? '' }}</p>
                                </div>
                                <div class="info-item">
                                    <label for="appointment-package">Chức vụ:</label>
                                    <p id="appointment-package">{{ $appoinmentDetail->doctor->title ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="column border border-primary">
                                <div class="info-item mt-2">
                                    <h4 class="text-center">Thông tin người khám</h4>
                                </div>
                                <hr>
                                <div class="info-item">
                                    <label for="hospital-name">Họ tên người khám:</label>
                                    <p id="hospital-name">
                                        {{ $appoinmentDetail->classify == 'ban_than' ? $appoinmentDetail->user->name : $appoinmentDetail->name }}
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label for="hospital-address">Số điện thoại:</label>
                                    <p id="hospital-address">
                                        {{ $appoinmentDetail->classify == 'ban_than' ? $appoinmentDetail->user->phone : $appoinmentDetail->phone }}
                                    </p>
                                </div>
                                @if ($appoinmentDetail->classify == 'ban_than')
                                    <div class="info-item">
                                        <label for="patient-name">Email:</label>
                                        <p id="patient-name">{{ $appoinmentDetail->user->email ?? '' }}</p>
                                    </div>
                                @endif
                                <div class="info-item">
                                    <label for="appointment-package">Địa chỉ:</label>
                                    <p id="appointment-package">
                                        {{ $appoinmentDetail->classify == 'ban_than' ? $appoinmentDetail->user->address : $appoinmentDetail->address }}
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label for="appointment-package">Trạng thái lịch khám:</label>
                                    <p id="appointment-package">
                                        {{ $statusAppoinment[$appoinmentDetail->status_appoinment] }}</p>
                                </div>
                                <div class="info-item">
                                    <label for="appointment-package">Trạng thái thanh toán:</label>
                                    <p id="appointment-package">
                                        {{ $statusPayment[$appoinmentDetail->status_payment_method] }}</p>
                                </div>
                                <div class="info-item">
                                    <label for="appointment-package">Ghi chú cho cho bác sĩ:</label>
                                    <p id="appointment-package">{{ $appoinmentDetail->notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection
