@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Add Specialty</h1>
    <form action="{{ route('admin.specialties.specialtyAdd') }}" method="post"  id="demoForm" enctype="multipart/form-data">
        @csrf
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" placeholder="Name">
        @error('name')
        <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror"
         placeholder="Leave a description product here" style="height: 100px" name="description" >{{ old('description') }}</textarea>
         @error('description')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image" onchange="showImage(event)">
        <img id="imgCate" src="" alt="Image Product" style="width:150px; display: none">
    </div>

    <div class="mb-3">
        <label class="form-label">classification (Phân loại)</label>
        <select name="classification">
          <option value="chuyen_khoa">Chuyên khoa</option>
          <option value="kham_tu_xa">Kham qua video (Khám từ xa)</option>
          <option value="tong_quat">Khám tổng quát (chỉ dành cho bệnh viện)</option>
        </select>
        @error('classification')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

      <input type="submit" class="btn btn-primary" name="them" value="ADD">
      <a href="{{ route('admin.specialties.specialtyDoctorList') }}">
      <input type="button" class="btn btn-primary" value="List Specialty">
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
