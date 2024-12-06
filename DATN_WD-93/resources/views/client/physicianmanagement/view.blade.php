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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

        .button-group a {
            display: inline-block;
            width: 120px; /* Đảm bảo nút có kích thước bằng nhau */
            text-align: center;
            margin: 0 5px; /* Khoảng cách giữa các nút */
            padding: 8px 10px;
            border-radius: 5px;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Màu gradient xanh dương từ đậm đến nhạt */
        .custom-btn {
            background: linear-gradient(to right, #0056b3, #007bff); /* Xanh đậm đến nhạt */
            border: none;
        }

        .category-item {
            display: inline-block;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .category-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .category-item img {
            border: 1px solid #ddd;
            transition: border-color 0.2s ease;
        }

        .category-item img:hover {
            border-color: #007bff;
        }


        /* Hiệu ứng hover */
        .custom-btn:hover {
            background: linear-gradient(to right, #004085, #0056b3); /* Tăng độ đậm khi hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Tạo hiệu ứng nổi bật */
        }

        .custom-alert {
        position: fixed;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }
    .custom-alert button {
        background: #721c24;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
    }
    .custom-alert.hidden {
        display: none;
    }

        /* Hiệu ứng focus */
        .custom-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5); /* Viền focus màu xanh nhạt */
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
                Quản lý bệnh nhận và hồ sơ bệnh nhân của bác sỹ {{$doctor->user->name}}
            </a>
            <button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-bs-target="#navbarNav" data-bs-toggle="collapse" type="button">
                <span class="navbar-toggler-icon">
                </span>
            </button>
        </div>
    </nav>


    <div class="container">
        <div class="mt-9">
        <div class="col-md-12">
        <div class="profile-header d-flex flex-column flex-md-row align-items-center">
            <img alt="Doctor's profile picture" height="100" src="{{ asset('upload/' . $doctor->user->image) }}" width="100" />
            <div class="ml-md-3 mt-2 mt-md-0 text-center text-md-start">
                <h1>Bác Sỹ: {{$doctor->user->name}}</h1>
                <a href="{{ route('appoinment.statistics', $doctor->id) }}" class="btn btn-secondary">Thống kê chi tiết</a>
                <a href="{{ route('timeslot.doctor.schedule', $doctor->id) }}" class="btn btn-secondary">Quản lý thời gian làm việc</a>
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
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tên bệnh nhân</th>
                            <th>Số điện thoại</th>
                            <th>Lý do khám</th>
                            <th>Ngày</th>
                            <th>Thời gian</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors->timeSlot as $timeSlot)
                            @foreach($timeSlot->appoinment as $appoinment)
                                @if($appoinment->status_appoinment !== null)
                                    @php
                                        $formattedDateTime = \Carbon\Carbon::parse($timeSlot->date . ' ' . $timeSlot->startTime)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                                    @endphp
                                    <tr>
                                        <td>{{ $appoinment->user->name }}</td>
                                        <td>{{ $appoinment->user->phone }}</td>
                                        <td>{{ $appoinment->notes }}</td>
                                        <td>{{ $formattedDateTime }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}
                                        </td>
                                        <td>
                                            @if($appoinment->status_appoinment === 'huy_lich_hen')
                                                <span class="text-danger">Lịch hẹn đã bị hủy</span>
                                            @elseif($appoinment->status_appoinment === 'da_xac_nhan')
                                                <span class="text-success">Đã xác nhận</span>
                                            @elseif($appoinment->status_appoinment === 'kham_hoan_thanh')
                                                <span class="text-primary">Đã khám thành công</span>
                                            @elseif($appoinment->status_appoinment === 'can_tai_kham')
                                                <span class="text-warning">Cần tái khám</span>
                                            @elseif($appoinment->status_appoinment === 'benh_nhan_khong_den')
                                                <span class="text-info">Bệnh nhân vắng mặt</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($appoinment->status_appoinment === 'da_xac_nhan')
                                            <div class="button-group">
                                                @if($appoinment->meet_link)
                                                <a href="{{ $appoinment->meet_link }}" target="_blank" class="btn custom-btn">Link Khám</a>
                                                @else
                                                
                                                @endif
                                                <a href="#" class="btn action-link confirm" data-appointment-id="{{ $appoinment->id }}">Xác nhận đang khám</a>
                                                <a href="#" class="btn action-link pending" data-user-id="{{ $appoinment->user_id }}" data-appointment-id="{{ $appoinment->id }}" data-doctor-id="{{ $doctor->id }}">Bệnh nhân chưa đến</a>
                                            </div>
                                            @elseif($appoinment->status_appoinment === 'kham_hoan_thanh' || $appoinment->status_appoinment === 'can_tai_kham')
                                                <a href="#" class="btn btn-info btn-sm appointment-history-link" data-appointment-id="{{ $appoinment->id }}">Chi tiết hóa đơn</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        
        <div id="appointmentHistoryModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Chi tiết lịch hẹn</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="appointmentHistoryContent">
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
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
                                <h4>Danh mục thuốc:</h4>
                                <div id="drug-category" class="d-flex flex-wrap">
                                    
                                </div>

                                <h4>Danh sách thuốc theo danh mục:</h4>
                                <div id="drug-list" class="d-flex flex-wrap">
                                    <p>Chọn danh mục để hiển thị thuốc.</p>
                                </div>

                                <h4>Thuốc đã chọn:</h4>
                                <div id="selected-drugs">
                                    <p>Chưa có thuốc nào được chọn.</p>
                                </div>
                             
                                <div id="selected-drugs-container"></div>
                                <input type="hidden" id="total_price_input" name="total_price">

                            </div>

                            <div id="custom-alert" class="custom-alert hidden">
                                <p id="alert-text"></p>
                                <button id="close-alert">Đóng</button>
                            </div>
                            
                            <div class="modal fade" id="drugInfoModal" tabindex="-1" aria-labelledby="drugInfoLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="drugInfoLabel">Thông tin thuốc</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="drug-info-body">
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
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

                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                            selectedTimeSlotIdInput.value = item.getAttribute('data-id');
                                            item.classList.replace('btn-outline-primary', 'btn-primary');
                                        });
                                    });
                                });

                                document.addEventListener("DOMContentLoaded", function () {
                                const drugCategoryContainer = document.getElementById("drug-category");
                                const drugListContainer = document.getElementById("drug-list");
                                const selectedDrugsContainer = document.getElementById("selected-drugs");

                                let selectedDrugs = {};
                                let totalPrice = 0;

                                function loadDrugCategories() {
                                    fetch('/appoinment/get-drug-categories')
                                        .then(response => response.json())
                                        .then(categories => {
                                            drugCategoryContainer.innerHTML = '';
                                            categories.forEach(category => {
                                                const categoryDiv = document.createElement('div');
                                                categoryDiv.className = 'category-item m-2 text-center';
                                                categoryDiv.style = "cursor: pointer; width: 150px;";

                                                const categoryImg = document.createElement('img');
                                                categoryImg.src = category.img;
                                                categoryImg.alt = category.name;
                                                categoryImg.style = "width: 100%; height: 100px; object-fit: cover; border-radius: 8px;";

                                                const categoryName = document.createElement('div');
                                                categoryName.textContent = category.name;
                                                categoryName.style = "margin-top: 8px; font-weight: bold;";

                                                categoryDiv.addEventListener('click', () => loadDrugs(category.id));

                                                categoryDiv.appendChild(categoryImg);
                                                categoryDiv.appendChild(categoryName);

                                                drugCategoryContainer.appendChild(categoryDiv);
                                            });
                                        });
                                }

                                function loadDrugs(categoryId) {
                                    fetch(`/appoinment/get-drugs-by-category/${categoryId}`)
                                        .then(response => response.json())
                                        .then(drugs => {
                                            drugListContainer.innerHTML = '';
                                            if (drugs.length === 0) {
                                                drugListContainer.innerHTML = '<p>Không có thuốc nào trong danh mục này.</p>';
                                                return;
                                            }
                                            drugs.forEach(drug => {
                                                if (!selectedDrugs[drug.id]) {
                                                    const drugDiv = document.createElement('div');
                                                    drugDiv.className = 'drug-item mb-3';

                                                    const drugImg = document.createElement('img');
                                                    drugImg.src = drug.image_url;
                                                    drugImg.alt = drug.name;
                                                    drugImg.style = "width: 100px; height: 100px; cursor: pointer;";

                                                    const drugInfo = document.createElement('div');
                                                    drugInfo.className = 'drug-info';
                                                    drugInfo.style.display = 'none';
                                                    drugInfo.innerHTML = `
                                                        <p><strong>Thành phần:</strong> ${drug.description}</p>
                                                    `;

                                                    drugImg.addEventListener('mouseover', () => {
                                                        drugInfo.style.display = 'block';
                                                    });

                                                    drugImg.addEventListener('mouseout', () => {
                                                        drugInfo.style.display = 'none';
                                                    });

                                                    const drugCheckbox = document.createElement('input');
                                                    drugCheckbox.type = 'checkbox';
                                                    drugCheckbox.id = `drug-${drug.id}`;
                                                    drugCheckbox.addEventListener('change', () => addDrugToSelection(drug, drugCheckbox.checked));

                                                    const drugLabel = document.createElement('label');
                                                    drugLabel.htmlFor = `drug-${drug.id}`;
                                                    drugLabel.textContent = drug.name;

                                                    drugDiv.appendChild(drugImg);
                                                    drugDiv.appendChild(drugInfo);
                                                    drugDiv.appendChild(drugLabel);
                                                    drugDiv.appendChild(drugCheckbox);

                                                    drugListContainer.appendChild(drugDiv);
                                                }
                                            });
                                        });
                                }

                                function addDrugToSelection(drug, isChecked) {
                                    if (isChecked) {
                                        if (!selectedDrugs[drug.id]) {
                                            const drugDiv = document.createElement('div');
                                            drugDiv.id = `selected-drug-${drug.id}`;
                                            drugDiv.className = 'selected-drug mb-3';

                                            const drugLabel = document.createElement('h5');
                                            drugLabel.textContent = drug.name;

                                            const variantSelect = document.createElement('select');
                                            variantSelect.className = 'form-control mt-2';
                                            variantSelect.addEventListener('change', (e) => {
                                                const selectedVariantId = e.target.value;
                                                const selectedVariant = drug.variantProducts.find(v => v.id == selectedVariantId);

                                                if (selectedVariant) {
                                                    selectedDrugs[drug.id].variant = selectedVariant;

                                                    const quantityInput = document.querySelector(`#selected-drug-${drug.id} input[type='number']`);
                                                    if (quantityInput) {
                                                        const currentInputQuantity = parseInt(quantityInput.value) || 1;

                                                        if (currentInputQuantity > selectedVariant.quantity) {
                                                            alert(`Số lượng nhập vượt quá tồn kho! Tồn kho hiện tại là ${selectedVariant.quantity}.`);
                                                            quantityInput.value = selectedVariant.quantity;
                                                        }
                                                    }

                                                    updatePrice(drug.id);
                                                }
                                            });


                                            drug.variantProducts.forEach(variant => {
                                                const option = document.createElement('option');
                                                option.value = variant.id;
                                                option.textContent = `${variant.name} - Giá: ${variant.price} VND - Số lượng: ${variant.quantity}`;
                                                variantSelect.appendChild(option);
                                            });

                                            const quantityInput = document.createElement('input');
                                            quantityInput.type = 'number';
                                            quantityInput.min = '1';
                                            quantityInput.value = '1';
                                            quantityInput.className = 'form-control mt-2';
                                            quantityInput.addEventListener('input', (e) => {
                                                const inputQuantity = parseInt(e.target.value) || 1;
                                                const currentVariant = selectedDrugs[drug.id].variant;

                                                if (inputQuantity <= 0) {
                                                    alert("Số lượng phải lớn hơn 0!");
                                                    e.target.value = 1; 
                                                } else if (inputQuantity > currentVariant.quantity) {
                                                    alert(`Số lượng nhập vượt quá tồn kho! Tồn kho hiện tại là ${currentVariant.quantity}.`);
                                                    e.target.value = currentVariant.quantity; 
                                                } else {
                                                    selectedDrugs[drug.id].quantity = inputQuantity;
                                                    updatePrice(drug.id);
                                                }
                                            });

                                            const priceLabel = document.createElement('p');
                                            priceLabel.id = `price-${drug.id}`;
                                            priceLabel.textContent = `Giá: ${drug.variantProducts[0].price} VND`;

                                            const removeButton = document.createElement('button');
                                            removeButton.className = 'btn btn-danger mt-2';
                                            removeButton.textContent = 'Xóa';
                                            removeButton.addEventListener('click', () => removeDrugFromSelection(drug.id));

                                            drugDiv.appendChild(drugLabel);
                                            drugDiv.appendChild(variantSelect);
                                            drugDiv.appendChild(quantityInput);
                                            drugDiv.appendChild(priceLabel);
                                            drugDiv.appendChild(removeButton);

                                            selectedDrugsContainer.appendChild(drugDiv);

                                            selectedDrugs[drug.id] = {
                                                name: drug.name,
                                                variant: drug.variantProducts[0],
                                                quantity: 1
                                            };

                                            updatePrice(drug.id);
                                        }
                                    } else {
                                        removeDrugFromSelection(drug.id);
                                    }
                                }

                                function updatePrice(drugId) {
                                    if (selectedDrugs[drugId]) {
                                        const drug = selectedDrugs[drugId];
                                        const totalDrugPrice = drug.variant.price * drug.quantity;

                                        const priceLabel = document.getElementById(`price-${drugId}`);
                                        if (priceLabel) {
                                            priceLabel.textContent = `Giá: ${totalDrugPrice.toLocaleString()} VND`;
                                        }

                                        calculateTotalPrice();
                                    }
                                }

                                function updateVariantQuantity(drugId, selectedVariant) {
                                    const quantityInput = document.querySelector(`#selected-drug-${drugId} input[type='number']`);
                                    const alertBox = document.getElementById('custom-alert');
                                    const alertText = document.getElementById('alert-text');
                                    const closeAlertButton = document.getElementById('close-alert');

                                    if (quantityInput) {
                                        const currentQuantity = parseInt(quantityInput.value) || 1;
                                        if (currentQuantity > selectedVariant.quantity) {
                                            alertText.textContent = `Số lượng vượt quá tồn kho! Tồn kho hiện tại: ${selectedVariant.quantity}.`;
                                            alertBox.classList.remove('hidden');

                                            closeAlertButton.addEventListener('click', () => {
                                                alertBox.classList.add('hidden');
                                            });

                                            quantityInput.value = selectedVariant.quantity;
                                            selectedDrugs[drugId].quantity = selectedVariant.quantity;
                                        }
                                    }
                                }

                                function removeDrugFromSelection(drugId) {
                                    delete selectedDrugs[drugId];

                                    const selectedDrugElement = document.getElementById(`selected-drug-${drugId}`);
                                    if (selectedDrugElement) {
                                        selectedDrugElement.remove(); 
                                    }

                                    calculateTotalPrice();
                                }

                                function calculateTotalPrice() {
                                    totalPrice = Object.values(selectedDrugs).reduce((sum, drug) => {
                                        return sum + (drug.variant.price * drug.quantity);
                                    }, 0);

                                    const totalPriceElement = document.getElementById('total-price');
                                    if (!totalPriceElement) {
                                        const priceDiv = document.createElement('div');
                                        priceDiv.id = 'total-price';
                                        priceDiv.className = 'mt-3';
                                        priceDiv.style = 'font-weight: bold; font-size: 1.2em;';
                                        priceDiv.textContent = `Tổng tiền: ${totalPrice.toLocaleString()} VND`;
                                        selectedDrugsContainer.appendChild(priceDiv);
                                    } else {
                                        totalPriceElement.textContent = `Tổng tiền: ${totalPrice.toLocaleString()} VND`;
                                    }
                                }

                                document.getElementById("confirmPurchase").addEventListener("click", function () {
                                    const selectedDrugsContainer = document.getElementById("selected-drugs-container");
                                    const totalPriceInput = document.getElementById("total_price_input");

                                    selectedDrugsContainer.innerHTML = '';  

                                    const drugIds = Object.keys(selectedDrugs); 

                                    
                                    drugIds.forEach(drugId => {
                                        const drug = selectedDrugs[drugId];  
                                        const productIdInput = document.createElement("input");
                                        productIdInput.type = "hidden";
                                        productIdInput.name = "order_details[][product_id]";
                                        productIdInput.value = drugId;

                                        const unitPriceInput = document.createElement("input");
                                        unitPriceInput.type = "hidden";
                                        unitPriceInput.name = "order_details[][unit_price]";
                                        unitPriceInput.value = drug.variant.price;

                                        const quantityInput = document.createElement("input");
                                        quantityInput.type = "hidden";
                                        quantityInput.name = "order_details[][quantity]";
                                        quantityInput.value = drug.quantity;

                                        const totalMoneyInput = document.createElement("input");
                                        totalMoneyInput.type = "hidden";
                                        totalMoneyInput.name = "order_details[][total_money]";
                                        totalMoneyInput.value = drug.variant.price * drug.quantity;

                                        const variantIdInput = document.createElement("input");
                                        variantIdInput.type = "hidden";
                                        variantIdInput.name = "order_details[][variant_id]";
                                        variantIdInput.value = drug.variant.id;

                                     
                                        selectedDrugsContainer.appendChild(productIdInput);
                                        selectedDrugsContainer.appendChild(unitPriceInput);
                                        selectedDrugsContainer.appendChild(quantityInput);
                                        selectedDrugsContainer.appendChild(totalMoneyInput);
                                        selectedDrugsContainer.appendChild(variantIdInput);
                                    });

                                    totalPriceInput.value = totalPrice;
                                });

                                loadDrugCategories();
                            });


                            </script>

                            <div class="mb-3">
                                <label for="" class="form-label">Ghi chu thêm</label>
                                <textarea class="form-control" name="notes" rows="3" placeholder="Ghi chu thêm" required></textarea>
                            </div>
                            <button type="submit" id="confirmPurchase" class="btn btn-primary">Xác nhận</button>
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
    <h5>Tra cứu hồ sơ khám bệnh</h5>

    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm bệnh nhân...">
    </div>



    <div id="patientList">
    @foreach($users as $us)
    @php
        // Tìm thông tin thống kê của người dùng hiện tại
        $userStat = $completionStats->firstWhere('user_id', $us->id);

        // Kiểm tra xem người dùng có phải là người mới hay không
        $isNewUser = !$userStat || $userStat->total_appointments < 3;

        // Xác định màu nền
        $bgColor = 'background-color: #ffffff;'; // Mặc định màu trắng
        if (!$isNewUser) {
            if ($userStat->completion_rate >= 70) {
                $bgColor = 'background-color: #28a745;'; // Xanh lá cây
            } elseif ($userStat->completion_rate >= 50) {
                $bgColor = 'background-color: #ff9800;'; // Màu cam
            } else {
                $bgColor = 'background-color: #dc3545;'; // Màu đỏ
            }
        }
    @endphp

    <div class="card mb-3 patient-card" data-name="{{ $us->name }}" style="{{ $bgColor }}">
        <div class="row g-0 align-items-center">
            <div class="col-md-3">
                <img src="{{ asset('upload/' . $us->image) }}" alt="Ảnh bệnh nhân" class="img-fluid rounded">
            </div>
            <div class="col-md-9">
                <div class="card-body">
                    <a href="{{ route('appoinment.physicianManagementdoctor', ['id1' => $us->id, 'id2' => $doctor->id]) }}">Chi tiết bệnh nhân</a>
                    <p>Tên bệnh nhân: <strong>{{ $us->name }}</strong></p>
                    <p>Số điện thoại bệnh nhân: <strong>{{ $us->phone }}</strong></p>
                    <p>Email bệnh nhân: <strong>{{ $us->email }}</strong></p>
                    @if(!$isNewUser)
                        <p>Phần trăm hoàn thành đơn: <strong>{{ $userStat->completion_rate }}%</strong></p>
                    @else
                        <p>Phần trăm hoàn thành đơn: <strong>Chưa có đủ dữ liệu</strong></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach

    </div>

    </div>

    </div>
