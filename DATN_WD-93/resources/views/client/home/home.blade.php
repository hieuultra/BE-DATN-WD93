@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')
<style>
    .slideshow-container11 {
      width: 100%;
      overflow: hidden;
      position: relative;
      margin-top: 30px; /* Add space between featured items and slideshow */
    }

    .slideshow-wrapper {
      display: flex;
      transition: transform 1s ease-in-out;
    }

    .slideshow-image {
      width: 100%; /* Each image will take the full width of the container */
      height: auto;
      object-fit: cover; /* Ensures images cover the container */
    }

    /* Set the width of the slideshow-wrapper to hold both images side by side */
    .slideshow-wrapper {
      width: 200%; /* Since there are 2 images, each image will occupy 50% */
    }

      /* Gradient and Shadow Effect */
      .stylish-text {
    font-size: 1.3em; /* Smaller font size */
    font-weight: bold;
    color: #ffcc00;
    background: linear-gradient(45deg, #ff6f91, #ff9671);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0.5px 0.5px 3px rgba(0, 0, 0, 0.1), 0 0 5px #ffcc00, 0 0 10px #ffcc00;
    animation: textGlow 1.5s ease-in-out infinite alternate;
  }

  /* Glow Effect */   @keyframes textGlow {
    0% {
      text-shadow: 0.5px 0.5px 3px rgba(0, 0, 0, 0.1), 0 0 5px #ffcc00, 0 0 10px #ffcc00;
    }
    100% {
      text-shadow: 0.5px 0.5px 3px rgba(0, 0, 0, 0.1), 0 0 8px #ffcc00, 0 0 15px #ffcc00;
    }
  }
  /* Optional Text Animation */
  .stylish-text {
    position: relative;
    overflow: hidden;
  }
  .stylish-text::before {
    content: 'CÁC TIỆN ÍCH';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
    -webkit-background-clip: text;
    animation: shine 2s linear infinite;
  }

  @keyframes shine {
    0% { left: -100%; }
    100% { left: 100%; }
  }
  .stylish-text-top-sellers {
    font-size: 1.3em; /* Increased font size for clarity */
    font-weight: bold;
    background: linear-gradient(45deg, #ffcc00, #ff5733); /* Gradient from yellow to orange */
    background-clip: text;
    -webkit-background-clip: text; /* For Safari compatibility */
    color: transparent; /* Make the text transparent to show the gradient */
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1), 0 0 12px #ff5733, 0 0 18px #ff5733; /* Stronger shadow effect */
    animation: textGlowTopSellers 1.5s ease-in-out infinite alternate; /* Glow effect */
  }

  /* Animation for glowing effect */
  @keyframes textGlowTopSellers {
    0% {
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1), 0 0 12px #ffcc00, 0 0 18px #ffcc00;
      opacity: 1;
    }
    50% {
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4), 0 0 20px #ff5733, 0 0 25px #ff5733;
      opacity: 1; /* Ensures text stays visible */
    }
    100% {
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.9), 0 0 12px #ffcc00, 0 0 18px #ffcc00;
      opacity: 1;
    }
  }

  .stylish-text-most-viewed {
    font-size: 1.3em; /* Font size */
    font-weight: 700; /* Increased font weight for better clarity */
    color: #FFD700; /* Gold/yellow color */
    text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3); /* Dark shadow to make the text stand out more */
    letter-spacing: 2px; /* Slight spacing between letters */
    animation: textGlowMostViewed 1.5s ease-in-out infinite alternate; /* Optional glow effect */
  }

  /* Optional Glow Effect Animation */
  @keyframes textGlowMostViewed {
    0% {
      text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3), 0 0 12px #FFD700, 0 0 18px #FFD700;
    }
    50% {
      text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.4), 0 0 18px #FFD700, 0 0 22px #FFD700;
    }
    100% {
      text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3), 0 0 12px #FFD700, 0 0 18px #FFD700;
    }
  }
  /* Stylish Text with Yellow Color and Bold Effect */
  .stylish-text-best-sellers {
    font-size: 1.3em; /* Font size */
    font-weight: 700; /* Increased font weight for better clarity */
    color: #FFD700; /* Gold/yellow color */
    text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3); /* Dark shadow to make the text stand out more */
    letter-spacing: 2px; /* Slight spacing between letters */
    animation: textGlowBestSellers 1.5s ease-in-out infinite alternate; /* Optional glow effect */
  }

  /* Optional Glow Effect Animation */
  @keyframes textGlowBestSellers {
    0% {
      text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3), 0 0 12px #FFD700, 0 0 18px #FFD700;
    }
    50% {
      text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.4), 0 0 18px #FFD700, 0 0 22px #FFD700;
    }
    100% {
      text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3), 0 0 12px #FFD700, 0 0 18px #FFD700;
    }
  }
  </style>

