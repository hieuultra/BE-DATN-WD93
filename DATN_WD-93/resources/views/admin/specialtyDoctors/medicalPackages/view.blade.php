@extends('admin.layout')
@section('titlepage','')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h1 class="text-center">Quản lý danh mục khám <span style="color: pink;">{{$package->hospital_name}}</span></h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-4">
        <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#addEditSpecialtyModal"
            data-package-id="{{ $package->id }}"
            onclick="showAddForm(this)">
            Thêm mới danh mục khám
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Tên danh mục khám</th>
                    <th>Nội dung khám</th>
                    <th>Mô tả</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody id="specialtiesTableBody">
                @foreach($achievements as $achievement)
                <tr id="achievement-{{ $achievement->id }}">
                    <td>{{$achievement->category}}</td>
                    <td>{{$achievement->name}}</td>
                    <td>{{$achievement->description}}</td>
                    <td>
                        <a href="#" onclick="showEditForm({{ $achievement->id }}, '{{ $achievement->category }}', '{{ $achievement->name }}', '{{ $achievement->description }}')">Sửa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addEditSpecialtyModal" tabindex="-1" aria-labelledby="addEditSpecialtyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditSpecialtyModalLabel">Thêm Danh mục khám cho {{$package->hospital_name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.medicalPackages.viewmedicalPackagesAdd') }}" method="post">
                    @csrf
                    <input type="hidden" id="package_id" name="package_id">

                    <div class="mb-3">
                        <label for="achievement" class="form-label">Danh mục khám</label>
                        <select name="category" required>
                            <option value="khám lâm sàng">khám lâm sàng</option>
                            <option value="xét nghiệm">xét nghiệm</option>
                            <option value="chuẩn đoán thăm dò chức năng">chuẩn đoán thăm dò chức năng</option>
                            <option value="tư vấn kết quả">tư vấn kết quả</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="achievement" class="form-label">Nội dung khám</label>
                        <textarea name="name" style="width: 400px; height: 200px;" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="achievement" class="form-label">Mô tả chi tiết (có thể để trống)</label>
                        <textarea name="description" style="width: 400px; height: 200px;"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal sửa thành tựu -->
<div class="modal fade" id="editAchievementModal" tabindex="-1" aria-labelledby="editAchievementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAchievementModalLabel">Chỉnh sửa Thành tựu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.medicalPackages.medicalPackagesUpdate') }}" method="post">
                    @csrf
                    <!-- Hidden input to store the achievement ID -->
                    <input type="hidden" id="achievement_id" name="achievement_id">

                    <div class="mb-3">
                        <label for="category" class="form-label">Thành tựu</label>
                        <select name="category" id="category" required class="form-select">
                            <option value="khám lâm sàng">khám lâm sàng</option>
                            <option value="xét nghiệm">xét nghiệm</option>
                            <option value="chuẩn đoán thăm dò chức năng">chuẩn đoán thăm dò chức năng</option>
                            <option value="tư vấn kết quả">tư vấn kết quả</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editName" class="form-label">Nội dung khám</label>
                        <textarea name="name" id="editName" style="width: 400px; height: 200px;" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Mô tả chi tiết (có thể để trống)</label>
                        <textarea name="description" id="editDescription" style="width: 400px; height: 200px;"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function showAddForm(button) {
        var packageId = button.getAttribute('data-package-id');
        document.getElementById('package_id').value = packageId;
    }

    function showEditForm(id, category, name, description) {
        document.getElementById('achievement_id').value = id;
        document.getElementById('category').value = category;
        document.getElementById('editName').value = name;
        document.getElementById('editDescription').value = description;
        new bootstrap.Modal(document.getElementById('editAchievementModal')).show();
    }


    function confirmDelete(id) {
        if (confirm("Bạn có chắc muốn xóa thành tựu này?")) {
            deleteAchievement(id);
        }
    }

    function deleteAchievement(id) {
        fetch(`/admin/medicalPackages/medicalPackagesDestroy/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    document.getElementById(`achievement-${id}`).remove();
                    alert('Xóa thành công!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Lỗi khi xóa thành tựu.');
            });
    }
</script>
@endsection