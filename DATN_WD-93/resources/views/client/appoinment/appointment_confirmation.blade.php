<!DOCTYPE html>
<html>

<head>
    <title>Instinct Pharmacy - Xác nhận lịch hẹn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .email-container {
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            color: #555555;
            margin-bottom: 10px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
            color: #333333;
        }

        ul li strong {
            color: #007bff;
        }

        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h1>Xin chào quý khách, {{ $user }}!</h1>
        <p>Cảm ơn quý khách đã sử dụng dịch vụ tại **Instinct Pharmacy**. Chúng tôi hy vọng quý khách sẽ có trải nghiệm khám thật tuyệt vời.</p>
        <p><strong>Thông tin lịch hẹn:</strong></p>
        <ul>
            <li><strong>Mã hóa đơn:</strong> {{ $appoinment->id }}</li>
            @if($appoinment->doctor)
            <li><strong>Bác sĩ:</strong> {{ $appoinment->doctor->user->name }}</li>
            <li><strong>Số điện thoại:</strong> {{ $appoinment->doctor->user->phone }}</li>
            <li><strong>Giá:</strong> {{ number_format($appoinment->doctor->examination_fee, 0, ',', '.') }} VND</li>
            @else
            <li><strong>Tên khoa khám:</strong> {{ $appoinment->package->hospital_name }}</li>
            <li><strong>Địa chỉ:</strong> {{ $appoinment->package->address }}</li>
            <li><strong>Giá:</strong> {{ number_format($appoinment->package->price, 0, ',', '.') }} VND</li>
            @endif
            <li><strong>Ngày hẹn:</strong> {{ \Carbon\Carbon::parse($available->date)->format('d/m/Y') }}</li>
            <li><strong>Thời gian cụ thể:</strong> {{ $available->startTime }} - {{ $available->endTime }}</li>
            <li><strong>Ghi chú:</strong> {{ $appoinment->notes }}</li>
            @if($appoinment->meet_link)
            <li><strong>Link meet:</strong> <a href="{{ $appoinment->meet_link }}" style="color: #007bff;">Click vào đây</a></li>
            @else
            <li><strong>Link meet:</strong> Không có link meet nào</li>
            @endif
        </ul>
        <p>Nếu quý khách có bất kỳ câu hỏi nào, xin vui lòng liên hệ với chúng tôi qua email hoặc số điện thoại đã cung cấp.</p>
        <div class="footer">
            <p>&copy; 2024 Instinct Pharmacy. Tất cả các quyền được bảo lưu. TG48</p>
        </div>
    </div>
</body>

</html>
