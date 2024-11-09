<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmation</title>
</head>
<body>
    <h1>Xin chào sikibidi: {{ $user }}</h1>
    <p>Cả ơn bro chúc bro có trải nghiệm khám thật tuyệt vời</p>
    <p><strong>Thông tin lịch hẹn:</strong></p>
    <ul>
        <li><strong>Bác Sỹ:</strong> {{ $appoinment->doctor->user->name }}</li>
        <li><strong>Số điện thoại:</strong> {{ $appoinment->doctor->user->phone }}</li>
        <li><strong>Ngày hẹn:</strong> {{ \Carbon\Carbon::parse($available->date)->format('d/m/Y') }}</li>
        <li><strong>Thời gian cụ thể:</strong> {{ $available->startTime }} - {{ $available->endTime }}</li>
        <li><strong>Notes:</strong> {{ $appoinment->notes }}</li>
    </ul>
    <p>TG 48</p>
</body>
</html>