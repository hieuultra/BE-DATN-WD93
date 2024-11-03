@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styleAppoinment.css') }}">

<div class="main">
    <div class="container mt-5">
        <div class="header-main d-flex">
            <div class="logo-header-main2 mb-5">
                <svg style="color: aqua;" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-buildings-fill" viewBox="0 0 16 16">
                    <path d="M15 .5a.5.5 0 0 0-.724-.447l-8 4A.5.5 0 0 0 6 4.5v3.14L.342 9.526A.5.5 0 0 0 0 10v5.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V14h1v1.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zM2 11h1v1H2zm2 0h1v1H4zm-1 2v1H2v-1zm1 0h1v1H4zm9-10v1h-1V3zM8 5h1v1H8zm1 2v1H8V7zM8 9h1v1H8zm2 0h1v1h-1zm-1 2v1H8v-1zm1 0h1v1h-1zm3-2v1h-1V9zm-1 2h1v1h-1zm-2-4h1v1h-1zm3 0v1h-1V7zm-2-2v1h-1V5zm1 0h1v1h-1z"/>
                  </svg>
                <span style="font-weight: bolder; font-size: 40px; color: #FFCC66;">BookingCare</span>
            </div>
            <div class="link d-flex">
                <a href="" class="nav-link nav">
                    <div class="text-link-header mt-2 ms-4">
                        <p style="margin: 0px; font-weight: bold; font-size: small; color: black;">Chuyên Khoa</p>
                        <p style="color: gray; font-size: small;">Tìm bác sĩ theo chuyên khoa</p>
                    </div>
                </a>
                <a href="" class="nav-link nav">
                    <div class="text-link-header mt-2 ms-4">
                        <p style="margin: 0px; font-weight: bold; font-size: small; color: black;">Cơ Sở Y Tế</p>
                        <p style="color: gray; font-size: small;">Chọn bệnh viện, phòng khám</p>
                    </div>
                </a>
                <a href="" class="nav-link nav">
                    <div class="text-link-header mt-2 ms-1">
                        <p style="margin: 0px; font-weight: bold; font-size: small; color: black;">Bác sĩ</p>
                        <p style="color: gray; font-size: small;">Chọn bác sĩ giỏi</p>
                    </div>
                </a>
                <a href="" class="nav-link nav">
                    <div class="text-link-header mt-2 ms-1">
                        <p style="margin: 0px; font-weight: bold; font-size: small; color: black;">Gói khám</p>
                        <p style="color: gray; font-size: small;">Khám sức khỏe tổng quát</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="title-link d-flex">
            <a href="" style="text-decoration: none; color: black;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                    <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
                </svg>
            </a>
            <div class="d-flex" style="padding: 2px 2px 0px 2px;">
                <span class="px-1" style="font-weight: 100; font-size: 18px;">/</span>
                <p style="font-weight: 100; font-size: 16px; padding-top: 2px;">Khám Chuyên Khoa</p>
            </div>
        </div>

        <div class="chuyenkhoa mt-4 mb-4">
            <div class="row" >
                @foreach ($firstBatch as $item)
                <div class="col" >
                    <div>
                        <a href="{{ route('appoinment.doctorsBySpecialtyId', $item->id) }}">
                            <div>
                                <img style="width: 90%; height: auto; border: 2px solid lightgray; border-radius: 10px;"
                                     src="{{ asset('upload/'.$item->image) }}" alt="">
                            </div>
                            <p class="pt-2 pb-2">{{ $item->name }}</p>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>


         <div class="chuyenkhoa mt-4 mb-4">
            <div class="row" >
                @foreach ($secondBatch as $item)
                <div class="col" >
                    <div>
                        <a href="{{ route('appoinment.doctorsBySpecialtyId', $item->id) }}">
                            <div>
                                <img style="width: 90%; height: auto; border: 2px solid lightgray; border-radius: 10px;"
                                     src="{{ asset('upload/'.$item->image) }}" alt="">
                            </div>
                            <p class="pt-2 pb-2">{{ $item->name }}</p>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!--  -->
        {{-- <div class="chuyenkhoa mt-4 mb-4">
            <div class="row" >
                <div class="col" >
                    <div>
                        <a href="">
                            <div>
                                <img style="width: 90%; height: auto; border: 2px solid lightgray; border-radius: 10px;"
                                     src="https://cdn.bookingcare.vn/fo/w384/2023/12/26/101713-san-phu-khoa.png" alt="">
                            </div>
                            <p class="pt-2 pb-2">Sản Phụ Khoa</p>
                        </a>
                    </div>
                </div>
                <div class="col" >
                    <div >
                        <a href="">
                            <div>
                                <img style="width: 90%; height: auto; border: 2px solid lightgray; border-radius: 10px;"
                                     src="https://cdn.bookingcare.vn/fo/w384/2023/12/26/101713-sieu-am-thai.png" alt="">
                            </div>
                            <p class="pt-2 pb-2">Siêu Âm Thai</p>
                        </a>
                    </div>
                </div>
                <div class="col" >
                    <div >
                        <a href="">
                            <div>
                                <img style="width: 90%; height: auto; border: 2px solid lightgray; border-radius: 10px;"
                                     src="https://cdn.bookingcare.vn/fo/w384/2023/12/26/101655-nhi-khoa.png" alt="">
                            </div>
                            <p class="pt-2 pb-2">Nhi Khoa</p>
                        </a>
                    </div>
                </div>
                <div class="col" >
                    <div >
                        <a href="">
                            <div>
                                <img style="width: 90%; height: auto; border: 2px solid lightgray; border-radius: 10px;"
                                     src="https://cdn.bookingcare.vn/fo/w384/2023/12/26/101638-da-lieu.png" alt="">
                            </div>
                            <p class="pt-2 pb-2">Da Liễu</p>
                        </a>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--  -->
        {{-- <div class="chuyenkhoa mt-4 mb-4">
            <div class="row" >
                <div class="col" >
                    <div>
                        <a href="">
                            <div>
                                <img style="width: 90%; height: auto; border: 2px solid lightgray; border-radius: 10px;"
                                     src="https://cdn.bookingcare.vn/fo/w384/2023/12/26/101739-viem-gan.png" alt="">
                            </div>
                            <p class="pt-2 pb-2">Bệnh Viêm Gan</p>
                        </a>
                    </div>
                </div>
                <div class="col" >
                    <div >
                        <a href="">
                            <div>
                                <img style="width: 90%; height: auto; border: 2px solid lightgray; border-radius: 10px;"
                                     src="https://cdn.bookingcare.vn/fo/w384/2023/12/26/101713-suc-khoe-tam-than.png" alt="">
                            </div>
                            <p class="pt-2 pb-2">Sức Khỏe Tâm Thần</p>
                        </a>
                    </div>
                </div>
                <div class="col" >
                    <div >
                        <a href="">
                            <div>
                                <img style="width: 90%; height: auto; border: 2px solid lightgray; border-radius: 10px;"
                                     src="https://cdn.bookingcare.vn/fo/w384/2023/12/26/101638-di-ung-mien-dich.png" alt="">
                            </div>
                            <p class="pt-2 pb-2">Dị Ứng Miễn Dịch</p>
                        </a>
                    </div>
                </div>
                <div class="col" >
                    <div >
                        <a href="">
                            <div>
                                <img style="width: 90%; height: auto; border: 2px solid lightgray; border-radius: 10px;"
                                     src="https://cdn.bookingcare.vn/fo/w384/2023/12/26/101638-ho-hap-phoi.png" alt="">
                            </div>
                            <p class="pt-2 pb-2">Hô Hấp - Phổi</p>
                        </a>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--  -->
        <!--  -->
    </div>
</div>

@endsection
