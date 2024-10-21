@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Add account</h1>
    <form action="{{ route('admin.users.userAdd') }}" method="post" enctype="multipart/form-data" id="demoForm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" placeholder="Name">
            @error('name')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" placeholder="Password">
            @error('password')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" name="address" placeholder="Address">
            @error('address')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" name="phone" placeholder="Phone">
            @error('phone')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" placeholder="Email">
            @error('email')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" class="form-control" name="image" onchange="showImage(event)">
            <img id="imgCate" src="" alt="Image Product" style="width:150px; display: none">
        </div>
        <input type="submit" class="btn btn-primary" value="Add" name="them">
        <a href="{{ route('admin.users.userList') }}">
            <input type="button" class="btn btn-primary" value="LIST_ACC">
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
