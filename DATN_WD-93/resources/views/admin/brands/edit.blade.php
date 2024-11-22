
@extends('admin.layout')
@section('titlepage', '')

@section('content')
<div class="container-fluid mt-4 px-4">
    <a href="{{ route('admin.brands.index') }}">
        <input type="button" class="btn btn-primary" value="Quay lại quản lí thương hiệu">
    </a>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cập nhật thương hiệu</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên thương hiệu</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $brand->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Tên thương hiệu">
                            @error('name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh thương hiệu</label>
                            <input type="file" id="image" name="image" class="form-control" onchange="showImage(event)">
                            @if($brand->image)
                            <img class="mt-2" id="image_product" src="{{ asset('storage/' . $brand->image) }}" alt="image" style="width: 385px;">
                            @endif
                            @error('image')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showImage(event) {
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function(){
        var dataURL = reader.result;
        var output = document.getElementById('image_product');
        output.src = dataURL;
        output.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
