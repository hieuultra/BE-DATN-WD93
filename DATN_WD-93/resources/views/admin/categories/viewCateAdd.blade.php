@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Add category</h1>
    <form action="{{ route('admin.categories.cateAdd') }}" method="post" enctype="multipart/form-data" id="demoForm">
        @csrf
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" placeholder="Name">
        @error('name')
        <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="img" onchange="showImage(event)">
        <img id="imgCate" src="" alt="Image Product" style="width:150px; display: none">
        @error('img')
        <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>

      <label for="status" class="form-label">Status:</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="1" checked>
        <label class="form-check-label" for="flexRadioDefault1">
          Display
        </label>
      </div>
      <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault2" value="0">
        <label class="form-check-label" for="flexRadioDefault2">
          Hidden
        </label>
      </div>

      <input type="submit" class="btn btn-primary" name="them" value="ADD">
      <a href="{{ route('admin.categories.categoriesList') }}">
      <input type="button" class="btn btn-primary" value="LIST_CAT">
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
