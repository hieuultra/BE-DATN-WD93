<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hướng Dẫn Đặt Lịch Khám</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .steps {
            margin-top: 30px;
        }

        .step {
            margin-bottom: 20px;
        }

        .step h5 {
            font-weight: bold;
        }

        .step p {
            font-size: 1.1rem;
        }

        .step ol {
            margin-left: 20px;
        }
    </style>
</head>

<body>
@extends('layout')
@section('content')
    <div class="container">
        <h1 class="my-4 text-center text-primary">Hướng Dẫn Đặt Lịch Khám</h1>

        <div class="steps">
            <div class="step">
                <h5>Bước 1: Chọn bác sĩ và chuyên khoa</h5>
                <p>Truy cập vào trang đặt lịch và chọn bác sĩ bạn muốn khám. Bạn có thể lọc bác sĩ theo chuyên khoa để dễ dàng tìm kiếm. Sau khi chọn bác sĩ, bạn sẽ thấy thông tin chi tiết về lịch làm việc của bác sĩ đó.</p>
            </div>

            <div class="step">
                <h5>Bước 2: Chọn thời gian và lịch khám</h5>
                <p>Chọn thời gian phù hợp cho buổi khám của bạn. Chúng tôi cung cấp lịch khám theo ngày giờ cố định, giúp bạn dễ dàng chọn lựa thời gian trống của bác sĩ.</p>
            </div>

            <div class="step">
                <h5>Bước 3: Điền thông tin cá nhân</h5>
                <p>Điền đầy đủ thông tin cá nhân của bạn bao gồm tên, số điện thoại và địa chỉ email. Thông tin này sẽ giúp chúng tôi liên lạc với bạn trong trường hợp có sự thay đổi lịch khám hoặc cần xác nhận thông tin.</p>
            </div>

            <div class="step">
                <h5>Bước 4: Chọn phương thức thanh toán</h5>
                <p>Chúng tôi cung cấp nhiều phương thức thanh toán linh hoạt. Bạn có thể chọn thanh toán tại bệnh viện hoặc thanh toán trực tuyến qua các hình thức như VNPAY. Hãy lựa chọn phương thức thanh toán phù hợp với bạn.</p>
                <ul>
                    <li><strong>Thanh toán tại bệnh viện:</strong> Thanh toán khi bạn đến khám tại bệnh viện.</li>
                    <li><strong>Thanh toán qua VNPAY:</strong> Thanh toán trực tuyến qua QR code hoặc thẻ tín dụng.</li>
                </ul>
            </div>

            <div class="step">
                <h5>Bước 5: Xác nhận và hoàn tất</h5>
                <p>Sau khi điền đầy đủ thông tin và chọn phương thức thanh toán, bạn chỉ cần nhấn nút "Đặt lịch" để hoàn tất quá trình. Bạn sẽ nhận được email hoặc tin nhắn thông báo xác nhận lịch khám từ chúng tôi.</p>
            </div>

            <div class="step">
                <h5>Bước 6: Tham gia khám và nhận dịch vụ</h5>
                <p>Vào ngày giờ đã hẹn, bạn đến bệnh viện hoặc sử dụng dịch vụ khám trực tuyến (nếu có) để hoàn tất buổi khám bệnh của mình. Chúng tôi sẽ cung cấp dịch vụ tận tâm để bạn có trải nghiệm tốt nhất.</p>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{route('appoinment.index')}}" class="btn btn-primary">Đặt Lịch Khám Ngay</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @endsection
</body>

</html>
