@component('mail::message')
    # Order Confirmation

     Hello {{ $bill->nameUser }},

     Thank you for your order. This is infor your order:

     *** Code Order *** {{ $bill->billCode }}.

     *** Products ***
     @foreach($bill->order_detail as $ct)
              - {{ $ct->product->name }} x {{ $ct->quantity }} : {{ number_format($ct->totalMoney) }} $
     @endforeach

     *** Total *** {{ number_format($bill->totalPrice) }} $

     *** We will contact you as soon as possible to confirm the order ***

     *** Thank you for your purchase from us  ***

     Best regards,
     {{ config('app.name') }}

@endcomponent
