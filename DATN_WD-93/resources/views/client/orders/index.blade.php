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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Id Bill</th>
                    <th class="text-center">Date Order</th>
                    <th class="text-center">Status Bill</th>
                    <th class="text-center">Total Bill</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($Bills as $item)
                <tr>
                    <th class="text-center">
                        <a href="{{ route('orders.show', $item->id) }}">
                        {{ $item->id }}
                    </a>
                    </th>
                    <td class="text-center">
                        {{ $item->created_at->format('d-m-Y') }}
                    </td>
                    <td class="text-center" style="color: dodgerblue">
                        {{ $statusBill[$item->status_bill] }}
                    </td>
                    <td class="text-center">
                         {{ number_format($item->totalPrice,0,',','.') }}$
                    </td>
                    <td class="text-center">
                        <a href="{{ route('orders.show', $item->id) }}" class="btn btn-primary">View</a>
                        <form action="{{ route('orders.update', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            @if ($item->status_bill == $type_cho_xac_nhan)
                            <input type="hidden" name="da_huy" value="1">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure unset bill right?')">Unset</button>

                            @elseif ($item->status_bill == $type_dang_van_chuyen)
                            <input type="hidden" name="da_giao_hang" value="1">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you received the goods?')">Order received</button>

                            @endif

                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <div class="cart-update" style="float: right">
            <button type="submit" href="" class="btn btn-primary">Update Cart</button>
        </div> --}}
      </div>

    </div>
  </div>

@endsection
