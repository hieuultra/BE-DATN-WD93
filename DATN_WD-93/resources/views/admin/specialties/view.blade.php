@extends('admin.layout')
@section('titlepage','')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h1 class="text-center">Quản lý chuyên ngành</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

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
                    <th>Ảnh</th>
                    <th>Mô tả chuyên môn</th>
                    <th>Số lượng bác sĩ</th>
                    <th>Ngày tạo</th>
                    <th>Loại</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody id="specialtiesTableBody">
                @foreach($specialties as $specialty)
                <tr id="specialty-row-{{ $specialty->id }}" class="category-item" data-name="{{ $specialty->name }}">
                    <td>{{ $specialty->id }}</td>
                    <td>{{ $specialty->name }}</td>
                    <td><img src="{{ asset('upload/' . $specialty->image) }}" alt="" style="width: 50px; height: 50px;"></td>
                    <td>{!! Str::limit($specialty->description, 100, '...') !!}</td>
                    <td>{{ $specialty->doctor_count }}</td>
                    <td>{{ $specialty->created_at->format('d-m-Y') }}</td>
                    <td>{{ $specialty->faculty }}</td>
                    <td>
                        <a href="{{ route('admin.specialties.specialtyedit', $specialty->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <button class="btn btn-danger btn-sm" onclick="deleteSpecialty({{ $specialty->id }})">Xóa</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination links -->
    <div class="pagination-container">
        {{ $specialties->links('pagination::bootstrap-4') }}
    </div>

    <script>
        function viewMore() {
            // Hide the "View More" button after clicking to load more items
            document.getElementById("viewMoreButton").style.display = 'none';

            // Find all hidden specialty rows and show them (if applicable)
            const hiddenRows = document.querySelectorAll('.category-item[style*="display: none"]');
            hiddenRows.forEach((row, index) => {
                if (index < 5) { // Show 5 more rows each time
                    row.style.display = 'table-row';
                }
            });

            // Show "View More" button if there are still hidden rows
            if (hiddenRows.length > 5) {
                document.getElementById("viewMoreButton").style.display = 'block';
            }
        }
    </script>
</div>

<div class="modal fade" id="addEditSpecialtyModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Thêm/Sửa Chuyên ngành</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEditSpecialtyForm" enctype="multipart/form-data">
                    <input type="hidden" id="specialtyId" name="id">
                    <div class="mb-3">
                        <label for="specialtyName" class="form-label">Tên chuyên ngành</label>
                        <input type="text" class="form-control" id="specialtyName" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="specialtyImage" class="form-label">Ảnh chuyên ngành</label>
                        <input type="file" class="form-control" id="specialtyImage" name="image">
                        <img id="previewImage" src="#" alt="Preview" style="display: none; width: 100px; height: 100px; margin-top: 10px;">
                    </div>
                    <div class="mb-3">
                        <label for="specialtyDescription" class="form-label">Mô tả chuyên môn</label>
                        <textarea class="form-control" id="specialtyDescription" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="specialtyDescription" class="form-label">Loại Chuyên ngành</label>
                        <select name="faculty" id="">
                            <option value="chuyên khoa">chuyên khoa</option>
                            <option value="khám từ xa">khám từ xa</option>
                            <option value="khám tổng quát">khám tổng quát</option>
                            <option value="xét nghiệm ý học">xét nghiệm ý học</option>
                        </select>
                    </div>

                    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
                    <script>
                        var editor = CKEDITOR.replace('specialtyDescription');

                        function showAddForm() {
                            document.getElementById('modalLabel').innerText = 'Thêm mới chuyên ngành';
                            document.getElementById('specialtyId').value = '';
                            document.getElementById('specialtyName').value = '';
                            editor.setData('');
                            document.getElementById('addEditSpecialtyForm').reset();
                            document.getElementById('previewImage').style.display = 'none';
                            document.getElementById('addEditSpecialtyForm').onsubmit = addSpecialty;
                        }


                        function addSpecialty(e) {
                            e.preventDefault();
                            let formData = new FormData(this);
                            formData.set('description', editor.getData());

                            axios.post('/admin/specialties/specialtyAdd', formData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            }).then(response => {
                                if (response.data.success) {
                                    addRowToTable(response.data.data);
                                    closeModal('Thêm mới chuyên khoa thành công.');
                                    window.location.reload();
                                }
                            }).catch(error => {
                                handleErrors(error);
                            });
                        }


                        function deleteSpecialty(id) {
                            if (confirm('Bạn có chắc chắn muốn xóa?')) {
                                axios.delete(`/admin/specialties/specialtyDestroy/${id}`)
                                    .then(response => {
                                        if (response.data.success) {
                                            document.getElementById(`specialty-row-${id}`).remove();
                                            alert('Xóa thành công');
                                        }
                                    }).catch(error => {
                                        handleErrors(error);
                                    });
                            }
                        }

                        function handleErrors(error) {
                            if (error.response && error.response.data && error.response.data.errors) {
                                let errors = error.response.data.errors;
                                let errorMessages = Object.values(errors).flat().join('\n');
                                alert(errorMessages);
                            } else {
                                alert('Có lỗi xảy ra. Vui lòng thử lại.');
                            }
                        }

                        function closeModal(message) {
                            let modal = bootstrap.Modal.getInstance(document.getElementById('addEditSpecialtyModal'));
                            modal.hide();
                            alert(message);
                            document.getElementById('addEditSpecialtyForm').reset();
                            document.getElementById('previewImage').style.display = 'none';
                        }

                        function addRowToTable(specialty) {
                            let tableBody = document.getElementById('specialtiesTableBody');
                            let newRow = `
                                <tr id="specialty-row-${specialty.id}" class="category-item" data-name="${specialty.name}">
                                    <td>${specialty.id}</td>
                                    <td>${specialty.name}</td>
                                    <td><img src="${specialty.image}" style="width: 50px; height: 50px;"></td>
                                    <td>${truncateString(specialty.description, 100)}</td>
                                    <td>${new Date(specialty.created_at).toLocaleDateString()}</td>
                                    <td>
                                        <a href="/admin/specialties/specialtyedit/${specialty.id}" class="btn btn-warning btn-sm">Sửa</a>
                                        <button class="btn btn-danger btn-sm" onclick="deleteSpecialty(${specialty.id})">Xóa</button>
                                    </td>
                                </tr>`;
                            tableBody.innerHTML += newRow;
                        }

                        function updateTableRow(specialty) {
                            let row = document.getElementById(`specialty-row-${specialty.id}`);
                            row.children[1].innerText = specialty.name;
                            row.children[2].innerHTML = `<img src="${specialty.image}" style="width: 50px; height: 50px;">`;
                            row.children[3].innerText = truncateString(specialty.description, 100);
                        }

                        function truncateString(str, num) {
                            return str.length <= num ? str : str.slice(0, num) + '...';
                        }

                        document.getElementById('searchInput').addEventListener('input', function() {
                            let filter = this.value.toLowerCase();
                            document.querySelectorAll('.category-item').forEach(function(item) {
                                let name = item.dataset.name.toLowerCase();
                                item.style.display = name.includes(filter) ? '' : 'none';
                            });
                        });
                    </script>

                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection