@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Chỉnh sửa chuyên đề</h1>
    <form action="{{ route('admin.topics.edit') }}" method="post"  enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $topic->id }}">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name"  value="{{ $topic->name }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="img" onchange="showImage(event)">
        <img id="imgTopic" src="{{ asset('upload/'.$topic->img)}}" width="120" height="100" alt="">
      </div>

      <label for="status" class="form-label">Status:</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="1" {{ $topic->status == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="flexRadioDefault1">
          Display
        </label>
      </div>
      <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault2" value="0"  {{ $topic->status == 0 ? 'checked' : '' }}>
        <label class="form-check-label" for="flexRadioDefault2">
          Hidden
        </label>
      </div>

      <input type="submit" class="btn btn-primary" value="Update" name="edit">
      <a href="{{ route('admin.topics.index') }}">
        <input type="button" class="btn btn-primary" value="LIST_CAT">
      </a>
    </form>
  </div>
  <script>
    //hien thi image khi add
    function showImage(event){
        const imgTopic = document.getElementById('imgTopic');
        const file =  event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(){
            imgTopic.src = reader.result;
            imgTopic.style.display = "block";
        }
        if(file){
            reader.readAsDataURL(file);
        }
    }
  </script>

@endsection
