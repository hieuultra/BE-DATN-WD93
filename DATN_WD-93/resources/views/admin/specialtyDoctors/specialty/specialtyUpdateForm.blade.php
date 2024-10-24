@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Edit Specialty</h1>
    <form action="{{ route('admin.specialties.specialtyUpdate') }}" method="post"  id="demoForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $specialty->id }}">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $specialty->name }}" name="name" placeholder="Name">
        @error('name')
        <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror"
         placeholder="Leave a description product here" style="height: 100px" name="description" >{{ $specialty->description }}</textarea>
         @error('description')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image" onchange="showImage(event)">
        <img id="imgCate" src="{{ asset('upload/'.$specialty->image) }}" alt="Image Product" style="width:150px;">
    </div>

      <input type="submit" class="btn btn-primary" name="them" value="Update">
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
