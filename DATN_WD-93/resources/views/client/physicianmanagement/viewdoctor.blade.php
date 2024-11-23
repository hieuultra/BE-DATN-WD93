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

        .rating:not(:checked)>input {
            position: absolute;
            appearance: none;
        }

        .rating:not(:checked)>label {
            float: right;
            cursor: pointer;
            font-size: 30px;
            color: #666;
        }

        .rating:not(:checked)>label:before {
            content: '★';
        }

        .rating>input:checked+label:hover,
        .rating>input:checked+label:hover~label,
        .rating>input:checked~label:hover,
        .rating>input:checked~label:hover~label,
        .rating>label:hover~input:checked~label {
            color: #e58e09;
        }

        .rating:not(:checked)>label:hover,
        .rating:not(:checked)>label:hover~label {
            color: #ff9e0b;
        }

        .rating>input:checked~label {
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
                Quay lại
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
                    <img alt="Doctor's profile picture" height="100" src="{{ asset('upload/' . $user->image) }}" width="100" />
                    <div class="ml-md-3 mt-2 mt-md-0 text-center text-md-start">
                        <h1>Tên bệnh nhân: {{$user->name}}</h1>
                    </div>
                </div>

                <div class="filter-form mb-3">
                    <div class="row">
                        <!-- Lọc theo mã hóa đơn -->
                        <div class="col-md-4">
                            <label for="filterInvoiceId">Mã hóa đơn:</label>
                            <input type="text" id="filterInvoiceId" class="form-control" placeholder="Nhập mã hóa đơn">
                        </div>

                        <!-- Lọc theo khoảng ngày -->
                        <div class="col-md-4">
                            <label for="filterStartDate">Từ ngày:</label>
                            <input type="date" id="filterStartDate" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="filterEndDate">Đến ngày:</label>
                            <input type="date" id="filterEndDate" class="form-control">
                        </div>
                    </div>
                    <button id="filterButton" class="btn btn-primary mt-3">Lọc</button>
                </div>


                <div class="appointments mt-3" style="margin-top: 10px;">
                    <h5>Lịch hẹn ngày hôm nay</h5>
                    <div class="appointments-grid2">
                        @foreach($appoinments as $appoinment)

                        @if($appoinment->status_appoinment !== null)
                        <div class="appointment-item2">
                            <p>Mã hóa đơn: {{$appoinment->id}}</p>
                            <p>Tên bệnh nhân: {{$appoinment->user->name}}</p>
                            <p>Số điện thoại: {{$appoinment->user->phone}}</p>
                            <p>Lý do khám: {{$appoinment->notes}}</p>
                            <p>Ngày: {{$appoinment->timeSlot->date}}</p>
                            <p>Thời gian: {{ \Carbon\Carbon::createFromFormat('H:i:s', $appoinment->timeSlot->startTime)->format('H:i') }} -
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $appoinment->timeSlot->endTime)->format('H:i') }}
                            </p>
                            @if($appoinment->status_appoinment === 'huy_lich_hen')
                            <p style="color: red;">Lịch hẹn đã bị hủy</p>
                            @elseif($appoinment->status_appoinment === 'kham_hoan_thanh')
                            <p style="color: blue;">Đã khám thành công</p>
                            <a href="#" class="appointment-history-link" data-appointment-id="{{ $appoinment->id }}">Chi tiết hóa đơn</a>
                            @elseif($appoinment->status_appoinment === 'can_tai_kham')
                            <p style="color: blueviolet;">Cần tái khám</p>
                            <a href="#" class="appointment-history-link" data-appointment-id="{{ $appoinment->id }}">Chi tiết hóa đơn</a>
                            @elseif($appoinment->status_appoinment === 'benh_nhan_khong_den')
                            <p style="color: green;">Bệnh nhân vắng mặt</p>
                            @else
                            <p style="color: yellowgreen;">Đã xác nhận đang chờ đến ngày khám</p>
                            <a href="#" class="cancel-appointment-link" data-appointment-id="{{ $appoinment->id }}">Hủy lịch hẹn</a>
                            @endif
                        </div>
                        @endif

                        @endforeach
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
                                <!-- Nội dung sẽ được AJAX cập nhật -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).on('click', '.appointment-history-link', function(event) {
            event.preventDefault();
            const appointmentId = $(this).data('appointment-id');

            $.ajax({
                url: `/appoinment/appointment_histories/${appointmentId}`, // Sửa lỗi chính tả
                type: 'GET',
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    let content = `<p>ID lịch hẹn: ${data.appoinment_id}</p>`;
                    content += `<p>Chẩn đoán: ${data.diagnosis || 'Không có thông tin'}</p>`;
                    content += `<p>Đơn thuốc: ${data.prescription || 'Không có thông tin'}</p>`;
                    content += `<p>Ngày tái khám: ${data.follow_up_date || 'Không có có ngày tái khám'}</p>`;
                    content += `<p>Ghi chú: ${data.notes || 'Không có thông tin'}</p>`;
                    $('#appointmentHistoryContent').html(content);

                    $('#appointmentHistoryModal').modal('show');
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.error || 'Không thể tải chi tiết lịch hẹn.';
                    alert(errorMessage);
                }
            });
        });



        document.getElementById('filterButton').addEventListener('click', function() {
            const invoiceId = document.getElementById('filterInvoiceId').value.toLowerCase();
            const startDate = document.getElementById('filterStartDate').value;
            const endDate = document.getElementById('filterEndDate').value;

            // Lấy tất cả các mục lịch hẹn
            const appointments = document.querySelectorAll('.appointment-item2');

            appointments.forEach(appointment => {
                const invoiceText = appointment.querySelector('p:nth-child(1)').textContent.toLowerCase();
                const dateText = appointment.querySelector('p:nth-child(5)').textContent;

                // Lấy ngày từ text
                const appointmentDate = new Date(dateText.split(': ')[1]);

                let matchesInvoice = true;
                let matchesDate = true;

                // Kiểm tra mã hóa đơn
                if (invoiceId && !invoiceText.includes(invoiceId)) {
                    matchesInvoice = false;
                }

                // Kiểm tra khoảng ngày
                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    if (appointmentDate < start || appointmentDate > end) {
                        matchesDate = false;
                    }
                }

                // Hiển thị hoặc ẩn lịch hẹn
                if (matchesInvoice && matchesDate) {
                    appointment.style.display = '';
                } else {
                    appointment.style.display = 'none';
                }
            });
        });


        document.addEventListener('DOMContentLoaded', () => {
        // Bắt sự kiện khi nhấn vào liên kết "Hủy lịch hẹn"
        document.querySelectorAll('.cancel-appointment-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                const appointmentId = this.getAttribute('data-appointment-id');
                const confirmation = confirm('Bạn có chắc chắn muốn hủy lịch hẹn này không?');

                if (confirmation) {
                    // Gửi yêu cầu AJAX để cập nhật status_appoinment
                    fetch(`/appoinment/appointments/cancel/${appointmentId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Lịch hẹn đã được hủy.');
                                location.reload(); // Tải lại trang để cập nhật danh sách
                            } else {
                                alert('Hủy lịch hẹn thất bại. Vui lòng thử lại.');
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        });
                }
            });
        });
    });
    </script>
    @endsection
</body>

</html>