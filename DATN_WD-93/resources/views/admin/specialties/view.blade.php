@extends('admin.layout')
@section('titlepage','')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
    <h1 class="text-center">Quản lý chuyên ngành</h1>

    <div class="mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEditSpecialtyModal" onclick="showAddForm()">Thêm mới chuyên ngành</button>
    </div>

    <div class="mb-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm chuyên ngành...">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên chuyên ngành</th>
                    <th>Mô tả chuyên môn</th>
                    <th>Ngày tạo</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody id="specialtiesTableBody">
                @foreach($specialties as $specialty)
                <tr id="specialty-row-{{ $specialty->id }}" class="category-item" data-name="{{ $specialty->name }}">
                    <td>{{ $specialty->id }}</td>
                    <td>{{ $specialty->name }}</td>
                    <td>{!! Str::limit($specialty->description, 100, '...') !!}</td>
                    <td>{{ $specialty->created_at->format('d-m-Y') }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="showEditForm({{ $specialty->id }}, '{{ $specialty->name }}', `{!! $specialty->description !!}`)">Sửa</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSpecialty({{ $specialty->id }})">Xóa</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addEditSpecialtyModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Thêm/Sửa Chuyên ngành</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEditSpecialtyForm">
                    <input type="hidden" id="specialtyId" name="id">
                    <div class="mb-3">
                        <label for="specialtyName" class="form-label">Tên chuyên ngành</label>
                        <input type="text" class="form-control" id="specialtyName" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="specialtyDescription" class="form-label">Mô tả chuyên môn</label>
                        <textarea class="form-control" id="specialtyDescription" name="description"></textarea>
                    </div>

                    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
                    <script>
                        var editor = CKEDITOR.replace('specialtyDescription');
                        var addEditSpecialtyModal = document.getElementById('addEditSpecialtyModal');
                        addEditSpecialtyModal.addEventListener('hidden.bs.modal', function () {
                            editor.setData('');
                        });
                    </script>

                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function showAddForm() {
        document.getElementById('modalLabel').innerText = 'Thêm mới chuyên ngành';
        document.getElementById('specialtyId').value = '';
        document.getElementById('specialtyName').value = '';
        CKEDITOR.instances['specialtyDescription'].setData(''); 
        document.getElementById('addEditSpecialtyForm').onsubmit = addSpecialty;
    }

    function showEditForm(id, name, description) {
        document.getElementById('modalLabel').innerText = 'Sửa chuyên ngành';
        document.getElementById('specialtyId').value = id;
        document.getElementById('specialtyName').value = name;

        CKEDITOR.instances['specialtyDescription'].setData(description); 

        let modal = new bootstrap.Modal(document.getElementById('addEditSpecialtyModal'));
        modal.show();
        document.getElementById('addEditSpecialtyForm').onsubmit = updateSpecialty; 
    }

    function addSpecialty(e) {
        e.preventDefault();
        let formData = new FormData(this);
        function truncateString(str, num) {
            if (str.length > num) {
                return str.slice(0, num) + '...';
            }
            return str;
        }
        axios.post('/admin/specialties/specialtyAdd', formData)
            .then(response => {
                if (response.data.success) {
                    let specialty = response.data.data;
                    let tableBody = document.getElementById('specialtiesTableBody');
                    let newRow = `<tr id="specialty-row-${specialty.id}" class="category-item" data-name="${specialty.name}">
                            <td>${specialty.id}</td>
                            <td>${specialty.name}</td>
                            <td>${truncateString(specialty.description, 100)}</td>
                            <td>${new Date(specialty.created_at).toLocaleDateString()}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="showEditForm(${specialty.id}, '${specialty.name}', \`${specialty.description}\`)">Sửa</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteSpecialty(${specialty.id})">Xóa</button>
                            </td>
                        </tr>`;
                    tableBody.innerHTML += newRow;
                    let modal = bootstrap.Modal.getInstance(document.getElementById('addEditSpecialtyModal'));
                    modal.hide();
                    alert('Thêm mới chuyên khoa thành công.');
                    document.getElementById('addEditSpecialtyForm').reset();
                }
            })
            .catch(error => {
                handleErrors(error);
            });
    }

    function updateSpecialty(e) {
        e.preventDefault();
        let id = document.getElementById('specialtyId').value;
        let name = document.getElementById('specialtyName').value;
        let description = CKEDITOR.instances['specialtyDescription'].getData();
        function truncateString(str, num) {
            if (str.length > num) {
                return str.slice(0, num) + '...';
            }
            return str;
        }

        axios.put(`/admin/specialties/specialtyUpdate/${id}`, {
                name,
                description
            })
            .then(response => {
                if (response.data.success) {
                    let specialty = response.data.data;
                    let row = document.getElementById(`specialty-row-${specialty.id}`);
                    row.innerHTML = `<td>${specialty.id}</td>
                        <td>${specialty.name}</td>
                        <td>${truncateString(specialty.description, 100)}</td>
                        <td>${new Date(specialty.created_at).toLocaleDateString()}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="showEditForm(${specialty.id}, '${specialty.name}', \`${specialty.description}\`)">Sửa</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteSpecialty(${specialty.id})">Xóa</button>
                        </td>`;
                    let modal = bootstrap.Modal.getInstance(document.getElementById('addEditSpecialtyModal'));
                    modal.hide();
                    alert('Cập nhật chuyên khoa thành công.');
                }
            })
            .catch(error => {
                handleErrors(error);
            });
    }

    function deleteSpecialty(id) {
        if (confirm('Bạn có chắc chắn muốn xóa chuyên khoa này không?')) {
            axios.delete(`/admin/specialties/specialtyDestroy/${id}`)
                .then(response => {
                    if (response.data.success) {
                        let row = document.getElementById(`specialty-row-${id}`);
                        row.remove();
                        alert('Xóa chuyên khoa thành công.');
                    }
                })
                .catch(error => {
                    if (error.response && error.response.data.message) {
                        alert(error.response.data.message);
                    } else {
                        console.error('Lỗi khi xóa chuyên khoa', error);
                        alert('Đã xảy ra lỗi khi xóa chuyên khoa.');
                    }
                });
        }
    }

    function handleErrors(error) {
        if (error.response && error.response.data.errors) {
            let errors = error.response.data.errors;
            console.error(errors);
            let errorMessages = [];

            if (errors.name) {
                errorMessages.push(errors.name[0]);
            }
            if (errors.description) {
                errorMessages.push(errors.description[0]);
            }
            alert(errorMessages.length ? errorMessages.join('\n') : 'Đã xảy ra lỗi.');
        } else {
            console.error('Lỗi khi cập nhật chuyên khoa', error);
        }
    }

    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const categories = document.querySelectorAll('.category-item');

        categories.forEach(category => {
            const categoryName = category.getAttribute('data-name').toLowerCase();
            if (categoryName.includes(searchTerm)) {
                category.style.display = '';
            } else {
                category.style.display = 'none';
            }
        });
    });
</script>
@endsection