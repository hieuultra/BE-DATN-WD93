@extends('admin.layout')
@section('titlepage', '')

@section('content')
<link href="{{ asset('assets/admin/libs/quill/quill.core.js') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <div class="container-fluid mt-4 px-4">
        {{-- <h1 class="mt-4">{{ $title }}</h1> --}}
        <a href="{{ route('admin.blogs.index') }}">
            <input type="button" class="btn btn-primary" value="Quay lại quản lí bài viết">
        </a>
        <div class="row mt-3">
          <div class="col-12">
              <div class="card">

                  <div class="card-header">
                      <h5 class="card-title mb-0">{{ $title }}</h5>
                  </div><!-- end card header -->

                  <div class="card-body">
                      <form action="{{ route('admin.blogs.update',$blog->id) }}" method="POST"
                          enctype="multipart/form-data">
                          <div class="row">
                              @csrf
                              @method("PUT")
                              <div class="col-lg-4">
                                  <div class="mb-3">
                                      <label for="title" class="form-label">Tiêu đề bài viết</label>
                                      <input type="text" id="title" name="title"
                                          class="form-control @error('title')
                                          is-invalid
                                      @enderror"
                                          value="{{ $blog->title }}" placeholder="Tiêu đề bài viết">
                                      @error('title')
                                          <p class="text-danger">{{ $message }}</p>
                                      @enderror
                                  </div>
                                  <div class="mb-3">
                                    <label for="short_content" class="form-label">Tóm tắt bài viết</label>
                                    <input type="text" id="short_content" name="short_content"
                                        class="form-control @error('short_content')
                                        is-invalid
                                    @enderror"
                                        value="{{ $blog->short_content }}" placeholder="Tiêu đề bài viết">
                                    @error('short_content')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                  <div class="mb-3">
                                      <label for="topic_id" class="form-label">Chuyên đề</label>
                                      <select name="topic_id"
                                          class="form-select @error('topic_id')
                                          is-invalid
                                      @enderror">
                                          <option selected>--- Chọn chuyên đề ---</option>
                                          @foreach ($listTopic as $item)
                                              <option value="{{ $item->id }}"
                                                  {{ $blog->topic_id == $item->id ? 'selected' : '' }}>
                                                  {{ $item->name }}</option>
                                          @endforeach
                                      </select>
                                      @error('topic_id')
                                          <p class="text-danger">{{ $message }}</p>
                                      @enderror
                                  </div>
                                  
                                  <div class="mb-3">
                                    <label for="image" class="form-label">Ảnh minh họa</label>
                                    <input type="file" id="image" name="image" class="form-control"
                                        onchange="showImage(event)">
                                    <img class="mt-2" id="image_product" src="{{ Storage::url($blog->image) }}" alt="image"
                                        style="width: 385px;">
                                        @error('image')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                              </div>
                              <div class="col-lg-8">
                                  <div class="mb-3">
                                      <label for="" class="form-label">Nội dung bài viết</label>
                                      <div id="quill-editor" style="height: 400px;">
                                      </div>
                                      <textarea name="content" id="content" class="d-none"></textarea>
                                      @error('content')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                  </div>
                              </div>
                              <div class="d-flex justify-content-center">
                                  <button type="submit" class="btn btn-primary">Chỉnh sửa bài viết</button>
                              </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
    </div>

    <!-- Quill Editor Js -->
    <script src="{{ asset('assets/admin/libs/quill/quill.core.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/quill/quill.min.js') }}"></script>

    <script>
        function showImage(event) {
            const image_product = document.getElementById('image_product');
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function() {
                image_product.src = reader.result;
                image_product.style.display = 'block';
            }
            if (file) {
                reader.readAsDataURL(file)
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var quill = new Quill("#quill-editor", {
                theme: "snow",
            })

            //Hiển thị nội dung cũ
            var old_content = `{!! $blog->content !!}`;
            quill.root.innerHTML = old_content;

            // Cập nhật lại textaria ẩn khi nội dung của quill-edit thay đổi
            quill.on('text-change', function() {
                var html = quill.root.innerHTML;
                document.getElementById('content').value = html;
            })
        })
    </script>

@endsection








{{-- @extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Chỉnh sửa chuyên đề</h1>
    <form action="{{ route('admin.topics.update', $topic->id) }}" method="POST"  enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <input type="hidden" name="id" value="{{ $topic->id }}">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name"  value="{{ $topic->name }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="img" onchange="showImage(event)">
        <img id="imgTopic" src="{{ Storage::url($topic->img)}}" width="120" height="100" alt="">
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
        <input type="button" class="btn btn-primary" value="Danh sách chuyên mục">
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

@endsection --}}
