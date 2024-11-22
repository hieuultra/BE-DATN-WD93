
@extends('admin.layout')
@section('titlepage', 'Tạo thương hiệu')

@section('content')
<link href="{{ asset('assets/admin/libs/quill/quill.core.js') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">

<div class="container-fluid mt-4 px-4">
    <a href="{{ route('admin.brands.index') }}">
        <input type="button" class="btn btn-primary" value="Quay lại quản lí thương hiệu">
    </a>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thêm thương hiệu</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên thương hiệu</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Tên thương hiệu">
                            @error('name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh thương hiệu</label>
                            <input type="file" id="image" name="image" class="form-control"
                                onchange="showImage(event)">
                            <img class="mt-2" id="image_product" src="" alt="image"
                                style="width: 385px; display: none">
                            @error('image')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Tạo thương hiệu</button>
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