<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lịch Sử Đặt Lịch Khám</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        <div class="row mb-4">
            <div class="col-md-6">
                <input type="text" id="searchById" class="form-control" placeholder="Tìm kiếm theo Mã lịch khám" onkeyup="filterAppointments()">
            </div>
            <div class="col-md-6">
                <input type="date" id="searchByDate" class="form-control" onchange="filterAppointments()">
            </div>
        </div>

        <div class="btn-group my-3" role="group">
            <button type="button" class="btn btn-primary active" onclick="showMyAppointments(this)">Lịch Đặt Khám Của Mình</button>
            <button type="button" class="btn btn-secondary" onclick="showFamilyAppointments(this)">Lịch Đặt Cho Người Thân</button>
        </div>

        <!--Đặt lịch cho bản thân-->
        <div id="myAppointments" style="display: block;">
            <h2>Lịch sử đặt cho bản thân</h2>
            @foreach($appoinments as $appointment)
            @foreach($available as $time)
            @if($time->id == $appointment->available_timeslot_id && $appointment->classify == 'ban_than')
            <div class="card mb-3 appointment-card" data-id="{{ $appointment->id }}" data-date="{{ \Carbon\Carbon::parse($time->date)->format('Y-m-d') }}">
                <div class="card-body">
                    <h5 class="card-title">Mã lịch khám: <span class="text-primary">{{ $appointment->id }}</span></h5>
                    @php
                    $formattedDate = \Carbon\Carbon::parse($time->date)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                    $review = $reviewDortor->filter(function ($rv) use ($appointment) {
                    return $rv->doctor_id == $appointment->doctor_id && $rv->appoinment_id == $appointment->id;
                    })->first();
                    @endphp
                    <p><strong>Ngày khám:</strong> {{ $formattedDate }}</p>
                    <p><strong>Thời gian:</strong> {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->startTime)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->endTime)->format('H:i') }}</p>
                    @if($appointment->doctor)
                    <p><strong>Bác sĩ:</strong> {{ $appointment->doctor->user->name }}</p>
                    @else
                    <p><strong>Tên khám tổng quát:</strong> {{ $appointment->package->hospital_name }}</p>
                    @endif
                    @if($appointment->doctor)
                    @foreach($clinics as $clinic)
                    @if($clinic->doctor_id == $appointment->doctor->id)
                    <p><strong>Địa điểm:</strong> Phòng khám {{ $clinic->address }}, {{$clinic->city}}</p>
                    @endif
                    @endforeach
                    @else
                    <p><strong>Địa chỉ khoa khám:</strong> {{ $appointment->package->address }}</p>
                    @endif
                    @if($appointment->meet_link)
                    <p><strong>Link meet:</strong> {{ $appointment->meet_link }}</p>
                    @else

                    @endif
                    @if($appointment->doctor)
                    <p class="price">Giá: {{ number_format($appointment->doctor->examination_fee, 0, ',', '.') }} đ</p>
                    @else
                    <p><strong>Giá khám:</strong> {{ number_format($appointment->package->price, 0, ',', '.') }} đ</p>
                    @endif
                    <p><strong>Lý do khám:</strong> {{ $appointment->notes }}</p>
                    <a href="#" class="btn btn-info btn-custom">Xem thêm</a>

                    @if($appointment->status_appoinment == 'cho_xac_nhan')
                    <a href="#" class="btn btn-danger btn-custom">Hủy lịch đặt</a>
                    <p style="color: yellowgreen;">Đang chờ xác nhận</p>

                    @elseif($appointment->status_appoinment == 'da_xac_nhan')
                    <p>Liên hệ đến bác Sỹ nếu bạn muốn hủy: {{$appointment->doctor->user->phone}}</p>
                    <p style="color: blue;">Lịch hẹn đã được xác nhận</p>

                    @elseif($appointment->status_appoinment == 'yeu_cau_huy')
                    <p style="color: blueviolet;">Yêu cầu hủy đang chờ duyệt</p>

                    @elseif($appointment->status_appoinment == 'kham_hoan_thanh' || $appointment->status_appoinment == 'can_tai_kham')
                    @if($review)
                    <p>Đánh giá của bạn</p>
                    <div class="rating">
                        @for ($i = 5; $i >= 1; $i--)
                        <input value="{{ $i }}" @if($review->rating == $i) checked @endif type="radio" disabled>
                        <label for="star{{ $i }}" title="text"></label>
                        @endfor
                    </div>
                    <a href="#" class="edit-review-btn" data-id="{{ $review->id }}">Sửa đánh giá</a>
                    @else
                    <a href="#" class="btn btn-custom-yellow review-btn" data-id="{{ $appointment->id }}" style="background-color: yellow; color: black; border: 1px solid yellow;">Đánh giá bác sĩ</a>
                    @endif
                    <a class="btn" onclick="fetchAppointmentHistory({{ $appointment->id }})">Xem đơn thuốc</a>
                    <p style="color: green;">{{ $appointment->status_appoinment == 'kham_hoan_thanh' ? 'Khám hoàn tất' : 'Cần tái khám' }}</p>

                    @elseif($appointment->status_appoinment == 'benh_nhan_khong_den')
                    <p style="color: orangered;">Bệnh nhân không đến</p>

                    @elseif($appointment->status_appoinment == 'huy_lich_hen')
                    <p style="color: red;">Lịch hẹn đã bị hủy</p>
                    @endif
                </div>
            </div>
            @endif
            @endforeach
            @endforeach
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



        <div class="modal fade" id="appointmentDetailsModal" tabindex="-1" aria-labelledby="appointmentDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appointmentDetailsModalLabel">Chi tiết lịch hẹn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Mã lịch khám:</strong> <span id="modalAppointmentId"></span></p>
                        <p><strong>Ngày khám:</strong> <span id="modalDate"></span></p>
                        <p><strong>Thời gian:</strong> <span id="modalTime"></span></p>
                        <p><strong>Bác sĩ:</strong> <span id="modalDoctor"></span></p>
                        <p><strong>Địa điểm:</strong> <span id="modalLocation"></span></p>
                        <p><strong>Giá:</strong> <span id="modalPrice"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
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
                                <label for="name" class="form-label">Tên người đặt</label>
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
                                <label for="location" class="form-label">Địa điểm</label>
                                <input type="text" class="form-control" id="location" name="location" readonly>
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

        <div class="modal fade" id="appointmentHistoryModal" tabindex="-1" aria-labelledby="appointmentHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appointmentHistoryModalLabel">Chi tiết đơn thuốc</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="appointmentHistoryContent">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!--Đặt lịch cho người thân-->
        <div id="familyAppointments" style="display: none;">
            <h2>Lịch sử đặt cho người thân</h2>
            @foreach($appoinments as $appointment)
            @foreach($available as $time)
            @if($time->id == $appointment->available_timeslot_id && $appointment->classify == 'cho_gia_dinh')
            <div class="card mb-3 appointment-card" data-id="{{ $appointment->id }}" data-date="{{ \Carbon\Carbon::parse($time->date)->format('Y-m-d') }}">
                <div class="card-body">
                    <h5 class="card-title">Mã lịch khám: <span class="text-primary">{{ $appointment->id }}</span></h5>
                    @php
                    $formattedDate = \Carbon\Carbon::parse($time->date)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                    $review = $reviewDortor->filter(function ($rv) use ($appointment) {
                    return $rv->doctor_id == $appointment->doctor_id && $rv->appoinment_id == $appointment->id;
                    })->first();
                    @endphp
                    <p><strong>Ngày khám:</strong> {{ $formattedDate }}</p>
                    <p><strong>Thời gian:</strong> {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->startTime)->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->endTime)->format('H:i') }}</p>
                    @if($appointment->doctor)
                    <p><strong>Bác sĩ:</strong> {{ $appointment->doctor->user->name }}</p>
                    @else
                    <p><strong>Tên khám tổng quát:</strong> {{ $appointment->package->hospital_name }}</p>
                    @endif
                    @if($appointment->doctor)
                    @foreach($clinics as $clinic)
                    @if($clinic->doctor_id == $appointment->doctor->id)
                    <p><strong>Địa điểm:</strong> Phòng khám {{ $clinic->address }}, {{$clinic->city}}</p>
                    @endif
                    @endforeach
                    @else
                    <p><strong>Địa chỉ khoa khám:</strong> {{ $appointment->package->address }}</p>
                    @endif
                    @if($appointment->meet_link)
                    <p><strong>Link meet:</strong> {{ $appointment->meet_link }}</p>
                    @else

                    @endif
                    @if($appointment->doctor)
                    <p class="price">Giá: {{ number_format($appointment->doctor->examination_fee, 0, ',', '.') }} đ</p>
                    @else
                    <p><strong>Giá khám:</strong> {{ number_format($appointment->package->price, 0, ',', '.') }} đ</p>
                    @endif
                    <p><strong>Lý do khám:</strong> {{ $appointment->notes }}</p>
                    <a href="#" class="btn btn-info btn-custom">Xem thêm</a>

                    @if($appointment->status_appoinment == 'cho_xac_nhan')
                    <a href="#" class="btn btn-danger btn-custom">Hủy lịch đặt</a>
                    <p style="color: yellowgreen;">Đang chờ xác nhận</p>

                    @elseif($appointment->status_appoinment == 'da_xac_nhan')
                    
                    <p style="color: blue;">Lịch hẹn đã được xác nhận</p>

                    @elseif($appointment->status_appoinment == 'yeu_cau_huy')
                    <p style="color: blueviolet;">Yêu cầu hủy đang chờ duyệt</p>

                    @elseif($appointment->status_appoinment == 'kham_hoan_thanh' || $appointment->status_appoinment == 'can_tai_kham')
                    @if($review)
                    <p>Đánh giá của bạn</p>
                    <div class="rating">
                        @for ($i = 5; $i >= 1; $i--)
                        <input value="{{ $i }}" @if($review->rating == $i) checked @endif type="radio" disabled>
                        <label for="star{{ $i }}" title="text"></label>
                        @endfor
                    </div>
                    <a href="#" class="edit-review-btn" data-id="{{ $review->id }}">Sửa đánh giá</a>
                    @else
                    <a href="#" class="btn btn-custom-yellow review-btn" data-id="{{ $appointment->id }}" style="background-color: yellow; color: black; border: 1px solid yellow;">Đánh giá bác sĩ</a>
                    @endif
                    <a class="btn" onclick="fetchAppointmentHistory({{ $appointment->id }})">Xem đơn thuốc</a>
                    <p style="color: green;">{{ $appointment->status_appoinment == 'kham_hoan_thanh' ? 'Khám hoàn tất' : 'Cần tái khám' }}</p>

                    @elseif($appointment->status_appoinment == 'benh_nhan_khong_den')
                    <p style="color: orangered;">Bệnh nhân không đến</p>

                    @elseif($appointment->status_appoinment == 'huy_lich_hen')
                    <p style="color: red;">Lịch hẹn đã bị hủy</p>
                    @endif
                </div>
            </div>
            @endif
            @endforeach
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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

        document.addEventListener("DOMContentLoaded", function() {
            const viewMoreButtons = document.querySelectorAll('.btn-info.btn-custom');

            viewMoreButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const appointmentCard = this.closest('.appointment-card');
                    const appointmentId = appointmentCard.getAttribute('data-id');
                    const appointmentDate = appointmentCard.getAttribute('data-date');
                    const appointmentTime = appointmentCard.querySelector('.card-body p:nth-child(3)').innerText;
                    const doctor = appointmentCard.querySelector('.card-body p:nth-child(4)').innerText;
                    const location = appointmentCard.querySelector('.card-body p:nth-child(5)').innerText;
                    const price = appointmentCard.querySelector('.card-body .price').innerText;

                    document.getElementById('modalAppointmentId').innerText = appointmentId;
                    document.getElementById('modalDate').innerText = appointmentDate;
                    document.getElementById('modalTime').innerText = appointmentTime;
                    document.getElementById('modalDoctor').innerText = doctor;
                    document.getElementById('modalLocation').innerText = location;
                    document.getElementById('modalPrice').innerText = price;

                    const appointmentDetailsModal = new bootstrap.Modal(document.getElementById('appointmentDetailsModal'));
                    appointmentDetailsModal.show();
                });
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            const cancelButtons = document.querySelectorAll('.btn-danger.btn-custom');

            cancelButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const appointmentCard = this.closest('.appointment-card');
                    const appointmentId = appointmentCard.getAttribute('data-id');
                    const userName = "{{ auth()->user()->name }}";
                    const appointmentDate = appointmentCard.querySelector('.card-body p:nth-child(2)').innerText.split(': ')[1];
                    const appointmentTime = appointmentCard.querySelector('.card-body p:nth-child(3)').innerText.split(': ')[1];
                    const doctorName = appointmentCard.querySelector('.card-body p:nth-child(4)').innerText.split(': ')[1];
                    const location = appointmentCard.querySelector('.card-body p:nth-child(5)').innerText.split(': ')[1];

                    document.getElementById('modalAppointmentId').value = appointmentId;
                    document.getElementById('name').value = userName;
                    document.getElementById('appointmentDate').value = appointmentDate;
                    document.getElementById('appointmentTime').value = appointmentTime;
                    document.getElementById('doctor').value = doctorName;
                    document.getElementById('location').value = location;

                    const cancelAppointmentModal = new bootstrap.Modal(document.getElementById('cancelAppointmentModal'));
                    cancelAppointmentModal.show();
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
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            notes: notes
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Lịch hẹn đã được hủy thành công');
                            location.reload();
                        } else {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        function fetchAppointmentHistory(appointmentId) {
            fetch(`/appoinment/appointment-history/${appointmentId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let historyContent = "<h4>Appointment History</h4>";
                        
                        data.histories.forEach(history => {
                            historyContent += `<p>Chẩn đoán: ${history.diagnosis}</p>`;
                            historyContent += `<p>Đơn thuốc: ${history.prescription}</p>`;
                            historyContent += `<p>Ngày tái khám: ${history.follow_up_date ? history.follow_up_date : 'Không có lịch hẹn tái khám'}</p>`;
                            historyContent += `<p>Nhắc nhở thêm: ${history.notes}</p>`;
                            historyContent += "<hr>";
                        });

                        document.getElementById('appointmentHistoryContent').innerHTML = historyContent;

                        let appointmentHistoryModal = new bootstrap.Modal(document.getElementById('appointmentHistoryModal'));
                        appointmentHistoryModal.show();
                    } else {
                        alert(data.message || 'Could not fetch appointment history.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching appointment history:', error);
                });
        }

    </script>
    @endsection
</body>

</html>