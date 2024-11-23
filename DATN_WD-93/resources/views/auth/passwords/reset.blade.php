{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
<?php
use Illuminate\Support\Facades\File;
?>
@extends('layout')
@section('titlepage', 'Instinct - Instinct Pharmacy System')
@section('title', 'Welcome')

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
                                <h1 class="h2">Cập nhật lại mật khẩu</h1>
                                <p class="lead">Vui lòng nhập mật khẩu mới</p>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="m-sm-4">
                                        <div class="text-center">
                                            <!-- <img src="" alt="logo" class="img-fluid rounded-circle" width="132" height="132" /> -->
                                            <h1 class="m-0 display-5 font-weight-semi-bold">
                                                <span
                                                    class="text-primary font-weight-bold border px-3 mr-1">Instinct</span>Shop
                                            </h1>
                                        </div>
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ route('password.update') }}">
                                            @csrf

                                            <input type="hidden" name="token" value="{{ $token }}">
                                            <div class="form-group">
                                                <label>Địa chỉ Email</label>
                                                <input
                                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                                    type="email" name="email" id="email"
                                                    placeholder="Enter your Email" value="{{ old('email') }}"
                                                    autocomplete="email" />
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input
                                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                    type="password" name="password" id="password"
                                                    placeholder="Enter your password" value="{{ old('password') }}"
                                                    autocomplete="password" />
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Password Confirm</label>
                                                <input class="form-control form-control-lg" type="password"
                                                    name="password_confirmation" id="password-confirm"
                                                    placeholder="Enter your password" value="{{ old('password') }}"
                                                    autocomplete="new-password" required>
                                            </div>
                                            <div class="text-center mt-3">
                                                <input type="submit" href="#" class="btn btn-lg btn-primary"
                                                    value="Xác nhận" name="dangnhap">
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
