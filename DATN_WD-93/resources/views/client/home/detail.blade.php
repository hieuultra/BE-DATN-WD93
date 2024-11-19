@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
    gap: 10px; /* Khoảng cách giữa các ô */
    flex-wrap: wrap; /* Gói các ô xuống hàng nếu không đủ chỗ */
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
    font-size: 1.8rem; /* Giá đã giảm lớn và nổi bật */
}

.original-price {
    font-size: 1.5rem; /* Giá gốc nhỏ hơn và mờ đi */
    color: #6c757d; /* Màu xám để làm nổi bật giá giảm */
}

.discount {
    background-color: #ffe6e6; /* Nền màu nhạt để làm nổi bật */
    border-radius: 5px; /* Bo góc mềm mại */
    padding: 5px 10px; /* Khoảng cách trong */
    font-size: 1.2rem; /* Kích thước chữ vừa đủ */
    font-weight: bold; /* Chữ đậm */
}
.rating-count {
    font-size: 0.9rem;
    color: #555;
    margin-left: 5px;
}

.sold-info {
    font-weight: bold;
    color: #28a745; /* Màu xanh lá cho số lượng đã bán */
}

.views-count {
    color: #6c757d; /* Màu xám nhạt cho số lượt xem */
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
.radio-buttons input[type="radio"]:checked + label {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

</style>

 <!-- Breadcrumb Start -->
 <div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Shop Detail</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                @php
                $tt = $sp['price'] - (($sp['price']  * $sp['discount']) / 100);
                     @endphp
                <div class="carousel-inner bg-light">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src="{{ asset('upload/' . $sp->img) }}" alt="Image">
                    </div>
                    @foreach($sp->imageProduct as $index => $imgs)
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
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h3 class="product-name">{{ $sp->name }}</h3>
                <div class="product-info d-flex align-items-center mb-3">
                    <small class="product-code px-2 pt-1">Mã:{{ $sp->idProduct }}</small>
                    <div class="mr-2">
                        @php
                        $averageRating = round($sp->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
                        $reviewCount = $sp->review_count ?? 0; // mặc định 0 nếu không có
                    @endphp

                    @for ($i = 1; $i <= 5; $i++)
                        <small class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
                    @endfor

                    <small class="rating-count">({{ $reviewCount }}) đánh giá</small>
                    <small class="sold-info ml-3">{{ $soldQuantity }} đã bán</small>

                    </div>
                    <small class="views-count ml-auto">{{ $sp->view }} Lượt xem</small>
                </div>
                <form action="{{ route('cart.addCart') }}" method="post"  >
                    @csrf
                <div class="d-flex mb-3 border-box">
                    <div class="variant-container">
                        {{-- @dd($sp->variantProduct) --}}
                        <div class="radio-buttons">
                            @foreach ($sp->variantProduct as $index => $item)
                            {{-- <div class="variant-box" data-id="{{ $item->id }}" >{{ $item->variantPackage->name }}
                            </div>
                            <input class="variant-box" type="radio" name="variant_id" id=""> --}}
                            <input type="radio" id="option-{{$loop->index}}" name="variantId" value="{{ $item->id }}">
                            <label for="option-{{$loop->index}}">{{ $item->variantPackage->name }}</label>
                            @endforeach
                        </div>
                        
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <h3 id="price" class="price font-weight-semi-bold mb-0 text-danger">
                        {{ number_format($tt, 0, ",", ".") }} VND
                    </h3>
                    <h4 class="original-price font-weight-semi-bold mb-0">
                        <del>{{ number_format($sp->price, 0, ",", ".") }} VND</del>
                    </h4>
                    <p class="discount text-danger mb-0">-{{ $sp->discount ?? 0 }}%</p>
                </div>
                <div class="d-flex">
                    <p class="inventory-status" id="quantity-display">Tồn kho:</p>
                    <p class=" inventory-status quantity">{{ $sp->quantity }}</p>
                </div>
                {{-- <p class="mb-4">{!! nl2br(e($sp->content)) !!}</p> --}}
                {{-- <div class="d-flex mb-4">
                    <strong class="text-dark mr-3">Colors:</strong>
                    
                </div> --}}
                <div class="d-flex align-items-center mb-4 pt-2">
                   
                        <div class="d-flex align-items-center me-4">
                            <h6 class="mb-0 me-2">Số lượng:</h6>
                            <div class="input-group" style="width: 130px;">
                                <button class="btn btn-outline-primary" type="button" id="btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <input type="text" class="form-control text-center" value="1" name="quantity" id="quantity-input">
                                <button class="btn btn-outline-primary" type="button" id="btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <input type="hidden" name="productId" value="{{ $sp->id }}">
                        </div>
                        {{-- <input type="hidden" name="variantId" id="id_variant" value="{{ $sp->id }}"> --}}
                        <button type="submit" class="btn btn-primary ms-4 addToCart">Thêm vào giỏ hàng</button>
                    </div>
                </form>

                <div class="d-flex pt-2">
                    <strong class="text-dark mr-2">Chia sẻ:</strong>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
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
                    <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Mô tả sản phẩm</a>
                    <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Chi tiết sản phẩm</a>
                    <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">{{ $product->review ? $product->review->count() : 0 }} đánh giá</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <p class="mb-4">{!! $sp->description !!}</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <p class="mb-3" style="font-weight: bold"> Instinct Pharmacy > {{ $sp->category->name }} > {{ $sp->name }}</p>
                        <p class="mb-4">{!! nl2br(e($sp->content)) !!}</p>
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                    </li>
                                  </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                    </li>
                                  </ul>
                            </div>
                        </div> --}}
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">
                                    {{ $product->review ? $product->review->count() : 0 }} đánh giá cho "{{ $product->name }}"
                                </h4>
                                    @foreach($product->review as $review)
                                        <div class="media mb-4">
                                            <img src="{{ asset('upload/' . $review->user->image) }}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px; height:55px">
                                            <div class="media-body">
                                                <h6>{{ $review->user->name }}<small> - <i>{{ $review->created_at->format('d M Y') }}</i></small></h6>
                                                <div class="text-primary mb-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                    @endfor
                                                </div>
                                                <p>{{ $review->comment }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                            </div>
                            <div class="col-md-6">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                @if($canReview)
                                    {{-- <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        <div class="text-primary">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div> --}}
                                    <form action="{{ route('reviews.store', ['productId' => $sp->id, 'billId' => $billId]) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="rating">Your Rating *</label>
                                            <select name="rating" class="form-control" required>
                                                <option value="">Choose rating</option>
                                                <option value="5">5 Stars</option>
                                                <option value="4">4 Stars</option>
                                                <option value="3">3 Stars</option>
                                                <option value="2">2 Stars</option>
                                                <option value="1">1 Star</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Your Review *</label>
                                            <textarea id="message" name="comment" cols="30" rows="5" class="form-control" required></textarea>
                                        </div>
                                        @if(auth()->check())
                                            <div class="form-group">
                                                <label for="name">Your Name *</label>
                                                <input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Your Email *</label>
                                                <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" readonly>
                                            </div>
                                        @endif
                                        <div class="form-group mb-0">
                                            <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                        </div>
                                    </form>
                                    @else
                                <p class="text-warning">You need to purchase this product to leave a review.</p>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản phẩm tương tự</span></h2>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach($splq as $s)
                @php $tt = $s->price - (($s->price * $s->discount) / 100); @endphp
                <div class="product-item bg-light">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset('upload/'.$s->img) }}" alt="">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href="{{ route('cart.listCart') }}"><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                            <a class="btn btn-outline-dark btn-square" href="{{ route('productDetail', $s->id) }}"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="{{ route('productDetail', $s->id) }}"
                            style="max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" >
                            {{ $s->name }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5 class="text-danger">{{ number_format($tt, 0, ",", ".") }} VND</h5><h6 class="text-muted ml-2"><del>{{ number_format($s->price, 0, ',', '.') }} VNĐ</del></h6>
                            <p class="discount text-danger mb-0">-{{ $s->discount ?? 0 }}%</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light">
                            <a href="{{ route('productDetail', $s->id) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <form action="{{ route('cart.addCart') }}" method="post">
                                @csrf
                                    <input type="hidden" name="quantity" value="1">
                                   <input type="hidden" name="productId" value="{{ $s->id }}">
                                <input type="submit" value="Add To Cart" class="btn btn-sm text-dark p-0" name="addtocart"><i class="fas fa-shopping-cart text-primary mr-1"></i>
                            </form>
                          </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            @php
                            $averageRating = round($s->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
                            $reviewCount = $s->review_count ?? 0; // mặc định 0 nếu không có
                        @endphp

                        @for ($i = 1; $i <= 5; $i++)
                            <small class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
                        @endfor

                        <small>({{ $reviewCount }})</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Products End -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('add-to-cart-form');
    const quantityInput = document.getElementById('quantity-input');

    form.addEventListener('submit', function(e) {
        var value = parseInt(quantityInput.value, 10);
        if (isNaN(value) || value < 1) {
            alert('Quantity must be a number >= 1');
            quantityInput.value = 1; // Reset giá trị về 1
            e.preventDefault(); // Ngăn không cho form submit
        }
    });

    // Existing code for plus/minus buttons
    const btnPlus = document.getElementById('btn-plus');
    const btnMinus = document.getElementById('btn-minus');

    btnPlus.addEventListener('click', function() {
        quantityInput.value = parseInt(quantityInput.value) + 1;
    });

    btnMinus.addEventListener('click', function() {
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    });

    // Existing change event to handle manual input
    $('#quantity-input').on('change', function(){
        var value = parseInt($(this).val(), 10);
        if (isNaN(value) || value < 1) {
            alert('Quantity must be a number >= 1');
            $(this).val(1);
        }
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const variantBoxes = document.querySelectorAll('.variant-box');
    variantBoxes.forEach(box => {
        box.addEventListener('click', () => {
            variantBoxes.forEach(b => b.classList.remove('selected')); // Xóa chọn ô khác
            box.classList.add('selected'); // Thêm lớp 'selected' vào ô nhấn
        });
    });
});
</script>
<script>
    var id_variant = '';
    $(document).ready(function () {
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        $(".variant-box").click(function (e) { 
            e.preventDefault();
                let namePakeges = $(this).html();
                $.ajax({
                    type: "GET",
                    url: "/get-price-quantity-vp",
                    data: {
                        namePakeges:namePakeges,
                    },
                    success: function (response) {
                        let price = response.price;
                        let quantity = response.quantity;
                        id_variant = response.id_variant,
                        $("#price").text(price);
                        $(".quantity").text(quantity);
                        $("#id_variant").val(id_variant);
                        
                    }
                });
                
        });
        // $(".addToCart").click(function (e) { 
        //     e.preventDefault();
        //     $.ajax({
        //         type: "POST",
        //         url: "/addCart",
        //         data: {
        //             id_variant:id_variant,
        //         },
        //         dataType: "dataType",
        //         success: function (response) {
        //             console.log('Gửi Thành Công');
                    
        //         }
        //     });
        // });
    });
</script>
@endsection
