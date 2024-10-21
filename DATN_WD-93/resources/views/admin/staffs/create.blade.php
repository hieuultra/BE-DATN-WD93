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
                    <h4 class="fs-18 fw-semibold m-0">Quản lý nhân viên</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center"
                            style="background-color: rgb(237, 245, 255)">
                            <h5 class="card-title mb-0">{{ $title }}</h5>
                            <a href="{{ route('admin.staffs.index') }}" class="btn btn-success"
                                style="border-radius: 5px;background-color: #0072bc; color: white !important; border: none; margin-right: 10px"><i
                                    class="fas fa-arrow-left me-2"></i> Quay
                                lại trang danh sách </a>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form action="{{ route('admin.staffs.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="trang_thai" class="form-label">🙍 Họ và Tên:</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid   @enderror"
                                                value="{{ old('name') }}" placeholder=" Nhập họ và tên (Bắt buộc)"
                                                required>
                                            @error('name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="trang_thai" class="form-label">📧 Email:</label>
                                            <input type="text" name="email"
                                                class="form-control @error('email') is-invalid   @enderror"
                                                value="{{ old('email') }}" placeholder="Nhập địa chỉ Email">
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="trang_thai" class="form-label">🔑 Mật khẩu:</label>
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid   @enderror"
                                                value="{{ old('password') }}" placeholder="Nhập mật khẩu (Bắt buộc)"
                                                required>
                                            @error('password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">🔓 Xác nhận mật
                                                khẩu:</label>
                                            <input type="password" name="password_confirmation"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                placeholder="Nhập lại mật khẩu (Bắt buộc)" required>
                                            @error('password_confirmation')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>





                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="trang_thai" class="form-label">☎️ Số điện thoại:</label>
                                            <input type="text" name="phone"
                                                class="form-control @error('phone') is-invalid   @enderror"
                                                value="{{ old('phone') }}" placeholder="Nhập số điện thoại (Bắt buộc)"
                                                required>
                                            @error('phone')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="trang_thai" class="form-label">🚩 Địa chỉ:</label>
                                            <input type="text" name="address"
                                                class="form-control @error('address') is-invalid   @enderror"
                                                value="{{ old('address') }}" placeholder="Nhập địa chỉ">
                                            @error('address')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="trang_thai" class="form-label">👔 Chức vụ:</label>
                                            <select name="role" class="form-select @error('role') is-invalid @enderror">
                                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Chọn
                                                    chức vụ (Bắt buộc) --</option>
                                                <option value="Pharmacist"
                                                    {{ old('role') == 'Pharmacist' ? 'selected' : '' }}>Nhân viên bán thuốc
                                                </option>
                                                <option value="Doctor" {{ old('role') == 'Doctor' ? 'selected' : '' }}>Bác
                                                    sỹ</option>
                                                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Người
                                                    quản lý</option>
                                            </select>
                                            @error('role')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="trang_thai" class="form-label">🖼️ Ảnh đại diện:</label>
                                            <input type="file" name="image" class="form-control"
                                                value="{{ old('image') }}" placeholder="Nhập mật khẩu (Bắt buộc)">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center ">
                                        <button type="submit"
                                            style="border-radius: 5px;background-color: #0072bc; color: white !important; border: none; margin-top: 30px"
                                            class="btn btn-primary">Tạo mới tài khoản</button>
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
