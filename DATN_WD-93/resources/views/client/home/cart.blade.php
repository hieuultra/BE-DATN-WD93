@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .pro-quantity {
        text-align: center; /* Center horizontally */
    }
    .quantity-container {
        display: inline-flex;
        align-items: center; /* Center vertically */
        justify-content: center; /* Center horizontally */
    }
</style>

   <!-- Breadcrumb Start -->
   <div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Shopping Cart</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->


<div class="container-fluid pt-5">
    <div class="row px-xl-5">
      <div class="col-lg-8 table-responsive mb-5">
        {{-- Hiển thị thông báo --}}
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if ($cart && $cart->items->count() > 0)
        <form action="{{ route('cart.updateCart') }}" method="POST">
            @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="pro-thumbnail">Ảnh</th>
                    <th class="pro-title">Sản phẩm</th>
                    <th class="pro-price">Giá</th>
                    <th class="pro-quantity">Số lượng</th>
                    <th class="pro-subtotal">Tổng</th>
                    <th class="pro-remove">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($cart as $key => $item) --}}
                @foreach ($cart->items as $item)
                <input type="hidden" name="id" value="{{ $item['id'] }}" id="">
                <tr>
                    <td class="pro-thumbnail"><a href="{{ route('productDetail',  $item->product_id) }}">
                        <img class="img-fluid" src="{{ asset('upload/'.$item['image']) }}" width="80" height="30" alt="Product" />
                        <input type="hidden" name="image" value="{{ $item['img'] }}" id="">
                    </a></td>
                    <td class="pro-title">
                        <a href="{{ route('productDetail',  $item->product_id) }}">{{ $item['name'] }}</a>
                        <input type="hidden" name="name" value="{{ $item['name'] }}" id="">
                    </td>
                    <td class="pro-price">
                        <span>{{ number_format($item['price'],0,',','.') }}VND</span>
                        <input type="hidden" name="price" value="{{ $item['price'] }}" id="">
                    </td>
                    <td class="pro-quantity">
                        <div class="d-flex align-items-center me-4">
                            <div class="input-group quantity-container" style="width: 130px;">
                                <button class="btn btn-outline-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <input type="text" class="form-control text-center quantity-input"
                                data-price="{{ $item['price'] }}" value="{{ $item['quantity'] }}" name="items[{{ $item['id'] }}][quantity]">
                                <button class="btn btn-outline-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="pro-subtotal"><span class="subtotal">{{  number_format($item['price'] * $item['quantity'],0,',','.') }} VND</span>
                        <input type="hidden" name="total"
                        value="{{ $item['price'] * $item['quantity'] }}">
                    </td>
                    <td class="pro-remove text-center" data-item-id="{{ $item['id'] }}"><a href="#"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <div class="cart-update" style="float: right">
            <button type="submit" href="" class="btn btn-primary">Update Cart</button>
        </div> --}}
    </form>
    @else
    <h3 style="text-align: center;color: rgb(222, 80, 80)">Giỏ hàng rỗng</h3>
   @endif
      </div>


      <div class="col-lg-4">
        <form class="mb-5" action="">
          <div class="input-group">
            <input type="text" class="form-control p-4" placeholder="Coupon Code" />
            <div class="input-group-append">
              <button class="btn btn-primary">Áp dụng mã giảm giá</button>
            </div>
          </div>
        </form>
        <div class="card border-secondary mb-5">
          <div class="card-header bg-secondary border-0">
            <h4 class="font-weight-semi-bold m-0">Tóm tắt giỏ hàng</h4>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between mb-3 pt-1">
              <h6 class="font-weight-medium">Tạm tính</h6>
              <h6 class="font-weight-medium subTotal">{{ number_format($subTotal,0,',','.') }}VND</h6>
            </div>
            <div class="d-flex justify-content-between">
              <h6 class="font-weight-medium">Vận chuyển</h6>
              <h6 class="font-weight-medium shipping">{{ number_format($shipping,0,',','.') }} VND</h6>
            </div>
          </div>
          <div class="card-footer border-secondary bg-transparent">
            <div class="d-flex justify-content-between mt-2">
              <h5 class="font-weight-bold">Tổng cộng</h5>
              <h5 class="font-weight-bold total_amount">{{ number_format($total,0,',','.') }} VND</h5>
            </div>
              <a href="{{ route('orders.create') }}" class="btn btn-block btn-primary my-3 py-3">
                Tiến hành thanh toán
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quản lý tất cả các phần tử nhập số lượng
        document.querySelectorAll('.quantity-container').forEach(function(container) {
            const quantityInput = container.querySelector('.quantity-input');
            const btnPlus = container.querySelector('.btn-plus');
            const btnMinus = container.querySelector('.btn-minus');

            btnPlus.addEventListener('click', function() {
                event.preventDefault();
                let currentValue = parseInt(quantityInput.value, 10);
                quantityInput.value = currentValue + 1;
                updateSubtotal(container);
                updateTotal();

                  // Gửi yêu cầu AJAX để cập nhật số lượng sản phẩm
                  updateCartAjax(); // Pass product ID and new quantity
            });

            btnMinus.addEventListener('click', function() {
                event.preventDefault();
                let currentValue = parseInt(quantityInput.value, 10);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                    updateSubtotal(container);
                    updateTotal();

                    // Gửi yêu cầu AJAX để cập nhật số lượng sản phẩm
                    updateCartAjax(); // Pass product ID and new quantity
                }
            });

        });

        function updateCartAjax() {
                var formData = $('form').serialize();
                $.ajax({
                    url: '/updateCart', // Đường dẫn xử lý cập nhật giỏ hàng
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Thông báo cập nhật thành công
                        console.log('Cart updated successfully');
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', xhr.responseText);
                        // Xử lý lỗi khi cập nhật giỏ hàng
                        alert('Error updating cart');
                    }
                });
            }

        function removeCartAjax(cartItemId) {
    $.ajax({
        url: '/removeCart',
        method: 'POST',
        data: {
            id: cartItemId, // Pass the cart item ID
            _token: '{{ csrf_token() }}' // Include CSRF token for security
        },
        success: function(response) {
            console.log('Product removed successfully:', response.message);
        },
        error: function(xhr, status, error) {
            console.log('Error:', xhr.responseText);
            alert('Error removing product');
        }
    });
}


        // Cập nhật subtotal cho từng sản phẩm
        function updateSubtotal(container) {
            const quantityInput = container.querySelector('.quantity-input');
            const price = parseFloat(quantityInput.dataset.price);
            const quantity = parseInt(quantityInput.value, 10);
            const subtotal = price * quantity;

            const subtotalElement = container.closest('tr').querySelector('.subtotal');
            subtotalElement.textContent = formatCurrency(subtotal);
        }

        // Định dạng tiền tệ với dấu chấm phân tách hàng nghìn và không có phần thập phân
        function formatCurrency(value) {
            const formatted = value.toFixed(0); // Làm tròn xuống số nguyên
            if (formatted.length > 3) {
                return formatted.replace(/\B(?=(\d{3})+(?!\d))/g, '.') +
                    ' VND'; // Thêm dấu chấm phân tách hàng nghìn
            }
            return formatted + ' VND'; // Trả về giá trị cho các số dưới 1000
        }

        // Xử lý khi người dùng nhập số âm
        document.querySelectorAll('.quantity-input').forEach(function(input) {
            input.addEventListener('change', function() {
                event.preventDefault();
                const value = parseInt(input.value, 10);
                if (isNaN(value) || value < 1) {
                    alert('Quantity must be a number >= 1');
                    input.value = 1;
                }
                updateSubtotal(input.closest('.quantity-container'));
                updateTotal();
                updateCartAjax();
            });
        });
        // Xử lý xóa sản phẩm trong giỏ hàng
