@extends('admin.layout')
@section('titlepage', 'Danh sách Đánh giá đã Xóa Mềm')

@section('content')
<style>
  .pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
  }
  .pagination a {
    margin: 0 5px;
    padding: 5px 10px;
    text-decoration: none;
    background-color: #316b7d;
    color: #fff;
    border-radius: 3px;
  }
  .pagination li {
    list-style-type: none;
  }
  table th,
  table td {
    word-wrap: break-word !important;
    white-space: normal !important;
    max-width: 150px !important;
  }
  td.product-name {
    max-width: 150px !important;
  }
</style>

<div class="container">
    <h1 class="mt-4 mb-4">Quản lý Đánh giá đã Xóa Mềm</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-trash-alt me-1"></i>
            Danh sách Đánh giá đã Xóa
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Mã</th>
                        <th class="text-center">Tên khách hàng</th>
                        <th class="text-center">Email</th>
                            <th class="text-center">Tên sản phẩm</th>
                            <th class="text-center">Sao</th>
                            <th class="text-center">Bình luận</th>
                            <th class="text-center">Ngày xóa</th>
                            <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listDeleted as $review)
                        <tr>
                            <td class="text-center">{{ $review->id }}</td>
                            <td class="text-center">{{ $review->user->name ?? 'Không xác định' }}</td>
                            <td class="text-center">{{ $review->user->email ?? 'Không xác định'}}</td>
                            <td class="text-center">{{ $review->product->name ?? 'Không xác định'}}</td>
                            <td class="text-center">{{ $review->rating }} / 5</td>
                            <td class="text-center">{{ $review->comment }}</td>
                            <td class="text-center">{{ $review->deleted_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.reviews.restore', $review->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có chắc muốn khôi phục không ?')">Khôi phục</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('admin.reviews.listReviews') }}" class="btn btn-primary btn-sm">Quay lại</a>
</div>
@endsection
