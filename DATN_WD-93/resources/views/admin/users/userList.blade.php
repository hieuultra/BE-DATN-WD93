@extends('admin.layout')
@section('titlepage', '')

@section('content')

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Danh sách tài khoản</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Bảng điều khiển</li>
            </ol>

            <!-- Data -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Danh sách tài khoản
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
                                <th>Mã</th>
                                <th>Tên</th>
                                <th>Địa chỉ</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>Ảnh</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    {{-- <td class="password-column">{{ $item->password }}</td> --}}
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td><img src="{{ asset('upload/' . $item->image) }}" height="150" width="300"
                                            alt=""></td>
                                    <td>{{ $item->role }}</td>
                                    <td>
                                        @if ($item->active == 1)
                                            Hoạt động
                                        @else
                                            Vô hiệu hóa
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->role == 'User')
                                            <a href=""
                                                class="btn {{ $item->active == 0 ? 'btn-success' : 'btn-danger' }}">
                                                <form action="{{ route('admin.users.userDestroy', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- Sử dụng @method('DELETE') trong đoạn mã nhằm mục đích gửi một yêu cầu HTTP DELETE từ form HTML.  --}}
                                                    <button style="background: none;  border: none; outline: none;"
                                                        type="submit"
                                                        onclick="return confirm('Bạn có chắc chắn muốn cập nhập?')">
                                                        @if ($item->active == 1)
                                                            Vô hiệu hóa
                                                        @else
                                                            Kích hoạt
                                                        @endif
                                                    </button>
                                                </form>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('admin.users.viewUserAdd') }}">
                        <input type="submit" class="btn btn-primary" name="them" value="Thêm Admin">
                    </a>

                </div>
            </div>
        </div>
    </main>

@endsection