</div>
            <div style="margin-top: 10px;">
                <h5>ĐỊA CHỈ KHÁM</h5>
                @if(!empty($clinic))
                <p>{{$clinic->address}}, {{$clinic->city}}</p>
                <p>{{$clinic->clinic_name}}</p>
                @else
                <p>Khám qua video call</p>
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
                    $('#confirmModalLabel').text('Xác nhận đang khám bệnh nhân: ' + data.user_name);
                    $('#appointmentId').val(data.appointment_id);
                    $('#doctorId').val(data.doctor_id);
                    $('#confirmModal').modal('show');
                },
                error: function() {
                    alert('Có lỗi xảy ra khi lấy dữ liệu cuộc hẹn.');
                }
            });
        });

        document.getElementById('searchInput').addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            const patientCards = document.querySelectorAll('.patient-card');

            patientCards.forEach(function (card) {
                const name = card.getAttribute('data-name').toLowerCase();
                if (name.includes(filter)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        $(document).on('click', '.appointment-history-link', function(event) {
            event.preventDefault();
            const appointmentId = $(this).data('appointment-id');

            $.ajax({
                url: `/appoinment/appointment_histories/${appointmentId}`,
                type: 'GET',
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    let content = `<p>ID lịch hẹn: ${data.appoinment_id}</p>`;
                    content += `<p>Chẩn đoán: ${data.diagnosis || 'Không có thông tin'}</p>`;
                    content += `<p>Ngày tái khám: ${data.follow_up_date || 'Không có có ngày tái khám'}</p>`;
                    content += `<p>Ghi chú: ${data.notes || 'Không có thông tin'}</p>`;

                    if (data.order_details && data.order_details.length > 0) {
                        content += `<h5>Chi tiết đơn thuốc:</h5>`;
                        content += `<table class="table table-bordered"><thead>
                                        <tr>
                                            <th>Tên sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Đơn giá</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                    </thead><tbody>`;
                        data.order_details.forEach(order => {
                            content += `<tr>
                                            <td><a href="http://127.0.0.1:8000/products/detail/${order.product_id}" target="_blank">${order.product_name}</a></td>
                                            <td>${order.quantity}</td>
                                            <td>${order.unit_price}</td>
                                            <td>${order.total_money}</td>
                                        </tr>`;
                        });
                        content += `</tbody></table>`;
                    } else {
                        content += `<p>Không có chi tiết đơn thuốc.</p>`;
                    }

                    $('#appointmentHistoryContent').html(content);
                    $('#appointmentHistoryModal').modal('show');
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.error || 'Không thể tải chi tiết lịch hẹn.';
                    alert(errorMessage);
                }
            });

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
                    autoConfirmAppointments(); 
                }
            });
        }

        function loadTodayAppointments() {
            $.ajax({
                url: "{{ route('appoinment.appointments.today') }}",
                type: 'GET',
                data: {
                    doctor_id: {{ $doctor->id }}
                },
                success: function(data) {
                    $('.appointments-grid2').html(data); 
                }
            });
        }

        function autoConfirmAppointments() {
            const appointments = document.querySelectorAll('.appointment-item');

            if (appointments.length > 0) {
                appointments.forEach((appointment) => {
                    const status = appointment.querySelector('.text-warning');
                    const form = appointment.querySelector('.confirm-form');

                    if (status && form) {
                        setTimeout(() => {
                            const appointmentId = appointment.dataset.appointmentId;
                            console.log(`Tự động xác nhận đơn hàng ID: ${appointmentId}`);

                            
                            $.ajax({
                                url: form.action,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    console.log(`Đơn hàng ID ${appointmentId} đã được xác nhận.`);
                                    loadPendingAppointments(); 
                                    loadTodayAppointments();
                                },
                                error: function(error) {
                                    console.error(`Lỗi khi xác nhận đơn hàng ID ${appointmentId}:`, error);
                                }
                            });
                        }, 5000); 
                    }
                });
            }
        }

        setInterval(loadPendingAppointments, 5000);
        loadPendingAppointments();
        loadTodayAppointments();


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
