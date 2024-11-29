@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    #img {
        height: 300px;
        width: 100%;
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
</style>
<!-- Products Start -->
<div class="container-fluid pt-5">
    <!-- Title -->
    <div class="text-center mb-4">
        <h2 class="section-title px-5">
            <span class="px-2">Products</span>
        </h2>
    </div>

    <!-- Search & sort -->
    <div class="row px-xl-5 pb-3">
        <!-- Search & sort -->
        <div class="col-12 pb-1">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <!-- Search -->
                <form action="index.php?act=search_pro" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search by name" name="kyw" />
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <!-- <i class="fa fa-search"></i> -->
                                <input type="submit" class="btn btn-primary" value="SEARCH" name="search">
                            </span>
                        </div>
                    </div>
                </form>
                <!-- Sort -->
                <div class="dropdown ml-4">
                    <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

    <div class="row px-xl-5 pb-3">
        <!-- Product -->
        @foreach ($products as $item)
        @php $variant = $item->variantProduct->first();
                              $tt = $variant->price - (($variant->price  * $item['discount']) / 100); @endphp
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
</div>
<!-- Products End -->
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
