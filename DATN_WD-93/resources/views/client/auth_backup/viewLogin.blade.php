{{-- <?php
use Illuminate\Support\Facades\File;
?> --}}
@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script>
  $().ready(function() {
    $("#demoForm").validate({
      onfocusout: false,
      onkeyup: false,
      onclick: false,
      rules: {
        "username": {
          required: true,
        },
        "password": {
          required: true,
        },

      },
      messages: {
        "username": {
          required: "Bắt buộc nhập username ",
        },
        "password": {
          required: "Bắt buộc nhập password ",
        }
      }
    });
  });
</script>
<style>
  label.error {
    color: red;
  }

  .tbao {
    color: red;
    font-weight: 500;
    font-size: medium;
  }
</style>

<body>
  <main class="main d-flex w-100 mt-5">
    <div class="container d-flex flex-column mt-5">
      <div class="row h-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
          <div class="d-table-cell align-middle">
            <div class="text-center mt-4">
              <h1 class="h2">Chào mừng</h1>
              <p class="lead">Đăng nhập để tiếp tục dùng các dịch vụ</p>
            </div>
            <div class="card">
              <div class="card-body">
                <div class="m-sm-4">
                  <div class="text-center">
                    <!-- <img src="" alt="logo" class="img-fluid rounded-circle" width="132" height="132" /> -->
                    <h1 class="m-0 display-5 font-weight-semi-bold">
                      <span class="text-primary font-weight-bold border px-3 mr-1">Instinct</span>Pharmacy
                    </h1>
                  </div>
                  <form action="{{ route('login') }}" method="post" id="demoForm">
                    @csrf
                    <div class="form-group">
                      <label>Email</label>
                      <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" name="email"
                       placeholder="Nhập Email của bạn" value="{{ old('email') }}" autocomplete="email" />
                     @error('email')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                     @enderror
                    </div>
                    <div class="form-group">
                      <label>Mật khẩu</label>
                      <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" name="password" placeholder="Nhập mật khẩu của bạn" />
                      @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                      <div class="d-flex mt-2 justify-content-between">
                        <small>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                {{ __('Quên mật khẩu?') }}
                            </a>
                        @endif
                        </small>
                        <br />
                        <small>
                          <a href="{{ route('viewRegister') }}">Tạo tài khoản?</a>
                        </small>
                      </div>
                    </div>
                    <div>
                      {{-- <div class="custom-control custom-checkbox align-items-center">
                        <input type="checkbox" class="custom-control-input" value="remember-me" name="remember-me" checked />
                        <label class="custom-control-label text-small">Remember me next time</label>
                      </div> --}}
                    </div>
                    <div class="text-center mt-3">
                      <input type="submit" href="#" class="btn btn-lg btn-primary" value="Login" name="dangnhap">
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

@endsection
