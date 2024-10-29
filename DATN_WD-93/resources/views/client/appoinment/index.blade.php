@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styleAppoinment.css') }}">
<style>
    .chosse {
  padding: 20px 0;
  margin-top: 150px;
}

.chosse-banner {
  gap: 30px; /* Tăng khoảng cách giữa các mục nếu cần */
}
</style>
 <!-- Banner -->
 <div class="banner">
    <img
      src="https://pmc.bookingcare.vn/assets/anh/bookingcare-cover-4.jpg"
      alt=""
    />
    <div class="title">
      <p>NỀN TẢNG Y TẾ</p>
      <p>CHĂM SÓC SỨC KHỎE TOÀN DIỆN</p>
        <input type="text" placeholder="Nhập Nội Dung Cần Tìm" style="font-size: 26px"/>
        <i class="fas fa-search"></i>
    </div>
  </div>
  <div class="chosse">
    <div class="container d-flex justify-content-center">1
      <div class="row">
        <div class="chosse-banner d-flex justify-content-center">
          <a href="{{ route('appoinment.specialistExamination') }}">
            <div class="col text-center">
              <div class="chosse-icon">
                <svg
                  class="pt-2"
                  xmlns="http://www.w3.org/2000/svg"
                  width="40"
                  height="40"
                  fill="currentColor"
                  class="bi bi-hospital"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M8.5 5.034v1.1l.953-.55.5.867L9 7l.953.55-.5.866-.953-.55v1.1h-1v-1.1l-.953.55-.5-.866L7 7l-.953-.55.5-.866.953.55v-1.1zM13.25 9a.25.25 0 0 0-.25.25v.5c0 .138.112.25.25.25h.5a.25.25 0 0 0 .25-.25v-.5a.25.25 0 0 0-.25-.25zM13 11.25a.25.25 0 0 1 .25-.25h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25zm.25 1.75a.25.25 0 0 0-.25.25v.5c0 .138.112.25.25.25h.5a.25.25 0 0 0 .25-.25v-.5a.25.25 0 0 0-.25-.25zm-11-4a.25.25 0 0 0-.25.25v.5c0 .138.112.25.25.25h.5A.25.25 0 0 0 3 9.75v-.5A.25.25 0 0 0 2.75 9zm0 2a.25.25 0 0 0-.25.25v.5c0 .138.112.25.25.25h.5a.25.25 0 0 0 .25-.25v-.5a.25.25 0 0 0-.25-.25zM2 13.25a.25.25 0 0 1 .25-.25h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25z"
                  />
                  <path
                    d="M5 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 1 1v4h3a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h3V3a1 1 0 0 1 1-1zm2 14h2v-3H7zm3 0h1V3H5v12h1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1zm0-14H6v1h4zm2 7v7h3V8zm-8 7V8H1v7z"
                  />
                </svg>
              </div>
              <p class="chosse-banner-text">
                Khám <br />
                Chuyên Khoa
              </p>
            </div>
          </a>
          <a href="">
            <div class="col">
              <div class="chosse-icon">
                <svg
                  class="pt-2"
                  xmlns="http://www.w3.org/2000/svg"
                  width="40"
                  height="40"
                  fill="currentColor"
                  class="bi bi-telephone-inbound"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M15.854.146a.5.5 0 0 1 0 .708L11.707 5H14.5a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 1 0v2.793L15.146.146a.5.5 0 0 1 .708 0m-12.2 1.182a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"
                  />
                </svg>
              </div>
              <p class="chosse-banner-text">
                Khám <br />
                Từ Xa
              </p>
            </div>
          </a>
          <a href="">
            <div class="col">
              <div class="chosse-icon">
                <svg
                  class="pt-2"
                  xmlns="http://www.w3.org/2000/svg"
                  width="40"
                  height="40"
                  fill="currentColor"
                  class="bi bi-journal-check"
                  viewBox="0 0 16 16"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0"
                  />
                  <path
                    d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"
                  />
                  <path
                    d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"
                  />
                </svg>
              </div>
              <p class="chosse-banner-text">Khám <br />Tổng Quát</p>
            </div>
          </a>
          <a href="">
            <div class="col">
              <div class="chosse-icon">
                <svg
                  class="pt-2"
                  xmlns="http://www.w3.org/2000/svg"
                  width="40"
                  height="40"
                  fill="currentColor"
                  class="bi bi-eyedropper"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M13.354.646a1.207 1.207 0 0 0-1.708 0L8.5 3.793l-.646-.647a.5.5 0 1 0-.708.708L8.293 5l-7.147 7.146A.5.5 0 0 0 1 12.5v1.793l-.854.853a.5.5 0 1 0 .708.707L1.707 15H3.5a.5.5 0 0 0 .354-.146L11 7.707l1.146 1.147a.5.5 0 0 0 .708-.708l-.647-.646 3.147-3.146a1.207 1.207 0 0 0 0-1.708zM2 12.707l7-7L10.293 7l-7 7H2z"
                  />
                </svg>
              </div>
              <p class="chosse-banner-text">
                Xét Nghiệm <br />
                Y Học
              </p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- End Banner -->
  <!-- Main -->
  <div class="main">
    <div class="container mt-5">
      <div class="title-chuyenkhoa">
        <h3>Chuyên Khoa Phổ Biến</h3>
        <button class="btn-xt" type="submit">Xem Thêm</button>
      </div>
      <div class="chuyenkhoa mt-4 mb-4">
        <div class="row">
            @foreach ($specialties as $item)
          <div class="col">
            <div>
              <a href="">
                <div>
                  <img
                    style="
                      width: 90%;
                      height: auto;
                      border: 2px solid lightgray;
                      border-radius: 10px;
                    "
                    src="{{ asset('upload/'.$item->image) }}"
                    alt=""
                  />
                </div>
                <p class="pt-2 pb-2">{{ $item->name }}</p>
              </a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="title-chuyenkhoa">
        <h3>Bác Sĩ Từ Xa Qua VIDEO</h3>
        <button class="btn-xt" type="submit">Xem Thêm</button>
      </div>
      <div class="chuyenkhoa mt-4 mb-4">
        <div class="row">
          <div class="col">
            <div>
              <a href="">
                <div>
                  <img
                    style="
                      width: 90%;
                      height: auto;
                      border: 2px solid lightgray;
                      border-radius: 10px;
                    "
                    src="https://cdn.bookingcare.vn/fo/w384/2024/01/04/160245-tam-ly-tu-xa.png"
                    alt=""
                  />
                </div>
                <p class="pt-2 pb-2">Tư Vấn Trị Liệu Tâm Lý Từ Xa</p>
              </a>
            </div>
          </div>
          <div class="col">
            <div>
              <a href="">
                <div>
                  <img
                    style="
                      width: 90%;
                      height: auto;
                      border: 2px solid lightgray;
                      border-radius: 10px;
                    "
                    src="https://cdn.bookingcare.vn/fo/w384/2024/01/04/103343-tam-than-tu-xa-1.png"
                    alt=""
                  />
                </div>
                <p class="pt-2 pb-2">Sức Khỏe Tâm Thần Từ Xa</p>
              </a>
            </div>
          </div>
          <div class="col">
            <div>
              <a href="">
                <div>
                  <img
                    style="
                      width: 90%;
                      height: auto;
                      border: 2px solid lightgray;
                      border-radius: 10px;
                    "
                    src="https://cdn.bookingcare.vn/fo/w384/2024/01/04/160245-da-lieu-tu--xa.png"
                    alt=""
                  />
                </div>
                <p class="pt-2 pb-2">Bác Sĩ Da Liễu Từ Xa</p>
              </a>
            </div>
          </div>
          <div class="col">
            <div>
              <a href="">
                <div>
                  <img
                    style="
                      width: 90%;
                      height: auto;
                      border: 2px solid lightgray;
                      border-radius: 10px;
                    "
                    src="https://cdn.bookingcare.vn/fo/w384/2024/01/04/160245-cxk-tu--xa.png"
                    alt=""
                  />
                </div>
                <p class="pt-2 pb-2">Bác Sĩ Cơ-Xương-Khớp Từ Xa</p>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="title-chuyenkhoa">
        <h3>Cơ Sở Y Tế Nổi Bật</h3>
        <button class="btn-xt" type="submit">Xem Thêm</button>
      </div>
      <div class="chuyenkhoa mt-4 mb-4">
        <div class="row">
          <div class="col">
            <div>
              <a href="">
                <div>
                  <img
                    style="
                      width: 90%;
                      height: 140px;
                      border: 2px solid lightgray;
                      border-radius: 10px;
                    "
                    src="https://cdn.bookingcare.vn/fo/w640/2018/06/18/083122lo-go-viet-duc.jpg"
                    alt=""
                  />
                </div>
                <p class="pt-2 pb-2">Bệnh Viện Hữu Nghị Việt Đức</p>
              </a>
            </div>
          </div>
          <div class="col">
            <div>
              <a href="">
                <div>
                  <img
                    style="
                      width: 90%;
                      height: 140px;
                      border: 2px solid lightgray;
                      border-radius: 10px;
                    "
                    src="https://cdn.bookingcare.vn/fo/w640/2019/03/11/152704logo-bvcr-moi.jpg"
                    alt=""
                  />
                </div>
                <p class="pt-2 pb-2">Bệnh Viện Chợ Rẫy</p>
              </a>
            </div>
          </div>
          <div class="col">
            <div>
              <a href="">
                <div>
                  <img
                    style="
                      width: 90%;
                      height: 140px;
                      border: 2px solid lightgray;
                      border-radius: 10px;
                    "
                    src="https://cdn.bookingcare.vn/fo/w640/2022/08/26/092249-doctor-check.jpg"
                    alt=""
                  />
                </div>
                <p class="pt-2 pb-2">
                  Doctor Check - Tầm Soát Bệnh Để<br />
                  Sống Thọ Hơn
                </p>
              </a>
            </div>
          </div>
          <div class="col">
            <div>
              <a href="">
                <div>
                  <img
                    style="
                      width: 90%;
                      height: 140px;
                      border: 2px solid lightgray;
                      border-radius: 10px;
                    "
                    src="https://cdn.bookingcare.vn/fo/w640/2022/07/14/155206-logo-y-duoc-1.jpg"
                    alt=""
                  />
                </div>
                <p class="pt-2 pb-2">
                  Phòng khám Bệnh viện <br />Đại học Y Dược 1
                </p>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="title-chuyenkhoa">
        <h3>Bác Sĩ Nổi Bật Tuần Qua</h3>
        <button class="btn-xt" type="submit">Xem Thêm</button>
      </div>
      <div class="chuyenkhoa mt-4 mb-4">
        <div class="row">
            @foreach ($doctors as $item)
            @php
            $u = $item->user;
           @endphp
          <div class="col">
            <div>
              <a href="">
                <div class="d-flex justify-content-center">
                  <img
                    style="
                      width: 150px;
                      height: 150px;
                      border-radius: 50%;
                      border: 2px solid lightgray;
                    "
                    src="{{ asset('upload/'.$u->image) }}"
                    alt=""
                  />
                </div>
                <p
                  class="pt-2"
                  style="text-align: center; margin-bottom: 0px"
                >
                  {{ $item->title }} <br />
                  {{ $u->name }}
                </p>
              </a>
              <p style="text-align: center; color: gray">{{ $item->position }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <!-- End Main -->

@endsection
