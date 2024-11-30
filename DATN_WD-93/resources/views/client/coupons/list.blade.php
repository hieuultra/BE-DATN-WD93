@extends('layout')
@section('titlepage', 'Instinct - Instinct Pharmacy System')
@section('title', 'Welcome')

@section('content')

<style>
    .pro-quantity {
        text-align: center;
        /* Center horizontally */
    }

    .quantity-container {
        display: inline-flex;
        align-items: center;
        /* Center vertically */
        justify-content: center;
        /* Center horizontally */
    }
</style>
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-12 table-responsive mb-5">
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
            <h1 class="text-center mb-4">Mã giảm giá cho bạn</h1>

<table class="table table-bordered" style="">
    <thead>
        <tr>
            <th class="pro-thumbnail" style="text-align: center">Mã</th>
            <th class="pro-title" style="text-align: center">Giảm giá:</th>
            <th class="pro-title" style="text-align: center">Hạn dùng:</th>
            <th class="pro-remove" style="text-align: center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach ($cart as $key => $item) --}}
        @foreach ($coupons as $coupon)
            <tr>
                <td class="pro-title" style="text-align: center">
                    {{ $coupon->code }}
                </td>
                <td class="pro-title" style="text-align: center">
                    @if ($coupon->type == 'fixed')
                        {{ number_format($coupon->value, 0, ',', '.') }} VNĐ
                    @else
                        {{ $coupon->value }}%
                    @endif
                </td>
                <td class="pro-price" style="text-align: center">
                    {{ $coupon->expiry_date }}
                </td>
                <td class="pro-subtotal" style="text-align: center"><button class="btn btn-primary" onclick="copyToClipboard('{{ $coupon->code }}')">Sao chép mã</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
        </div>
    </div>

<script>
    function copyToClipboard(code) {
        navigator.clipboard.writeText(code).then(() => {
            alert('Đã sao chép mã: ' + code);
        });
    }
</script>


@endsection
