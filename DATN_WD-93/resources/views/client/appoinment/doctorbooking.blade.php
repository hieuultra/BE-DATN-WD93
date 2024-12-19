<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <style>
        body {
            background-color: #e6f7f7;
        }

        .navbar {
            background-color: #e6f7f7;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #ffb100;
            cursor: pointer;
        }

        .navbar-nav .nav-link {
            color: #000;
            font-size: 16px;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 0;
        }

        .breadcrumb-item a {
            color: #007bff;
            text-decoration: none;
        }

        .content {
            padding: 20px;
        }

        .content h1 {
            font-size: 28px;
            font-weight: bold;
        }

        .content h2 {
            font-size: 20px;
            font-weight: bold;
        }

        .content p {
            font-size: 16px;
        }

        .content ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        .content ul li {
            font-size: 16px;
        }

        .content a {
            color: #007bff;
            text-decoration: none;
        }

        .more-content {
            display: none;
        }

        .fullscreen-menu {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            z-index: 1000;
            padding: 20px;
            box-sizing: border-box;
        }

        .fullscreen-menu a {
            display: block;
            padding: 10px 0;
            color: #fff;
            text-decoration: none;
            font-size: 24px;
        }

        .fullscreen-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .close-menu {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 30px;
            cursor: pointer;
        }

        .doctor-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 16px;
            display: flex;
            align-items: flex-start;
            background-color: #fff;
            flex-wrap: wrap;
        }

        .doctor-card img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
        }

        .doctor-info {
            margin-left: 16px;
            flex: 1;
        }

        .doctor-info h5 {
            margin: 0;
            font-size: 18px;
            color: #007bff;
        }

        .doctor-info p {
            margin: 4px 0;
            font-size: 14px;
            color: #666;
        }

        .doctor-info .location {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #666;
        }

        .custom-navbar {
            background-color: #FFD700; /* Màu vàng */
            color: #000; /* Màu chữ đen */
        }

        .custom-navbar .navbar-brand,
        .custom-navbar .nav-link {
            color: #000 !important; /* Màu chữ đen cho liên kết */
        }

        .custom-navbar .nav-link:hover {
            color: #333 !important; /* Màu chữ đậm hơn khi hover */
        }

