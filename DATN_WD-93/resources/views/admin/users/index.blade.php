@extends('admin.layout')

{{-- @section('title')
    {{ $title }}
@endsection --}}

@section('css')
@endsection

@section('content')
    <style>
        /* Font cho phần tiêu đề (heading) */
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
                {{-- <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users.create') }}" class="btn"
                        style="background-color: #0072bc; color: white !important;"s> <i class="fas fa-plus me-2"></i>Thêm
                        người dùng</a>
                </div> --}}
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
                                        {{-- <select name="searchRole" class="form-control" style="height: 38px;">
                                            <option value="" selected disabled>Lọc quyền</option>
                                            <option value="all" {{ request('searchStatus') == '2' ? 'selected' : '' }}>
                                                Tất cả</option>
                                            <option value="Admin" {{ request('searchRole') == 'Admin' ? 'selected' : '' }}>
                                                Người quản lý</option>
                                            <option value="Pharmacist"
                                                {{ request('searchRole') == 'Pharmacist' ? 'selected' : '' }}>Nhân viên bán
                                                thuốc</option>
                                            <option value="Doctor"
                                                {{ request('searchRole') == 'Doctor' ? 'selected' : '' }}>Bác sỹ</option>
                                        </select> --}}

                                        <select name="searchStatus" class="form-control"
                                            style="height: 38px; margin-left: 5px">
                                            <option value="" disabled selected>Chọn trạng thái</option>
                                            <option value="2" {{ request('searchStatus') == '2' ? 'selected' : '' }}>
                                                Tất cả</option>
                                            <option value="1" {{ request('searchStatus') == '1' ? 'selected' : '' }}>
                                                Hoạt động</option>
                                            <option value="0" {{ request('searchStatus') == '0' ? 'selected' : '' }}>
                                                Đã hủy</option>
                                        </select>
                                        <input class="form-control" type="search" name="search"
                                            value="{{ request('search') }}" placeholder="Tìm kiếm"
                                            style="height: 38px; margin-left: 15px; width: 200%;">
                                        <button class="btn btn-outline-primary" type="submit"
                                            style="height: 38px;margin-left: 5px; width: 100%;background-color: #0072bc; color: white !important; ">Tìm
                                            kiếm</button>
                                    </form>
                                </div>
                            </div>

                        </div><!-- end card header -->


                        <div class="card-body">
                            <div class="table-responsive">

                                {{-- @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('warning'))
                                    <div class="alert alert-danger">
                                        {{ session('warning') }}
                                    </div>
                                @endif --}}

                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Ảnh</th>
                                            <th scope="col">Họ và tên</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Địa chỉ</th>
                                            <th scope="col">Số điện thoại</th>
                                            <th scope="col">Đơn hàng</th>
                                            <th scope="col">Lịch sử khám</th>
                                            <th scope="col">Bình luận</th>
                                            {{-- <th scope="col">Quyền</th> --}}
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $index => $item)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>

                                                    <div class="mt-2">
                                                        @if ($item->image)
                                                            <img src="{{ asset('storage/' . $item->image) }}"
                                                                alt="Ảnh đại diện"
                                                                style="max-width: 40px; max-height: 40px; border-radius: 15px">
                                                        @else
                                                            <img src="{{ asset('storage/uploads/avatar/avatar.png') }}"
                                                                alt="Ảnh đại diện"
                                                                style="max-width: 40px; max-height: 40px; border-radius: 15px">
                                                        @endif
                                                    </div>

                                                </td>
                                                <td> {{ $item->name }} </td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->address }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td><a href="{{ route('admin.bill.index', ['id' => $item->id]) }}"
                                                        class="btn">👁️‍🗨️</a>
                                                </td>
                                                <td><a href="{{ route('admin.users.edit', $item->id) }}"
                                                        class="btn">👁️‍🗨️</a>
                                                </td>
                                                <td><a href="{{ route('admin.users.edit', $item->id) }}"
                                                        class="btn">👁️‍🗨️</a>
                                                </td>
                                                {{-- <td>{{ $item->role }}</td> --}}
                                                <td>
                                                    @if ($item->deleted_at)
                                                        <span class="badge bg-danger">Đã hủy</span>
                                                    @else
                                                        <span class="badge bg-success">Hoạt động</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.users.edit', $item->id) }}" class="btn"
                                                        style="background-color: #0072bc; color: white !important;">Sửa</a>
                                                    {{-- <form action="{{ route('admin.users.destroy', $item->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="confirm('Bạn có muốn xóa sản phẩm không ')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            Hủy
                                                        </button>
                                                    </form> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <style>
                                    /* .pagination .page-link {
                                                                                                                                                            color: #0072bc !important;
                                                                                                                                                        } */

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
