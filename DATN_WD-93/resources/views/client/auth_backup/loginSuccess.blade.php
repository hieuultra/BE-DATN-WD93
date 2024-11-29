@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')

<style>
    label.error {
        color: red;
    }

    .tbao {
        color: red;
    }
    .btn-custom {
            padding: 5px 10px; /* Điều chỉnh kích thước padding để nút nhỏ hơn */
            font-size: 12px; /* Điều chỉnh kích thước chữ để nút thon gọn hơn */
        }
</style>
<main class="main d-flex w-100 mt-5">
    <div class="container d-flex flex-column mt-5">
        <div class="row h-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">
                    <div class="text-center mt-4">
                        <h1 class="h2">Đăng nhập thành công</h1>
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
                                    <div class="text-center mt-4 font-weight-bold border px-3 mr-1">
                                        Chào <br />
                                        {{ Auth::user()->name }}
                                    </div>
                                    <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px">
                                        <img src="{{asset('upload/'.Auth::user()->image) }}" alt="" width="400" height="200">
                                    </div>
                                    <div class="form-group">
                                            <li><a href="{{ route('orders.index') }}">Đơn mua </a></li>
                                            <li><a href="{{ route('appoinment.appointmentHistory', $user = Auth::user()->id) }}">Lịch sử đặt khám</li></a>
                                            @if(Auth::user()->role == 'Doctor')
                                            <li><a href="{{ route('appoinment.physicianManagement', $user = Auth::user()->id) }} ">Quản lý lịch khám</li></a>
                                            @endif
                                           <li>  @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}">
                                                {{ __('Quên mật khẩu?') }}
                                            </a>
                                                @endif
                                            </li>
                                            <li> <a href="{{ route('viewEditAcc') }}">Cập nhập tài khoản </a> </li>
                                            <li> <a href="../admin">Quản trị viên </a></li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <li><input type="submit" class="btn btn-danger btn-custom" value="Đăng xuất"></li>
                                                {{-- <li><a href="{{ route('logout') }}">Log out </a></li> --}}
                                            </form>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="tbao">
                        {{-- <?php
                        if (isset($tbao) && ($tbao) != "") {
                            echo $tbao;
                        }
                        ?> --}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
