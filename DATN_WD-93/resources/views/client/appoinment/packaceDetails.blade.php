<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        BookingCare
    </title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #e6f7f9;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ff9900;
        }

        .navbar-nav .nav-link {
            color: #333;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        .header-icons a {
            color: #007bff;
            margin-left: 15px;
        }

        .breadcrumb {
            background-color: #fff;
        }

        .breadcrumb-item a {
            color: #007bff;
        }

        .schedule {
            margin-left: auto;
            text-align: right;
            flex: 1;
        }

        .schedule h6 {
            font-size: 14px;
            color: #007bff;
            margin-bottom: 8px;
        }

        .schedule .time-slot {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .schedule .time-slot div {
            background-color: #f0f0f0;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
        }

        .schedule .address {
            margin-top: 16px;
            font-size: 14px;
            color: #666;
        }

        @media (max-width: 768px) {
            .doctor-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .doctor-info {
                margin-left: 0;
                margin-top: 16px;
            }

            .schedule {
                margin-left: 0;
                margin-top: 16px;
                text-align: left;
            }
        }

        .doctor-info {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .doctor-info img {
            border-radius: 50%;
            margin-right: 20px;
        }

        .doctor-info .doctor-details {
            max-width: 600px;
        }

        .doctor-info .doctor-details h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .doctor-info .doctor-details p {
            margin: 0;
            color: #666;
        }

        .doctor-info .doctor-details .location {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .doctor-info .doctor-details .location i {
            color: #007bff;
            margin-right: 5px;
        }

        .doctor-info .doctor-details .buttons {
            margin-top: 10px;
        }

        .doctor-info .doctor-details .buttons button {
            margin-right: 10px;
        }

        .schedule {
            margin-top: 20px;
        }

        .schedule h5 {
            font-size: 1rem;
            font-weight: bold;
            color: #333;
        }

        .schedule .time-slots {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .schedule .time-slots button {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 10px 20px;
            border-radius: 5px;
            color: #333;
        }

        .schedule .time-slots button:hover {
            background-color: #007bff;
            color: #fff;
        }

        .clinic-info {
            margin-top: 20px;
        }

        .clinic-info h5 {
            font-size: 1rem;
            font-weight: bold;
            color: #333;
        }

        .clinic-info p {
            margin: 0;
            color: #666;
        }

        .feedback-section {
            margin: 20px;
        }

        .feedback-item {
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 0;
        }

        .feedback-item:last-child {
            border-bottom: none;
        }

        .feedback-item a {
            color: #00a2e8;
            text-decoration: none;
        }

        .feedback-item a:hover {
            text-decoration: underline;
        }

        .footer {
            background-color: #006666;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }

        .footer a {
            color: #ffdd00;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
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
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                BookingCare
            </a>
            <button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                class="navbar-toggler" data-bs-target="#navbarNav" data-bs-toggle="collapse" type="button">
                <span class="navbar-toggler-icon">
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Chuyên khoa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Cơ sở y tế
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Bác sĩ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Gói khám
                        </a>
                    </li>
                </ul>
                <div class="header-icons">
                    <a href="#">
                        <i class="fas fa-calendar-alt">
                        </i>
                        Lịch hẹn
                    </a>
                    <a href="#">
                        <i class="fas fa-question-circle">
                        </i>
                        Hỗ trợ
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">
                        Khám chuyên khoa
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">
                        {{$package->specialty->name}}
                    </a>
                </li>
            </ol>
        </nav>
        <div class="doctor-info">
            <img alt="Doctor's portrait" height="100"
                src="{{ asset('upload/' . $package->image) }}"
                width="100" />
            <div class="doctor-details">
                <h2>
                    <span class="badge bg-warning text-dark">
                        Yêu thích
                    </span>
                    {{$package->hospital_name}}
                </h2>
                <p>
                    {!! Str::limit($package->description, 340, '...') !!}
                </p>
                <div class="location">
                    <i class="fas fa-map-marker-alt">
                    </i>
                    <span>
                        {{$package->address}}
                    </span>
                </div>
                <div class="buttons">
                    <button class="btn btn-primary">
                        <i class="fas fa-thumbs-up">
                        </i>
                        Thích 0
                    </button>
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-share">
                        </i>
                        Chia sẻ
                    </button>
                </div>
            </div>
        </div>
        <div class="schedule">
            <label for="dateSelect-{{ $package->id }}">Chọn ngày:</label>
            <select id="dateSelect-{{ $package->id }}" class="form-select date-select" aria-label="Chọn ngày">
                @php
                $availableDates = $package->timeSlot->filter(function ($timeSlot) {
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

            <div class="time-slots">
                @foreach($package->timeSlot as $timeSlot)
                @php
                $formattedDateValue = \Carbon\Carbon::parse($timeSlot->date)->format('Y-m-d');
                @endphp
                <div class="time-slot mt-3 time-slot-item" data-date="{{ $formattedDateValue }}">
                    @if($timeSlot->isAvailable == 1)
                    <a href="{{ route('appoinment.formbookingdt', $timeSlot->id) }}" style="text-decoration: none;" class="border p-2 rounded">
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} -
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}
                    </a>
                    @endif
                </div>
                @endforeach
            </div>

            <p style="margin-top: 10px;">
                Chọn <i class="fas fa-check-circle"></i> và đặt {{ number_format($package->price, 0, ',', '.') }} vnd
            </p>
        </div>

        <div class="content" style="margin-top: 10px;">
            {!! $package->description !!}
        </div>

        <div class="feedback-section">
            <h1>Phản hồi của bệnh nhân sau khi đi khám</h1>
            @foreach($packagerv->review as $review)
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
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dateSelect = document.getElementById('dateSelect-{{ $package->id }}');
                const timeSlotItems = document.querySelectorAll('.time-slot-item');

                function filterTimeSlots() {
                    const selectedDate = dateSelect.value;
                    timeSlotItems.forEach(slot => {
                        slot.style.display = slot.getAttribute('data-date') === selectedDate ? 'block' : 'none';
                    });
                }

                dateSelect.addEventListener('change', filterTimeSlots);
                filterTimeSlots();
            });
        </script>
        @endsection
</body>

</html>