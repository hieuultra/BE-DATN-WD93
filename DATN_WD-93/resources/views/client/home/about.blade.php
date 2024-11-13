@extends('layout')
@section('titlepage', 'Instinct - Instinct Pharmacy System')
@section('title', 'Welcome')

@section('content')

    <style>
        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .rounded {
            border-radius: .25rem !important;
        }

        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        }

        blockquote {
            background: #f8f9fa;
            padding: 15px;
            border-left: 5px solid #007bff;
        }

        .blockquote-footer {
            color: #6c757d;
        }

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap');

        .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
        }

        .image-container img {
            transition: transform 0.5s ease;
            border-radius: 15px;
        }

        .image-container:hover img {
            transform: scale(1.1);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.5s ease;
            border-radius: 15px;
        }

        .image-container:hover .overlay {
            opacity: 1;
        }

        .text {
            font-family: 'Poppins', sans-serif;
            color: #fff;
            font-size: 22px;
            font-weight: 600;
            text-align: center;
        }

        .overlay-link {
            text-decoration: none;
        }

        .product-name {
            margin-top: 10px;
            font-size: 16px;
            font-weight: 500;
            color: #333;
            text-align: center;
        }

        .news-section {
            padding: 40px 0;
        }

        .news-title {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .news-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            /* Khoảng cách giữa các tin tức */
        }

        .news-item img {
            width: 100%;
            height: 250px;
            /* Kích thước cố định */
            object-fit: cover;
            /* Đảm bảo ảnh không bị méo */
            transition: transform 0.3s ease;
        }

        .news-item:hover img {
            transform: scale(1.1);
            /* Zoom ảnh khi hover */
        }

        .news-overlay {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 5px 10px;
            font-size: 16px;
            border-radius: 5px;
            display: none;
            /* Ẩn đi khi chưa hover */
        }

        .news-item:hover .news-overlay {
            display: block;
            /* Hiển thị overlay khi hover */
        }

        .view-now {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            text-align: center;
        }

        .news-overlay-link {
            display: block;
            /* Làm cho overlay có thể nhấn */
            text-decoration: none;
            /* Xóa gạch chân */
        }

        .news-content {
            padding: 15px;
            margin-top: 20px;
            /* Khoảng cách giữa ảnh và nội dung */
        }

        .news-text {
            font-size: 14px;
            color: #555;
            text-align: center;
        }
    </style>

    <div class="container my-5">
        <div class="text-center mb-5">
            <h2>Giới thiệu về chúng tôi</h2>
            <p>Khám phá câu chuyện đằng sau cửa hàng thời trang của chúng tôi</p>
        </div>

        <!-- Introduction Section -->
        <div class="row mb-5">
            <div class="col-md-6">
                <img src="{{ asset('img/a1.jpg') }}" alt="Fashion Store" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div>
                    <h3>Sứ mệnh của chúng tôi</h3>
                    <p>Chúng tôi mong muốn cung cấp các xu hướng thời trang mới nhất với giá cả phải chăng. Bộ sưu tập của
                        chúng tôi được tuyển chọn cẩn thận để đảm bảo chất lượng và phong cách tốt nhất cho khách hàng.</p>
                    <p>Hãy tham gia cùng chúng tôi trên hành trình biến thời trang trở nên dễ tiếp cận và thú vị hơn với mọi
                        người.</p>
                </div>
            </div>
        </div>
        <!-- Our Team Section -->
        <div class="text-center mb-5">
            <h3>Gặp gỡ đội ngũ của chúng tôi</h3>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                <img src="{{ asset('img/bs1.jpg') }}" alt="Team Member 1" class="img-fluid rounded-circle mb-3"
                    style="width: 150px; height: 150px;">
                <h5>Đoàn Quang Hà</h5>
                <p>Master Doctor</p>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('img/bs2.jpg') }}" alt="Team Member 2" class="img-fluid rounded-circle mb-3"
                    style="width: 150px; height: 150px;">
                <h5>Ngô Trọng Liêm</h5>
                <p>Senior Doctor</p>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('img/bs3.jpg') }}" alt="Team Member 3" class="img-fluid rounded-circle mb-3"
                    style="width: 150px; height: 150px;">
                <h5>Chu Thị Vân</h5>
                <p>CEO</p>
            </div>
        </div>

        <!-- Product Showcase Section -->
        <div class="text-center mb-5">
            <h3>Sản phẩm của chúng tôi</h3>
        </div>
        <div class="row mb-5">
            <div class="col-md-4 mb-3">
                <div class="image-container">
                    <a href="link_san_pham_1" class="overlay-link">
                        <img src="{{ asset('img/P25474_1.jpg') }}" alt="Product 1" class="img-fluid rounded shadow-sm"
                            style="">
                        <div class="overlay">
                            <span class="text">Đặt mua ngay</span>
                        </div>
                    </a>
                </div>
                <h6 class="mt-2 product-name">Hộp thuốc STERIMAR chính hãng</h6>
            </div>

            <div class="col-md-4 mb-3">
                <div class="image-container">
                    <a href="link_san_pham_2" class="overlay-link">
                        <img src="{{ asset('img/P25174_1.jpg') }}" alt="Product 2" class="img-fluid rounded shadow-sm">
                        <div class="overlay">
                            <span class="text">Đặt mua ngay</span>
                        </div>
                    </a>
                </div>
                <h6 class="mt-2 product-name">Cá ngừ bổ sung dinh dưỡng cho mọi lứa tuổi</h6>
            </div>

            <div class="col-md-4 mb-3">
                <div class="image-container">
                    <a href="link_san_pham_3" class="overlay-link">
                        <img src="{{ asset('img/P02182_1.jpg') }}" alt="Product 3" class="img-fluid rounded shadow-sm">
                        <div class="overlay">
                            <span class="text">Đặt mua ngay</span>
                        </div>
                    </a>
                </div>
                <h6 class="mt-2 product-name">POSINOR chất lượng cao</h6>
            </div>
        </div>

        <!-- Customer Reviews Section -->
        <div class="text-center mb-5">
            <h3>Khách hàng của chúng tôi nói gì</h3>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p class="mb-0">"Chất lượng tuyệt vời và dịch vụ chăm sóc khách hàng tuyệt vời!"</p>
                    <footer class="blockquote-footer">Khách hàng</footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p class="mb-0">"Cửa hàng thời trang tốt nhất tôi từng mua sắm."</p>
                    <footer class="blockquote-footer">Khách hàng</footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p class="mb-0">"Rất khuyến khích cho bất kỳ ai đang tìm kiếm sản phẩm thuốc."</p>
                    <footer class="blockquote-footer">Khách hàng</footer>
                </blockquote>
            </div>
        </div>
        <!-- News Section -->
        <div class="news-section">
            <h3 class="news-title">Tin tức mới nhất</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="news-item">
                        <a href="link_news_1" class="news-overlay-link">
                            <div class="news-overlay">
                                <span class="view-now">Xem ngay</span>
                            </div>
                            <img src="{{ asset('img/New1.jpg') }}" alt="News 1" class="img-fluid">
                        </a>
                        <div class="news-content">
                            <p class="news-text">Cập nhật mới về dịch vụ chăm sóc sức khỏe và những thay đổi trong quy trình
                                đặt lịch khám online.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="news-item">
                        <a href="link_news_2" class="news-overlay-link">
                            <div class="news-overlay">
                                <span class="view-now">Xem ngay</span>
                            </div>
                            <img src="{{ asset('img/New2.jpg') }}" alt="News 2" class="img-fluid">
                        </a>
                        <div class="news-content">
                            <p class="news-text">Hướng dẫn cách sử dụng ứng dụng để đặt lịch khám và nhận các ưu đãi đặc
                                biệt của cửa hàng.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="news-item">
                        <a href="link_news_3" class="news-overlay-link">
                            <div class="news-overlay">
                                <span class="view-now">Xem ngay</span>
                            </div>
                            <img src="{{ asset('img/New3.jpg') }}" alt="News 3" class="img-fluid">
                        </a>
                        <div class="news-content">
                            <p class="news-text">Cập nhật về các bác sĩ mới gia nhập và những chương trình khám chữa bệnh
                                của chúng tôi.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="news-item">
                        <a href="link_news_4" class="news-overlay-link">
                            <div class="news-overlay">
                                <span class="view-now">Xem ngay</span>
                            </div>
                            <img src="{{ asset('img/New4.webp') }}" alt="News 4" class="img-fluid">
                        </a>
                        <div class="news-content">
                            <p class="news-text">Lợi ích của việc khám sức khỏe định kỳ và những điều cần lưu ý khi đến
                                khám tại bệnh viện.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>

@endsection
