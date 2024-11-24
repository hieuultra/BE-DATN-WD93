@extends('admin.layout')
@section('titlepage','')

@section('content')

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Chi tiết đơn hàng</h1>
        {{-- <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.bills.index') }}">List Bills</a></li>
            <li class="breadcrumb-item active">Order Details</li>
        </ol> --}}

        <!-- Order Details -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-1"></i>
                Chi tiết đơn hàng
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <th>Thông tin người đặt hàng</th>
                        <th>Thông tin người nhận</th>
                    </thead>
                      <tbody>
                        <tr>
                            <td>
                                  <ul>
                                    <li>Tên: <b>{{ $bill->user->name }}</b></li>
                                    <li>Email: <b>{{ $bill->user->email }}</b></li>
                                    <li>Số điện thoại: <b>{{ $bill->user->phone }}</b></li>
                                    <li>Địa chỉ: <b>{{ $bill->user->address }}</b></li>
                                    <li>Vai trò: <b>{{ $bill->user->role }}</b></li>
                                  </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>Tên: <b>{{ $bill->nameUser }}</b></li>
                                    <li>Email: <b>{{ $bill->emailUser }}</b></li>
                                    <li>Số điện thoại: <b>{{ $bill->phoneUser }}</b></li>
                                    <li>Địa chỉ: <b>{{ $bill->addressUser }}</b></li>
                                    <li>Trạng thái đơn hàng: <b>{{ $statusBill[$bill->status_bill]}}</b></li>
                                    <li>Trạng thái thanh toán: <b>{{ $statusPaymentMethod[$bill->status_payment_method]}}</b></li>
                                    <li>Tổng hàng: <b>{{ number_format($bill->moneyProduct,0,',','.') }}VND</b></li>
                                    <li>Phí vận chuyển: <b>40.000VND</b></li>
                                    <li>Giảm giá: <b>{{ number_format($bill->moneyShip,0,',','.') }}VND</b></li>
                                    <li>Tổng tiền: <b class="fs-5 text-danger">{{ number_format($bill->totalPrice,0,',','.') }}VND</b></li>
                                </ul>
                            </td>
                        </tr>
                      </tbody>
                </table>
            </div>
        </div>

        <!-- Products in Order -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-box me-1"></i>
                Sản phẩm
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Tên</th>
                            <th>Ảnh</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Tổng giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bill->order_detail as $detail)
                            @php
                                $product= $detail->product;
                            @endphp
                            <tr>
                                <td>{{ $product->idProduct }}</td>
                                <td>{{ $product->name }}</td>
                                <td><img class="img-fluid" src="{{ asset('upload/'.$product->img) }}" width="75px"></td>
                                <td>{{ number_format($detail->unitPrice,0,',','.') }}VND</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->totalMoney,0,',','.') }}VND</td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
                <a href="{{ route('admin.bills.index') }}">
                    <input type="button" class="btn btn-primary" value="Danh sách đơn hàng">
                      </a>
            </div>
        </div>
    </div>
</main>


@endsection
