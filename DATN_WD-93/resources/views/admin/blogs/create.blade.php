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
                      <form action="{{ route('admin.blogs.store') }}" method="POST"
                          enctype="multipart/form-data">
                          <div class="row">
                              @csrf
                              <div class="col-lg-4">
                                  <div class="mb-3">
                                      <label for="title" class="form-label">Tiêu đề bài viết</label>
                                      <input type="text" id="title" name="title"
                                          class="form-control @error('title')
                                          is-invalid
                                      @enderror"
                                          value="{{ old('title') }}" placeholder="Tiêu đề bài viết">
                                      @error('title')
                                          <p class="text-danger">{{ $message }}</p>
                                      @enderror
                                  </div>
                                  <div class="mb-3">
                                    <label for="short_content" class="form-label">Nội dung tóm tắt</label>
                                    <input type="text" id="short_content" name="short_content"
                                        class="form-control @error('short_content')
                                        is-invalid
                                    @enderror"
                                        value="{{ old('short_content') }}" placeholder="Nội dung tóm tắt">
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
                                                  {{ old('topic_id') == $item->id ? 'selected' : '' }}>
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
                                    <img class="mt-2" id="image_product" src="" alt="image"
                                        style="width: 385px; display: none">
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
                                  <button type="submit" class="btn btn-primary">Tạo bài viết</button>
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
            var old_content = `{!! old('content') !!}`;
            quill.root.innerHTML = old_content;

            // Cập nhật lại textaria ẩn khi nội dung của quill-edit thay đổi
            quill.on('text-change', function() {
                var html = quill.root.innerHTML;
                document.getElementById('content').value = html;
            })
        })
    </script>

@endsection
