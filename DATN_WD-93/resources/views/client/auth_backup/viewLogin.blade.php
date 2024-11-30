{{-- <?php
use Illuminate\Support\Facades\File;
?> --}}
@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
  .input-group-append .input-group-text {
  background-color: #f8f9fa;
  border: none;
  cursor: pointer;
}

.input-group-append .input-group-text:hover {
  background-color: #e9ecef;
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
                  {{-- Hiển thị thông báo --}}
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    @if (session('success'))
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: "{{ session('success') }}",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    @endif

                    @if (session('error'))
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: "{{ session('error') }}",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    @endif
                });
            </script>
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
                        <div class="input-group">
                      <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Nhập mật khẩu của bạn" />
                      <div class="input-group-append">
                        <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                          <i class="fa fa-eye"></i>
                        </span>
                      </div>
                    </div>
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
                      <input type="submit" href="#" class="btn btn-lg btn-primary" value="Đăng nhập" name="dangnhap">
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
<script>
    document.getElementById('toggle-password').addEventListener('click', function () {
      const passwordField = document.getElementById('password');
      const icon = this.querySelector('i');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });

    document.getElementById('toggle-confirm-password').addEventListener('click', function () {
      const confirmPasswordField = document.getElementById('confirm-password');
      const icon = this.querySelector('i');
      if (confirmPasswordField.type === 'password') {
        confirmPasswordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        confirmPasswordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });
  </script>
@endsection
