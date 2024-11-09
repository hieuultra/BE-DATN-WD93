@extends('admin.layout')
@section('titlepage','')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Form Update -->
<div id="updateFormContainer" style="max-width: 600px; margin: auto;">
    <h5 class="mt-4">Cập nhật chuyên ngành</h5>
    <form action="{{ route('admin.specialties.specialtyUpdate', $specialty->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $specialty->id }}">
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="updateSpecialtyName" class="form-label">Tên chuyên ngành</label>
            <input type="text" class="form-control" name="name" value="{{ $specialty->name }}" required>
        </div>
        @error('image')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="updateSpecialtyImage" class="form-label">Ảnh chuyên ngành</label>
            <img src="{{ asset('upload/' . $specialty->image) }}" alt="Current Image" id="currentImage" style="width: 50px; height: 50px;">
            <input type="file" class="form-control" name="image" onchange="previewImage(event)">
            <img id="updatePreviewImage" src="#" alt="Preview" style="display: none; width: 100px; height: 100px; margin-top: 10px;">
        </div>
        @error('description')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="specialtyDescription" class="form-label">Mô tả chuyên môn</label>
            <textarea class="form-control" id="specialtyDescription" name="description">{{ $specialty->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="specialtyDescription" class="form-label">Loại Chuyên ngành</label>
            <select name="faculty" id="">
                <option value="chuyên khoa" {{ $specialty->faculty == 'chuyên khoa' ? 'selected' : '' }}>chuyên khoa</option>
                <option value="khám từ xa" {{ $specialty->faculty == 'khám từ xa' ? 'selected' : '' }}>khám từ xa</option>
                <option value="khám tổng quát" {{ $specialty->faculty == 'khám tổng quát' ? 'selected' : '' }}>khám tổng quát</option>
                <option value="xét nghiệm ý học" {{ $specialty->faculty == 'xét nghiệm ý học' ? 'selected' : '' }}>xét nghiệm ý học</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>

<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    // Khởi tạo CKEditor
    CKEDITOR.replace('specialtyDescription');

    function previewImage(event) {
        const currentImage = document.getElementById('currentImage');
        const previewImage = document.getElementById('updatePreviewImage');

        // Ẩn ảnh cũ và hiển thị ảnh mới
        currentImage.style.display = 'none';
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block'; // Hiển thị ảnh mới
            }
            reader.readAsDataURL(file);
        } else {
            // Nếu không có file nào được chọn, hiển thị lại ảnh cũ
            currentImage.style.display = 'block';
            previewImage.style.display = 'none';
        }
    }
</script>
@endsection