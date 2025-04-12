@extends('layout')
@section('titlepage', 'Instinct - Instinct Pharmacy System')
@section('title', 'Welcome')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .product-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .product-code {
            font-weight: bold;
            color: #555;
        }

        .views-count {
            color: #777;
        }

        .inventory-status {
            font-size: 14px;
            color: #28a745;
            font-weight: bold;
        }

        .product-description {
            line-height: 1.6;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-muted {
            color: #6c757d;
        }

        /* Container cho các ô vuông biến thể */
        .variant-container {
            display: flex;
            gap: 10px;
            /* Khoảng cách giữa các ô */
            flex-wrap: wrap;
            /* Gói các ô xuống hàng nếu không đủ chỗ */
        }

        /* Các ô vuông biến thể */
        .variant-box {
            padding: 10px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s, border-color 0.3s;
        }

        /* Hiệu ứng khi di chuột qua */
        .variant-box:hover {
            background-color: #f0f0f0;
            border-color: #333;
        }

        /* Kiểu dáng khi ô biến thể được chọn */
        .variant-box.selected {
            background-color: #333;
            color: #fff;
            border-color: #333;
        }

        .alert {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .price {
            font-size: 1.8rem;
            /* Giá đã giảm lớn và nổi bật */
        }

        .original-price {
            font-size: 1.5rem;
            /* Giá gốc nhỏ hơn và mờ đi */
            color: #6c757d;
            /* Màu xám để làm nổi bật giá giảm */
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

        .rating-count {
            font-size: 0.9rem;
            color: #555;
            margin-left: 5px;
        }

        .sold-info {
            font-weight: bold;
            color: #28a745;
            /* Màu xanh lá cho số lượng đã bán */
        }

        .views-count {
            color: #6c757d;
            /* Màu xám nhạt cho số lượt xem */
        }

        .radio-buttons input[type="radio"] {
            display: none;
        }

        .radio-buttons label {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #f8f9fa;
            color: #333;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
        }

        .radio-buttons label:hover {
            background-color: #e0e0e0;
            border-color: #999;
        }

        .radio-buttons input[type="radio"]:checked+label {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
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



        .option:focus {
            border: 2px solid gray;
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
        .addToCart {
            border: 1px solid aqua;
            background-color: rgb(252, 227, 0);
            border-radius: 5px;
            width: 100%;
            height: 40px;
            font-weight: bold;
            color: black;
        }
        .description-text {
    max-height: 100px; /* Giới hạn chiều cao */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.description-text.expanded {
    max-height: none; /* Gỡ bỏ giới hạn chiều cao khi mở rộng */
    white-space: normal;
}
.flash-sale {
  background: linear-gradient(90deg, #ffc107, #f44336);
  color: white;
  padding: 20px;
  border-radius: 10px;
  font-family: Arial, sans-serif;
  margin: 20px 0;
}

.flash-sale-header {
  display: flex; /* Sử dụng Flexbox */
  justify-content: space-between; /* Khoảng cách đều giữa các phần tử */
  align-items: center; /* Căn giữa theo chiều dọc */
  margin-bottom: 10px;
}

.flash-sale-header h5 {
  margin: 0;
  font-size: 1rem;
  font-weight: bold;
}

.flash-sale-timer {
  text-align: right;
}

.flash-sale-timer p {
  margin: 0;
  font-size: 0.9rem;
}

#timer {
  display: flex;
  gap: 5px;
  font-size: 1.5rem;
  font-weight: bold;
  margin-top: 5px;
}

#timer span {
  background: black;
  color: white;
  padding: 5px 10px;
  border-radius: 5px;
}

h2 {
  font-size: 1.8rem;
  font-weight: bold;
  margin: 10px 0;
}

.flash-sale-progress {
  margin-top: 10px;
}

.flash-sale-progress p {
  margin: 0 0 5px;
  font-size: 0.9rem;
}

.progress-bar {
  background: #ddd;
  border-radius: 10px;
  overflow: hidden;
  height: 20px;
  width: 100%;
  position: relative;
}

.progress-fill {
  background: #ffc107;
  height: 100%;
  width: 0;
  transition: width 0.5s ease;
  text-align: center;
  font-size: 0.9rem;
  line-height: 20px;
  color: black;
}
.thumbnail-images .small-img {
    cursor: pointer;
    border: 2px solid transparent;
    transition: border 0.3s ease;
}

.thumbnail-images .small-img:hover,
.thumbnail-images .small-img.active {
    border: 2px solid #007bff;
}
    </style>

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Trang chủ</a>
                    <a class="breadcrumb-item text-dark" href="#">{{ $sp->category->name }}</a>
                    <span class="breadcrumb-item active">{{ $sp->name }}</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    @php
                        $variant = $sp->variantProduct->first();
                        $tt = $variant->price - (($variant->price  * $sp['discount']) / 100);
                        $spQuantity = $sp->variantProduct->first();
                    @endphp
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('upload/' . $sp->img) }}" alt="Image">
                        </div>
                        @foreach ($sp->imageProduct as $index => $imgs)
                            <div class="carousel-item">
                                <img class="w-100 h-100" src="{{ Storage::url($imgs->image) }}" alt="Image">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>

                    <!-- Thumbnail Images -->
                    <div class="thumbnail-images mt-3">
                        <div class="row">
                            <div class="col-3">
                                <img class="img-thumbnail small-img active" src="{{ asset('upload/' . $sp->img) }}" alt="Thumbnail" data-target="#product-carousel" data-slide-to="0">
                            </div>
                            @foreach ($sp->imageProduct as $index => $imgs)
                                <div class="col-3">
                                    <img class="img-thumbnail small-img" src="{{ Storage::url($imgs->image) }}" alt="Thumbnail" data-target="#product-carousel" data-slide-to="{{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3 class="product-name">{{ $sp->name }}</h3>
                    <div class="product-info d-flex align-items-center mb-3">
                        <small class="product-code px-2 pt-1">{{ $sp->idProduct }}</small>
                        <small class="product-code px-2 pt-1">Thương hiệu: {{ $sp->brand->name }}</small>
                        <div class="mr-2">
                            @php
                                $averageRating = round($sp->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
                                $reviewCount = $sp->review_count ?? 0; // mặc định 0 nếu không có
                            @endphp

                            @for ($i = 1; $i <= 5; $i++)
                                <small class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
                            @endfor

                            <small class="rating-count">({{ $reviewCount }}) đánh giá</small>

                            {{-- @foreach ($soldQuantity as $variant) --}}
                             {{-- <small class="sold-info ml-3">{{ $variant->total_quantity }} đã bán</small> --}}
                             <small class="sold-info ml-3">{{ $soldQuantity }} đã bán</small>
                            {{-- @endforeach --}}


                        </div>
                        <small class="views-count ml-auto">{{ $sp->view }} Lượt xem</small>
                    </div>
                    <div class="flash-sale">
                        <div class="flash-sale-header">
                          <h4 style="font-weight: bold">Online giá rẻ quá</h4>
                          <div class="flash-sale-timer">
                            <p>Kết thúc trong:</p>
                            <div id="timer">
                              <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span>
                            </div>
                          </div>
                        </div>
                        <div class="flash-sale-progress">
                          <p>Còn <span id="">{{ $spQuantity->quantity }}</span>/{{ $spQuantity->quantity }} Suất</p>
                          <div class="progress-bar">
                            <div class="progress-fill" style="width: 80%;"></div>
                          </div>
                        </div>
                      </div>


                    <form action="{{ route('cart.addCart') }}" method="post">
                        @csrf
                        <div class="d-flex mb-3 border-box">
                            <div class="variant-container">
                                {{-- @dd($sp->variantProduct) --}}
                                <div class="radio-buttons">
                                    {{-- @dd($sp->variantProduct) --}}
                                    @foreach ($sp->variantProduct as $index => $item)
                                        {{-- <div class="variant-box" data-id="{{ $item->id }}" >{{ $item->variantPackage->name }}
                            </div>
                            <input class="variant-box" type="radio" name="variant_id" id=""> --}}
                                        <input type="radio" id="option-{{ $loop->index }}" name="variantId"
                                            value="{{ $item->id_variant }}" data-price="{{ $item->price }}"
                                            data-quantity="{{ $item->quantity }}"
                                            data-discount="{{ $sp->discount ?? 0 }}">
                                        <label for="option-{{ $loop->index }}">{{ $item->variantPackage->name }}</label>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <h3 id="price" class="price font-weight-semi-bold mb-0 text-danger">
                                {{ number_format($tt, 0, ',', '.') }} VND
                            </h3>
                            <h4 class="original-price font-weight-semi-bold mb-0">
                                <del>{{ number_format($sp->price, 0, ',', '.') }} VND</del>
                            </h4>
                            <p class="discount text-danger mb-0" id="discount">-{{ $sp->discount ?? 0 }}%</p>
                        </div>
                        <div class="d-flex">
                            <p class="inventory-status" id="quantity-display">Tồn kho: </p>
                            <p class=" inventory-status mx-3 quantity" id="stock-quantity">{{ $spQuantity->quantity }}</p>
                        </div>
                        {{-- <p class="mb-4">{!! nl2br(e($sp->content)) !!}</p> --}}
                        {{-- <div class="d-flex mb-4">
                    <strong class="text-dark mr-3">Colors:</strong>

                </div> --}}
                        <div class="d-flex align-items-center mb-4 pt-2">

                            <div class="d-flex align-items-center me-4">
                                <h6 class="mb-0 me-2">Số lượng: </h6>
                                <div class="input-group mx-3" style="width: 150px;">
                                    <div class="btn btn-outline-primary" id="btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </div>
                                    <input type="text" class="form-control text-center" value="1" name="quantity"
                                        id="quantity-input" data-max="{{ $sp->quantity }}">
                                    <div class="btn btn-outline-primary" id="btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                                <input type="hidden" name="productId" value="{{ $sp->id }}">
                            </div>
                            {{-- <input type="hidden" name="variantId" id="id_variant" value="{{ $sp->id }}"> --}}
                        </div>
                        <button type="submit" class="btn btn-primary ms-4 addToCart">Thêm vào giỏ hàng</button>
                    </form>

                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Chia sẻ:</strong>
                        <div class="d-inline-flex">
                            <!-- Facebook -->
                            <a class="text-dark px-2"
                               href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}"
                               target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>

                            <!-- Twitter -->
                            <a class="text-dark px-2"
                               href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{ urlencode($sp->name) }}"
                               target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>

                            <!-- LinkedIn -->
                            <a class="text-dark px-2"
                               href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(Request::url()) }}"
                               target="_blank">
                                <i class="fab fa-linkedin-in"></i>
                            </a>

                            <!-- Pinterest (nếu có ảnh sản phẩm) -->
                            <a class="text-dark px-2"
                               href="https://pinterest.com/pin/create/button/?url={{ urlencode(Request::url()) }}&media={{ asset('upload/' . $sp->img) }}&description={{ urlencode($sp->name) }}"
                               target="_blank">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Mô tả sản
                            phẩm</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Chi tiết sản phẩm</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab"
                            href="#tab-pane-3">{{ $product->review ? $product->review->count() : 0 }} đánh giá</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <p class="mb-4 description-text" id="description">{!! Str::limit($sp->description, 50) !!}</p>
                            <button class="btn btn-link p-0" id="toggle-description">Xem thêm</button>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-2">
                            <p class="mb-3" style="font-weight: bold"> Instinct Pharmacy > {{ $sp->category->name }} >
                                {{ $sp->name }}</p>
                            <p class="mb-4">{!! nl2br(e($sp->content)) !!}</p>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4">
                                        {{ $product->review ? $product->review->count() : 0 }} đánh giá cho
                                        "{{ $product->name }}"
                                    </h4>
                                    @foreach ($product->review as $review)
                                        <div class="media mb-4">
                                            <img src="{{ asset('upload/' . $review->user->image) }}" alt="Image"
                                                class="img-fluid mr-3 mt-1" style="width: 45px; height:55px">
                                            <div class="media-body">
                                                <h6>{{ $review->user->name }}<small> -
                                                        <i>{{ $review->created_at->format('d M Y') }}</i></small></h6>
                                                <div class="text-primary mb-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                    @endfor
                                                </div>
                                                <p>{{ $review->comment }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <h4 class="mb-4">Để lại đánh giá</h4>
                                    @if ($canReview)
                                    <p class="text-warning">Vui lòng vào đơn hàng để đánh giá sản phẩm nếu đã nhận hàng.</p>
                                    @else
                                        <p class="text-warning">Bạn cần mua sản phẩm này thì mới có thể để lại đánh giá.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <button class="btn btn-outline-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#questionForm" aria-expanded="false" aria-controls="questionForm">
                        Gửi câu hỏi về sản phẩm
                    </button>

                    <div class="collapse" id="questionForm">
                        <form method="POST" action="{{ route('product.question.store') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $sp->id }}">

                            @guest
                                <div class="form-group">
                                    <label>Họ tên</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            @endguest

                            <div class="form-group">
                                <label>Câu hỏi của bạn</label>
                                <textarea name="question" class="form-control" rows="4" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">Gửi câu hỏi</button>
                        </form>
                    </div>
                </div>

                @foreach($sp->questions as $q)
                <li class="list-group-item">
                    <strong>{{ $q->name ?? $q->user->name }}</strong> hỏi:
                    <p>{{ $q->question }}</p>

                    @if($q->answer)
                        <div class="mt-2 text-success">
                            <strong>Phản hồi từ shop:</strong>
                            <p>{{ $q->answer }}</p>
                        </div>
                    @endif
                </li>
            @endforeach

            </div>
        </div>
    </div>
    <!-- Shop Detail End -->




    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản phẩm
                tương tự</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ($splq as $s)
                    @php $variant = $s->variantProduct->first();
                              $tt = $variant->price - (($variant->price  * $s['discount']) / 100); @endphp
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('upload/' . $s->img) }}" alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href="{{ route('cart.listCart') }}"><i
                                            class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square"
                                        href="{{ route('productDetail', $s->id) }}"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate"
                                    href="{{ route('productDetail', $s->id) }}"
                                    style="max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $s->name }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h6 class="text-danger">{{ number_format($tt, 0, ',', '.') }} VND</h6>
                                    <h6 class="text-muted ml-2">@if ($s->variantProduct->isNotEmpty())
                                        @php
                                            $variant = $s->variantProduct->first(); // Lấy biến thể đầu tiên
                                        @endphp
                                        <del>Giá: {{ number_format($variant->price, 0, ',', '.') }} VND</del>
                                    @else
                                        <del>Giá: Không có thông tin</del>
                                    @endif
                                </h6>
                                    </h6>
                                    <p class="discount text-danger mb-0">-{{ $s->discount ?? 0 }}%</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light">
                                    <a href="{{ route('productDetail', $s->id) }}" class="btn btn-sm text-dark p-0"><i
                                            class="fas fa-eye text-primary mr-1"></i>Xem</a>
                                    <form action="" method="post">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="productId" value="{{ $s->id }}">
                                        <input type="button" data-id="{{ $s->id }}" value="Thêm vào giỏ"
                                       class="btn btn-sm text-dark p-0 addToCartShow" name="addtocart"><i
                                        class="fas fa-shopping-cart text-primary mr-1"></i>
                                </form>
                            </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    @php
                                        $averageRating = round($s->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
                                        $reviewCount = $s->review_count ?? 0; // mặc định 0 nếu không có
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        <small
                                            class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
                                    @endfor

                                    <small>({{ $reviewCount }})</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
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
            </div>
        </div>
    </div>
    <!-- Products End -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.querySelector('#toggle-description');
            const description = document.querySelector('#description');

            toggleButton.addEventListener('click', function () {
                if (description.classList.contains('expanded')) {
                    // Thu gọn
                    description.classList.remove('expanded');
                    description.innerHTML = `{!! Str::limit($sp->description, 50) !!}`;
                    toggleButton.textContent = 'Xem thêm';
                } else {
                    // Mở rộng
                    description.classList.add('expanded');
                    description.innerHTML = `{!! $sp->description !!}`;
                    toggleButton.textContent = 'Thu gọn';
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const variantOptions = document.querySelectorAll('input[name="variantId"]');
            const priceDisplay = document.getElementById('price');
            const quantityDisplay = document.querySelector('.quantity');
            const quantityInput = document.getElementById('quantity-input'); // Lấy ô nhập số lượng
            const originalPriceElement = document.querySelector('.original-price del'); // Giá gốc
            const discountElement = document.querySelector('#discount');

            // Hàm cập nhật thông tin khi thay đổi biến thể
            function updateVariantInfo(option) {
                if (option.checked) {
                    // Lấy dữ liệu từ data attributes
                    const price = parseFloat(option.dataset.price || 0); // Giá gốc
                    const discount = parseFloat(option.dataset.discount || 0);
                    const discountedPrice = price - (price * discount / 100);
                    const quantity = option.dataset.quantity;

                    // Cập nhật giá và số lượng tồn kho
                    priceDisplay.textContent = `${new Intl.NumberFormat('vi-VN').format(discountedPrice)} VND`;
                    originalPriceElement.textContent = `${new Intl.NumberFormat('vi-VN').format(price)} VND`;
                    discountElement.textContent = `-${discount}%`;
                    // priceDisplay.textContent = new Intl.NumberFormat('vi-VN').format(price) + ' VND';
                    quantityDisplay.textContent = quantity;

                    // Cập nhật lại giá trị data-max cho ô nhập số lượng
                    quantityInput.setAttribute('data-max', quantity);
                    quantityInput.value = 1;

                    // Kiểm tra và cập nhật lại số lượng nếu giá trị hiện tại lớn hơn tồn kho của biến thể
                    const currentQuantity = parseInt(quantityInput.value, 10);
                    if (currentQuantity > parseInt(quantity, 10)) {
                        quantityInput.value = quantity; // Đặt lại số lượng hiện tại
                        // alert('Số lượng bạn chọn đã được cập nhật theo tồn kho mới!');
                    }
                    console.log('data-max đã thay đổi thành:', quantityInput.getAttribute('data-max'));
                }
            }

            // Lặp qua tất cả các tùy chọn biến thể và thiết lập sự kiện change
            variantOptions.forEach(option => {
                option.addEventListener('change', () => {
                    updateVariantInfo(option);
                });
            });

            // Cập nhật dữ liệu lần đầu khi một biến thể được chọn mặc định
            if (variantOptions.length > 0) {
                const firstOption = variantOptions[0]; // Lấy biến thể đầu tiên
                firstOption.checked = true; // Đặt biến thể đầu tiên là được chọn
                updateVariantInfo(firstOption); // Cập nhật thông tin theo biến thể đầu tiên
            }

            // Xử lý các sự kiện cho ô nhập số lượng
            const input = $('#quantity-input');
            input.on('input', function() {
                let value = $(this).val();
                const maxStock = parseInt(quantityInput.getAttribute('data-max'), 10);;
                console.log(maxStock);

                // Loại bỏ ký tự không hợp lệ và kiểm tra tồn kho
                value = value.replace(/[^0-9]/g, '');
                if (value === '' || parseInt(value, 10) < 1) {
                    value = 1;
                } else if (parseInt(value, 10) > maxStock) {
                    value = maxStock;
                    alert('Không thể tăng vượt quá số lượng tồn kho!');
                }

                $(this).val(value);
            });

            // Tăng số lượng
            $('#btn-plus').on('click', function() {
                let value = parseInt(input.val(), 10) || 1;
                const maxStock = parseInt(quantityInput.getAttribute('data-max'), 10);
                console.log(maxStock);
                if (value < maxStock) {
                    input.val(value + 1); // Tăng số lượng nếu chưa đạt tối đa
                } else {
                    alert('Không thể tăng vượt quá số lượng tồn kho!');
                }
            });

            // Giảm số lượng
            $('#btn-minus').on('click', function() {
                let value = parseInt(input.val(), 10) || 1;
                if (value > 1) {
                    input.val(value - 1); // Giảm số lượng nếu lớn hơn 1
                }
            });
        });
    </script>

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
<script>
    // Set thời gian kết thúc flash sale (ví dụ: 24 giờ từ bây giờ)
    const flashSaleEnd = new Date().getTime() + 24 * 60 * 60 * 1000;

    // Cập nhật thời gian còn lại mỗi giây
    const timerInterval = setInterval(() => {
      const now = new Date().getTime();
      const distance = flashSaleEnd - now;

      if (distance <= 0) {
        clearInterval(timerInterval);
        document.getElementById("timer").innerHTML = "Đã kết thúc";
        return;
      }

      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      document.getElementById("hours").textContent = hours.toString().padStart(2, "0");
      document.getElementById("minutes").textContent = minutes.toString().padStart(2, "0");
      document.getElementById("seconds").textContent = seconds.toString().padStart(2, "0");
    }, 1000);

    // Tự động giảm số lượng còn lại và cập nhật thanh tiến trình
    let totalSlots = 50;
    let soldSlots = 10;

    function updateProgressBar() {
      const remainingSlots = totalSlots - soldSlots;
      document.getElementById("remaining-slots").textContent = remainingSlots;
      const progressPercentage = (soldSlots / totalSlots) * 100;
      document.querySelector(".progress-fill").style.width = progressPercentage + "%";
    }

    // Mô phỏng việc bán hàng mỗi 5 giây
    setInterval(() => {
      if (soldSlots < totalSlots) {
        soldSlots++;
        updateProgressBar();
      }
    }, 5000);

    // Khởi tạo thanh tiến trình
    updateProgressBar();
  </script>
<script>
    document.querySelectorAll('.small-img').forEach((img, index) => {
    img.addEventListener('click', function() {
        document.querySelector('.small-img.active').classList.remove('active');
        this.classList.add('active');
    });
});

</script>
@endsection
