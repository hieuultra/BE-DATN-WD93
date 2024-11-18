<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        Doctor Profile
    </title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #e0f7fa;
        }

        .navbar-brand {
            color: #007bff;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: #007bff;
        }

        .container {
            margin-top: 20px;
        }

        .profile-header {
            display: flex;
            align-items: center;
        }

        .profile-header img {
            border-radius: 50%;
            margin-right: 20px;
        }

        .profile-header h1 {
            font-size: 24px;
            font-weight: bold;
        }

        .profile-header p {
            margin: 0;
        }

        .schedule-table th,
        .schedule-table td {
            text-align: center;
            padding: 10px;
        }

        .schedule-table th {
            background-color: #f8f9fa;
        }

        .schedule-table td {
            border: 1px solid #dee2e6;
        }

        .feedback-section {
            margin-top: 20px;
        }

        .feedback-section h5 {
            font-size: 18px;
            font-weight: bold;
        }

        .feedback-section p {
            margin: 0;
        }

        .time-slot {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            padding: 10px;
        }

        .time-slot-item {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .time-slot-item:hover {
            background-color: #0056b3;
        }

        .appointments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }

        .appointment-item {
            border: 2px solid yellow;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
            text-align: center;
        }

        .appointments-grid2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            padding: 10px;
        }

        .appointment-item2 {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .appointment-item2:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .appointment-history-link {
            border: 2px solid #1E90FF;
            background-color: #1E90FF; 
            color: #ffffff;
            padding: 5px 10px; 
            border-radius: 5px; 
            text-decoration: none; 
        }

        .appointment-history-link:hover {
            background-color: #187bcd; 
            color: #f0f0f0;
        }

        .appointment-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-link {
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            transition: all 0.3s ease;
        }

        .action-link.confirm {
            color: #28a745;
            border: 2px solid #28a745; 
        }

        .action-link.pending {
            color: #dc3545;
            border: 2px solid #dc3545;
        }

        .appointment-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-link {
            padding: 8px 16px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
        }

        .action-link.confirm {
            color: #28a745;
            border: 2px solid #28a745;
        }

        .action-link.pending {
            color: #dc3545;
            border: 2px solid #dc3545;
        }

        .rating:not(:checked) > input {
        position: absolute;
        appearance: none;
        }

        .rating:not(:checked) > label {
        float: right;
        cursor: pointer;
        font-size: 30px;
        color: #666;
        }

        .rating:not(:checked) > label:before {
        content: '★';
        }

        .rating > input:checked + label:hover,
        .rating > input:checked + label:hover ~ label,
        .rating > input:checked ~ label:hover,
        .rating > input:checked ~ label:hover ~ label,
        .rating > label:hover ~ input:checked ~ label {
        color: #e58e09;
        }

        .rating:not(:checked) > label:hover,
        .rating:not(:checked) > label:hover ~ label {
        color: #ff9e0b;
        }

        .rating > input:checked ~ label {
        color: #ffa723;
        }

        @media (max-width: 768px) {
            .appointment-actions {
                flex-direction: column;
                align-items: stretch;
            }
        }

        @media (max-width: 768px) {
            .appointment-actions {
                flex-direction: column;
                align-items: stretch;
            }
        }

        @media (max-width: 768px) {
            .appointments-grid2 {
                grid-template-columns: 1fr; 
            }
        }

        @media (max-width: 768px) {
            .time-slot {
                grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            }
        }

        @media (max-width: 576px) {
            .time-slot-item {
                padding: 8px;
                font-size: 0.9em;
            }
        }

        @media (max-width: 992px) {
            .position-fixed {
                position: static !important;
                top: auto;
                right: auto;
            }
        }
    </style>
</head>

<body>
@extends('layout')
@section('content')
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-stethoscope">
                </i>
                BookingCare
            </a>
            <button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-bs-target="#navbarNav" data-bs-toggle="collapse" type="button">
                <span class="navbar-toggler-icon">
                </span>
            </button>
        </div>
    </nav>


    <div class="container">
        <div class="row mt-4">
        <div class="col-md-8">
        <div class="profile-header d-flex flex-column flex-md-row align-items-center">
            <img alt="Doctor's profile picture" height="100" src="{{ asset('upload/' . $doctor->user->image) }}" width="100" />
            <div class="ml-md-3 mt-2 mt-md-0 text-center text-md-start">
                <h1>Bác Sỹ: {{$doctor->user->name}}</h1>
                <button class="btn btn-primary mb-1">Chỉnh sửa thông tin</button>
                <a href="{{ route('appoinment.statistics', $doctor->id) }}" class="btn btn-secondary">Thống kê chi tiết</a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
        @endif

        <div class="appointments mt-3">
            <div id="appointments-grid" class="appointments-grid">
                    
            </div>
        </div>

        <div class="appointments mt-3" style="margin-top: 10px;">
            <h5>Lịch hẹn ngày hôm nay</h5>
            <div class="appointments-grid2">
                @foreach($doctors->timeSlot as $timeSlot)
                    @foreach($timeSlot->appoinment as $appoinment)
                        @if($appoinment->status_appoinment !== null)
                            @php
                                $formattedDateTime = \Carbon\Carbon::parse($timeSlot->date . ' ' . $timeSlot->startTime)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                            @endphp
                            <div class="appointment-item2">
                                <p>Tên bệnh nhân: {{$appoinment->user->name}}</p>
                                <p>Số điện thoại: {{$appoinment->user->phone}}</p>
                                <p>Lý do khám: {{$appoinment->notes}}</p>
                                <p>Ngày: {{ $formattedDateTime }}</p>
                                <p>Thời gian: {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}
                                </p>
                                @if($appoinment->status_appoinment === 'huy_lich_hen')
                                    <p style="color: red;">Lịch hẹn đã bị hủy</p>
                                @elseif($appoinment->status_appoinment === 'da_xac_nhan')
                                <div class="appointment-actions">
                                    <a href="{{ $appoinment->meet_link }}" target="_blank" rel="noopener noreferrer">
                                        {{ $appoinment->meet_link }}
                                    </a>
                                    <a href="#" class="action-link confirm" data-appointment-id="{{ $appoinment->id }}" style="text-decoration: none;">Xác nhận đang khám</a>
                                    <a style="text-decoration: none;" href="#" class="action-link pending" data-user-id="{{ $appoinment->user_id }}" data-appointment-id="{{ $appoinment->id }}" data-doctor-id="{{ $doctor->id }}">Bệnh nhân chưa đến</a>
                                </div>
                                @elseif($appoinment->status_appoinment === 'kham_hoan_thanh')
                                    <p style="color: blue;">Đã khám thành công</p>
                                    <a href="#" class="appointment-history-link" data-appointment-id="{{ $appoinment->id }}">Chi tiết hóa đơn</a>
                                @elseif($appoinment->status_appoinment === 'can_tai_kham')
                                    <p style="color: blueviolet;">Cần tái khám</p> 
                                    <a href="#" class="appointment-history-link" data-appointment-id="{{ $appoinment->id }}">Chi tiết hóa đơn</a>
                                @elseif($appoinment->status_appoinment === 'benh_nhan_khong_den')
                                    <p style="color: green;">Bệnh nhân vắng mặt</p>    
                                @endif
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>

        
        <div class="modal fade" id="appointmentHistoryModal" tabindex="-1" aria-labelledby="appointmentHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appointmentHistoryModalLabel">Chi tiết hóa đơn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="appointmentHistoryContent">
                        
                    </div>
                </div>
            </div>
        </div>

       
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Xác nhận đang khám</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('appoinment.confirmAppointmentHistories') }}" method="POST">
                        @csrf    
                            <input type="hidden" id="userId" name="user_id">
                            <input type="hidden" id="appointmentId" name="appoinment_id">
                            <input type="hidden" id="doctorId" name="doctor_id">

                            <div class="mb-3">
                                <label for="" class="form-label">Chuẩn đoán</label>
                                <textarea class="form-control" name="diagnosis" rows="3" placeholder="Chuẩn đoán" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Toa thuốc hoặc chỉ định</label>
                                <textarea class="form-control" name="prescription" rows="3" placeholder="Toa thuốc hoặc chỉ định" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="dateSelect-{{ $doctor->id }}" class="form-label">Chọn ngày tái khám</label>
                                <select id="dateSelect-{{ $doctor->id }}" class="form-select date-select" aria-label="Chọn ngày">
                                    <option value="" selected disabled>Chọn Thứ, Ngày, Tháng</option>
                                    @php
                                    $availableDates = $doctor->timeSlot->filter(function ($timeSlot) {
                                        return $timeSlot->isAvailable == 1;
                                    })->unique(function ($item) {
                                        return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
                                    });
                                    @endphp
                                    @foreach($availableDates as $timeSlots)
                                        @php
                                        $formattedDate = \Carbon\Carbon::parse($timeSlots->date)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                                        $formattedDateValue = \Carbon\Carbon::parse($timeSlots->date)->format('Y-m-d');
                                        @endphp
                                        <option value="{{ $formattedDateValue }}">{{ $formattedDate }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="time-slot mt-3">
                                @foreach($doctor->timeSlot as $timeSlot)
                                    @php
                                    $formattedDateValue = \Carbon\Carbon::parse($timeSlot->date)->format('Y-m-d');
                                    @endphp
                                    @if($timeSlot->isAvailable == 1)
                                        <button type="button" 
                                                class="btn btn-outline-primary time-slot-item" 
                                                data-date="{{ $formattedDateValue }}" 
                                                data-id="{{ $timeSlot->id }}" 
                                                data-start-time="{{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }}" 
                                                data-end-time="{{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}"
                                                style="display: none;">
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}
                                        </button>
                                    @endif
                                @endforeach
                            </div>

                            <input type="hidden" name="selected_date" id="selectedDate">
                            <input type="hidden" name="selected_time_slot" id="selectedTimeSlot">
                            <input type="hidden" name="selected_time_slot_id" id="selectedTimeSlotId">

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const dateSelect = document.getElementById('dateSelect-{{ $doctor->id }}');
                                    const timeSlotItems = document.querySelectorAll('.time-slot-item');
                                    const selectedDateInput = document.getElementById('selectedDate');
                                    const selectedTimeSlotInput = document.getElementById('selectedTimeSlot');
                                    const selectedTimeSlotIdInput = document.getElementById('selectedTimeSlotId');

                                    dateSelect.addEventListener('change', function () {
                                        const selectedDate = dateSelect.value;
                                        selectedDateInput.value = selectedDate;

                                        timeSlotItems.forEach(item => {
                                            item.style.display = 'none';
                                            item.classList.remove('btn-primary');
                                            item.classList.add('btn-outline-primary');
                                        });

                                        timeSlotItems.forEach(item => {
                                            if (item.getAttribute('data-date') === selectedDate) {
                                                item.style.display = 'inline-block';
                                            }
                                        });
                                    });

                                    timeSlotItems.forEach(item => {
                                        item.addEventListener('click', function () {
                                            timeSlotItems.forEach(btn => btn.classList.replace('btn-primary', 'btn-outline-primary'));

                                            selectedTimeSlotInput.value = `${item.getAttribute('data-start-time')} - ${item.getAttribute('data-end-time')}`;
                                            selectedTimeSlotIdInput.value = item.getAttribute('data-id'); // Store the time slot ID
                                            item.classList.replace('btn-outline-primary', 'btn-primary');
                                        });
                                    });
                                });
                            </script>

                            <div class="mb-3">
                                <label for="" class="form-label">Ghi chu thêm</label>
                                <textarea class="form-control" name="notes" rows="3" placeholder="Ghi chu thêm" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="notArrivedModal" tabindex="-1" aria-labelledby="notArrivedModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notArrivedModalLabel">Bệnh nhân chưa đến</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="patientName" class="form-label">Họ và tên bệnh nhân</label>
                            <input type="text" class="form-control" id="patientName" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="patientPhone" class="form-label">Số điện thoại bệnh nhân</label>
                            <input type="text" class="form-control" id="patientPhone" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="patientEmail" class="form-label">Email bệnh nhân</label>
                            <input type="text" class="form-control" id="patientEmail" readonly>
                        </div>

                        <form action="{{ route('appoinment.confirmAppointmentkoden') }}" method="POST">
                        @csrf   
                            <input type="hidden" id="notArrivedAppointmentId" name="appointment_id">
                            <div class="mb-3">
                                <label for="notArrivedReason" class="form-label">Lý do</label>
                                <textarea class="form-control" id="notArrivedReason" name="reason" rows="3" placeholder="Lý do bệnh nhân chưa đến"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="schedule" style="margin-top: 10px;">
            <h5 for="dateSelect-{{ $doctor->id }}">Lịch khám chưa có người đặt</h5>
             <select id="dateSelect-{{ $doctor->id }}" class="form-select date-select" aria-label="Chọn ngày">
                @php
                $availableDates = $doctor->timeSlot->filter(function ($timeSlot) {
                return $timeSlot->isAvailable == 1;
                })->unique(function ($item) {
                return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
                });
                @endphp
                @foreach($availableDates as $timeSlots)
                @php
                $formattedDate = \Carbon\Carbon::parse($timeSlots->date)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                $formattedDateValue = \Carbon\Carbon::parse($timeSlots->date)->format('Y-m-d');
                @endphp
                    <option value="{{ $formattedDateValue }}">{{ $formattedDate }}</option>
                @endforeach
                </select>

            <div class="time-slot mt-3">
                @foreach($doctor->timeSlot as $timeSlot)
                @php
                $formattedDateValue = \Carbon\Carbon::parse($timeSlot->date)->format('Y-m-d');
                @endphp
                @if($timeSlot->isAvailable == 1)
                    <div class="time-slot-item" data-date="{{ $formattedDateValue }}">
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} -
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}
                    </div>
                @endif
                @endforeach
            </div>
        </div>
  
                
        <div class="appointments mt-3">
            <h5>Tra cứu lịch hẹn</h5>

            <label for="filterSelect">Lọc theo thứ trong tuần:</label>
            <select id="filterSelect" class="form-select" aria-label="Lọc lịch hẹn">
                <option value="all">Tất cả</option>
                <option value="monday">Thứ Hai</option>
                <option value="tuesday">Thứ Ba</option>
                <option value="wednesday">Thứ Tư</option>
                <option value="thursday">Thứ Năm</option>
                <option value="friday">Thứ Sáu</option>
                <option value="saturday">Thứ Bảy</option>
                <option value="sunday">Chủ Nhật</option>
            </select>

            <input type="text" id="filterName" class="form-control mt-2" placeholder="Lọc theo tên người đặt">
            <input type="text" id="filterId" class="form-control mt-2" placeholder="Lọc theo ID lịch hẹn">
            <input type="date" id="filterDate" class="form-control mt-2" placeholder="Lọc theo ngày đặt">
            
            <div class="appointments-grid mt-3">
                @foreach($doctor->timeSlot as $timeSlot)
                    @foreach($timeSlot->appoinment as $appoinment)
                        @if($appoinment->status_appoinment !== null)
                            @php
                                $formattedDateTime = \Carbon\Carbon::parse($timeSlot->date . ' ' . $timeSlot->startTime)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                                $dayOfWeek = \Carbon\Carbon::parse($timeSlot->date)->isoFormat('dddd');
                            @endphp
                            <div class="appointment-item" 
                                data-day="{{ strtolower($dayOfWeek) }}"
                                data-name="{{ strtolower($appoinment->user->name) }}"
                                data-id="{{ $appoinment->id }}"
                                data-date="{{ $timeSlot->date }}">
                                <p>Mã lịch khám: {{$appoinment->id}}</p>
                                <p>Tên bệnh nhân: {{$appoinment->user->name}}</p>
                                <p>Ngày: {{ $formattedDateTime }}</p>
                                <p>Thời gian: {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}
                                </p>
                                @if($appoinment->status_appoinment === 'yeu_cau_huy')
                                    <p class="text-danger">Đang chờ xác nhận hủy</p>
                                @elseif($appoinment->status_appoinment === 'cho_xac_nhan')
                                    <p style="color: #007bff;">Đang chờ xác nhận</p>
                                @elseif($appoinment->status_appoinment === 'huy_lich_hen')
                                    <p style="color: red;">lịch hẹn đã bị hủy</p>
                                @elseif($appoinment->status_appoinment === 'kham_hoan_thanh')
                                    <p style="color: pink;">Khám hoàn tất</p>
                                    <a href="#" class="appointment-history-link" data-appointment-id="{{ $appoinment->id }}">Chi tiết hóa đơn</a>
                                @elseif($appoinment->status_appoinment === 'can_tai_kham')
                                    <p style="color: palegreen;">Cần tái khám</p>
                                    <a href="#" class="appointment-history-link" data-appointment-id="{{ $appoinment->id }}">Chi tiết hóa đơn</a>
                                @elseif($appoinment->status_appoinment === 'benh_nhan_khong_den')
                                    <p style="color: greenyellow;">bênh nhân vắng mặt</p>
                                @else
                                    <p style="color: blue;">Đã xác nhận</p>
                                @endif
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>

    </div>
</div>
            <div style="margin-top: 10px;">
                <h5>ĐỊA CHỈ KHÁM</h5>
                @if(empty($clinic) != 'Null')
                <p>{{$clinic->address}}, {{$clinic->city}}</p>
                <p>{{$clinic->clinic_name}}</p>
                @else
                <p>Khám qua vieo call</p>
                @endif
                <h5>GIÁ KHÁM: {{ number_format($doctor->examination_fee, 0, ',', '.') }} VND</h5>
            </div>
            <div style="margin-top: 10px;">
                <h3>Đánh giá cho bác sĩ: {{ $doctor->user->name }}</h3>

                @foreach($doctorrv->review as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="rating">
                                <input value="5" @if($review->rating == 5) checked @endif type="radio" disabled>
                                <label title="text" for="star5"></label>
                                <input value="4" @if($review->rating == 4) checked @endif type="radio" disabled>
                                <label title="text" for="star4"></label>
                                <input value="3" @if($review->rating == 3) checked @endif type="radio" disabled>
                                <label title="text" for="star3"></label>
                                <input value="2" @if($review->rating == 2) checked @endif type="radio" disabled>
                                <label title="text" for="star2"></label>
                                <input value="1" @if($review->rating == 1) checked @endif type="radio" disabled>
                                <label title="text" for="star1"></label>
                            </div>
                            <p><strong>Người đánh giá:</strong> {{ $review->user->name }}</p>
                            <p><strong>Nhận xét:</strong> {{ $review->comment }}</p>
                            <p><small>Ngày đánh giá: {{ $review->created_at->format('d/m/Y') }}</small></p>
                        </div>
                    </div>
                @endforeach

                @if($doctorrv->review->isEmpty())
                    <p>Chưa có đánh giá nào cho bác sĩ này.</p>
                @endif
        </div>
    </div>
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Thành công!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    <script>
        $(document).on('click', '.action-link.confirm', function(event) {
            event.preventDefault();
            const appointmentId = $(this).data('appointment-id');
            $.ajax({
                url: '/appoinment/appointments/get-details',
                type: 'GET',
                data: {
                    appointment_id: appointmentId
                },
                success: function(data) {
                    $('#userId').val(data.user_id);
                    $('#appointmentId').val(data.appointment_id);
                    $('#doctorId').val(data.doctor_id);
                    $('#confirmModal').modal('show');
                },
                error: function() {
                    alert('Có lỗi xảy ra khi lấy dữ liệu cuộc hẹn.');
                }
            });
        });

        $(document).on('click', '.appointment-history-link', function(event) {
            event.preventDefault();
            const appointmentId = $(this).data('appointment-id');
            
            $.ajax({
                url: `/appoinment/appointment-history/${appointmentId}`,
                type: 'GET',
                success: function(data) {
                    let content = `<p>ID lịch hẹn: ${data.appoinment_id}</p>`;
                    content += `<p>Chẩn đoán: ${data.diagnosis}</p>`;
                    content += `<p>Đơn thuốc: ${data.prescription}</p>`;
                    content += `<p>Ngày tái khám: ${data.follow_up_date}</p>`;
                    content += `<p>Ghi chú: ${data.notes}</p>`;
                    $('#appointmentHistoryContent').html(content);
                    
                    $('#appointmentHistoryModal').modal('show');
                },
                error: function() {
                    alert('Không thể tải chi tiết lịch hẹn.');
                }
            });
        });

        $(document).ready(function() {
            function filterAppointments() {
                const selectedDay = $('#filterSelect').val();
                const filterName = $('#filterName').val().toLowerCase();
                const filterId = $('#filterId').val();
                const filterDate = $('#filterDate').val();

                $('.appointment-item').each(function() {
                    const day = $(this).data('day');
                    const name = $(this).data('name');
                    const id = $(this).data('id').toString();
                    const date = $(this).data('date');

                    let show = true;

                    if (selectedDay !== 'all' && selectedDay !== day) {
                        show = false;
                    }

                    if (filterName && !name.includes(filterName)) {
                        show = false;
                    }

                    if (filterId && id !== filterId) {
                        show = false;
                    }

                    if (filterDate && date !== filterDate) {
                        show = false;
                    }

                    $(this).toggle(show);
                });
            }

            $('#filterSelect, #filterName, #filterId, #filterDate').on('input change', filterAppointments);
        });

        $(document).on('click', '.action-link.pending', function(event) {
            event.preventDefault();  
            const appointmentId = $(this).data('appointment-id');
            const doctorId = $(this).data('doctor-id');
            const userId = $(this).data('user-id');

            $.ajax({
                url: '/appoinment/appointments/get_patient_info',
                type: 'GET',
                data: { user_id: userId, appointment_id: appointmentId },
                success: function(response) {
                    $('#patientName').val(response.patient.name);
                    $('#patientPhone').val(response.patient.phone);
                    $('#patientEmail').val(response.patient.email);
                    $('#appointmentReason').val(response.appointment.reason);
                    $('#notArrivedUserId').val(userId);
                    $('#notArrivedAppointmentId').val(appointmentId);
                    $('#notArrivedDoctorId').val(doctorId);
                    $('#notArrivedModal').modal('show');
                },
                error: function() {
                    alert('Có lỗi xảy ra khi lấy thông tin bệnh nhân.');
                }
            });
        });



        function loadPendingAppointments() {
            $.ajax({
                url: "{{ route('appoinment.appointments.pending') }}",
                type: 'GET',
                data: {
                doctor_id: {{ $doctor->id }}
                },
                success: function(data) {
                    $('#appointments-grid').html(data);
                }
            });
        }

        setInterval(loadPendingAppointments, 5000);
        loadPendingAppointments();

        document.querySelectorAll('.date-select').forEach(function(select) {
            select.addEventListener('change', function() {
                let selectedDate = this.value;
                let doctorSchedule = this.closest('.schedule');
                let timeSlots = doctorSchedule.querySelectorAll('.time-slot-item');

                timeSlots.forEach(function(slot) {
                    if (slot.dataset.date === selectedDate) {
                        slot.style.display = 'block';
                    } else {
                        slot.style.display = 'none';
                    }
                });
            });
        });

        document.querySelectorAll('.date-select').forEach(function(select) {
            select.dispatchEvent(new Event('change'));
        });


        document.getElementById('filterSelect').addEventListener('change', function() {
            let selectedFilter = this.value;
            let appointmentItems = document.querySelectorAll('.appointment-item');

            appointmentItems.forEach(item => {
                let itemDay = item.getAttribute('data-day');
                if (selectedFilter === 'all') {
                    item.style.display = 'block';
                } else if (itemDay === selectedFilter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
    @endsection
</body>

</html>