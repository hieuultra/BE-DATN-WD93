@component('mail::message')
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
@endcomponent
