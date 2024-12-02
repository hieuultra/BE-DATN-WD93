@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .pro-quantity {
        text-align: center; /* Center horizontally */
    }
    .quantity-container {
        display: inline-flex;
        align-items: center; /* Center vertically */
        justify-content: center; /* Center horizontally */
    }
  /* Đảm bảo liên kết có gạch chân và màu sắc khác khi active */
    a.active {
        color: dodgerblue;  /* Màu chữ khi active */
        text-decoration: underline;  /* Gạch chân */
        font-weight: bold;  /* Đậm hơn một chút */
    }

    /* Khi hover vào liên kết (dù active hay không) */
    a:hover {
        color: #007bff;  /* Màu chữ khi hover */
        text-decoration: underline;  /* Gạch chân khi hover */
    }

</style>
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
      <div class="col-lg-12 table-responsive mb-5">
        {{-- Hiển thị thông báo --}}
        @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        </script>
        @endif

        @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Thất bại!',
                text: '{{ session('error') }}',
                confirmButtonText: 'Thử lại'
            });
        </script>
        @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <!-- Lấy tất cả đơn hàng và đánh dấu khi không có trạng thái lọc -->
                <th class="text-center">
                    <a href="{{ route('orders.index') }}" class="{{ request('status') == null ? 'active' : '' }}">Tất cả</a>
                </th>
                @foreach ($allStatusBill as $statusKey => $statusName)
                    <th class="text-center">
                        <a href="{{ route('orders.index', ['status' => $statusKey]) }}" class="{{ request('status') == $statusKey ? 'active' : '' }}">
                            {{ $statusName }}
                        </a>
                    </th>
                @endforeach
            </tr>
        </thead>
    </table>
    <!-- Tìm kiếm đơn hàng -->
    <form method="GET" action="{{ route('orders.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Bạn có thể tìm kiếm theo Mã đơn hàng hoặc Tên sản phẩm">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
        </div>
    </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Mã đơn hàng</th>
                    <th class="text-center">Thời gian đặt</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Tổng đơn</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bills as $item)
                <tr>
                    <th class="text-center">
                        <a href="{{ route('orders.show', $item->id) }}">
                        {{ $item->billCode }}
                    </a>
                    </th>
                    <td class="text-center">
                        {{ $item->created_at->format('d-m-Y') }}
                    </td>
                    <td class="text-center" style="color: dodgerblue">
                        {{ $statusBill[$item->status_bill] }}
                    </td>
                    <td class="text-center">
                         {{ number_format($item->totalPrice,0,',','.') }}VND
                    </td>
                    <td class="text-center">
                        <a href="{{ route('orders.show', $item->id) }}" class="btn btn-primary">Xem</a>
                        <form action="{{ route('orders.update', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            @if ($item->status_bill == $type_cho_xac_nhan && $item->status_payment_method !='da_thanh_toan')
                            <input type="hidden" name="da_huy" value="1">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">Hủy đơn</button>
                            @elseif ($item->status_bill == $type_dang_van_chuyen)
                            <input type="hidden" name="da_giao_hang" value="1">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Bạn có chắc đã nhận được hàng?')">Đã nhận hàng</button>
                            @endif
                        </form>
                        @if ($item->status_bill == $type_da_giao_hang || $item->status_bill == $type_da_huy || $item->status_bill == $type_khach_hang_tu_choi)
                        <form action="{{ route('cart.reorder', $item->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Mua lại</button>
                        </form>
                    @endif
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
