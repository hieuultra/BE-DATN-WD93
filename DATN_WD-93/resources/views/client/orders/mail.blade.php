{{-- @component('mail::message')
<div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; font-size: 16px;">
    <h1 style="color: #2c3e50; font-family: Verdana, sans-serif;">Xác nhận đơn hàng</h1>
    Xin chào {{ $bill->nameUser }}

    Cảm ơn bạn đã đặt hàng! Dưới đây là thông tin đơn hàng của bạn:

    Chi tiết đơn hàng:

    Mã đơn hàng:{{ $bill->billCode }}

    Sản phẩm
        @foreach($bill->order_detail as $ct)
            {{ $ct->product->name }}
            Số lượng: {{ $ct->quantity }}
            Giá: {{ number_format($ct->totalMoney) }} ₫
                            @php
                             $variant = $ct->productVariant;
                            @endphp
            @if($variant)
            Loại:
                    {{ $variant->variantPackage->name }}

            @endif

        @endforeach

    Tổng cộng:
    {{ number_format($bill->totalPrice) }} ₫

    Chúng tôi sẽ giao hàng cho bạn sớm nhất có thể. Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi!

    Cảm ơn bạn đã mua hàng! Chúng tôi hy vọng được phục vụ bạn lần nữa.

    Trân trọng,
    {{ config('app.name') }}
</div>
@endcomponent --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #2c3e50;
            color: #fff;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 18px;
            color: #e74c3c;
        }
        .fee-details {
            white-space: pre-wrap; /* Cho phép xuống dòng */
            text-align: right; /* Căn phải cho cột */
        }
    </style>
</head>
<body>
    <h1>Xác nhận đơn hàng</h1>
    <p>Xin chào <strong>{{ $bill->email }}</strong>,</p>

    <p>Cảm ơn bạn đã đặt hàng! Dưới đây là thông tin chi tiết đơn hàng của bạn:</p>

    <table>
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th style="text-align: center;">Số lượng</th>
                <th style="text-align: right;">Giá</th>
                <th style="text-align: right;">Loại</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill->order_detail as $detail)
            <tr>
                <td>{{ $detail->product->name }}</td>
                <td style="text-align: center;">{{ $detail->quantity }}</td>
                <td style="text-align: right;">{{ number_format($detail->totalMoney) }} ₫</td>
                <td style="text-align: right;">
                    @if($detail->productVariant && $detail->productVariant->variantPackage)
                        {{ $detail->productVariant->variantPackage->name }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
     <!-- Phí vận chuyển và giảm giá -->
     <table>
        <tbody>
            <tr>
                <td colspan="2" class="fee-details">Phí vận chuyển:</td>
                <td style="text-align: right;">40.000 ₫</td>
            </tr>
            <tr>
                <td colspan="2" class="fee-details">Giảm giá đơn:</td>
                <td style="text-align: right;">-{{ number_format($bill->moneyShip, 0, ',', '.') }} ₫</td>
            </tr>
        </tbody>
    </table>

    <p class="total">Tổng cộng: {{ number_format($bill->totalPrice) }} ₫</p>

    <p>Chúng tôi sẽ giao hàng cho bạn sớm nhất có thể. Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi!</p>

    <p>Trân trọng,<br><strong>Instinct Pharmacy</strong></p>
</body>
</html>

