<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhắc nhở lịch khám</title>
</head>
<body>
    <h1>Xin chào {{ $user->name }},</h1>

    <p>Bạn có một lịch hẹn khám với thông tin chi tiết như sau:</p>

    <ul>
        <li><strong>Ngày khám:</strong> {{ \Carbon\Carbon::parse($appointment->timeSlot->date)->format('d/m/Y') }}</li>
        <li><strong>Thời gian bắt đầu:</strong> {{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->timeSlot->startTime)->format('H:i') }}</li>
        <li><strong>Bác sĩ:</strong> {{ $appointment->doctor->user->name }}</li>
    </ul>

    <p>Hãy đến đúng giờ để tránh bị mất lịch hẹn của bạn.</p>

    <p>Trân trọng,</p>
    <p>Hệ thống đặt lịch khám</p>
</body>
</html>
