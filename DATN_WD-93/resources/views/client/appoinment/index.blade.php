<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Healthcare Platform
    </title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
   
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />

  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    <style>
        
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

       
        .hero-section {
            background: url('https://upanh123.com/wp-content/uploads/2021/03/anh-gia-dinh-hoat-hinh2.png') no-repeat center center;
            background-size: cover;
            text-align: center;
            color: white;
            padding: 100px 0;
            position: relative;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
        }

        .search-results {
            border: 1px solid #ccc;
            text-align: left;
            max-height: 400px;
            overflow-y: auto;
            background: black;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            display: none;
        }

        .search-results div {
            padding: 5px;
            cursor: pointer;
        }

        .search-results div:hover {
            background-color: #f0f0f0;
            color: black;
        }

        
        .services.hidden {
            display: none;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .hero-content h2 {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }

        .search-bar {
            max-width: 600px;
            margin: 0 auto 50px;
        }

        .search-bar input {
            border-radius: 50px;
            padding: 10px 20px;
            width: 100%;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        
        .services {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .service-item {
            text-align: center;
            color: black;
        }

        .service-item img {
            width: 60px;
            height: 60px;
        }

        .service-item p {
            margin-top: 10px;
            font-size: 1rem;
        }

        
        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

       
        .specialty-card {
            background-color: #fff;
            border: none;
            text-align: center;
            padding: 20px;
            margin: 10px;
        }

        .specialty-card img {
            width: 100%;
            max-width: 300px;
            height: auto;
        }

        .specialty-card p {
            margin-top: 10px;
            font-size: 16px;
        }


        .view-more {
            background-color: #e0e0e0;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #ccc;
        }

        .carousel-item .specialty-card {
            margin-right: 20px;
        }

        .specialty-card img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }


        .carousel-control-prev,
        .carousel-control-next {
            z-index: 10;
            width: 5%;
        }

        .carousel-control-prev {
            left: -40px;
        }

        .carousel-control-next {
            right: -40px;
        }

        .specialty-containerht {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }

        .specialty-cards {
            padding: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.2s;
        }

        .specialty-cards img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .specialty-cards:hover {
            transform: scale(1.05);
        }

        @media (min-width: 992px) {
            .specialty-containerht {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .specialty-cards {
            padding: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.2s;
        }

        .specialty-cards img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .specialty-cards:hover {
            transform: scale(1.05);
        }


        @media (max-width: 768px) {
            .specialty-card img {
                width: 150px;
                height: 150px;
            }
        }

        @media (max-width: 576px) {
            .specialty-card img {
                width: 120px;
                height: 120px;
            }
        }

        @media (max-width: 992px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content h2 {
                font-size: 1.2rem;
            }

            .specialty-card img {
                width: 100%;
                height: auto;
            }
        }

        @media (max-width: 768px) {
            .carousel-item {
                flex-direction: column;
                align-items: center;
            }

            .specialty-card {
                margin: 10px auto;
            }

            .carousel-control-prev,
            .carousel-control-next {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .section-title {
                font-size: 20px;
            }

            .hero-content h1 {
                font-size: 1.8rem;
            }

            .hero-content h2 {
                font-size: 1rem;
            }

            .search-bar input {
                padding: 8px 16px;
            }
        }
    </style>
</head>

<body>
    @extends('layout')
    @section('content')
    <div class="container mt-3">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>

    <div class="hero-section">
        <div class="hero-content">
            <h1 style="color: #fff;">T1 KHI NHÀ VUA TRỞ LẠI</h1>
            <h2 style="color: #fff;">NHÀ VÔ DỊCH CKTG 2 NĂM LIÊN TIẾP 2 LẦN</h2>
            <form>
                <div class="search-bar">
                    <input type="text" id="search-input" placeholder="Tìm phòng khám" autocomplete="off">
                    <div id="search-results" class="search-results"></div>
                </div>
            </form>
            <div class="services" id="services-section">
                <div class="service-item">
                    <button onclick="toggleContent()" style="background: none; border: none;">
                        <img src="https://www.cliniclistturkey.com/wp-content/uploads/2023/09/image-308.jpeg" alt="Specialized Examination" height="60" width="60">
                        <p style="color: #fff;">Chuyên khoa</p>
                    </button>
                </div>
                <div class="service-item">
                    <button onclick="toggleContent2()" style="background: none; border: none;">
                        <img src="https://is4-ssl.mzstatic.com/image/thumb/Purple122/v4/3f/50/e5/3f50e5bd-c30c-c586-2216-3976e5ee1542/AppIcons-1x_U007emarketing-0-7-0-85-220.png/1200x630wa.png" alt="Remote Examination">
                        <p style="color: #fff;">Khám qua video</p>
                    </button>
                </div>
                <div class="service-item">
                    <a href="/viewSikibidi" style="text-decoration: none;">
                        <img src="https://v-virtuales-marinela-frontend-assets.s3.amazonaws.com/assets/img/icon-register.png" alt="General Examination" height="60" width="60">
                        <p style="color: #fff;">Lần đầu bạn đến</p>
                    </a>
                </div>
                <div class="service-item">
                    <img src="https://www.lipotype.com/wp-content/uploads/2023/12/human_plasma_standard-3.png" alt="Medical Testing">
                    <p style="color: #fff;">Sét nghiệm y học</p>
                </div>
            </div>
        </div>
    </div>


    <div id="an">
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title">
                    Chuyên khoa phổ biến
                </div>
                <button class="view-more" onclick="toggleContent()">
                    XEM THÊM
                </button>
            </div>
            <div id="specialtyCarousel1" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-between align-items-center">
                            @foreach($specialties->slice(0, 3) as $item)
                            <a href="{{ route('appoinment.booKingCare', $item->id) }}" style="text-decoration: none;">
                                <div class="specialty-card">
                                    <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                                    <p>{{$item->name}}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex justify-content-between align-items-center">
                            @foreach($specialties->slice(3, 3) as $item)
                            <a href="{{ route('booKingCare', $item->id) }}" style="text-decoration: none;">
                                <div class="specialty-card">
                                    <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                                    <p>{{$item->name}}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex justify-content-between align-items-center">
                            @foreach($specialties->slice(6, 3) as $item)
                            <a href="{{ route('booKingCare', $item->id) }}" style="text-decoration: none;">
                                <div class="specialty-card">
                                    <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                                    <p>{{$item->name}}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex justify-content-between align-items-center">
                            @foreach($specialties->slice(9, 3) as $item)
                            <a href="{{ route('booKingCare', $item->id) }}" style="text-decoration: none;">
                                <div class="specialty-card">
                                    <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                                    <p>{{$item->name}}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#specialtyCarousel1" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#specialtyCarousel1" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div id="specialtyContent" style="display: none;">
            <div class="specialty-containerht">
                @foreach($specialties as $item)
                <a href="{{ route('appoinment.booKingCare', $item->id) }}" style="text-decoration: none;">
                    <div class="specialty-cards">
                        <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                        <p>{{$item->name}}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title">
                    Bác sĩ từ xa qua Video
                </div>
                <button class="view-more" onclick="toggleContent2()">
                    XEM THÊM
                </button>
            </div>
            <div id="specialtyCarousel2" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-between align-items-center">
                            @foreach($specialties->slice(0, 3) as $item)
                            <a href="{{ route('appoinment.booKingCare', $item->id) }}" style="text-decoration: none;">
                                <div class="specialty-card">
                                    <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                                    <p>{{$item->name}}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex justify-content-between align-items-center">
                            @foreach($specialties->slice(3, 3) as $item)
                            <a href="{{ route('appoinment.booKingCare', $item->id) }}" style="text-decoration: none;">
                                <div class="specialty-card">
                                    <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                                    <p>{{$item->name}}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#specialtyCarousel2" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#specialtyCarousel2" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div id="specialtyContent2" style="display: none;">
            <div class="specialty-containerht">
                @foreach($specialties as $item)
                <a href="{{ route('appoinment.booKingCare', $item->id) }}" style="text-decoration: none;">
                    <div class="specialty-cards">
                        <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                        <p>{{$item->name}}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title">
                    Khám tổng quát
                </div>
                <button class="view-more" onclick="toggleContent3()">
                    XEM THÊM
                </button>
            </div>
            <div id="specialtyCarousel3" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-between align-items-center">
                            @foreach($specialties->slice(0, 3) as $item)
                            <a href="{{ route('appoinment.booKingCare', $item->id) }}" style="text-decoration: none;">
                                <div class="specialty-card">
                                    <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                                    <p>{{$item->name}}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex justify-content-between align-items-center">
                            @foreach($specialties->slice(3, 3) as $item)
                            <a href="{{ route('appoinment.booKingCare', $item->id) }}" style="text-decoration: none;">
                                <div class="specialty-card">
                                    <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                                    <p>{{$item->name}}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#specialtyCarousel3" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#specialtyCarousel3" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div id="specialtyContent3" style="display: none;">
            <div class="specialty-containerht">
                @foreach($specialties as $item)
                <a href="" style="text-decoration: none;">
                    <div class="specialty-cards">
                        <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                        <p>{{$item->name}}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title">
                    Xét nghiệm y học
                </div>
                <button class="view-more" onclick="toggleContent4()">
                    XEM THÊM
                </button>
            </div>
            <div id="specialtyCarousel4" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-between align-items-center">
                            @foreach($specialties->slice(0, 3) as $item)
                            <a href="" style="text-decoration: none;">
                                <div class="specialty-card">
                                    <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                                    <p>{{$item->name}}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex justify-content-between align-items-center">
                            @foreach($specialties->slice(3, 3) as $item)
                            <a href="" style="text-decoration: none;">
                                <div class="specialty-card">
                                    <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                                    <p>{{$item->name}}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#specialtyCarousel4" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#specialtyCarousel4" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div id="specialtyContent4" style="display: none;">
            <div class="specialty-containerht">
                @foreach($specialties as $item)
                <a href="" style="text-decoration: none;">
                    <div class="specialty-cards">
                        <img alt="Image of a joint representing {{$item->name}}" src="{{ asset('upload/' . $item->image) }}" />
                        <p>{{$item->name}}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $('#search-input').on('focus', function() {
                    $('#services-section').addClass('hidden');
                    $('#search-results').empty().show();
                });

                $('#search-input').on('input', function() {
                    let query = $(this).val();

                    if (query.length > 0) {
                        $.ajax({
                            url: "{{ route('appoinment.autocompleteSearch') }}",
                            type: "GET",
                            data: {
                                query: query
                            },
                            success: function(data) {
                                let resultsDiv = $('#search-results');
                                resultsDiv.empty();

                                if (data.length > 0) {
                                    data.forEach(function(clinics) {
                                        resultsDiv.append(`
                                            <a href="/booKingCare/${clinics.id}">
                                                <div>
                                                    ${clinics.name} 
                                                    <img style="width: 100px; height: 100px;" src="/upload/${clinics.image}">
                                                </div>
                                            </a>
                                        `);
                                    });
                                } else {
                                    resultsDiv.append('<div>Không tìm thấy phòng khám</div>');
                                }
                            }
                        });
                    } else {
                        $('#search-results').hide();
                        $('#services-section').removeClass('hidden');
                    }
                });

                $(document).on('click', function(event) {
                    if (!$(event.target).closest('#search-input, #search-results').length) {
                        if ($('#search-input').val().length === 0) {
                            $('#services-section').removeClass('hidden');
                            $('#search-results').hide();
                        }
                    }
                });
            });


            function toggleContent() {
                const carousel = document.getElementById("specialtyCarousel1");
                const specialtyContent = document.getElementById("specialtyContent");

                if (carousel.style.display === "none") {
                    carousel.style.display = "block";
                    specialtyContent.style.display = "none";
                } else {
                    carousel.style.display = "none";
                    specialtyContent.style.display = "block";
                }
            }

            function toggleContent2() {
                const carousel2 = document.getElementById("specialtyCarousel2");
                const specialtyContent2 = document.getElementById("specialtyContent2");

                if (carousel2.style.display === "none") {
                    carousel2.style.display = "block";
                    specialtyContent2.style.display = "none";
                } else {
                    carousel2.style.display = "none";
                    specialtyContent2.style.display = "block";
                }
            }

            function toggleContent3() {
                const carousel3 = document.getElementById("specialtyCarousel3");
                const specialtyContent3 = document.getElementById("specialtyContent3");

                if (carousel3.style.display === "none") {
                    carousel3.style.display = "block";
                    specialtyContent3.style.display = "none";
                } else {
                    carousel3.style.display = "none";
                    specialtyContent3.style.display = "block";
                }
            }

            function toggleContent4() {
                const carousel4 = document.getElementById("specialtyCarousel4");
                const specialtyContent4 = document.getElementById("specialtyContent4");

                if (carousel4.style.display === "none") {
                    carousel4.style.display = "block";
                    specialtyContent4.style.display = "none";
                } else {
                    carousel4.style.display = "none";
                    specialtyContent4.style.display = "block";
                }
            }
        </script>
        @endsection
</body>

</html>