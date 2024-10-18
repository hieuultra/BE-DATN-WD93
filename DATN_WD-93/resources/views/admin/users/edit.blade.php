@extends('admin.layout')

@section('title')
    {{ $title }}
@endsection

@section('css')
@endsection

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Chỉnh sửa người dùng</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center"
                            style="background-color: rgb(237, 245, 255)">
                            <h5 class="card-title mb-0">{{ $title }}</h5>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-success"
                                style="border-radius: 5px;background-color: #0072bc; color: white !important; border: none; margin-right: 10px"><i
                                    class="fas fa-arrow-left me-2"></i> Quay
                                lại trang danh sách </a>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form action="{{ route('admin.users.update', $user->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Thêm phương thức PUT để cập nhật -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">🙍 Họ và Tên:</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name', $user->name) }}"
                                                placeholder=" Nhập họ và tên (Bắt buộc)" required>
                                            @error('name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">📧 Email:</label>
                                            <input type="text" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', $user->email) }}" placeholder="Nhập địa chỉ Email">
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">🖼️ Ảnh đại diện:</label>
                                            @if ($user->image != null)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $user->image) }}" alt="Ảnh đại diện"
                                                        style="max-width: 80px; max-height: 80px;">
                                                </div>
                                            @endif
                                            <input type="file" name="image" class="form-control"
                                                value="{{ old('image') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">☎️ Số điện thoại:</label>
                                            <input type="text" name="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone', $user->phone) }}"
                                                placeholder="Nhập số điện thoại (Bắt buộc)" required>
                                            @error('phone')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">🚩 Địa chỉ:</label>
                                            <input type="text" name="address"
                                                class="form-control @error('address') is-invalid @enderror"
                                                value="{{ old('address', $user->address) }}" placeholder="Nhập địa chỉ">
                                            @error('address')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="role" class="form-label">👔 Chức vụ:</label>
                                            <select name="role" class="form-select @error('role') is-invalid @enderror">
                                                <option value="" disabled
                                                    {{ old('role', $user->role) ? '' : 'selected' }}>-- Chọn
                                                    chức vụ (Bắt buộc) --</option>
                                                <option value="Pharmacist"
                                                    {{ old('role', $user->role) == 'Pharmacist' ? 'selected' : '' }}>Nhân
                                                    viên bán thuốc
                                                </option>
                                                <option value="Doctor"
                                                    {{ old('role', $user->role) == 'Doctor' ? 'selected' : '' }}>Bác
                                                    sỹ</option>
                                                <option value="Admin"
                                                    {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Người
                                                    quản lý</option>
                                            </select>
                                            @error('role')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-center ">
                                        <button type="submit"
                                            style="border-radius: 5px;background-color: #0072bc; color: white !important; border: none; margin-top: 30px"
                                            class="btn btn-primary">Cập nhật tài khoản</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
    </div>
@endsection
