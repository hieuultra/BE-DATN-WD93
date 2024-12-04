<!DOCTYPE html>
<html lang="vi">

<head>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }

        .doctor-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .doctor-info img {
            margin-right: 15px;
        }

        .doctor-info h5 {
            margin: 0;
            font-size: 18px;
            color: #007bff;
        }

        .alert {
            padding: 15px;
            border: 1px solid transparent;
            border-radius: 4px;
            transition: opacity 0.5s ease-in-out;
        }
        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
        }

        .doctor-info p {
            margin: 0;
            font-size: 14px;
            color: #6c757d;
        }

        .form-check-label {
            margin-right: 20px;
        }

        .modal-backdrop {
            display: none !important;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .payment-info {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .payment-info p {
            margin: 0;
            font-size: 14px;
        }

        .payment-info .text-end {
            font-weight: bold;
            color: #dc3545;
        }

        .note {
            background-color: #e9f7ff;
            padding: 15px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    @extends('layout')
    @section('content')
    
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(isset($existingAppointment))
        <div id="appointment-notification" class="alert alert-warning" style="position: fixed; top: 20px; right: 20px; z-index: 9999; display: none;">
            <p>Bạn đã đặt lịch vào thời điểm này:</p>
            <ul>
                <li>Bác sĩ: {{ $existingAppointment->doctor->user->name }}</li>
                <li>Thời gian: {{ $existingAppointment->timeSlot->startTime }}</li>
                <li>Ngày: {{ $existingAppointment->timeSlot->date }}</li>
            </ul>
        </div>
    @endif


    <a href="{{route('appoinment.booKingCare', $doctor->specialty->id)}}">Quay lại</a>
    <div class="container">
        <div class="doctor-info">
            <img alt="Doctor's profile picture" class="profile-img" height="60"
                src="{{ asset('upload/' . $doctor->user->image) }}"
                width="60" />
            <div>
                <h5 class="text-primary">
                    {{$doctor->user->name}} - Chuyên khoa: {{$doctor->specialty->name}}
                </h5>
                <p>
                    @php
                    $formattedDate = \Carbon\Carbon::parse($timeSlot->date)
                    ->locale('vi')
                    ->isoFormat('dddd - D/MM/YYYY');
                    @endphp
                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} -
                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }} - {{ $formattedDate }}
                </p>
                
            </div>
        </div>

        <div class="mb-3 d-flex">
            @if(isset($existingAppointment))

            @else
            <button type="button" id="selfButton" class="btn btn-primary flex-fill me-2">Đặt cho mình</button>
            <button type="button" id="otherButton" class="btn btn-secondary flex-fill">Đặt cho người thân</button>
            @endif
        </div>

        <!-- Form đặt cho người thân -->
        <form id="form1" action="{{route('appoinment.bookAnAppointment')}}" method="POST"  @if(isset($existingAppointment))  @else style="display: none;" @endif>
            @csrf
            <h5>Đặt cho người thân</h5>
            <input type="text" name="lua_chon" value="cho_nguoi_than" style="display: none;">
            <input type="text" name="user_id" value="{{ $user = Auth::user()->id;}}" style="display: none;">
            <input type="text" name="doctor_id" value="{{$doctor->id}}" style="display: none;">
            <input type="text" name="available_timeslot_id" value="{{$timeSlot->id}}" style="display: none;">
            <input type="text" name="appointment_date" value="{{$timeSlot->date}}" style="display: none;">
            <div class="mb-3">
                <label class="form-label" for="patientName">
                    Họ tên bệnh nhân (bắt buộc)
                </label>
                <input class="form-control" id="patientName" name="name" placeholder="Họ tên bệnh nhân (bắt buộc)" type="text" required/>
                <small class="form-text text-muted">
                    Hãy ghi rõ Họ Và Tên, viết hoa những chữ cái đầu tiên, ví dụ: Trần Văn Phú
                </small>
            </div>
            <div class="mb-3">
                <label class="form-label" for="phone">
                    Số điện thoại liên hệ (bắt buộc)
                </label>
                <input class="form-control" id="phone" name="phone" placeholder="Số điện thoại liên hệ (bắt buộc)" type="text" required/>
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">
                    Địa chỉ email
                </label>
                <input class="form-control" id="email" name="email" value="{{$user = Auth::user()->email}}" type="email" required/>
            </div>
            <div class="mb-3">
                <label class="form-label" for="province1">
                    -- Chọn Tỉnh/Thành --
                </label>
                <select class="form-select" id="province1" name="tinh_thanh" required onchange="updateDistricts('province1', 'district1')">
                    <option selected="">
                        -- Chọn Tỉnh/Thành --
                    </option>
                    <option value="hanoi">Hà Nội</option>
                    <option value="hochiminh">Hồ Chí Minh</option>
                    <option value="danang">Đà Nẵng</option>
                    <option value="haiphong">Hải Phòng</option>
                    <option value="nhaTrang">Nha Trang</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="district1" required>
                    -- Chọn Quận/Huyện --
                </label>
                <select class="form-select" name="quan_huyen" id="district1" required>
                    <option selected="">
                        -- Chọn Quận/Huyện --
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="address">
                    Địa chỉ
                </label>
                <input class="form-control" name="dia_chi" id="address" placeholder="Địa chỉ" type="text" required/>
            </div>
            <div class="mb-3">
                <label class="form-label" for="reason">
                    Lý do khám
                </label>
                <textarea class="form-control" name="notes" id="reason" placeholder="Lý do khám" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    Hình thức thanh toán
                </label>
                @if($doctor->specialty->classification == 'chuyen_khoa' || $doctor->specialty->classification == 'tong_quat')
                <div class="form-check">
                    <input checked="" class="form-check-input" name="status_payment_method" id="selfPayLater" name="selfPaymentMethod" type="radio"
                        value="thanh_toan_tai_benh_vien" >
                    <label class="form-check-label" for="selfPayLater">
                        Thanh toán sau tại cơ sở y tế (không dùng được khi thanh toán cho khám từ xa)
                    </label>
                </div>
                @else
                <div class="form-check">
                    <input checked="" class="form-check-input" name="status_payment_method" id="selfPayLater" name="selfPaymentMethod" type="radio"
                        value="thanh_toan_tai_benh_vien" >
                    <label class="form-check-label" for="selfPayLater">
                        Thanh toán tại nhà sau khi nhận được thuốc
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="status_payment_method" id="selfPayLater" name="selfPaymentMethod" type="radio"
                        value="thanh_toan_vnpay" >
                    <label class="form-check-label" for="selfPayLater">
                        Thanh toán qua vnpay
                    </label>
                </div>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Giá khám</label>
                <p class="form-text">{{ number_format($doctor->examination_fee, 0, ',', '.') }} VND</p>
                <input type="text" name="" value="{{ $doctor->price }}" style="display: none;">
            </div>
            <div class="mb-3">
                <label class="form-label">Phí đặt lịch</label>
                <p class="form-text">Miễn phí đặt lịch</p>
            </div>

            <div class="alert alert-info" role="alert">
                <strong>Lưu ý</strong>
                <ul>
                    <li>Thông tin ảnh/chụp cung cấp sẽ được sử dụng làm hồ sơ khám bệnh, khi đến đăng ký khám bệnh vui
                        lòng mang theo CMND/CCCD.</li>
                    <li>Chỉ có thể hủy lịch, hoặc thay đổi chủ đặt lịch, trước 24h so với thời gian khám đã đặt.</li>
                    <li>Quý khách vui lòng kiểm tra kỹ thông tin trước khi nhấn "Xác nhận".</li>
                </ul>
            </div>
            @if($doctor->specialty->classification == 'chuyen_khoa' || $doctor->specialty->classification == 'tong_quat')
            <div class="mb-3">
                 <button class="btn btn-primary" type="submit">
                    Đặt lịch
                </button>
            </div>
            @else
            <div class="mb-3">
               <div class="siuu" style="display: none;">
                 <button class="btn btn-primary" type="submit">
                    Đặt lịch
                </button>
               </div>
            </div>
            @endif
        </form>

        <div class="modal fade" id="vnpayModal" tabindex="-1" aria-labelledby="vnpayModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="vnpayModalLabel">Thanh toán qua VNPAY</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img src="https://th.bing.com/th/id/OIP.DU7OoLbkclicTJS46K_BfwHaCg?rs=1&pid=ImgDetMain" alt="VNPAY Logo" class="img-fluid">
                        </div>
                        <div id="paymentInfo">
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <p class="fw-bold">Quét mã QR để thanh toán</p>
                                    <div id="qrCodeContainer"></div>
                                </div>

                                <div class="col-md-6">
                                    <p class="text-muted text-center">Hoặc nhập thông tin thẻ bên dưới:</p>
                                    <form id="vnpayForm">
                                        <div class="mb-3">
                                            <label for="vnpCardNumber" class="form-label">Số thẻ</label>
                                            <input type="text" class="form-control" id="vnpCardNumber" placeholder="Nhập số thẻ" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="vnpCardHolder" class="form-label">Tên chủ thẻ</label>
                                            <input type="text" class="form-control" id="vnpCardHolder" placeholder="Nhập tên chủ thẻ" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="vnpExpireDate" class="form-label">Ngày hết hạn</label>
                                                <input type="text" class="form-control" id="vnpExpireDate" placeholder="MM/YY" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="vnpCvv" class="form-label">CVV</label>
                                                <input type="text" class="form-control" id="vnpCvv" placeholder="Nhập CVV" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 text-center">
                                            <button class="btn btn-success w-100" type="button" id="submitVnpayPayment">Thanh toán</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </div>
        </div>
        @if(isset($existingAppointment))

        @else
        <!-- Form đặt cho mình -->
        @if(Auth::check())
        <form id="form2" action="{{route('appoinment.bookAnAppointment')}}" method="POST">
            @csrf
            <h5>Đặt cho bản thân mình</h5>
            <input type="text" name="lua_chon" value="dat_cho_minh" style="display: none;">
            <input type="text" name="user_id" value="{{ $user = Auth::user()->id }}" style="display: none;">
            <input type="text" name="doctor_id" value="{{$doctor->id}}" style="display: none;">
            <input type="text" name="available_timeslot_id" value="{{$timeSlot->id}}" style="display: none;">
            <input type="text" name="appointment_date" value="{{$timeSlot->date}}" style="display: none;">
            <div class="mb-3">
                <label class="form-label" for="selfName">
                    Họ tên (bắt buộc)
                </label>
                <strong>@if ($errors->has('name'))
                    <div style="color: red;">{{ $errors->first('name') }}</div>
                    @endif
                </strong><br>
                <input class="form-control" id="selfName" name="name" placeholder="Họ tên (bắt buộc)" value="{{$user = Auth::user()->name}}" type="text" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="selfPhone">
                    Số điện thoại (bắt buộc)
                </label>
                <strong>@if ($errors->has('phone'))
                    <div style="color: red;">{{ $errors->first('phone') }}</div>
                    @endif
                </strong><br>
                <input class="form-control" id="selfPhone" name="phone" value="{{$user = Auth::user()->phone}}" type="text" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="selfEmail">
                    Địa chỉ email
                </label>
                <strong>@if ($errors->has('email'))
                    <div style="color: red;">{{ $errors->first('email') }}</div>
                    @endif
                </strong><br>
                <input class="form-control" id="selfEmail" name="email" value="{{$user = Auth::user()->email}}" type="email" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="selfAddress">
                    Địa chỉ
                </label>
                <strong>@if ($errors->has('dia_chi'))
                    <div style="color: red;">{{ $errors->first('dia_chi') }}</div>
                    @endif
                </strong><br>
                <input class="form-control" id="selfAddress" name="dia_chi" value="{{$user = Auth::user()->address}}" type="text" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="selfReason">
                    Lý do khám
                </label>
                <strong>@if ($errors->has('notes'))
                    <div style="color: red;">{{ $errors->first('notes') }}</div>
                    @endif
                </strong><br>
                <textarea class="form-control" name="notes" id="selfReason" placeholder="Lý do khám" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    Hình thức thanh toán
                </label>
                @if($doctor->specialty->classification == 'chuyen_khoa' || $doctor->specialty->classification == 'tong_quat')
                <div class="form-check">
                    <input checked="" class="form-check-input" name="status_payment_method" id="selfPayLater" name="selfPaymentMethod" type="radio"
                        value="thanh_toan_tai_benh_vien" >
                    <label class="form-check-label" for="selfPayLater">
                        Thanh toán sau tại cơ sở y tế
                    </label>
                </div>
                @else
                <div class="form-check">
                    <input checked="" class="form-check-input" name="status_payment_method" id="selfPayLater" name="selfPaymentMethod" type="radio"
                        value="thanh_toan_tai_benh_vien" >
                    <label class="form-check-label" for="selfPayLater">
                        Thanh toán tại (không dùng được ở đặt khám qua video)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="status_payment_method" id="selfPayLater" name="selfPaymentMethod" type="radio"
                        value="thanh_toan_vnpay2" >
                    <label class="form-check-label" for="selfPayLater">
                        Thanh toán qua vnpay
                    </label>
                </div>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Giá khám</label>
                <p class="form-text">{{ number_format($doctor->examination_fee, 0, ',', '.') }} VND</p>
                <input type="text" name="" value="{{ $doctor->price }}" style="display: none;">
            </div>
            <div class="mb-3">
                <label class="form-label">Phí đặt lịch</label>
                <p class="form-text">Miễn phí đặt lịch</p>
            </div>

            <div class="alert alert-info" role="alert">
                <strong>Lưu ý</strong>
                <ul>
                    <li>Thông tin ảnh/chụp cung cấp sẽ được sử dụng làm hồ sơ khám bệnh, khi đến đăng ký khám bệnh vui
                        lòng mang theo CMND/CCCD.</li>
                    <li>Chỉ có thể hủy lịch, hoặc thay đổi chủ đặt lịch, trước 24h so với thời gian khám đã đặt.</li>
                    <li>Quý khách vui lòng kiểm tra kỹ thông tin trước khi nhấn "Xác nhận".</li>
                </ul>
            </div>
            @if($doctor->specialty->classification == 'chuyen_khoa' || $doctor->specialty->classification == 'tong_quat')
            <div class="mb-3">
                 <button class="btn btn-primary" type="submit">
                    Đặt lịch
                </button>
            </div>
            @else
            <div class="mb-3">
               <div class="siuu2" style="display: none;">
                 <button class="btn btn-primary" type="submit">
                    Đặt lịch
                </button>
               </div>
            </div>
            @endif
        </form>
        @endif
        @endif
    </div>


    <div class="modal fade" id="vnpayModal2" tabindex="-1" aria-labelledby="vnpayModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="vnpayModalLabel">Thanh toán qua VNPAY</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img src="https://th.bing.com/th/id/OIP.DU7OoLbkclicTJS46K_BfwHaCg?rs=1&pid=ImgDetMain" alt="VNPAY Logo" class="img-fluid">
                    </div>
                    <div id="paymentInfo">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <p class="fw-bold">Quét mã QR để thanh toán</p>
                                <div id="qrCodeContainer2"></div>
                            </div>

                            <div class="col-md-6">
                                <p class="text-muted text-center">Hoặc nhập thông tin thẻ bên dưới:</p>
                                <form id="vnpayForm">
                                    <div class="mb-3">
                                        <label for="vnpCardNumber2" class="form-label">Số thẻ</label>
                                        <input type="text" class="form-control" id="vnpCardNumber2" placeholder="Nhập số thẻ" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="vnpCardHolder2" class="form-label">Tên chủ thẻ</label>
                                        <input type="text" class="form-control" id="vnpCardHolder2" placeholder="Nhập tên chủ thẻ" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="vnpExpireDate2" class="form-label">Ngày hết hạn</label>
                                            <input type="text" class="form-control" id="vnpExpireDate2" placeholder="MM/YY" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="vnpCvv2" class="form-label">CVV</label>
                                            <input type="text" class="form-control" id="vnpCvv2" placeholder="Nhập CVV" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 text-center">
                                        <button class="btn btn-success w-100" type="button" id="submitVnpayPayment2">Thanh toán</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>

    <script>
       document.addEventListener("DOMContentLoaded", function () {
            const vnpayOption = document.querySelector('input[value="thanh_toan_vnpay2"]');
            const bookingButtonContainer = document.querySelector(".siuu2");
            const vnpayModal = new bootstrap.Modal(document.getElementById("vnpayModal2"));
            const submitPaymentButton = document.getElementById("submitVnpayPayment2");
            const qrCodeContainer = document.getElementById("qrCodeContainer2");

            const fakeCardData = {
                cardNumber: "1234567812345678",
                cardHolder: "Nguyen Van A",
                expireDate: "12/25",
                cvv: "123"
            };

            bookingButtonContainer.style.display = "none"; 

            vnpayOption.addEventListener("change", function () {
                if (this.checked) {
                    vnpayModal.show();
                    generateQRCode(); 
                }
            });

           
            function generateQRCode() {
                qrCodeContainer.innerHTML = "";
                const randomPaymentUrl = "https://example.com/payment/" + Math.random().toString(36).substring(2, 10);
                
                const qrCode = new QRCode(qrCodeContainer, {
                    text: randomPaymentUrl,
                    width: 200,
                    height: 200,
                });

                return randomPaymentUrl;
            }

            submitPaymentButton.addEventListener("click", function () {
                const cardNumber = document.getElementById("vnpCardNumber2").value;
                const cardHolder = document.getElementById("vnpCardHolder2").value;
                const expireDate = document.getElementById("vnpExpireDate2").value;
                const cvv = document.getElementById("vnpCvv2").value;

                if (cardNumber === fakeCardData.cardNumber && 
                    cardHolder === fakeCardData.cardHolder && 
                    expireDate === fakeCardData.expireDate && 
                    cvv === fakeCardData.cvv) {
                    alert("Thanh toán thành công!");
                    vnpayModal.hide(); // Đóng modal VNPAY
                    bookingButtonContainer.style.display = "block"; // Hiển thị nút Đặt lịch
                    document.querySelector('.modal-backdrop').remove(); // Xóa backdrop
                } else {
                    alert("Thông tin thẻ không hợp lệ!");
                }
            });
        });


    </script>

    <script>
       document.addEventListener("DOMContentLoaded", function () {
            const vnpayOption = document.querySelector('input[value="thanh_toan_vnpay"]');
            const bookingButtonContainer = document.querySelector(".siuu");
            const vnpayModal = new bootstrap.Modal(document.getElementById("vnpayModal"));
            const submitPaymentButton = document.getElementById("submitVnpayPayment");
            const qrCodeContainer = document.getElementById("qrCodeContainer");

            // Dữ liệu thẻ giả
            const fakeCardData = {
                cardNumber: "1234567812345678",
                cardHolder: "Nguyen Van A",
                expireDate: "12/25",
                cvv: "123"
            };

            // Ẩn nút Đặt lịch khi chưa thanh toán
            bookingButtonContainer.style.display = "none"; 

            // Hiển thị modal VNPAY khi chọn thanh toán VNPAY
            vnpayOption.addEventListener("change", function () {
                if (this.checked) {
                    vnpayModal.show();
                    generateQRCode();  // Tạo QR Code khi chọn thanh toán VNPAY
                }
            });

            // Tạo QR Code
            function generateQRCode() {
                qrCodeContainer.innerHTML = "";
                const randomPaymentUrl = "https://example.com/payment/" + Math.random().toString(36).substring(2, 10);
                
                const qrCode = new QRCode(qrCodeContainer, {
                    text: randomPaymentUrl,
                    width: 200,
                    height: 200,
                });

                return randomPaymentUrl;
            }

            // Xử lý khi thanh toán thành công
            submitPaymentButton.addEventListener("click", function () {
                const cardNumber = document.getElementById("vnpCardNumber").value;
                const cardHolder = document.getElementById("vnpCardHolder").value;
                const expireDate = document.getElementById("vnpExpireDate").value;
                const cvv = document.getElementById("vnpCvv").value;

                if (cardNumber === fakeCardData.cardNumber && 
                    cardHolder === fakeCardData.cardHolder && 
                    expireDate === fakeCardData.expireDate && 
                    cvv === fakeCardData.cvv) {
                    alert("Thanh toán thành công!");
                    vnpayModal.hide(); // Đóng modal VNPAY
                    bookingButtonContainer.style.display = "block"; // Hiển thị nút Đặt lịch
                    document.querySelector('.modal-backdrop').remove(); // Xóa backdrop
                } else {
                    alert("Thông tin thẻ không hợp lệ!");
                }
            });
        });


    </script>


    <script>

    document.addEventListener('DOMContentLoaded', function () {
        const notification = document.getElementById('appointment-notification');

        if (notification) {
            // Hiển thị thông báo
            notification.style.display = 'block';

            // Tự động ẩn thông báo sau 3 giây
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 500); // Thời gian fade out
            }, 3000); // Hiển thị trong 3 giây
        }
    });


        const selfButton = document.getElementById("selfButton");
        const otherButton = document.getElementById("otherButton");
        const form1 = document.getElementById("form1");
        const form2 = document.getElementById("form2");

        selfButton.addEventListener("click", () => {
            form1.style.display = "none";
            form2.style.display = "block";
            selfButton.style.display = "none";
            otherButton.style.display = "block";
        });

        otherButton.addEventListener("click", () => {
            form1.style.display = "block";
            form2.style.display = "none"; 
            selfButton.style.display = "block"; 
            otherButton.style.display = "none"; 
        });

        function updateDistricts(provinceId, districtId) {
            const provinceSelect = document.getElementById(provinceId);
            const districtSelect = document.getElementById(districtId);

            districtSelect.innerHTML = '<option selected="">-- Chọn Quận/Huyện --</option>';
            const selectedProvince = provinceSelect.value;
            let districts = [];

            switch (selectedProvince) {
                case "hanoi":
                    districts = ["Ba Đình", "Hoàn Kiếm", "Đống Đa", "Hai Bà Trưng", "Tây Hồ", "Long Biên"];
                    break;
                case "hochiminh":
                    districts = ["Quận 1", "Quận 2", "Quận 3", "Quận 4", "Quận 5", "Quận 6"];
                    break;
                case "danang":
                    districts = ["Hải Châu", "Thanh Khê", "Sơn Trà", "Ngũ Hành Sơn"];
                    break;
                case "haiphong":
                    districts = ["Hồng Bàng", "Lê Chân", "Ngô Quyền", "Kiến An"];
                    break;
                case "nhaTrang":
                    districts = ["Nha Trang", "Cam Ranh", "Diên Khánh"];
                    break;
                default:
                    break;
            }

            districts.forEach(district => {
                const option = document.createElement("option");
                option.value = district.toLowerCase().replace(/\s+/g, '-');
                option.textContent = district;
                districtSelect.appendChild(option);
            });
        }
    </script>
    @endsection
</body>

</html>