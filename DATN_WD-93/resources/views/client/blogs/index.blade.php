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

        /* .image-container {
                                position: relative;
                                overflow: hidden;
                                border-radius: 15px;
                            }

                            .image-container img {
                                transition: transform 0.5s ease;
                                border-radius: 15px;
                            }

                            .image-container:hover img {
                                transform: scale(1.1); */
        /* } */

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

        .input-group {
            width: 30%;
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

        .card img {
            object-fit: cover;
            /* Đảm bảo ảnh không bị biến dạng */
            width: 100%;
            /* Chiếm toàn bộ chiều rộng */
            height: 100%;
            /* Đảm bảo chiều cao đồng đều */
        }

        .image-container {
            width: 100%;
            /* Chiếm toàn bộ chiều rộng */
            height: 200px;
            /* Đặt chiều cao cố định cho khung ảnh */
            overflow: hidden;
            /* Ẩn phần ảnh thừa nếu ảnh lớn hơn khung */
        }

        .image-container img {
            object-fit: cover;
            /* Đảm bảo ảnh bao phủ toàn bộ khung mà không bị kéo dãn */
            width: 100%;
            /* Ảnh chiếm toàn bộ chiều rộng khung */
            height: 100%;
            /* Ảnh chiếm toàn bộ chiều cao khung */
        }
    </style>

    <div class="container my-5">
        <h1 class="text-center mb-4">Tin Tức Nổi Bật</h1>
        <div class="d-flex justify-content-between align-items-center mb-4">
            {{-- <button class="btn btn-primary">Xem danh mục bài viết</button> --}}

            <!-- Thanh tìm kiếm -->
            <form class="d-flex input-group" action="" method="GET" role="search">
                <input class="form-control me-2" type="search" placeholder="Tìm kiếm bài viết..." aria-label="Search" value="{{ request('search') }}" >
                <button class="btn btn-outline-warning" type="submit" id="button-addon2">Tìm kiếm</button>
            </form>
        </div>
        <div class="row g-4">
            <!-- Bài viết ngang -->
            <div class="col-md-8">
                @foreach ($blogTT as $item)
                    <div class="card rounded mt-3">
                        <div class="row g-0">
                            <!-- Hình ảnh -->
                            <div class="col-md-5">
                                <div class="image-container">
                                    <img src="{{ Storage::url($item->image) }}" class="img-fluid" alt="Bài viết ngang">
                                </div>
                            </div>
                            <!-- Nội dung -->
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->title }}</h5>
                                    <p class="card-text">
                                        {{ $item->short_content }}
                                    </p>
                                    <a href="{{ route('blog.show', $item->id) }}" class="btn btn-primary">Đọc thêm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Bài viết 3 -->
            <div class="col-md-4">
                <div class="card rounded mt-3">
                    <div class="card-title mt-4 d-flex align-items-center justify-content-center">
                        <h4> Chuyên mục</h4>
                    </div>
                @foreach ($listTopic as $item)
                    <a href="{{ route('blog.list',  $item->id) }}">
                        <div class="card rounded mx-4 my-2 ">
                            <div class="row">
                                <div class="col-5 m-1">
                                    <img src="{{ Storage::url($item->img) }}" class="image-container" alt="Bài viết 3"
                                        style="width:70%">
                                </div>
                                <div class="col-5 d-flex align-items-center justify-content-center">
                                    <div class="">
                                        <h4>
                                            {{ $item->name }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                        @endforeach
                        <div class="d-flex align-items-center justify-content-center my-3">
                            <a href="" class="btn btn-primary" style="margin-top: auto;">Xem tất cả</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <!-- Button "Xem danh mục bài viết" -->
            <h3>Sức khỏe</h3>

            <!-- Thanh tìm kiếm -->
            <a href="" class="btn btn-primary">Xem thêm >></a>
        </div>
        <div class="row g-4 mt-3">
            <!-- Bài viết 1 -->
            @foreach ($blog1 as $item)
                <div class="col-md-4">
                    <div class="card mt-3" style="height: 100%;"> <!-- Đảm bảo card có chiều cao bằng nhau -->
                        <img src="{{ Storage::url($item->image) }}" class="image-container" alt="Bài viết 3"
                            style="object-fit: cover; height: 150px; width: 100%;"> <!-- Chiều cao ảnh cố định -->
                        <div class="card-body" style="">
                            <!-- Cố định chiều cao cho phần body -->
                            <h5 class="card-title" style="">{{ $item->title }}</h5>
                            <!-- Cố định chiều cao cho tiêu đề -->
                            <p class="card-text" style="">{{ $item->short_content }}</p>
                            <!-- Cố định chiều cao cho mô tả -->
                            <a href="{{ route('blog.show', $item->id) }}" class="btn btn-primary" style="margin-top: auto;">Đọc thêm</a>
                            <!-- Đẩy nút xuống dưới -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <!-- Button "Xem danh mục bài viết" -->
            <h3>Sức khỏe</h3>

            <!-- Thanh tìm kiếm -->
            <a href="" class="btn btn-primary">Xem thêm >></a>
        </div>
        <div class="row g-4 mt-3">
            <!-- Bài viết 1 -->
            @foreach ($blog2 as $item)
                <div class="col-md-4">
                    <div class="card mt-3" style="height: 100%;"> <!-- Đảm bảo card có chiều cao bằng nhau -->
                        <img src="{{ Storage::url($item->image) }}" class="image-container" alt="Bài viết 3"
                            style="object-fit: cover; height: 150px; width: 100%;"> <!-- Chiều cao ảnh cố định -->
                        <div class="card-body" style="">
                            <!-- Cố định chiều cao cho phần body -->
                            <h5 class="card-title" style="">{{ $item->title }}</h5>
                            <!-- Cố định chiều cao cho tiêu đề -->
                            <p class="card-text" style="">{{ $item->short_content }}</p>
                            <!-- Cố định chiều cao cho mô tả -->
                            <a href="{{ route('blog.show', $item->id) }}" class="btn btn-primary" style="margin-top: auto;">Đọc thêm</a>
                            <!-- Đẩy nút xuống dưới -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <!-- Button "Xem danh mục bài viết" -->
            <h3>Sức khỏe</h3>

            <!-- Thanh tìm kiếm -->
            <a href="" class="btn btn-primary">Xem thêm >></a>
        </div>
        <div class="row g-4 mt-3">
            <!-- Bài viết 1 -->
            @foreach ($blog3 as $item)
                <div class="col-md-4">
                    <div class="card mt-3" style="height: 100%;"> <!-- Đảm bảo card có chiều cao bằng nhau -->
                        <img src="{{ Storage::url($item->image) }}" class="image-container" alt="Bài viết 3"
                            style="object-fit: cover; height: 150px; width: 100%;"> <!-- Chiều cao ảnh cố định -->
                        <div class="card-body" style="">
                            <!-- Cố định chiều cao cho phần body -->
                            <h5 class="card-title" style="">{{ $item->title }}</h5>
                            <!-- Cố định chiều cao cho tiêu đề -->
                            <p class="card-text" style="">{{ $item->short_content }}</p>
                            <!-- Cố định chiều cao cho mô tả -->
                            <a href="{{ route('blog.show', $item->id) }}" class="btn btn-primary" style="margin-top: auto;">Đọc thêm</a>
                            <!-- Đẩy nút xuống dưới -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection