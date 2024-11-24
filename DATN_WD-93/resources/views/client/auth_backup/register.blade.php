@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
<style>
  label.error {
    color: red;
  }

  .tbao {
    color: red;
  }
</style>

<body>
  <main class="main d-flex w-100 mt-5">
    <div class="container d-flex flex-column mt-5">
      <div class="row h-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
          <div class="d-table-cell align-middle">
            <div class="text-center mt-4">
              <h1 class="h2">Bắt đầu</h1>
              <p class="lead">
                Bắt đầu tạo tài khoản để được dùng những dịch vụ tốt nhất.
              </p>
            </div>
            <div class="card">
              <div class="card-body">
                <div class="m-sm-4">
                  <form method="post" action="{{ route('register') }}" enctype="multipart/form-data" id="demoForm">
                    @csrf
                    <div class="form-group">
                        <label>Tên</label>
                        <input class="form-control form-control-lg" type="text" name="name" placeholder="Nhập tên của bạn" value="{{ old('name') }}" />
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                      </div>
                    <div class="form-group">
                      <label>Mật khẩu</label>
                      <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password"
                       name="password" placeholder="Nhập mật khẩu" value="{{ old('password') }}" autocomplete="new-password" />
                      @error('password')
                      <p class="text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                    <div class="form-group">
                        <label>Nhập lại mật khẩu</label>
                        <input class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" type="password"
                        name="password_confirmation" placeholder="Nhập lại mật khẩu" value="{{ old('password_confirmation') }}" autocomplete="new-password" />
                        @error('password_confirmation')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                      </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input class="form-control form-control-lg" type="email" name="email" placeholder="Nhập email" value="{{ old('email') }}" />
                      @error('email')
                      <p class="text-danger">{{ $message }}</p>
                  @enderror
                    </div>
                    <div class="form-group">
                      <label>Địa chỉ</label>
                      <input class="form-control form-control-lg" type="text" name="address" placeholder="Nhập địa chỉ" value="{{ old('address') }}" />
                      @error('address')
                      <p class="text-danger">{{ $message }}</p>
                  @enderror
                    </div>
                    <div class="form-group">
                      <label>Số điện thoại</label>
                      <input class="form-control form-control-lg" type="text" name="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}" />
                      @error('phone')
                      <p class="text-danger">{{ $message }}</p>
                  @enderror
                    </div>
                    <div class="form-group">
                      <label>Ảnh (nếu có)</label>
                      <input class="form-control form-control-lg" type="file" name="image" placeholder="Enter your image" />
                    </div>
                    <div class="text-center mt-3">
                      <input type="submit" href="#" class="btn btn-lg btn-primary" name="signUp" value="Tạo">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
