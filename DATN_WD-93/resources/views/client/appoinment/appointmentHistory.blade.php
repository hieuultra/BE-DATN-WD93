<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lịch Sử Đặt Lịch Khám</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        .price {
            font-weight: bold;
        }

        .btn-custom {
            margin-right: 5px;
        }

        .btn-group .btn.active {
            background-color: #ffc107;
            color: #000;
        }

        .btn-custom-yellow {
            background-color: yellow;
            color: white;
            border: 1px solid yellow;
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
    </style>
</head>

<body>
    @extends('layout')
    @section('content')
    <div class="container">
        <h1 class="text-center">Lịch Sử Đặt Lịch Khám</h1>

        <div class="filter-bar mb-3">
            <label for="statusFilter">Lọc theo trạng thái:</label>
            <select id="statusFilter" class="form-control" style="width: 200px; display: inline-block;">
                <option value="">Tất cả</option>
                <option value="cho_xac_nhan">Đang chờ xác nhận</option>
                <option value="da_xac_nhan">Đã xác nhận</option>
                <option value="yeu_cau_huy">Yêu cầu hủy</option>
                <option value="kham_hoan_thanh">Khám hoàn tất</option>
                <option value="can_tai_kham">Cần tái khám</option>
                <option value="benh_nhan_khong_den">Bệnh nhân không đến</option>
                <option value="huy_lich_hen">Lịch hẹn đã bị hủy</option>
            </select>
        </div>

        <div class="btn-group my-3" role="group">
            <button type="button" class="btn btn-primary active" onclick="showMyAppointments(this)">Lịch Đặt Khám Của Mình</button>
            <button type="button" class="btn btn-secondary" onclick="showFamilyAppointments(this)">Lịch Đặt Cho Người Thân</button>
        </div>

        <!--Đặt lịch cho bản thân-->
        <div id="myAppointments" style="display: block;">
            <h2 class="text-center">Lịch sử đặt cho bản thân</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã lịch khám</th>
                            <th>Ngày khám</th>
                            <th>Thời gian</th>
                            <th>Bác sĩ</th>
                            <th>Địa điểm</th>
                            <th>Giá</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appoinments as $appointment)
                        @foreach($available as $time)
                        @if($time->id == $appointment->available_timeslot_id && $appointment->classify == 'ban_than')
                        @php
                        $formattedDate = \Carbon\Carbon::parse($time->date)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                        $review = $reviewDortor->filter(function ($rv) use ($appointment) {
                        return $rv->doctor_id == $appointment->doctor_id && $rv->appoinment_id == $appointment->id;
                        })->first();
                        @endphp
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $formattedDate }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $time->startTime)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->endTime)->format('H:i') }}</td>
                            <td>{{ $appointment->doctor ? $appointment->doctor->user->name : $appointment->package->hospital_name }}</td>
                            <td>
                                @if($appointment->doctor)
                                @foreach($clinics as $clinic)
                                @if($clinic->doctor_id == $appointment->doctor->id)
                                Phòng khám {{ $clinic->address }}, {{ $clinic->city }}
                                @endif
                                @endforeach
                                @else
                                {{ $appointment->package->address }}
                                @endif
                                @if($appointment->meet_link && $appointment->status_appoinment != 'huy_lich_hen' && $appointment->status_appoinment != 'benh_nhan_khong_den')
                                <p><strong>Link meet:</strong> <a href="{{ $appointment->meet_link }}" target="_blank">{{ $appointment->meet_link }}</a></p>
                                @else
                                
                                @endif
                            </td>
                            <td>{{ number_format($appointment->doctor ? $appointment->doctor->examination_fee : $appointment->package->price, 0, ',', '.') }} đ</td>
                            <td>
                                @if($appointment->status_payment_method == 'da_thanh_toan')
                                <span style="color: green;">Đã thanh toán</span>
                                @else
                                <span style="color: red;">Chưa thanh toán</span>
                                @endif
                            </td>
                            <td>
                                @switch($appointment->status_appoinment)
                                @case('cho_xac_nhan')
                                <span data-status="cho_xac_nhan" style="color: yellowgreen;">Đang chờ xác nhận</span>
                                @break

                                @case('da_xac_nhan')
                                <span data-status="da_xac_nhan" style="color: blue;">Lịch hẹn đã được xác nhận</span>
                                @break

                                @case('yeu_cau_huy')
                                <span data-status="yeu_cau_huy" style="color: blueviolet;">Yêu cầu hủy đang chờ duyệt</span>
                                @break

                                @case('kham_hoan_thanh')
                                <span data-status="kham_hoan_thanh" style="color: green;">Khám hoàn tất</span>
                                @break

                                @case('can_tai_kham')
                                <span data-status="can_tai_kham" style="color: green;">Cần tái khám</span>
                                @break

                                @case('benh_nhan_khong_den')
                                <span data-status="benh_nhan_khong_den" style="color: orangered;">Bệnh nhân không đến</span>
                                @break

                                @case('huy_lich_hen')
                                <span data-status="huy_lich_hen" style="color: red;">Lịch hẹn đã bị hủy</span>
                                @break
                                @endswitch
                            </td>
                            <td>
                                @if($appointment->status_appoinment == 'cho_xac_nhan')
                                <a href="#" class="btn btn-danger btn-custom cancel-appointment-btn"
                                    data-id="{{ $appointment->id }}"
                                    data-name="{{ $appointment->package ? $appointment->package->hospital_name : 'N/A' }}"
                                    data-date="{{ $formattedDate }}"
                                    data-time="{{ \Carbon\Carbon::createFromFormat('H:i:s', $time->startTime)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->endTime)->format('H:i') }}"
                                    data-doctor="{{ $appointment->doctor ? $appointment->doctor->user->name : 'N/A' }}">
                                    Hủy lịch đặt
                                </a>
                                @elseif($appointment->status_appoinment == 'kham_hoan_thanh' || $appointment->status_appoinment == 'can_tai_kham')
                                @if($review)
                                <a href="#" class="btn btn-primary btn-sm edit-review-btn" data-id="{{ $review->id }}">Xem đánh giá</a>
                                @else
                                <a href="#" class="btn btn-warning btn-sm review-btn" data-id="{{ $appointment->id }}">Đánh giá bác sĩ</a>
                                @endif
                                <a href="#" class="btn btn-info btn-sm appointment-history-link" data-appointment-id="{{ $appointment->id }}">Chi tiết hóa đơn</a>
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

        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel">Đánh giá bác sĩ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('appoinment.reviewDortor') }}" method="POST">
                            @csrf
                            <input type="hidden" id="userId" name="user_id">
                            <input type="hidden" id="doctorId" name="doctor_id">
                            <input type="hidden" id="appoinmentId" name="appoinment_id">

                            <div class="mb-3">
                                <label for="rating" class="form-label">Đánh giá</label>
                                <div class="rating">
                                    <input value="5" name="rating" id="star5" type="radio">
                                    <label title="text" for="star5"></label>
                                    <input value="4" name="rating" id="star4" type="radio" checked="">
                                    <label title="text" for="star4"></label>
                                    <input value="3" name="rating" id="star3" type="radio">
                                    <label title="text" for="star3"></label>
                                    <input value="2" name="rating" id="star2" type="radio">
                                    <label title="text" for="star2"></label>
                                    <input value="1" name="rating" id="star1" type="radio">
                                    <label title="text" for="star1"></label>
                                </div>
                            </div><br>
                            <div class="mb-3">
                                <label for="review" class="form-label">Nhận xét</label>
                                <textarea class="form-control" id="review" name="comment" rows="3" placeholder="Nhận xét của bạn về bác sĩ"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editReviewModalLabel">Sửa đánh giá</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editReviewForm">
                            <input type="hidden" id="reviewId" name="review_id">

                            <div class="mb-3">
                                <label for="editComment" class="form-label">Nội dung đánh giá</label>
                                <textarea class="form-control" id="editComment" name="comment" rows="3"></textarea>
                            </div>

                            <div class="mb-3">

                                @for ($i = 5; $i >= 1; $i--)
                                <input id="star{{ $i }}" name="rating" value="{{ $i }}" type="radio">
                                <label for="star{{ $i }}">{{ $i }} sao</label>
                                @endfor

                            </div>

                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="cancelAppointmentModal" tabindex="-1" aria-labelledby="cancelAppointmentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelAppointmentModalLabel">Hủy lịch hẹn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="cancelAppointmentForm">
                            <input type="hidden" id="modalAppointmentId" name="appointment_id">

                            <div class="mb-3">
                                <label for="name" class="form-label">Tên loại khám tổng quát</label>
                                <input type="text" class="form-control" id="name" name="name" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="appointmentDate" class="form-label">Ngày khám</label>
                                <input type="text" class="form-control" id="appointmentDate" name="appointmentDate" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="appointmentTime" class="form-label">Thời gian</label>
                                <input type="text" class="form-control" id="appointmentTime" name="appointmentTime" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="doctor" class="form-label">Bác sĩ</label>
                                <input type="text" class="form-control" id="doctor" name="doctor" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Lý do hủy</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                        </form>
                    </div>
                </div>
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


        <!--Đặt lịch cho người thân-->
        <div id="familyAppointments" style="display: none;">
            <h2 class="text-center">Lịch sử đặt cho bản thân</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã lịch khám</th>
                            <th>Ngày khám</th>
                            <th>Thời gian</th>
                            <th>Bác sĩ</th>
                            <th>Địa điểm</th>
                            <th>Giá</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appoinments as $appointment)
                        @foreach($available as $time)
                        @if($time->id == $appointment->available_timeslot_id && $appointment->classify == 'cho_gia_dinh')
                        @php
                        $formattedDate = \Carbon\Carbon::parse($time->date)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                        $review = $reviewDortor->filter(function ($rv) use ($appointment) {
                        return $rv->doctor_id == $appointment->doctor_id && $rv->appoinment_id == $appointment->id;
                        })->first();
                        @endphp
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $formattedDate }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $time->startTime)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->endTime)->format('H:i') }}</td>
                            <td>{{ $appointment->doctor ? $appointment->doctor->user->name : $appointment->package->hospital_name }}</td>
                            <td>
                                @if($appointment->doctor)
                                @foreach($clinics as $clinic)
                                @if($clinic->doctor_id == $appointment->doctor->id)
                                Phòng khám {{ $clinic->address }}, {{ $clinic->city }}
                                @endif
                                @endforeach
                                @else
                                {{ $appointment->package->address }}
                                @endif
                                @if($appointment->meet_link && $appointment->status_appoinment != 'huy_lich_hen' && $appointment->status_appoinment != 'benh_nhan_khong_den')
                                <p><strong>Link meet:</strong> <a href="{{ $appointment->meet_link }}" target="_blank">{{ $appointment->meet_link }}</a></p>
                                @else
                                
                                @endif
                            </td>
                            <td>{{ number_format($appointment->doctor ? $appointment->doctor->examination_fee : $appointment->package->price, 0, ',', '.') }} đ</td>
                            <td>
                                @if($appointment->status_payment_method == 'da_thanh_toan')
                                <span style="color: green;">Đã thanh toán</span>
                                @else
                                <span style="color: red;">Chưa thanh toán</span>
                                @endif
                            </td>
                            <td>
                                @switch($appointment->status_appoinment)
                                @case('cho_xac_nhan')
                                <span data-status="cho_xac_nhan" style="color: yellowgreen;">Đang chờ xác nhận</span>
                                @break

                                @case('da_xac_nhan')
                                <span data-status="da_xac_nhan" style="color: blue;">Lịch hẹn đã được xác nhận</span>
                                @break

                                @case('yeu_cau_huy')
                                <span data-status="yeu_cau_huy" style="color: blueviolet;">Yêu cầu hủy đang chờ duyệt</span>
                                @break

                                @case('kham_hoan_thanh')
                                <span data-status="kham_hoan_thanh" style="color: green;">Khám hoàn tất</span>
                                @break

                                @case('can_tai_kham')
                                <span data-status="can_tai_kham" style="color: green;">Cần tái khám</span>
                                @break

                                @case('benh_nhan_khong_den')
                                <span data-status="benh_nhan_khong_den" style="color: orangered;">Bệnh nhân không đến</span>
                                @break

                                @case('huy_lich_hen')
                                <span data-status="huy_lich_hen" style="color: red;">Lịch hẹn đã bị hủy</span>
                                @break
                                @endswitch
                            </td>
                            <td>
                                @if($appointment->status_appoinment == 'cho_xac_nhan')
                                <a href="#" class="btn btn-danger btn-custom cancel-appointment-btn"
                                    data-id="{{ $appointment->id }}"
                                    data-name="{{ $appointment->package ? $appointment->package->hospital_name : 'N/A' }}"
                                    data-date="{{ $formattedDate }}"
                                    data-time="{{ \Carbon\Carbon::createFromFormat('H:i:s', $time->startTime)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->endTime)->format('H:i') }}"
                                    data-doctor="{{ $appointment->doctor ? $appointment->doctor->user->name : 'N/A' }}">
                                    Hủy lịch đặt
                                </a>
                                @elseif($appointment->status_appoinment == 'kham_hoan_thanh' || $appointment->status_appoinment == 'can_tai_kham')
                                @if($review)
                                <a href="#" class="btn btn-primary btn-sm edit-review-btn" data-id="{{ $review->id }}">Xem đánh giá</a>
                                @else
                                <a href="#" class="btn btn-warning btn-sm review-btn" data-id="{{ $appointment->id }}">Đánh giá bác sĩ</a>
                                @endif
                                <a href="#" class="btn btn-info btn-sm appointment-history-link" data-appointment-id="{{ $appointment->id }}">Chi tiết hóa đơn</a>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: '{{ session('
            error ') }}',
            timer: 5000,
            timerProgressBar: true
        })
    </script>
    @endif

    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '{{ session('
            success ') }}',
            timer: 5000,
            timerProgressBar: true
        })
    </script>
    @endif


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).on('click', '.edit-review-btn', function(e) {
            e.preventDefault();
            var reviewId = $(this).data('id');

            $.ajax({
                url: '/appoinment/reviews/' + reviewId + '/edit',
                type: 'GET',
                success: function(response) {
                    $('#reviewId').val(response.id);
                    $('#editComment').val(response.comment);
                    $('input[name="rating"][value="' + response.rating + '"]').prop('checked', true);
                    $('#editReviewModal').modal('show');
                },
                error: function() {
                    alert('Không thể tải dữ liệu đánh giá.');
                }
            });
        });

        $('#editReviewForm').submit(function(e) {
            e.preventDefault();
            var reviewId = $('#reviewId').val();
            var formData = $(this).serialize();

            $.ajax({
                url: '/appoinment/reviews/' + reviewId,
                type: 'PUT',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('Đánh giá đã được cập nhật.');
                    $('#editReviewModal').modal('hide');
                    location.reload();
                },
                error: function() {
                    alert('Không thể cập nhật đánh giá.');
                }
            });
        });


        $(document).ready(function() {
            $('.review-btn').click(function(e) {
                e.preventDefault();
                var appointmentId = $(this).data('id');

                $.ajax({
                    url: '/appoinment/appointments/get-review-data',
                    type: 'POST',
                    data: {
                        appointment_id: appointmentId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#userId').val(response.user_id);
                        $('#doctorId').val(response.doctor_id);
                        $('#appoinmentId').val(response.appoinment_id);
                        $('#reviewModal').modal('show');
                    },
                    error: function() {
                        alert('Có lỗi xảy ra khi lấy thông tin đánh giá.');
                    }
                });
            });
        });

        function showMyAppointments(button) {
            document.getElementById('myAppointments').style.display = 'block';
            document.getElementById('familyAppointments').style.display = 'none';
            updateActiveButton(button);
        }

        function showFamilyAppointments(button) {
            document.getElementById('myAppointments').style.display = 'none';
            document.getElementById('familyAppointments').style.display = 'block';
            updateActiveButton(button);
        }

        function updateActiveButton(button) {
            document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
        }

        function filterAppointments() {
            let searchById = document.getElementById('searchById').value.toLowerCase();
            let searchByDate = document.getElementById('searchByDate').value;

            document.querySelectorAll('.appointment-card').forEach(card => {
                let cardId = card.getAttribute('data-id').toLowerCase();
                let cardDate = card.getAttribute('data-date');

                if ((searchById && cardId.includes(searchById)) || (searchByDate && cardDate === searchByDate) || (!searchById && !searchByDate)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const cancelButtons = document.querySelectorAll('.cancel-appointment-btn');

            cancelButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const appointmentId = this.dataset.id;
                    const name = this.dataset.name;
                    const date = this.dataset.date;
                    const time = this.dataset.time;
                    const doctor = this.dataset.doctor;

                    document.getElementById('modalAppointmentId').value = appointmentId;
                    document.getElementById('name').value = name;
                    document.getElementById('appointmentDate').value = date;
                    document.getElementById('appointmentTime').value = time;
                    document.getElementById('doctor').value = doctor;

                    const cancelModal = new bootstrap.Modal(document.getElementById('cancelAppointmentModal'));
                    cancelModal.show();
                });
            });
        });

        document.getElementById('cancelAppointmentForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const appointmentId = document.getElementById('modalAppointmentId').value;
            const notes = document.getElementById('notes').value;

            fetch(`/appoinment/appointments/${appointmentId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        notes
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Hủy lịch hẹn thành công!');
                        location.reload(); 
                    } else {
                        alert(data.message || 'Đã xảy ra lỗi. Vui lòng thử lại.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
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
                    content += `<p>Tổng giá trị đơn thuốc: ${parseInt(data.bill).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</p>`;

                    if (data.order_details && data.order_details.length > 0) {
                        content += `<h5>Chi tiết đơn thuốc:</h5>`;
                        content += `<table class="table table-bordered"><thead>
                                        <tr>
                                            <th>Tên sản phẩm</th>
                                            <th>Biến thể của thuốc</th>
                                            <th>Số lượng</th>
                                            <th>Đơn giá</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                    </thead><tbody>`;
                        data.order_details.forEach(order => {
                            content += `<tr>
                                            <td><a href="http://127.0.0.1:8000/products/detail/${order.product_id}" target="_blank">${order.product_name}</a></td>
                                            <td>${order.name}</td>
                                            <td>${order.quantity}</td>
                                            <td>${parseInt(order.unit_price).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</td>
                                            <td>${parseInt(order.total_money).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</td>
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

        document.getElementById('statusFilter').addEventListener('change', function() {
            const filterValue = this.value;
            const rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                const statusCell = row.querySelector('td:nth-child(8) span');
                if (!filterValue || (statusCell && statusCell.getAttribute('data-status') === filterValue)) {
                    row.style.display = ''; // Hiển thị
                } else {
                    row.style.display = 'none'; // Ẩn
                }
            });
        });
    </script>
    @endsection
</body>

</html>