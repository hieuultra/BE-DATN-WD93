@extends('layout')
@section('titlepage', 'Instinct - Instinct Pharmacy System')
@section('title', 'Welcome')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .slideshow-container11 {
            width: 100%;
            overflow: hidden;
            position: relative;
            margin-top: 30px;
            /* Add space between featured items and slideshow */
        }

        .slideshow-wrapper {
            display: flex;
            transition: transform 1s ease-in-out;
        }

        .slideshow-image {
            width: 100%;
            /* Each image will take the full width of the container */
            height: auto;
            object-fit: cover;
            /* Ensures images cover the container */
        }

        /* Set the width of the slideshow-wrapper to hold both images side by side */
        .slideshow-wrapper {
            width: 200%;
            /* Since there are 2 images, each image will occupy 50% */
        }

        /* Gradient and Shadow Effect */
        .stylish-text {
            font-size: 1.3em;
            /* Smaller font size */
            font-weight: bold;
            color: #ffcc00;
            background: linear-gradient(45deg, #ff6f91, #ff9671);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0.5px 0.5px 3px rgba(0, 0, 0, 0.1), 0 0 5px #ffcc00, 0 0 10px #ffcc00;
            animation: textGlow 1.5s ease-in-out infinite alternate;
        }

        /* Glow Effect */
        @keyframes textGlow {
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
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .stylish-text-top-sellers {
            font-size: 1.3em;
            /* Increased font size for clarity */
            font-weight: bold;
            background: linear-gradient(45deg, #ffcc00, #ff5733);
            /* Gradient from yellow to orange */
            background-clip: text;
            -webkit-background-clip: text;
            /* For Safari compatibility */
            color: transparent;
            /* Make the text transparent to show the gradient */
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1), 0 0 12px #ff5733, 0 0 18px #ff5733;
            /* Stronger shadow effect */
            animation: textGlowTopSellers 1.5s ease-in-out infinite alternate;
            /* Glow effect */
        }

        /* Animation for glowing effect */
        @keyframes textGlowTopSellers {
            0% {
                text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1), 0 0 12px #ffcc00, 0 0 18px #ffcc00;
                opacity: 1;
            }

            50% {
                text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4), 0 0 20px #ff5733, 0 0 25px #ff5733;
                opacity: 1;
                /* Ensures text stays visible */
            }

            100% {
                text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.9), 0 0 12px #ffcc00, 0 0 18px #ffcc00;
                opacity: 1;
            }
        }

        .stylish-text-most-viewed {
            font-size: 1.3em;
            /* Font size */
            font-weight: 700;
            /* Increased font weight for better clarity */
            color: #FFD700;
            /* Gold/yellow color */
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
            /* Dark shadow to make the text stand out more */
            letter-spacing: 2px;
            /* Slight spacing between letters */
            animation: textGlowMostViewed 1.5s ease-in-out infinite alternate;
            /* Optional glow effect */
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
            font-size: 1.3em;
            /* Font size */
            font-weight: 700;
            /* Increased font weight for better clarity */
            color: #FFD700;
            /* Gold/yellow color */
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
            /* Dark shadow to make the text stand out more */
            letter-spacing: 2px;
            /* Slight spacing between letters */
            animation: textGlowBestSellers 1.5s ease-in-out infinite alternate;
            /* Optional glow effect */
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

        .discount {
            background-color: #ffe6e6;
            /* Nền màu nhạt để làm nổi bật */
            border-radius: 5px;
            /* Bo góc mềm mại */
            padding: 5px 10px;
            /* Khoảng cách trong */
            font-size: 1.2rem;
            /* Kích thước chữ vừa đủ */
            font-weight: bold;
            /* Chữ đậm */
        }

        #popup {
            display: none;
            /* Initially hidden */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            z-index: 1000;
            width: 700px;
            height: auto;
        }

        /* Background overlay */
        #overlay {
            display: none;
            /* Initially hidden */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .increase {
            width: 50px;
            height: 40px;
            border: 2px solid gray;
            border-radius: 5px;
        }

        .reduce {
            width: 50px;
            height: 40px;
            border: 2px solid gray;
            border-radius: 5px;
        }

        .quantityAdd {
            width: 40px;
            height: 40px;
            text-align: center
        }

        .addToCart {
            border: 1px solid aqua;
            background-color: aqua;
            border-radius: 5px;
            width: 100%;
            height: 40px;
            font-weight: bold;
            color: black;
        }

        .option:focus {
            border: 2px solid gray;
        }

