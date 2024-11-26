@extends('layout')
@section('titlepage', 'Instinct - Instinct Pharmacy System')
@section('title', 'Welcome')

@section('content')
    <style>
        #img {
            height: 300px;
            width: 100%;
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
    </style>

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Functional food</a>
                    <span class="breadcrumb-item active">Functional Food List</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="bg-secondary pr-3">Lọc theo khoảng giá</span>
                </h5>
                <div class="bg-light p-4 mb-30">
                    <form method="post" action="{{ route('products.filter') }}">
                        @csrf
                        <div class="custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="price[]" value="0-100000" id="price-1">
                            <label class="custom-control-label" for="price-1">0 VND - 100000 VND</label>
                        </div>
                        <div class="custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="price[]" value="100000-200000" id="price-2">
                            <label class="custom-control-label" for="price-2">100000 VND - 200000 VND</label>
                        </div>
                        <div class="custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="price[]" value="200000-300000" id="price-3">
                            <label class="custom-control-label" for="price-3">200000 VND - 300000 VND</label>
                        </div>
                        <div class="custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="price[]" value="300000-400000" id="price-4">
                            <label class="custom-control-label" for="price-4">300000 VND - 400000 VND</label>
                        </div>
                        <div class="custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="price[]" value="400000-500000" id="price-5">
                            <label class="custom-control-label" for="price-5">400000 VND - 500000 VND</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                    </form>
                </div>
                <!-- Price End -->

                <!-- Color Start -->
                {{-- <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Lọc theo phân loại</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form action="" method="">
                        <div class="custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="color-all">
                            <label class="custom-control-label" for="price-all">Tất cả phân loại</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-1">
                            <label class="custom-control-label" for="color-1">Black</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-2">
                            <label class="custom-control-label" for="color-2">White</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-3">
                            <label class="custom-control-label" for="color-3">Red</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-4">
                            <label class="custom-control-label" for="color-4">Blue</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="color-5">
                            <label class="custom-control-label" for="color-5">Green</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div> --}}
                <!-- Color End -->

                <!-- Size Start -->
                {{-- <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by size</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="size-all">
                            <label class="custom-control-label" for="size-all">All Size</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-1">
                            <label class="custom-control-label" for="size-1">XS</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-2">
                            <label class="custom-control-label" for="size-2">S</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-3">
                            <label class="custom-control-label" for="size-3">M</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-4">
                            <label class="custom-control-label" for="size-4">L</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="size-5">
                            <label class="custom-control-label" for="size-5">XL</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div> --}}
                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                                <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Latest</a>
                                        <a class="dropdown-item" href="#">Popularity</a>
                                        <a class="dropdown-item" href="#">Best Rating</a>
                                    </div>
                                </div>
                                <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Showing</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">10</a>
                                        <a class="dropdown-item" href="#">20</a>
                                        <a class="dropdown-item" href="#">30</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach ($products as $item)
                        @php $variant = $item->variantProduct->first();
                              $tt = $variant->price - (($variant->price  * $item['discount']) / 100); @endphp

                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100 tuan" src="{{ asset('upload/' . $item->img) }}"
                                        alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href="{{ route('cart.listCart') }}"><i
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
                                        {{ $item->name }}
                                    </a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5 class="text-danger"> {{ number_format($tt, 0, ',', '.') }} VND</h5>
                                        <h6 class="text-muted ml-2">@if ($item->variantProduct->isNotEmpty())
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
                                        <form action="" method="post">
                                            {{-- @csrf --}}
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="productId" value="{{ $item->id }}">
                                            <input type="button" data-id="{{ $item->id }}" value="Thêm vào giỏ"
                                                class="btn btn-sm text-dark p-0 addToCartShow" name="addtocart"><i
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
                    <div class="col-12 pb-1">
                        <nav aria-label="Page navigation">
                            <!-- Kiểm tra nếu đang ở trang đầu tiên -->
                            <ul class="pagination justify-content-center mb-3">
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}"
                                            aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                @endif

                                <!-- Tạo các liên kết trang -->
                                @foreach ($products->links()->elements[0] as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li class="page-item active"><a class="page-link"
                                                href="#">{{ $page }}</a></li>
                                    @else
                                        <li class="page-item"><a class="page-link"
                                                href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                <!-- Kiểm tra nếu còn trang sau -->
                                @if ($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            {{-- popup addtocart --}}

            <div id="overlay"></div>

            <div id="popup">
                {{-- NameProduct --}}
                <div style="display: flex; justify-content: space-between">
                    <span id="productName" style="color: black; font-weight: bold; font-size: 18px"></span>
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
                    <div class="col">
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
                                    <p id="quantity" style=" font-size: 14px; color: black; font-weight: bold;"></p>
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
                    <div class="col">
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
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
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
                $("#overlay").fadeOut(); // Ẩn nền mờ
                $("#popup").fadeOut(); // Ẩn popup
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
                        let total = response.total;
                        $("#price").text(price);
                        $("#quantity").text(quantity);
                        $("#total").text(total + 'VND');
                    }
                });
            });
            //active button
            $("#addToCart").click(function(e) {
                e.preventDefault();
                let quantity = $("#quantityAdd").val();
                let price = $("#price").html();
                let name = $("#productName").html();
                let img = $("#productImage").attr("src");
                let replaceImg = img.replace('/upload/', '');
                let replacePrice = price.replace('VNĐ', '');
                let newPrice = replacePrice.replace('.', '');
                console.log(id_variantProduct);
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
                        alert('Thêm thành công');
                        console.log("Thêm Sản Phẩm Vào Thành Công!!!");
                        // console.log(id_variantProduct);
                        // console.log(productId);
                        $('#count').text(response.count);
                    }
                });
            });
        });
    </script>
@endsection
