@extends('admin.layout')
@section('titlepage','')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h1 class="text-center">Quản lý Thành tựu bác sĩ <span style="color: pink;">{{$doctor->user->name}}</span></h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-4">
        <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#addEditSpecialtyModal"
            data-doctor-id="{{ $doctor->id }}"
            onclick="showAddForm(this)">
            Thêm mới Thành tựu bác sĩ
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Tên thành tựu</th>
                    <th>Nội dung quá trình đào tạo</th>
                    <th>Năm thực hiện</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody id="specialtiesTableBody">
                @foreach($achievements as $achievement)
                <tr id="achievement-{{ $achievement->id }}">
                    <td>{{$achievement->type}}</td>
                    <td>{{$achievement->description}}</td>
                    <td>{{$achievement->year}}</td>
                    <td>
                        <a href="#" onclick="showEditForm({{ $achievement->id }}, '{{ $achievement->type }}', '{{ $achievement->description }}', '{{ $achievement->year }}')">Sửa</a>
                        <button onclick="confirmDelete({{ $achievement->id }})">Xóa</button>
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
                <h5 class="modal-title" id="addEditSpecialtyModalLabel">Thêm Thành tựu cho Bác sĩ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.achievements.achievementsAdd') }}" method="post">
                    @csrf
                    <input type="hidden" id="doctor_id" name="doctor_id">

                    <div class="mb-3">
                        <label for="achievement" class="form-label">Thành tựu</label>
                        <select name="type" required>
                            <option value="education">education (giáo dục)</option>
                            <option value="research">research (nghiên cứu)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="achievement" class="form-label">Thành tựu</label>
                        <textarea name="description" style="width: 400px; height: 200px;" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="achievement" class="form-label">Năm Hoàn thành</label>
                        <input type="text" name="year" pattern="\d{4}" title="Vui lòng nhập một năm hợp lệ (4 chữ số)" required>
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
                <form action="{{ route('admin.achievements.achievementsUpdate') }}" method="post">
                    @csrf
                    <input type="hidden" id="achievement_id" name="achievement_id">

                    <div class="mb-3">
                        <label for="achievement" class="form-label">Thành tựu</label>
                        <select name="type" id="achievement" required class="form-select">
                            <option value="education">Education (Giáo dục)</option>
                            <option value="research">Research (Nghiên cứu)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Mô tả</label>
                        <input type="text" class="form-control" id="editDescription" name="description" required>
                    </div>

                    <div class="mb-3">
                        <label for="editYear" class="form-label">Năm</label>
                        <input type="number" class="form-control" id="editYear" name="year" required>
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
        var doctorId = button.getAttribute('data-doctor-id');
        document.getElementById('doctor_id').value = doctorId;
    }

    function showEditForm(id, type, description, year) {
        document.getElementById('achievement_id').value = id;
        document.getElementById('achievement').value = type;
        document.getElementById('editDescription').value = description;
        document.getElementById('editYear').value = year;
        new bootstrap.Modal(document.getElementById('editAchievementModal')).show();
    }

    function confirmDelete(id) {
        if (confirm("Bạn có chắc muốn xóa thành tựu này?")) {
            deleteAchievement(id);
        }
    }

    function deleteAchievement(id) {
        fetch(`/admin/achievements/achievementsds/${id}`, {
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
                } else {
                    alert('Lỗi khi xóa thành tựu.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Lỗi khi xóa thành tựu.');
            });
    }
</script>
@endsection