/* Card Style */
.blog-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.blog-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.blog-card img {
  border-bottom: 1px solid #ddd;
  transition: opacity 0.3s ease;
}

.blog-card img:hover {
  opacity: 0.85;
}

.blog-card h5 {
  font-size: 1.25rem;
  color: #333;
  font-weight: bold;
}

.blog-card p {
  font-size: 0.9rem;
  color: #777;
}

.blog-card .d-flex {
  font-size: 0.8rem;
}

.blog-card .fa {
  color: #888;
}

/* Optional: Add a background hover effect */
.blog-card:hover {
  background-color: #f8f9fa;
}
    </style>
<script>

</script>
    <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#header-carousel" data-slide-to="1"></li>
                        <li data-target="#header-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px">
                            <img class="position-absolute w-100 h-100"
                                src="{{ asset('img/b18.png') }}"
                                style="object-fit: cover" />
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
                        <div class="carousel-item position-relative" style="height: 430px">
                            <img class="position-absolute w-100 h-100"
                                src="{{ asset('img/slidepc4.jpg') }}" style="object-fit: cover" />
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
                        <div class="carousel-item position-relative" style="height: 430px">
                            <img class="position-absolute w-100 h-100"
                                src="{{ asset('img/1610x492_banner_PC_6cce2d4c65.webp') }}"
                                style="object-fit: cover" />
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
                    <img class="img-fluid" src="{{ asset('img/3DrMNgGFb8o9ofWTS27HK7UXD7TA7FW2Wa692CMN.webp') }}"
                        alt="" />
                    {{-- <div class="offer-text">
            <h6 class="text-white text-uppercase">Save 20%</h6>
            <h3 class="text-white mb-3">Special Offer</h3>
            <a href="" class="btn btn-primary">Shop Now</a>
          </div> --}}
                </div>
                <div class="product-offer mb-30" style="height: 200px">
                    <img class="img-fluid" src="{{ asset('img/slidepc1.jpg') }}" alt="" />
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
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Giao hàng siêu tốc</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Miễn phí vận chuyển</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">3 ngày đổi trả</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 hỗ trợ</h5>
                </div>
            </div>

            <div class="slideshow-container11">
                <div class="slideshow-wrapper">
                    <img src="{{ asset('img/53ea83e5e8786bfd65824c9d0e73d011.png') }}" class="slideshow-image"
                        alt="Image 1" />
                    <img src="{{ asset('img/21481b827dcf2d53dd6827cdc4cf7ab4.png') }}" class="slideshow-image"
                        alt="Image 2" />
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
                            <img class="img-fluid" src="{{ asset('img/20240825092057-0-6.png') }}" alt="" />
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Tư vấn thuốc</h6>
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
                            <h6>Đặt lịch khám</h6>
                            <!-- <small class="text-body">100 Products</small> -->
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="cat-item img-zoom d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px">
                            <img class="img-fluid" src="{{ asset('img/20240326143426-0-Booking.webp') }}"
                                alt="" />
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Thuốc theo toa</h6>
                            <!-- <small class="text-body">100 Products</small> -->
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="cat-item img-zoom d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px">
                            <img class="img-fluid" src="{{ asset('img/20240717085927-0-Dealhot.webp') }}"
                                alt="" />
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Liên hệ dược sĩ</h6>
                            <!-- <small class="text-body">100 Products</small> -->
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="cat-item img-zoom d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px">
                            <img class="img-fluid" src="{{ asset('img/20240825092125-0-2.webp') }}" alt="" />
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Chi tiêu cho sức khỏe</h6>
                            <!-- <small class="text-body">100 Products</small> -->
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="cat-item img-zoom d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px">
                            <img class="img-fluid" src="{{ asset('img/20240823122418-0-Booking.png') }}"
                                alt="" />
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Khuyến mại hấp dẫn tháng 12</h6>
                            <!-- <small class="text-body">100 Products</small> -->
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="cat-item img-zoom d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px">
                            <img class="img-fluid" src="{{ asset('img/20240326143321-0-Booking-4.webp') }}"
                                alt="" />
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Lịch sử P-Xu Vàng</h6>
                            <!-- <small class="text-body">100 Products</small> -->
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="cat-item img-zoom d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px">
                            <img class="img-fluid" src="{{ asset('img/20240829020158-0-BenhSoi.webp') }}"
                                alt="" />
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Các bệnh phổ biến</h6>
                            <!-- <small class="text-body">100 Products</small> -->
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="cat-item img-zoom d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px">
                            <img class="img-fluid" src="{{ asset('img/20240917161106-0-HealthCheckup.png') }}"
                                alt="" />
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Hồ sơ sức khỏe</h6>
                            <!-- <small class="text-body">100 Products</small> -->
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="cat-item img-zoom d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px">
                            <img class="img-fluid" src="{{ asset('img/20240912062123-0-PeriodicHealthCheck.webp') }}"
                                alt="" />
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Kiểm tra sức khỏe</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="cat-item img-zoom d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px">
                            <img class="img-fluid" src="{{ asset('img/20240327032301-0-Booking (16).webp') }}"
                                alt="" />
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Lấy mã giảm giá</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="cat-item img-zoom d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px">
                            <img class="img-fluid" src="{{ asset('img/20240326143307-0-Booking-6.webp') }}"
                                alt="" />
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>Doanh nghiệp</h6>
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
                        <input type="text" class="form-control" name="query" placeholder="Tìm kiếm sản phẩm"
                            name="kyw" />
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
                    <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Sort by
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
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
                    {{-- <div class="flash-sale">
                        <h2 class="text-center text-danger">🔥 Flash Sale - Hôm Nay 🔥</h2> --}}
                    <div class="row px-xl-5">
                        <!-- Product list for the first slide -->
                        @foreach ($newProducts as $item)
                            @php
                             $variant = $item->variantProduct->first();
                             if ($variant) {
                                    // Nếu biến thể tồn tại, tính toán giá trị
                                    $tt = $variant->price - (($variant->price * $item['discount']) / 100);
                                } else {
                                    // Nếu không có biến thể, đặt giá trị mặc định
                                    $tt = null;
                                }
                            @endphp
                            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="{{ asset('upload/' . $item->img) }}"
                                            alt="" />
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square"
                                                href="{{ route('cart.listCart') }}"><i
                                                    class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i
                                                    class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i
                                                    class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square"
                                                href="{{ route('productDetail', $item->id) }}"><i
                                                    class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="{{ route('productDetail', $item->id) }}"
                                            style="max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item->name }}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            @if ($tt !== null)
                                            <h6 class="text-danger">{{ number_format($tt, 0, ',', '.') }} VND</h6>
                                            @else
                                                <h6 class="text-danger">Giá: Chưa thêm giá</h6>
                                            @endif
                                            <h6 class="text-muted ml-2">
                                                @if ($item->variantProduct->isNotEmpty())
                                                            @php
                                                                $variant = $item->variantProduct->first(); // Lấy biến thể đầu tiên
                                                            @endphp
                                                            <del>Giá: {{ number_format($variant->price, 0, ',', '.') }} VND</del>
                                                        @else
                                                            <del>Giá: Chưa có biến thể</del>
                                                        @endif
                                                    </h6>
                                            <p class="discount text-danger mb-0">-{{ $item->discount ?? 0 }}%</p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between bg-light">
                                            <a href="{{ route('productDetail', $item->id) }}"
                                                class="btn btn-sm text-dark p-0"><i
                                                    class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                                            <form action="" method="post">
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="productId" value="{{ $item->id }}">
                                                <input type="button" value="Thêm vào giỏ" data-id="{{ $item->id }}"
                                                    class="btn btn-sm text-dark p-0 addToCartShow"><i
                                                    class="fas fa-shopping-cart text-primary mr-1 "></i>
                                            </form>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            @php
                                                $averageRating = round($item->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
                                                $reviewCount = $item->review_count ?? 0; // mặc định 0 nếu không có
                                            @endphp

                                            @for ($i = 1; $i <= 5; $i++)
                                                <small
                                                    class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
                                            @endfor

                                            <small>({{ $reviewCount }})</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- </div> --}}
                </div>

                <!-- Thêm một carousel-item mới cho các sản phẩm khác -->
                <div class="carousel-item">
                    <div class="row px-xl-5">
                        @foreach ($newProducts1 as $item)
                            @php $variant = $item->variantProduct->first();
                              $tt = $variant->price - (($variant->price  * $item['discount']) / 100); @endphp
                            <!-- Product 5 -->
                            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="{{ asset('upload/' . $item->img) }}"
                                            alt="" />
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square"
                                                href="{{ route('cart.listCart') }}"><i
                                                    class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i
                                                    class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i
                                                    class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square"
                                                href="{{ route('productDetail', $item->id) }}"><i
                                                    class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="{{ route('productDetail', $item->id) }}"
                                            style="max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $item->name }}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h6 class="text-danger">{{ number_format($tt, 0, ',', '.') }} VND</h6>
                                            <h6 class="text-muted ml-2">
                                                @if ($item->variantProduct->isNotEmpty())
                                                            @php
                                                                $variant = $item->variantProduct->first(); // Lấy biến thể đầu tiên
                                                            @endphp
                                                            <del>Giá: {{ number_format($variant->price, 0, ',', '.') }} VND</del>
                                                        @else
                                                            <del>Giá: Không có thông tin</del>
                                                        @endif
                                                    </h6>
                                            <p class="discount text-danger mb-0">-{{ $item->discount ?? 0 }}%</p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between bg-light">
                                            <a href="{{ route('productDetail', $item->id) }}"
                                                class="btn btn-sm text-dark p-0"><i
                                                    class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                                            <form action="{{ route('cart.addCart') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="productId" value="{{ $item->id }}">
                                                <input type="button" value="Thêm vào giỏ"
                                                    class="btn btn-sm text-dark p-0 addToCartShow"
                                                    data-id="{{ $item->id }}"><i
                                                    class="fas fa-shopping-cart text-primary mr-1"></i>
                                            </form>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            @php
                                                $averageRating = round($item->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
                                                $reviewCount = $item->review_count ?? 0; // mặc định 0 nếu không có
                                            @endphp

                                            @for ($i = 1; $i <= 5; $i++)
                                                <small
                                                    class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
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
            <a class="carousel-control-prev custom-control" href="#productCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next custom-control" href="#productCarousel" role="button" data-slide="next">
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
                    <img class="img-fluid"
                        src="{{ asset('img/k1.jpg') }}" alt="" />
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Bạn cần khám sức khỏe</h6>
                        <h3 class="text-white mb-3">Nhanh và chính xác</h3>
                        <a href="{{ route('appoinment.index') }}" class="btn btn-primary">Đặt ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px">
                    <img class="img-fluid" src="{{ asset('img/Frame 3467714-3.webp') }}"
                        alt="" />
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Khuyến mãi lên đến 30%</h6>
                        <h3 class="text-white mb-3">Khuyến mại đặc biệt</h3>
                        <a href="{{ route('products') }}" class="btn btn-primary">Mua ngay</a>
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
                <span class="px-2 stylish-text-most-viewed"> 🔥LƯỢT XEM NHIỀU🔥</span>
            </h2>
        </div>
        <div class="row px-xl-5">
            @foreach ($mostViewedProducts as $item)
                @php $variant = $item->variantProduct->first();
                              $tt = $variant->price - (($variant->price  * $item['discount']) / 100);
                               @endphp
                <!-- Product 5 -->
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('upload/' . $item->img) }}" alt="" />
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="{{ route('cart.listCart') }}"><i
                                        class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square"
                                    href="{{ route('productDetail', $item->id) }}"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate"
                                href="{{ route('productDetail', $item->id) }}"
                                style="max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $item->name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h6 class="text-danger">{{ number_format($tt, 0, ',', '.') }} VND</h6>
                                <h6 class="text-muted ml-2"> @if ($item->variantProduct->isNotEmpty())
                                    @php
                                        $variant = $item->variantProduct->first(); // Lấy biến thể đầu tiên
                                    @endphp
                                    <del>Giá: {{ number_format($variant->price, 0, ',', '.') }} VND</del>
                                @else
                                    <del>Giá: Chưa có biến thể</del>
                                @endif
                                </h6>
                                <p class="discount text-danger mb-0">-{{ $item->discount ?? 0 }}%</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light">
                                <a href="{{ route('productDetail', $item->id) }}" class="btn btn-sm text-dark p-0"><i
                                        class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                                <form action="" method="post">

                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="productId" value="{{ $item->id }}">
                                    <input type="button" data-id=" {{ $item->id }} " value="Thêm vào giỏ"
                                        class="btn btn-sm text-dark p-0 addToCartShow"><i
                                        class="fas fa-shopping-cart text-primary mr-1"></i>
                                </form>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                @php
                                    $averageRating = round($item->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
                                    $reviewCount = $item->review_count ?? 0; // mặc định 0 nếu không có
                                @endphp

                                @for ($i = 1; $i <= 5; $i++)
                                    <small
                                        class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
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
    <div class="text-center mb-1">
      <h2 class="section-title px-5 text-uppercase mx-xl-5 mb-4">
        <span class="px-2 stylish-text">Thương hiệu</span>
      </h2>
    </div>
  <div class="row px-xl-5">
    <div class="col">
      <div class="owl-carousel vendor-carousel">
        @foreach($brands as $brand)
        <div class="bg-light p-4">
          <a href="{{ route('productsByBrandId', ['brand_id' => $brand->id]) }}"><img src="{{ Storage::url($brand->image) }} " alt="" /></a>
          <span class="d-block text-center mt-2 fw-bold">{{ $brand->products_count }} sản phẩm</span>
        </div>
       @endforeach
      </div>
    </div>
  </div>
</div>
<!-- Vendor End -->

    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <!-- Title -->
        <div class="text-center mb-4">
            <h2 class="section-title px-5 text-uppercase mx-xl-5 mb-4">
                <span class="px-2 stylish-text-best-sellers">🔥SẢN PHẨM KHUYẾN MÃI🔥</span>
            </h2>
        </div>
        <div class="row px-xl-5">
            @foreach ($highestDiscountProducts as $item)
                @php $variant = $item->variantProduct->first();
                              $tt = $variant->price - (($variant->price  * $item['discount']) / 100); @endphp
                <!-- Product 5 -->
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('upload/' . $item->img) }}" alt="" />
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="{{ route('cart.listCart') }}"><i
                                        class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square"
                                    href="{{ route('productDetail', $item->id) }}"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate"
                                href="{{ route('productDetail', $item->id) }}"
                                style="max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $item->name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h6 class="text-danger">{{ number_format($tt, 0, ',', '.') }} VND</h6>
                                <h6 class="text-muted ml-2"> @if ($item->variantProduct->isNotEmpty())
                                    @php
                                        $variant = $item->variantProduct->first(); // Lấy biến thể đầu tiên
                                    @endphp
                                    <del>Giá: {{ number_format($variant->price, 0, ',', '.') }} VND</del>
                                @else
                                    <del>Giá: Chưa có biến thể</del>
                                @endif
                                </h6>
                                <p class="discount text-danger mb-0">-{{ $item->discount ?? 0 }}%</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light">
                                <a href="{{ route('productDetail', $item->id) }}" class="btn btn-sm text-dark p-0"><i
                                        class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                                <form action="{{ route('cart.addCart') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="productId" value="{{ $item->id }}">
                                    <input type="button" value="Thêm vào giỏ"
                                        class="btn btn-sm text-dark p-0 addToCartShow" data-id="{{ $item->id }}"><i
                                        class="fas fa-shopping-cart text-primary mr-1 "></i>
                                </form>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                @php
                                    $averageRating = round($item->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
                                    $reviewCount = $item->review_count ?? 0; // mặc định 0 nếu không có
                                @endphp

                                @for ($i = 1; $i <= 5; $i++)
                                    <small
                                        class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
                                @endfor

                                <small>({{ $reviewCount }})</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



<!-- Blog Section Start -->
<div class="container-fluid py-5">
    <!-- Section Title -->
    <div class="text-center mb-5">
      <h2 class="section-title px-5 text-uppercase mx-xl-5 mb-4">
        <span class="px-2 stylish-text">Tin mới nhất</span>
      </h2>
    </div>
    <!-- Blog Carousel -->
    <div class="row px-xl-5">
      <div class="col">
        <div class="owl-carousel vendor-carousel">
          <!-- Loop qua danh sách blogs -->
          @foreach($blogs as $blog)
          <div class="blog-card bg-white shadow-lg rounded overflow-hidden">
            <a href="{{ route('blog.show', ['id' => $blog->id]) }}">
              <!-- Ảnh bài viết -->
              <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="img-fluid" />
            </a>
            <!-- Nội dung bài viết -->
            <div class="p-4">
              <!-- Tiêu đề bài viết -->
              <h5 class="fw-bold text-dark">{{ $blog->title }}</h5>
              <!-- Nội dung tóm tắt -->
              <p class="text-muted">
                {{ \Illuminate\Support\Str::limit($blog->short_content, 100) }}
              </p>
              <!-- Thêm thông tin thêm (Ngày đăng, tác giả) -->
              <div class="d-flex justify-content-between mt-3">
                <span class="text-muted"><i class="fa fa-clock"></i> {{ $blog->created_at->format('d/m/Y') }}</span>
                <span class="text-muted"><i class="fa fa-user"></i> {{ $blog->author ?? 'Admin' }}</span>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <!-- Blog Section End -->



    {{-- popup addtocart --}}

    <div id="overlay"></div>

    <div id="popup">
        {{-- NameProduct --}}
        <div style="display: flex; justify-content: space-between">
            <span id="productName" style="color: black; font-weight: bold; font-size: 18px"></span>
            <p id="mess2" style="color: red; text-align: left; font-size:14px; margin-top:3px; margin-bottom:0px; margin-left:20px;"></p>
            <button id="closePopup" style="border: none; background-color: white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path
                        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                </svg>
            </button>
        </div>
        {{-- EndName --}}
        {{-- Image & Quantity & Price & Variant & AddtoCart --}}
        <div class="row mt-3 mb-3">
            <div class="col-7">
                <div class="d-flex">
                    <div style="border: 2px solid gray; border-radius:5px; width: 150px; height: auto; ">
                        <img id="productImage" src="" style="width: 100%; height: 100%;" alt="">
                    </div>
                    {{-- price & quantity --}}
                    <div class="mx-2">
                        <div class="d-flex">
                            <span style="font-size: 14px;">Giá thành:</span>
                            <del id="price" style="font-size: 14px; color: black; font-weight: bold;"></del>
                        </div>
                        <div class="d-flex">
                            <span style="font-size: 14px;">Khuyến mãi:</span>
                            <p id="total" style="font-size: 14px; color: red; font-weight: bold;"></p>
                        </div>
                        <div class="d-flex">
                            <span style="font-size: 14px;">Số lượng trong kho:</span>
                            <p id="quantity" style=" font-size: 14px; color: red; font-weight: bold;"></p>
                        </div>
                        {{-- Tăng giảm số lượng  --}}
                        <div class="mt-4">
                            <button class="reduce" id="reduce">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8" />
                                </svg>
                            </button>
                            <input class="quantityAdd" id="quantityAdd" type="text" disabled value="1">
                            <button class="increase" id="increase">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                </svg>
                            </button>
                        </div>
                        {{-- End Tăng giảm số lượng --}}
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div>
                    <span>Kiểu Loại:</span>
                    <div id="variantList">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="addToCart" id="addToCart">Thêm Vào Giỏ Hàng</button>

        {{-- End Image & Quantity & Price & Variant & AddtoCart --}}
    </div>
    {{-- End popupAddtocart --}}
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
        // addToCartShow
        var productId = '';
        var variants = '';
        var discount = null;
        $(document).ready(function() {
            // Hiển thị popup
            $(".addToCartShow").click(function() {
                productId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "/get-product-info",
                    data: {
                        id: productId
                    },
                    success: function(response) {
                        let productName = response.name;
                        let productImg = response.img;
                        let packages = response.packages;
                        variants = response.variants;
                        $("#productName").text(productName);
                        $("#productImage").attr('src', '{{ asset('upload/') }}' + '/' +
                            productImg);
                        $("#variantList").empty();
                        packages.forEach(function(package) {
                            $("#variantList").append(
                                '<button class="option" style="border: 2px solid; background-color: aqua; border-radius: 5px; margin-bottom: 10px; margin-left:5px; height: 30px;" data-id=" ' +
                                package.id + ' "> ' + package.name + '</button>'
                            );
                        });
                        $("#overlay").fadeIn(); // Hiển thị nền mờ
                        $("#popup").fadeIn(); // Hiển thị popup
                    },
                    error: function() {
                        alert('Có lỗi xảy ra khi tải thông tin sản phẩm!');
                    }
                });

            });
            // Đóng popup
            $("#closePopup, #overlay").click(function() {
                $("#total").empty();
                    $("#price").empty();
                    $("#quantity").empty();
                $("#overlay").fadeOut(); // Ẩn nền mờ
                $("#popup").fadeOut(); // Ẩn popup
                packageId = '';
            });
        });
        $(document).ready(function() {
    // Lắng nghe sự kiện focus và blur trên các button có class 'option'
    $('#variantList').on('focus', '.option', function() {
        $(this).css({
            'background-color': 'yellow',
            'border-color': 'red'
        });
    }).on('blur', '.option', function() {
        $(this).css({
            'background-color': 'aqua',
            'border-color': 'initial'
        });
    });
});
        // Tăng giảm số lượng
        $(document).ready(function() {

            $("#increase").click(function() {
                let currentValue = parseInt($("#quantityAdd").val());
                $("#quantityAdd").val(currentValue + 1);
            });
            $("#reduce").click(function() {
                let currentValue = parseInt($("#quantityAdd").val());
                if (currentValue > 1) { // Không giảm dưới 1
                    $("#quantityAdd").val(currentValue - 1);
                }
            });
            var packageId = '';
            var id_variantProduct = '';
            var total = '';

            $(document).on('click', '.option', function() {
                packageId = $(this).data('id'); // Lấy giá trị của data-id

                variants.forEach(function(variant) {
                    if (variant.id_variant == packageId) {
                        id_variantProduct = variant.id;
                    }
                });
                $.ajax({
                    type: "GET",
                    url: "/get-price-quantity-variant",
                    data: {
                        id: id_variantProduct,
                    },
                    success: function(response) {
                        let price = response.price;
                        let quantity = response.quantity;
                        total = response.total;
                        discount = response.dis;
                        // console.log(total);
                        // alert(discount);

                        $("#price").text(price);
                        $("#quantity").text(quantity);
                        $("#total").text(total + 'VND');
                    }
                });
                $('#overlay').click(function() {
                    $("#total").empty();
                    $("#price").empty();
                    $("#quantity").empty();
                    packageId = '';
          });
            });
            //active button
            $("#addToCart").click(function(e) {
                e.preventDefault();
                let quantity = $("#quantity").html();
                // console.log(quantity);

               if (packageId && quantity > 0) {
                let quantity = $("#quantityAdd").val();
                let price = $("#price").html();
                let name = $("#productName").html();
                let img = $("#productImage").attr("src");
                let replaceImg = img.replace('/upload/', '');
                let replacePrice = price.replace('VNĐ', '');
                let newPrice = replacePrice.replace('.', '');
                let priceDis = $("#total").html();
                let replacePriceDis = priceDis.replace('VND', '');
                let newPriceDis = replacePriceDis.replace('.', '');
                console.log(total);
                console.log(packageId);
                console.log(id_variantProduct);
                if (discount !== null) {
                    // console.log(newPriceDis);
                    $.ajax({
                    type: "POST",
                    url: "/add-to-cart-home",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_product: productId,
                        id_variantProduct: id_variantProduct,
                        quantity: quantity,
                        price: newPriceDis,
                        name: name,
                        img: replaceImg,
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Thành công',
                                        text: response.message,
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                    console.log("Thêm Sản Phẩm Vào Thành Công!!!");
                                    console.log(response.count);
                                    $('#count').text(response.count); // Cập nhật số lượng sản phẩm trong giỏ hàng
                                }
                                packageId = '';
                    }
                });
                } else if(discount == null) {
                    // console.log(newPrice);
                    $.ajax({
                    type: "POST",
                    url: "/add-to-cart-home",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_product: productId,
                        id_variantProduct: id_variantProduct,
                        quantity: quantity,
                        price: newPrice,
                        name: name,
                        img: replaceImg,
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Thành công',
                                        text: response.message,
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                    console.log("Thêm Sản Phẩm Vào Thành Công!!!");
                                    console.log(response.count);
                                    $('#count').text(response.count); // Cập nhật số lượng sản phẩm trong giỏ hàng
                                }
                                packageId = '';
                    }
                });
                }
               } else {
                $("#mess2").text('Vui lòng chọn loại và kiểm tra số lượng!!!');
                setTimeout(function() {
                $("#mess2").text('');
                            }, 2000);
               }
                // console.log(id_variantProduct);

            });
        });
    </script>
@endsection
