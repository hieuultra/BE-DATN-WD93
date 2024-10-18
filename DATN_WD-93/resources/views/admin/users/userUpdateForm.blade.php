@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Update account</h1>
    <form action="{{ route('admin.users.userUpdate') }}" method="post" enctype="multipart/form-data" id="demoForm">
        @csrf
        <input type="hidden" name="id" value="{{ $acc->id }}">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" value="{{ $acc->username  }}" name="username">
        </div>

        {{-- <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" class="form-control " value="{{ $acc->password }}" name="password">
        </div> --}}

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control " value="{{ $acc->name }}" name="name" >
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control " value="{{ $acc->address  }}" name="address" >

        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control " value="{{ $acc->phone  }}" name="phone" >

        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="{{ $acc->email  }}" name="email">
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" class="form-control" name="image" onchange="showImage(event)">
            <img id="imgCate" src="{{ asset('upload/'.$acc->image)}}" alt="Image Product" width="120" height="70">
        </div>
        <input type="submit" class="btn btn-primary" value="Update" name="update">
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