document.querySelectorAll('.pro-remove').forEach(function(removeButton) {
    removeButton.addEventListener('click', function(event) {
        event.preventDefault();

        const row = this.closest('tr');
        const cartItemId = this.getAttribute('data-item-id'); // Get the ID of the item to remove

        // Remove the product from the UI
        row.remove();
        updateTotal();

        // Call the removeCartAjax function with the cart item ID
        removeCartAjax(cartItemId); // Pass the item ID to the function
    });
});

        // Hàm cập nhật tổng số
        function updateTotal() {
            let subTotal = 0;
            // Tính tổng các sản phẩm có trong giỏ hàng
            document.querySelectorAll('.quantity-input').forEach(function(input) {
                const price = parseFloat(input.dataset.price);
                const quantity = parseInt(input.value, 10);
                subTotal += price * quantity;
            });

            // Lấy số tiền vận chuyển
            const shipping = parseFloat(document.querySelector('.shipping').textContent.replace(/\./g, '')
                .replace(' VND', ''));
            const total = subTotal + shipping;

            // Cập nhật giá trị
            document.querySelector('.subTotal').textContent = formatCurrency(subTotal);
            document.querySelector('.total_amount').textContent = formatCurrency(total);
        }

        // Cập nhật tổng số khi trang được tải
        updateTotal();

    });
</script>


@endsection
