<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>
    @extends('layout')
    @section('content')
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" id="navbarDropdown">
                <i class="fas fa-bars"></i> BookingCare
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        @if(Auth::check())
                        <a class="nav-link" href="{{ route('appoinment.appointmentHistory', $user = Auth::user()->id) }}">Lịch sửa đặt khám</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if(Auth::check())
                        <a class="nav-link" href="{{ route('appoinment.physicianManagement', $user = Auth::user()->id) }}">Bác sỹ quản lý</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Bác sĩ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Gói khám</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
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
                    <span class="badge bg-warning text-dark me-2">Yêu thích</span>
                    <h5>{{ $doctor->user->name }}</h5>
                </div>
                <p>{!! Str::limit($doctor->bio, 300, '...') !!}</p>
                <div class="location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $doctor->user->address }}</span>
                </div>
                <a class="text-primary" href="{{ route('appoinment.doctorDetails', $doctor->id) }}">Xem thêm</a>
            </div>


            <div class="schedule">
                <label for="dateSelect-{{ $doctor->id }}">Chọn ngày:</label>
                <select id="dateSelect-{{ $doctor->id }}" class="form-select date-select" aria-label="Chọn ngày">
                    @php
                    $availableDates = $doctor->timeSlot->filter(function ($timeSlot) {
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
                    @else
                    <div class="time-slot-item" style="color: red;">
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} -
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }} (đã có người đặt)
                    </div>
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
                    <p>{{ $clinic->city}}, {{ $clinic->address }}</p>
                </div>
                @else

                @endif
                @endforeach
            </div>
        </div>
        @endforeach



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
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