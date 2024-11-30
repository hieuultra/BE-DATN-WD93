@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Cập nhập danh mục</h1>
    <form action="{{ route('admin.categories.cateUpdate') }}" method="post"  enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $cate->id }}">
      <div class="mb-3">
        <label class="form-label">Tên</label>
        <input type="text" class="form-control" name="name"  value="{{ $cate->name }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Ảnh</label>
        <input type="file" class="form-control" name="img" onchange="showImage(event)">
        <img id="imgCate" src="{{ asset('upload/'.$cate->img)}}" width="120" height="100" alt="">
      </div>

      <label for="status" class="form-label">Trạng Thái:</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="1" {{ $cate->status == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="flexRadioDefault1">
          Hiện
        </label>
      </div>
      <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault2" value="0"  {{ $cate->status == 0 ? 'checked' : '' }}>
        <label class="form-check-label" for="flexRadioDefault2">
          Ẩn
        </label>
      </div>

      <input type="submit" class="btn btn-primary" value="Cập nhập" name="update">
      <a href="{{ route('admin.categories.categoriesList') }}">
        <input type="button" class="btn btn-primary" value="Quay Lại">
      </a>
    </form>
  </div>
  <script>
    //hien thi image khi add
    function showImage(event){
        const imgCate = document.getElementById('imgCate');
        const file =  event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(){
            imgCate.src = reader.result;
            imgCate.style.display = "block";
        }
        if(file){
            reader.readAsDataURL(file);
        }
    }
  </script>

@endsection
