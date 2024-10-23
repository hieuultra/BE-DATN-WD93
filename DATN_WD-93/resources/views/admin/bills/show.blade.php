@extends('admin.layout')
@section('titlepage','')

@section('content')

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Order Details</h1>
        {{-- <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.bills.index') }}">List Bills</a></li>
            <li class="breadcrumb-item active">Order Details</li>
        </ol> --}}

        <!-- Order Details -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-1"></i>
                Order Details
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <th>Order Account Information</th>
                        <th>Consignee Information</th>
                    </thead>
                      <tbody>
                        <tr>
                            <td>
                                  <ul>
                                    <li>Name Account: <b>{{ $bill->user->name }}</b></li>
                                    <li>Email Account: <b>{{ $bill->user->email }}</b></li>
                                    <li>Phone Account: <b>{{ $bill->user->phone }}</b></li>
                                    <li>Address Account: <b>{{ $bill->user->address }}</b></li>
                                    <li> Role Account: <b>{{ $bill->user->role }}</b></li>
                                  </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>Name User: <b>{{ $bill->nameUser }}</b></li>
                                    <li>Email User: <b>{{ $bill->emailUser }}</b></li>
                                    <li>Phone User: <b>{{ $bill->phoneUser }}</b></li>
                                    <li>Address User: <b>{{ $bill->addressUser }}</b></li>
                                    <li>Status Bill: <b>{{ $statusBill[$bill->status_bill]}}</b></li>
                                    <li>Status Payment Method: <b>{{ $statusPaymentMethod[$bill->status_payment_method]}}</b></li>
                                    <li>Money Product: <b>{{ number_format($bill->moneyProduct,0,',','.') }}$</b></li>
                                    <li>Money Ship: <b>{{ number_format($bill->moneyShip,0,',','.') }}$</b></li>
                                    <li>Total Price: <b class="fs-5 text-danger">{{ number_format($bill->totalPrice,0,',','.') }}$</b></li>
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
                Products in Order
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bill->order_detail as $detail)
                            @php
                                $product= $detail->product;
                            @endphp
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td><img class="img-fluid" src="{{ asset('upload/'.$product->img) }}" width="75px"></td>
                                <td>{{ number_format($detail->unitPrice,0,',','.') }}$</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->totalMoney,0,',','.') }}$</td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
                <a href="{{ route('admin.bills.index') }}">
                    <input type="button" class="btn btn-primary" value="List Bills">
                      </a>
            </div>
        </div>
    </div>
</main>


@endsection
