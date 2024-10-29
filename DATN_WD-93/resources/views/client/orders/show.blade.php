@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .order-details {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        background-color: #f9f9f9;
    }
    .order-details h4 {
        margin-top: 0;
    }
    .order-details table {
        width: 100%;
        margin-bottom: 20px;
    }
    .order-details table th, .order-details table td {
        padding: 10px;
        text-align: left;
    }
    .order-details table thead th {
        background-color: #f2f2f2;
    }
</style>

<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-12">
            <div class="order-details">
                <h4>Order Details</h4>

                {{-- Thông tin đơn hàng --}}
                <div class="order-info">
                    <h5 class="text-center">Order Information</h5>
                    <table>
                        <tr>
                            <th class="text-center">Order Code:</th>
                            <td class="text-danger text-center">{{ $bill->billCode }}</td>
                        </tr>
                        <tr>
                            <th class="text-center">Consignee name :</th>
                            <td class="text-center">{{ $bill->nameUser }}</td>
                        </tr>
                        <tr>
                            <th class="text-center">Date Ordered:</th>
                            <td class="text-center">{{ $bill->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th class="text-center">Status Bill:</th>
                            <td class="text-center">{{ $statusBill[$bill->status_bill] }}</td>
                        </tr>
                        <tr>
                            <th class="text-center">Status_payment_method:</th>
                            <td class="text-center">{{ $status_payment_method[$bill->status_payment_method] }}</td>
                        </tr>
                        <tr>
                            <th class="text-center">Shipping Address:</th>
                            <td class="text-center">{{ $bill->addressUser }}</td>
                        </tr>
                        <tr>
                            <th class="text-center">Contact Number:</th>
                            <td class="text-center">{{ $bill->phoneUser }}</td>
                        </tr>
                        <tr>
                            <th class="text-center">Email:</th>
                            <td class="text-center">{{ $bill->emailUser }}</td>
                        </tr>
                        <tr>
                            <th class="text-center">Money Product:</th>
                            <td class="text-center">{{ number_format($bill->moneyProduct,0,',','.') }}$</td>
                        </tr>
                        <tr>
                            <th class="text-center">Money Ship:</th>
                            <td class="text-center">{{ number_format($bill->moneyShip,0,',','.') }}$</td>
                        </tr>
                        <tr>
                            <th class="text-center">Total Price:</th>
                            <td class="text-center">{{ number_format($bill->totalPrice,0,',','.') }}$</td>
                        </tr>
                    </table>
                </div>

                {{-- Chi tiết sản phẩm --}}
                <div class="order-items">
                    <h5>Order Items</h5>
                    <table>
                        <thead>
                            <tr>
                                <th>Product Code</th>
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
                                $product = $detail->product;
                            @endphp
                            <tr>
                                <td>{{ $product->idProduct }}</td>
                                <td><a href="{{ route('productDetail', $detail->product_id) }}">{{ $product->name }}</a></td>
                                <td><img class="img-fluid" src="{{ asset('upload/'.$product->img) }}" width="75px"></td>
                                <td>{{ number_format($detail->unitPrice,0,',','.') }}$</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->totalMoney,0,',','.') }}$</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Nút quay lại --}}
                <div class="mt-4">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Order History</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