<!-- Carousel Start -->
<div class="container-fluid mb-3">
    <div class="row px-xl-5">
      <div class="col-lg-8">
        <div
          id="header-carousel"
          class="carousel slide carousel-fade mb-30 mb-lg-0"
          data-ride="carousel"
        >
          <ol class="carousel-indicators">
            <li
              data-target="#header-carousel"
              data-slide-to="0"
              class="active"
            ></li>
            <li data-target="#header-carousel" data-slide-to="1"></li>
            <li data-target="#header-carousel" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div
              class="carousel-item position-relative active"
              style="height: 430px"
            >
              <img
                class="position-absolute w-100 h-100"
                src="{{ asset('img/20240909015811-0-Slide banner - 1590x604px (1).webp') }}"
                style="object-fit: cover"
              />
              {{-- <div
                class="carousel-caption d-flex flex-column align-items-center justify-content-center"
              >
                <div class="p-3" style="max-width: 700px">
                   <h1
                    class="display-4 text-white mb-3 animate__animated animate__fadeInDown"
                  >
                    Men Fashion
                  </h1>
                  <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                    Lorem rebum magna amet lorem magna erat diam stet. Sadips
                    duo stet amet amet ndiam elitr ipsum diam
                  </p>
                  <a
                    class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                    href="#"
                    >Shop Now</a
                  >
                </div>
              </div> --}}
            </div>
            <div
              class="carousel-item position-relative"
              style="height: 430px"
            >
              <img
                class="position-absolute w-100 h-100"
                src="{{ asset('img/20240905071756-0-389x143_2 3.png') }}"
                style="object-fit: cover"
              />
              {{-- <div
                class="carousel-caption d-flex flex-column align-items-center justify-content-center"
              >
                <div class="p-3" style="max-width: 700px">
                  <h1
                    class="display-4 text-white mb-3 animate__animated animate__fadeInDown"
                  >
                    Women Fashion
                  </h1>
                  <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                    Lorem rebum magna amet lorem magna erat diam stet. Sadips
                    duo stet amet amet ndiam elitr ipsum diam
                  </p>
                  <a
                    class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                    href="#"
                    >Shop Now</a
                  >
                </div>
              </div> --}}
            </div>
            <div
              class="carousel-item position-relative"
              style="height: 430px"
            >
              <img
                class="position-absolute w-100 h-100"
                src="{{ asset('img/20240510022448-0-THUCUDOIMOI BANNERWEB_590x604.webp') }}"
                style="object-fit: cover"
              />
              {{-- <div
                class="carousel-caption d-flex flex-column align-items-center justify-content-center"
              >
                <div class="p-3" style="max-width: 700px">
                   <h1
                    class="display-4 text-white mb-3 animate__animated animate__fadeInDown"
                  >
                    Kids Fashion
                  </h1>
                  <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                    Lorem rebum magna amet lorem magna erat diam stet. Sadips
                    duo stet amet amet ndiam elitr ipsum diam
                  </p>
                  <a
                    class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                    href="#"
                    >Shop Now</a
                  >
                </div>
              </div> --}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="product-offer mb-30" style="height: 200px">
          <img
            class="img-fluid"
            src="{{ asset('img/20241104090355-0-Sieuqua-1590x604px.avif') }}"
            alt=""
          />
          {{-- <div class="offer-text">
            <h6 class="text-white text-uppercase">Save 20%</h6>
            <h3 class="text-white mb-3">Special Offer</h3>
            <a href="" class="btn btn-primary">Shop Now</a>
          </div> --}}
        </div>
        <div class="product-offer mb-30" style="height: 200px">
          <img
            class="img-fluid"
            src="{{ asset('img/20240731045253-0-Slide banner 1.webp') }}"
            alt=""
          />
          {{-- <div class="offer-text">
            <h6 class="text-white text-uppercase">Save 20%</h6>
            <h3 class="text-white mb-3">Special Offer</h3>
            <a href="" class="btn btn-primary">Shop Now</a>
          </div> --}}
        </div>
      </div>
    </div>
  </div>
  <!-- Carousel End -->

  <!-- Featured Start -->
  <div class="container-fluid pt-3">
    <div class="row px-xl-5 pb-3">
      <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
        <div
          class="d-flex align-items-center bg-light mb-4"
          style="padding: 30px"
        >
          <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
          <h5 class="font-weight-semi-bold m-0">Giao hàng siêu tốc</h5>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
        <div
          class="d-flex align-items-center bg-light mb-4"
          style="padding: 30px"
        >
          <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
          <h5 class="font-weight-semi-bold m-0">Miễn phí vận chuyển</h5>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
        <div
          class="d-flex align-items-center bg-light mb-4"
          style="padding: 30px"
        >
          <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
          <h5 class="font-weight-semi-bold m-0">3 ngày đổi trả</h5>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
        <div
          class="d-flex align-items-center bg-light mb-4"
          style="padding: 30px"
        >
          <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
          <h5 class="font-weight-semi-bold m-0">24/7 hỗ trợ</h5>
        </div>
      </div>

      <div class="slideshow-container11">
        <div class="slideshow-wrapper">
          <img src="{{ asset('img/53ea83e5e8786bfd65824c9d0e73d011.png') }}" class="slideshow-image" alt="Image 1" />
          <img src="{{ asset('img/21481b827dcf2d53dd6827cdc4cf7ab4.png') }}" class="slideshow-image" alt="Image 2" />
        </div>
      </div>

    </div>
  </div>
  <!-- Featured End -->

  <!-- Categories Start -->
  <div class="container-fluid pt-1">
    <!-- Title -->
    <div class="text-center mb-4">
      <h2 class="section-title px-5">
        <span class="px-2 stylish-text">CÁC TIỆN ÍCH</span>
      </h2>
    </div>
    <div class="row px-xl-5 pb-3">
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <a class="text-decoration-none" href="">
          <div class="cat-item d-flex align-items-center mb-4">
            <div class="overflow-hidden" style="width: 100px; height: 100px">
              <img
                class="img-fluid"
                src="{{ asset('img/20240825092057-0-6.png') }}"
                alt=""
              />
            </div>
            <div class="flex-fill pl-3">
              <h6>Drug consultation</h6>
              <!-- <small class="text-body">100 Products</small> -->
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <a class="text-decoration-none" href="{{ route('appoinment.index') }}">
          <div class="cat-item img-zoom d-flex align-items-center mb-4">
            <div class="overflow-hidden" style="width: 100px; height: 100px">
              <img class="img-fluid" src="{{ asset('img/Booking.webp') }}" alt="" />
            </div>
            <div class="flex-fill pl-3">
              <h6>Make an appointment</h6>
              <!-- <small class="text-body">100 Products</small> -->
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <a class="text-decoration-none" href="">
          <div class="cat-item img-zoom d-flex align-items-center mb-4">
            <div class="overflow-hidden" style="width: 100px; height: 100px">
              <img
                class="img-fluid"
                src="{{ asset('img/20240326143426-0-Booking.webp') }}"
                alt=""
              />
            </div>
            <div class="flex-fill pl-3">
              <h6>Prescription medication</h6>
              <!-- <small class="text-body">100 Products</small> -->
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <a class="text-decoration-none" href="">
          <div class="cat-item img-zoom d-flex align-items-center mb-4">
            <div class="overflow-hidden" style="width: 100px; height: 100px">
              <img
                class="img-fluid"
                src="{{ asset('img/20240717085927-0-Dealhot.webp') }}"
                alt=""
              />
            </div>
            <div class="flex-fill pl-3">
              <h6>Contact pharmacist</h6>
              <!-- <small class="text-body">100 Products</small> -->
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <a class="text-decoration-none" href="">
          <div class="cat-item img-zoom d-flex align-items-center mb-4">
            <div class="overflow-hidden" style="width: 100px; height: 100px">
              <img
                class="img-fluid"
                src="{{ asset('img/20240825092125-0-2.webp') }}"
                alt=""
              />
            </div>
            <div class="flex-fill pl-3">
              <h6>Health spending</h6>
              <!-- <small class="text-body">100 Products</small> -->
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <a class="text-decoration-none" href="">
          <div class="cat-item img-zoom d-flex align-items-center mb-4">
            <div class="overflow-hidden" style="width: 100px; height: 100px">
              <img
                class="img-fluid"
                src="{{ asset('img/20240823122418-0-Booking.png') }}"
                alt=""
              />
            </div>
            <div class="flex-fill pl-3">
              <h6>Hot deal October</h6>
              <!-- <small class="text-body">100 Products</small> -->
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <a class="text-decoration-none" href="">
          <div class="cat-item img-zoom d-flex align-items-center mb-4">
            <div class="overflow-hidden" style="width: 100px; height: 100px">
              <img
                class="img-fluid"
                src="{{ asset('img/20240326143321-0-Booking-4.webp') }}"
                alt=""
              />
            </div>
            <div class="flex-fill pl-3">
              <h6>Gold P-Xu History</h6>
              <!-- <small class="text-body">100 Products</small> -->
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <a class="text-decoration-none" href="">
          <div class="cat-item img-zoom d-flex align-items-center mb-4">
            <div class="overflow-hidden" style="width: 100px; height: 100px">
              <img
                class="img-fluid"
                src="{{ asset('img/20240829020158-0-BenhSoi.webp') }}"
                alt=""
              />
            </div>
            <div class="flex-fill pl-3">
              <h6>Measles</h6>
              <!-- <small class="text-body">100 Products</small> -->
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <a class="text-decoration-none" href="">
          <div class="cat-item img-zoom d-flex align-items-center mb-4">
            <div class="overflow-hidden" style="width: 100px; height: 100px">
              <img
                class="img-fluid"
                src="{{ asset('img/20240917161106-0-HealthCheckup.png') }}"
                alt=""
              />
            </div>
            <div class="flex-fill pl-3">
              <h6>Health profile</h6>
              <!-- <small class="text-body">100 Products</small> -->
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <a class="text-decoration-none" href="">
          <div class="cat-item img-zoom d-flex align-items-center mb-4">
            <div class="overflow-hidden" style="width: 100px; height: 100px">
              <img
                class="img-fluid"
                src="{{ asset('img/20240912062123-0-PeriodicHealthCheck.webp') }}"
                alt=""
              />
            </div>
            <div class="flex-fill pl-3">
              <h6>Health Check</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <a class="text-decoration-none" href="">
          <div class="cat-item img-zoom d-flex align-items-center mb-4">
            <div class="overflow-hidden" style="width: 100px; height: 100px">
              <img
                class="img-fluid"
                src="{{ asset('img/20240327032301-0-Booking (16).webp') }}"
                alt=""
              />
            </div>
            <div class="flex-fill pl-3">
              <h6>Exclusive discount code</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <a class="text-decoration-none" href="">
          <div class="cat-item img-zoom d-flex align-items-center mb-4">
            <div class="overflow-hidden" style="width: 100px; height: 100px">
              <img
                class="img-fluid"
                src="{{ asset('img/20240326143307-0-Booking-6.webp') }}"
                alt=""
              />
            </div>
            <div class="flex-fill pl-3">
              <h6>Business</h6>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
  <!-- Categories End -->

  <!-- Search & sort -->
  <div class="row px-xl-5 pb-3">
    <!-- Search & sort -->
    <div class="col-12 pb-1">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <!-- Search -->
        <form action="{{ route('products.search') }}" method="GET">
          <div class="input-group">
            <input
              type="text"
              class="form-control"
              name="query"
              placeholder="Tìm kiếm sản phẩm" name="kyw"
            />
            <div class="input-group-append">
              <span class="input-group-text bg-transparent text-primary">
                <!-- <i class="fa fa-search"></i> -->
                <input type="submit" class="btn btn-primary" value="Tìm" />
              </span>
            </div>
          </div>
        </form>
        <!-- Sort -->
        <div class="dropdown ml-4">
          <button
            class="btn border dropdown-toggle"
            type="button"
            id="triggerId"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            Sort by
          </button>
          <div
            class="dropdown-menu dropdown-menu-right"
            aria-labelledby="triggerId"
          >
            <a class="dropdown-item" href="#">Latest</a>
            <a class="dropdown-item" href="#">Popularity</a>
            <a class="dropdown-item" href="#">Best Rating</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Products Start -->
  <div class="container-fluid pt-5 pb-3 hieu">
    <!-- Title -->
    <div class="text-center mb-4">
      <h2 class="section-title px-5">
        <span class="px-2 stylish-text-top-sellers">SẢN PHẨM BÁN CHẠY TOÀN QUỐC</span>
      </h2>
    </div>

    <div id="productCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="row px-xl-5">
              <!-- Product list for the first slide -->
              @foreach ($newProducts as $item)
              @php $tt = $item['price'] - (($item['price']  * $item['discount']) / 100); @endphp
              <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                  <div class="product-img position-relative overflow-hidden">
                    <img class="img-fluid w-100" src="{{ asset('upload/'.$item->img) }}" alt="" />
                    <div class="product-action">
                      <a class="btn btn-outline-dark btn-square" href="{{ route('cart.listCart') }}"><i class="fa fa-shopping-cart"></i></a>
                      <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                      <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                      <a class="btn btn-outline-dark btn-square" href="{{ route('productDetail', $item->id) }}"><i class="fa fa-search"></i></a>
                    </div>
                  </div>
                  <div class="text-center py-4">
                    <a class="h6 text-decoration-none text-truncate" href="{{ route('productDetail', $item->id) }}"
                        style="max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" >{{ $item->name }}</a>
                    <div class="d-flex align-items-center justify-content-center mt-2">
                      <h5 class="text-danger">{{ number_format($tt, 0, ",", ".") }} $</h5>
                      <h6 class="text-muted ml-2"><del>{{ number_format($item->price, 0, ',', '.') }} $</del></h6>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light">
                        <a href="{{ route('productDetail', $item->id) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                        <form action="{{ route('cart.addCart') }}" method="post">
                            @csrf
                                <input type="hidden" name="quantity" value="1">
                               <input type="hidden" name="productId" value="{{ $item->id }}">
                            <input type="submit" value="Thêm vào giỏ" class="btn btn-sm text-dark p-0" name="addtocart"><i class="fas fa-shopping-cart text-primary mr-1"></i>
                        </form>
                      </div>
                    <div class="d-flex align-items-center justify-content-center mb-1">
                        @php
                        $averageRating = round($item->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
                        $reviewCount = $item->review_count ?? 0; // mặc định 0 nếu không có
                    @endphp

                    @for ($i = 1; $i <= 5; $i++)
                        <small class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
                    @endfor

                    <small>({{ $reviewCount }})</small>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          <!-- Thêm một carousel-item mới cho các sản phẩm khác -->
          <div class="carousel-item">
            <div class="row px-xl-5">
              @foreach ($newProducts1 as $item)
              @php $tt = $item['price'] - (($item['price']  * $item['discount']) / 100); @endphp
              <!-- Product 5 -->
              <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                  <div class="product-img position-relative overflow-hidden">
                    <img class="img-fluid w-100" src="{{ asset('upload/'.$item->img) }}" alt="" />
                    <div class="product-action">
                      <a class="btn btn-outline-dark btn-square" href="{{ route('cart.listCart') }}"><i class="fa fa-shopping-cart"></i></a>
                      <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                      <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                      <a class="btn btn-outline-dark btn-square" href="{{ route('productDetail', $item->id) }}"><i class="fa fa-search"></i></a>
                    </div>
                  </div>
                  <div class="text-center py-4">
                    <a class="h6 text-decoration-none text-truncate" href="{{ route('productDetail', $item->id) }}"
                        style="max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $item->name }}</a>
                    <div class="d-flex align-items-center justify-content-center mt-2">
                      <h5 class="text-danger">{{ number_format($tt, 0, ",", ".") }} $</h5>
                      <h6 class="text-muted ml-2"><del>{{ number_format($item->price, 0, ',', '.') }} $</del></h6>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light">
                        <a href="{{ route('productDetail', $item->id) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                        <form action="{{ route('cart.addCart') }}" method="post">
                            @csrf
                                <input type="hidden" name="quantity" value="1">
                               <input type="hidden" name="productId" value="{{ $item->id }}">
                            <input type="submit" value="Thêm vào giỏ" class="btn btn-sm text-dark p-0" name="addtocart"><i class="fas fa-shopping-cart text-primary mr-1"></i>
                        </form>
                      </div>
                    <div class="d-flex align-items-center justify-content-center mb-1">
                        @php
                        $averageRating = round($item->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
                        $reviewCount = $item->review_count ?? 0; // mặc định 0 nếu không có
                    @endphp

                    @for ($i = 1; $i <= 5; $i++)
                        <small class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
                    @endfor

                    <small>({{ $reviewCount }})</small>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

      <!-- Các nút điều hướng -->
      <a
        class="carousel-control-prev custom-control"
        href="#productCarousel"
        role="button"
        data-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a
        class="carousel-control-next custom-control"
        href="#productCarousel"
        role="button"
        data-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>


  <!-- Products End -->

  <!-- Offer Start -->
  <div class="container-fluid pt-5 pb-3">
    <div class="row px-xl-5">
      <div class="col-md-6">
        <div class="product-offer mb-30" style="height: 300px">
          <img
            class="img-fluid"
            src="{{ asset('img/20240910063535-0-Slide bannerpayday924-1590x604px.webp') }}"
            alt=""
          />
          <div class="offer-text">
            <h6 class="text-white text-uppercase">Save 20%</h6>
            <h3 class="text-white mb-3">Special Offer</h3>
            <a href="" class="btn btn-primary">Shop Now</a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="product-offer mb-30" style="height: 300px">
          <img
            class="img-fluid"
            src="{{ asset('img/20240918020343-0-Web Listerine287x232.webp') }}"
            alt=""
          />
          <div class="offer-text">
            <h6 class="text-white text-uppercase">Save 20%</h6>
            <h3 class="text-white mb-3">Special Offer</h3>
            <a href="" class="btn btn-primary">Shop Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Offer End -->

  <!-- Products Start -->
  <div class="container-fluid pt-5 pb-3">
     <!-- Title -->
     <div class="text-center mb-4">
      <h2 class="section-title px-5 text-uppercase mx-xl-5 mb-4">
        <span class="px-2 stylish-text-most-viewed">LƯỢT XEM NHIỀU</span>
      </h2>
    </div>
    <div class="row px-xl-5">
        @foreach ($mostViewedProducts as $item)
        @php $tt = $item['price'] - (($item['price']  * $item['discount']) / 100); @endphp
        <!-- Product 5 -->
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <div class="product-item bg-light mb-4">
          <div class="product-img position-relative overflow-hidden">
            <img
              class="img-fluid w-100"
              src="{{ asset('upload/'.$item->img) }}"
              alt=""
            />
            <div class="product-action">
              <a class="btn btn-outline-dark btn-square" href="{{ route('cart.listCart') }}"
                ><i class="fa fa-shopping-cart"></i
              ></a>
              <a class="btn btn-outline-dark btn-square" href=""
                ><i class="far fa-heart"></i
              ></a>
              <a class="btn btn-outline-dark btn-square" href=""
                ><i class="fa fa-sync-alt"></i
              ></a>
              <a class="btn btn-outline-dark btn-square" href="{{ route('productDetail', $item->id) }}"
                ><i class="fa fa-search"></i
              ></a>
            </div>
          </div>
          <div class="text-center py-4">
            <a class="h6 text-decoration-none text-truncate" href="{{ route('productDetail', $item->id) }}" style="max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
              > {{ $item->name }}</a
            >
            <div
              class="d-flex align-items-center justify-content-center mt-2"
            >
              <h5 class="text-danger">{{ number_format($tt, 0, ",", ".") }} $</h5>
              <h6 class="text-muted ml-2"><del>{{ number_format($item->price, 0, ',', '.') }} $</del></h6>
            </div>
            <div class="card-footer d-flex justify-content-between bg-light">
                <a href="{{ route('productDetail', $item->id) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                <form action="{{ route('cart.addCart') }}" method="post">
                    @csrf
                        <input type="hidden" name="quantity" value="1">
                       <input type="hidden" name="productId" value="{{ $item->id }}">
                    <input type="submit" value="Thêm vào giỏ" class="btn btn-sm text-dark p-0" name="addtocart"><i class="fas fa-shopping-cart text-primary mr-1"></i>
                </form>
              </div>
            <div
              class="d-flex align-items-center justify-content-center mb-1"
            >
            @php
            $averageRating = round($item->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
            $reviewCount = $item->review_count ?? 0; // mặc định 0 nếu không có
        @endphp

        @for ($i = 1; $i <= 5; $i++)
            <small class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
        @endfor

        <small>({{ $reviewCount }})</small>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <!-- Products End -->

  <!-- Vendor Start -->
  <div class="container-fluid py-5">
      <!-- Title -->
      <div class="text-center mb-4">
        <h2 class="section-title px-5 text-uppercase mx-xl-5 mb-4">
            <span class="px-2 stylish-text-best-sellers">SẢN PHẨM kHUYẾN MÃI</span>
        </h2>
      </div>
      <div class="row px-xl-5">
        @foreach ($highestDiscountProducts as $item)
        @php $tt = $item['price'] - (($item['price']  * $item['discount']) / 100); @endphp
        <!-- Product 5 -->
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <div class="product-item bg-light mb-4">
          <div class="product-img position-relative overflow-hidden">
            <img
              class="img-fluid w-100"
              src="{{ asset('upload/'.$item->img) }}"
              alt=""
            />
            <div class="product-action">
              <a class="btn btn-outline-dark btn-square" href="{{ route('cart.listCart') }}"
                ><i class="fa fa-shopping-cart"></i
              ></a>
              <a class="btn btn-outline-dark btn-square" href=""
                ><i class="far fa-heart"></i
              ></a>
              <a class="btn btn-outline-dark btn-square" href=""
                ><i class="fa fa-sync-alt"></i
              ></a>
              <a class="btn btn-outline-dark btn-square" href="{{ route('productDetail', $item->id) }}"
                ><i class="fa fa-search"></i
              ></a>
            </div>
          </div>
          <div class="text-center py-4">
            <a class="h6 text-decoration-none text-truncate" href="{{ route('productDetail', $item->id) }}" style="max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
              > {{ $item->name }}</a
            >
            <div
              class="d-flex align-items-center justify-content-center mt-2"
            >
              <h5 class="text-danger">{{ number_format($tt, 0, ",", ".") }} $</h5>
              <h6 class="text-muted ml-2"><del>{{ number_format($item->price, 0, ',', '.') }} $</del></h6>
            </div>
            <div class="card-footer d-flex justify-content-between bg-light">
                <a href="{{ route('productDetail', $item->id) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                <form action="{{ route('cart.addCart') }}" method="post">
                    @csrf
                        <input type="hidden" name="quantity" value="1">
                       <input type="hidden" name="productId" value="{{ $item->id }}">
                    <input type="submit" value="Thêm vào giỏ" class="btn btn-sm text-dark p-0" name="addtocart"><i class="fas fa-shopping-cart text-primary mr-1"></i>
                </form>
              </div>
            <div
              class="d-flex align-items-center justify-content-center mb-1"
            >
            @php
            $averageRating = round($item->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
            $reviewCount = $item->review_count ?? 0; // mặc định 0 nếu không có
        @endphp

        @for ($i = 1; $i <= 5; $i++)
            <small class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
        @endfor

        <small>({{ $reviewCount }})</small>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <!-- Vendor End -->
<script>
  let currentIndex = 0;
  const slides = document.querySelectorAll('.slideshow-image');
  const slideshowWrapper = document.querySelector('.slideshow-wrapper');
  const totalSlides = slides.length;

  function autoSlide() {
    currentIndex = (currentIndex + 1) % totalSlides; // Loop back to the first image when reaching the end
    slideshowWrapper.style.transform = `translateX(-${currentIndex * 50}%)`; // Move the slideshow
  }

  setInterval(autoSlide, 3000); // Change image every 3 seconds
</script>
@endsection
