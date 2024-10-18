@extends('admin.layout')

@section('css')
@endsection

@section('content')
    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .card-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        body,
        p,
        table,
        input,
        button {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
        }

        .btn {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
        }
    </style>
    <div class="content">
        <div class="container-xxl">
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Quản lý người dùng</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row w-100">
                                <div class="col-6">
                                    <h5 class="card-title mt-1">{{ $title }}</h5>
                                </div>
                                <div class="col-6">
                                    <form method="GET" action="{{ route('admin.users.index') }}"
                                        class="d-flex align-items-center">
                                        <select name="searchStatus" class="form-control"
                                            style="height: 38px; margin-left: 5px">
                                            <option value="" disabled selected>Chọn trạng thái</option>
                                            <option value="2" {{ request('searchStatus') == '2' ? 'selected' : '' }}>
                                                Tất cả</option>
                                            <option value="1" {{ request('searchStatus') == '1' ? 'selected' : '' }}>
                                                Hoạt động</option>
                                            <option value="0" {{ request('searchStatus') == '0' ? 'selected' : '' }}>Đã
                                                hủy</option>
                                        </select>
                                        <input class="form-control" type="search" name="search"
                                            value="{{ request('search') }}" placeholder="Tìm kiếm"
                                            style="height: 38px; margin-left: 15px; width: 200%;">
                                        <button class="btn btn-outline-primary" type="submit"
                                            style="height: 38px;margin-left: 5px; width: 100%;background-color: #0072bc; color: white !important;">Tìm
                                            kiếm</button>
                                    </form>
                                </div>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Tổng giá</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Địa chỉ</th>
                                            <th scope="col">Số điện thoại</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Thanh toán</th>
                                            <th scope="col">Giá sản phẩm</th>
                                            <th scope="col">Số lượng</th>
                                            <th scope="col">Tiền ship</th>
                                            <th scope="col">Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $index => $item)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ $item->totalPrice }}</td>
                                                <td> {{ $item->status }}</td>
                                                <td>{{ $item->addressUser }}</td>
                                                <td>{{ $item->phoneUser }}</td>
                                                <td>{{ $item->emailUser }}</td>
                                                <td>{{ $item->statusPaymentMethod }}</td>
                                                <td>{{ $item->moneyProduct }}</td>
                                                <td>{{ $item->moneyShip }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>
                                                    <a href="{{ route('admin.users.edit', $item->id) }}" class="btn"
                                                        style="background-color: #0072bc; color: white !important;">Sửa</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <style>
                                    .pagination .page-item.active .page-link {
                                        background-color: #0072bc !important;
                                        border-color: #0072bc !important;
                                    }

                                    .pagination .page-link:hover {
                                        background-color: #005f9e !important;
                                        border-color: #005f9e !important;
                                        color: white;
                                    }
                                </style>

                                <div class="mt-3 d-flex justify-content-center">
                                    {{ $data->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
@endsection

@section('js')
@endsection