.custom-navbar .navbar-brand:hover {
    text-decoration: underline; /* Gạch chân khi hover */
}


        .specialty-details {
            background-color: #f8f9fa; /* Light background for the section */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .description {
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Hiển thị 3 dòng */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .description.expanded {
            display: block; /* Hiển thị toàn bộ nội dung */
            -webkit-line-clamp: unset;
            overflow: visible;
        }

        .specialty-name {
            font-size: 1.5em; /* Larger font size for the specialty name */
            font-weight: bold;
            margin-bottom: 15px;
        }

        .specialty-description {
            font-size: 1em; /* Slightly larger font for the description */
            color: #333; /* Darker color for the description text */
            line-height: 1.6;
            font-style: italic;
        }

        /* Add some styling to the "limit" description */
        .specialty-description::after {
            content: '...'; /* Add an ellipsis at the end of the limited description */
        }

        /* Optional: Responsive Design */
        @media (max-width: 768px) {
            .specialty-details {
                padding: 15px;
            }
            .specialty-name {
                font-size: 1.8em;
            }
            .specialty-description {
                font-size: 1em;
            }
        }

        .doctor-info .location i {
            margin-right: 4px;
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

        #dateSelect {
            width: 100%;
            max-width: 300px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .strike-through {
            text-decoration: line-through;
            color: #999;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
        }

        .flame-effect {
            color: red;
            font-weight: bold;
            position: relative;
            display: inline-block;
            animation: flame 1s infinite alternate;
        }

        @keyframes flame {
            0% { text-shadow: 0 0 5px orange, 0 0 10px yellow, 0 0 15px red; }
            100% { text-shadow: 0 0 10px red, 0 0 20px orange, 0 0 25px yellow; }
        }

    </style>
</head>

<body>
    @extends('layout')
    @section('content')
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('appoinment.index')}}" id="navbarDropdown">
                Quay Lại
            </a>
        </div>
    </nav>


    <div class="container mt-4">
    <div class="specialty-details">
        <h2 class="specialty-name text-primary">CHUYÊN KHOA: {{$specialty->name}}</h2>
        <h3 class="specialty-description">Mô tả: <div id="description" class="description">
            {!! nl2br(e($specialty->description)) !!}
        </div>
        <button id="toggle-button" class="btn btn-primary mt-2">Xem thêm</button></h3>
    </div>


        <div class="row mb-4 align-items-center">
            <div class="col">
                <input type="text" id="doctorSearch" class="form-control" placeholder="Tìm kiếm bác sĩ..." onkeyup="filterDoctors()">
            </div>
        </div>


        @foreach($doctors as $doctor)
        <div class="doctor-card" data-name="{{ $doctor->user->name }}" style="margin-top: 10px;">

            <img alt="Doctor's portrait" height="80" src="{{ asset('upload/' . $doctor->user->image) }}" width="80" />
            <div class="doctor-info">
                <div class="d-flex align-items-center mb-2">
                    @if(number_format($doctor->review_avg_rating, 1) >= 4.0)
                    <h5 class="flame-effect" style="color: red; font-weight: bold;">
                        🔥 {{ $doctor->user->name }} 🔥
                    </h5>
                    @else
                    <h5 class="text-primary">
                        {{ $doctor->user->name }}
                    </h5>
                    @endif
                </div>
                @if($doctor->review_count > 0) 
                <h6>Số lượt đánh giá: {{ $doctor->review_count }}</h6>
                <h6>
                    Số sao trung bình: 
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($doctor->review_avg_rating))
                            <!-- Sao đầy -->
                            <i class="fas fa-star" style="color: gold;"></i>
                        @elseif ($i - 0.5 <= $doctor->review_avg_rating)
                            <!-- Sao nửa -->
                            <i class="fas fa-star-half-alt" style="color: gold;"></i>
                        @else
                            <!-- Sao trống -->
                            <i class="far fa-star" style="color: gold;"></i>
                        @endif
                    @endfor
                    ({{ number_format($doctor->review_avg_rating, 1) }} / 5)
                </h6>
                @else
                <h6>Chưa có đánh giá: {{ $doctor->review_count }}</h6>
                @endif
                <p>{!! Str::limit($doctor->bio, 300, '...') !!}</p>
                <div class="location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $doctor->user->address }}</span>
                </div>
                <a class="text-primary" href="{{ route('appoinment.doctorDetails', $doctor->id) }}">Xem thêm</a>
            </div>


            <div class="schedule">
                <label for="dateSelect-{{ $doctor->id }}">Chọn ngày đặt khám:</label>
                <select id="dateSelect-{{ $doctor->id }}" class="form-select date-select" aria-label="Chọn ngày">
                    @php
                        $availableDates = $doctor->timeSlot->filter(function ($timeSlot) {
                            return $timeSlot->isAvailable == 1;
                        })->unique(function ($item) {
                            return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
                        });
                        $availableDates = $availableDates->sortBy(function ($timeSlot) {
                            return \Carbon\Carbon::parse($timeSlot->date);
                        });
                    @endphp
                    @foreach($availableDates as $timeSlot)
                        @php
                            $formattedDate = \Carbon\Carbon::parse($timeSlot->date)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                            $formattedDateValue = \Carbon\Carbon::parse($timeSlot->date)->format('Y-m-d');
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
                    <a href="{{ route('appoinment.formbookingdt', $timeSlot->id) }}" style="text-decoration: none;">
                        <div class="time-slot-item" data-date="{{ $formattedDateValue }}">
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} -
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}
                        </div>
                    </a>
                    @endif
                    @endforeach
                </div>

                <p class="mt-2">
                    <i class="fas fa-hand-pointer"></i> Chọn và đặt (Phí đặt lịch {{ number_format($doctor->examination_fee, 0, ',', '.') }}đ)
                </p>
                @foreach($clinics as $clinic)
                @if($doctor->id == $clinic->doctor_id)
                <div class="address">
                    <strong>ĐỊA CHỈ KHÁM: {{ $clinic->address }}</strong>
                    <p>{{ $clinic->clinic_name}}</p>
                </div>
                @else

                @endif
                @endforeach
            </div>
        </div>
        @endforeach



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if (session('jsError'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: "{{ session('jsError') }}",
                    });
                @endif
            });
        </script>

        <script>

            document.addEventListener("DOMContentLoaded", function () {
                const description = document.getElementById("description");
                const toggleButton = document.getElementById("toggle-button");

                toggleButton.addEventListener("click", () => {
                    if (description.classList.contains("expanded")) {
                        description.classList.remove("expanded");
                        toggleButton.textContent = "Xem thêm";
                    } else {
                        description.classList.add("expanded");
                        toggleButton.textContent = "Thu gọn";
                    }
                });
            });


            document.querySelectorAll('.date-select').forEach(function(select) {
                select.addEventListener('change', function() {
                    let selectedDate = this.value;
                    let doctorCard = this.closest('.doctor-card');
                    let timeSlots = doctorCard.querySelectorAll('.time-slot-item');

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


            function filterDoctors() {
                const searchInput = document.getElementById('doctorSearch').value.toLowerCase();
                const doctorCards = document.querySelectorAll('.doctor-card');

                doctorCards.forEach(card => {
                    const doctorName = card.getAttribute('data-name').toLowerCase();
                    const matchesSearch = doctorName.includes(searchInput);

                    if (matchesSearch) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            document.getElementById('closeMenu').addEventListener('click', function() {
                var fullscreenMenu = document.getElementById('fullscreenMenu');
                fullscreenMenu.style.display = 'none';
            });

            document.addEventListener('click', function(event) {
                var isClickInside = document.getElementById('navbarDropdown').contains(event.target) || document.getElementById('fullscreenMenu').contains(event.target);
                if (!isClickInside) {
                    document.getElementById('fullscreenMenu').style.display = 'none';
                }
            });
        </script>
        @endsection
</body>

</html>
