@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Thêm biến thể</h1>
    <form action="{{ route('admin.variantPros.packageAdd') }}" method="post"  id="demoForm">
        @csrf
      <div class="mb-3">
        <label class="form-label">Tên</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" placeholder="Name">
        @error('name')
        <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>
      <input type="submit" class="btn btn-primary" name="them" value="Thêm">
      <a href="{{ route('admin.variantPros.variantProList') }}">
      <input type="button" class="btn btn-danger" value="Quay lại">
        </a>
    </form>
  </div>
@endsection
