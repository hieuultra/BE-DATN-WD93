@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')

<main class="main d-flex w-100 mt-5">
    <div class="container d-flex flex-column">
        <div class="row h-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">
                    <div class="text-center mt-4">
                        <h1 class="h2">Cập nhập tài khoản</h1>
                    </div>

                    <div class="card">
                        <div class="card-body">
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

                        {{-- Display validation errors --}}
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                            <div class="m-sm-4">
                                <form action="{{ route('editAcc') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                        <label>Tên</label>
                                        <input class="form-control form-control-lg" type="text" name="name" value=" {{ Auth::user()->name }}" />
                                        <label>Mật khẩu</label>
                                        <input class="form-control form-control-lg" type="password" name="password" value=" {{ Auth::user()->password }}" />
                                        <label>Địa chỉ</label>
                                        <input class="form-control form-control-lg" type="text" name="address" value=" {{ Auth::user()->address }}" />
                                        <label>Số điện thoại</label>
                                        <input class="form-control form-control-lg" type="text" name="phone" value=" {{ Auth::user()->phone }}" />
                                        <label>Email</label>
                                        <input class="form-control form-control-lg" type="email" name="email" value=" {{ Auth::user()->email }}" />
                                        <label>Ảnh</label>
                                        <input class="form-control form-control-lg" type="file" name="image" value="" />
                                        <img src="{{asset('upload/'.Auth::user()->image) }}" alt="" height="160" width="200">
                                    </div>
                                    <div class="text-center mt-3">
                                        <input type="submit" href="#" class="btn btn-lg btn-primary" value="Lưu" name="edit">
                                        <!-- <button type="submit" class="btn btn-lg btn-primary">Reset password</button> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div style="color: red;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
