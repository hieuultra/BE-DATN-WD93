@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Order</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

<div class="container-fluid pt-5">
    <form name="sentMessage" action="{{ route('orders.store') }}" method="POST" id="demoForm">
        @csrf
    <div class="row px-xl-5">
        <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Địa chỉ thanh toán</h4>
                    <h6>Bạn đã có tài khoản? <a href="{{ route('viewLogin') }}">Đăng nhập</a></h6>
                    <div class="row">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="col-md-6 form-group">
                            <label class="form-label"> Tên người nhận</label>
                            <input class="form-control" type="text" name="nameUser" placeholder="NameUser" value="{{ Auth::user()->name }}" />
                            @error('nameUser')
                                     <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email người nhận</label>
                            <input class="form-control" type="email" name="emailUser" placeholder="EmailUser" value="{{ Auth::user()->email }}" />
                            @error('emailUser')
                            <p class="text-danger">{{ $message }}</p>
                              @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại người nhận</label>
                            <input class="form-control" type="text" name="phoneUser" placeholder="Phone" value="{{ Auth::user()->phone }}" />
                            @error('phoneUser')
                            <p class="text-danger">{{ $message }}</p>
                              @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ người nhận</label>
                            <input class="form-control" type="text" name="addressUser" placeholder="Address" value="{{ Auth::user()->address }}" />
                            @error('addressUser')
                            <p class="text-danger">{{ $message }}</p>
                              @enderror
                        </div>
                    </div>
                </div>

                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0 text-dark">Phương thức thanh toán</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="paypal" value="1" checked>
                                <label class="form-check-label" for="paypal">
                                    Thanh toán khi nhận hàng
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="directcheck" value="2">
                                <label class="form-check-label" for="directcheck">
                                    Thanh toán qua MOMO
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="momo" value="4">
                                <label class="form-check-label" for="momo">
                                    Thanh toán qua thẻ tín dụng
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <input type="submit" value="Place Order" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">
                    </div>
                </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Chi tiết đơn hàng</h4>
                </div>
                <div class="card-body">
                    <h5 class="font-weight-medium mb-3">Sản phẩm</h5>
                    <div class="product-list">
                        @foreach($carts->items as $item)
                            <div class="product-item d-flex align-items-center mb-2">
                                <img src="{{ asset('upload/' . $item['image']) }}" height="50px" class="me-2">
                                <div class="product-info me-3">
                                    <a href="{{ route('productDetail', $item->product_id) }}"><p class="mb-0">{{ $item['name'] }}</p></a>
                                    <p class="mb-0">{{ number_format($item['price'] * $item['quantity'],0,',','.') }}VND</p>
                                </div>
                                <span class="text-muted">x {{ $item['quantity'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <hr class="mt-0" />
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Tạm tính</h6>
                        <h6 class="font-weight-medium">{{ number_format($subTotal,0,',','.') }}VND</h6>
                        <input type="hidden" name="moneyProduct" value="{{ $subTotal }}">
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Vận chuyển</h6>
                        <h6 class="font-weight-medium">{{ number_format($shipping,0,',','.') }}VND</h6>
                        <input type="hidden" name="moneyShip" value="{{ $shipping }}">
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Tổng</h5>
                        <h5 class="font-weight-bold">{{ number_format($total,0,',','.') }}VND</h5>
                        <input type="hidden" name="totalPrice" value="{{ $total }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>

<style>
    .product-list {
        display: flex;
        flex-direction: column;
    }
    .product-item {
        display: flex;
        align-items: center;
    }
    .product-item img {
        margin-right: 10px;
    }
    .product-item .product-info {
        flex: 1;
    }
</style>

@endsection
