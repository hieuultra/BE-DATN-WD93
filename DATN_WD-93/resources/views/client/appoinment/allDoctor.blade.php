<html>

<head>
    <title>
        Đội ngũ Bác sĩ Bệnh viện Đa Khoa Phương Đông
    </title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .breadcrumb {
            background-color: #f8f9fa;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 0;
        }

        .breadcrumb a {
            text-decoration: none;
            color: #007bff;
        }

        .doctor-card {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .doctor-card img {
            max-width: 100px;
            border-radius: 50%;
        }

        .doctor-card h5 {
            font-size: 18px;
            margin-top: 10px;
        }

        .doctor-card p {
            margin: 5px 0;
        }

        .doctor-card a {
            color: #007bff;
            text-decoration: none;
        }

        .sidebar {
            border-left: 1px solid #ddd;
            padding-left: 20px;
        }

        .sidebar input {
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>

<body>
    @extends('layout')
    @section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>Đội ngũ Bác sĩ Bệnh viện Đa Khoa Phương Đông</h3>


                <input type="text" id="doctorSearch" class="form-control" placeholder="Tìm bác sĩ" onkeyup="filterDoctors()" />

                <p>
                    Bệnh viện Đa khoa Phương Đông quy tụ đội ngũ chuyên gia, giáo sư, bác sĩ đầu ngành, có nhiều năm kinh nghiệm công tác tại các bệnh viện tuyến đầu trong cả nước và tu nghiệp tại các trung tâm chăm sóc sức khỏe, bệnh viện lớn ở nước ngoài.
                </p>


                <div id="doctorList">
                    @foreach($doctors as $dt)
                    <div class="doctor-card row" data-doctor-name="{{ $dt->user->name }}">
                        <div class="col-md-2">
                            <img alt="Doctor" height="100" src="{{ asset('upload/' . $dt->user->image) }}" width="100" />
                        </div>
                        <div class="col-md-10">
                            <h5>
                                {{$dt->position}} {{$dt->user->name}}
                            </h5>
                            <p>{{$dt->title}}</p>
                            <p>{!! Str::limit($dt->bio, 300, '...') !!}</p>
                            <a href="{{ route('appoinment.doctorDetails', $dt->id) }}">
                                Xem thêm »
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4 sidebar">
                <ul>
                    <li style="color: #ddd; background-color: gray;">Chuyên khoa</li>
                    @foreach($specialties as $sp)
                    @if($sp->classification == 'chuyen_khoa')
                    <li><a href="{{ route('appoinment.booKingCare', $sp->id) }}" onclick="filterDoctorsBySpecialty('chuyen_khoa')">{{$sp->name}}</a></li>
                    @endif
                    @endforeach

                    <li style="color: #ddd; background-color: gray;">Khám Từ xa</li>
                    @foreach($specialties as $sp)
                    @if($sp->classification == 'kham_tu_xa')
                    <li><a href="{{ route('appoinment.booKingCare', $sp->id) }}" onclick="filterDoctorsBySpecialty('kham_tu_xa')">{{$sp->name}}</a></li>
                    @endif
                    @endforeach

                    <li style="color: #ddd; background-color: gray;">Tổng quát</li>
                    @foreach($specialties as $sp)
                    @if($sp->classification == 'tong_quat')
                    <li><a href="{{ route('appoinment.booKingCare', $sp->id) }}" onclick="filterDoctorsBySpecialty('tong_quat')">{{$sp->name}}</a></li>
                    @endif
                    @endforeach
                </ul>
            </div>

        </div>
    </div>

    <script>
        function filterDoctors() {
            var input = document.getElementById("doctorSearch");
            var filter = input.value.toLowerCase();
            var doctorList = document.getElementById("doctorList");
            var doctors = doctorList.getElementsByClassName("doctor-card");

            for (var i = 0; i < doctors.length; i++) {
                var doctorName = doctors[i].getAttribute("data-doctor-name").toLowerCase();
                if (doctorName.indexOf(filter) > -1) {
                    doctors[i].style.display = "";
                } else {
                    doctors[i].style.display = "none";
                }
            }
        }
    </script>
    @endsection
</body>

</html>