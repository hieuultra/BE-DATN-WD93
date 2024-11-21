@extends('admin.layout')
@section('titlepage','')

@section('content')

<main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">Danh sách mã giảm giá</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>

      <!-- Data -->
      <div class="card mb-4">

        {{-- hien thi tb success --}}

        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Danh sách mã giảm giá
        </div>
        <div class="card-body">
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
          <table id="datatablesSimple">
            <thead>
              <tr>
                <th>Mã giảm giá</th>
                <th>Giá trị</th>
                <th>Giá trị đơn hàng tối thiểu</th>
                <th>Ngày hết hạn</th>
                <th>Số lần sử dụng</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->code }}</td>
                    <td>{{ $coupon->value }} {{ $coupon->type == 'percentage' ? '%' : 'VND' }}</td>
                    <td>{{ $coupon->min_order_value }} VND</td>
                    <td>{{ $coupon->expiry_date }}</td>
                    <td>{{ $coupon->usage_limit  }}</td>
                    <td>{{ $coupon->is_active ? 'Đang hoạt động' : 'Không hoạt động' }}</td>
                    <td>
                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
          </table>
          <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">Thêm mã giảm giá</a>
        </div>
      </div>
    </div>
  </main>

@endsection