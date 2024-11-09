@extends('admin.layout')
@section('titlepage','')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="container mt-5">
        <h1 class="text-center">Quản lý nhân viên y tế</h1>

        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <select id="specialtyFilter" class="form-select w-100" onchange="filterBySpecialty()">
                    <option value="">All Specialties</option>
                    @foreach($specialties as $specialty)
                    <option value="{{ $specialty->id }}">
                        {{ $specialty->name }} ({{ $specialty->doctor_count }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6">
                <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm theo tên và email" oninput="filterBySpecialty()" />
            </div>
        </div>

        <button class="btn btn-primary mb-3" onclick="showAddForm()">Thêm mới nhân viên y tế</button>
        <a href="{{ route('admin.specialties.specialtyList') }}" class="btn btn-primary mb-3">Danh sách chuyên ngành</a>

        <div id="alertMessage" class="alert d-none"></div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên nhân viên y tế</th>
                        <th>Chuyên ngành</th>
                        <th>Ảnh đại diện</th>
                        <th>Giá một buổi khám</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="doctorsTableBody">
                    @foreach($doctors as $doctor)
                    <tr id="doctor-row-{{ $doctor->id }}" data-specialty-id="{{ $doctor->specialty->id }}">
                        <td>{{ $doctor->id }}</td>
                        <td>{{ $doctor->user->name }}</td>
                        <td>{{ $doctor->specialty->name }}</td>
                        <td>
                            <img src="{{ asset('upload/' . $doctor->user->image) }}" alt="Doctor Image" style="width: 50px; height: 50px;">
                        </td>
                        <td>{{ number_format($doctor->price, 0, ',', '.') }} vnd</td>
                        <td>{{ $doctor->user->email }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="showEditForm({{ $doctor->id }})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteDoctor({{ $doctor->id }})">Delete</button>
                            <button class="btn btn-info btn-sm" onclick="viewDoctorDetails({{ $doctor->id }})">View Details</button>
                            <a href="{{ route('admin.doctors.doctor.schedule', $doctor->id) }}" class="btn btn-red btn-sm" style="background-color: gray; color: white;">Thời gian làm việc</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

<div class="pagination-container">
    {{ $doctors->links('pagination::bootstrap-4') }}
</div>

    </div>

    <div class="modal fade" id="addEditDoctorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="doctorForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add New Doctor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="doctorId">
                        <div class="mb-3">
                            <label for="doctorName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="doctorName">
                        </div>
                        <div class="mb-3">
                            <label for="doctorPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="doctorPhone">
                        </div>
                        <div class="mb-3">
                            <label for="doctorEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="doctorEmail">
                        </div>
                        <div class="mb-3">
                            <label for="doctorPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="doctorPassword">
                        </div>
                        <div class="mb-3">
                            <label for="doctorAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="doctorAddress">
                        </div>
                        <div class="mb-3">
                            <label for="doctorSpecialty" class="form-label">Specialty</label>
                            <select class="form-select" id="doctorSpecialty">
                                <option value="">Select Specialty</option>
                                @foreach($specialties as $specialty)
                                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="doctorPrice" class="form-label">Giá mỗi buổi khám</label>
                            <input type="number" class="form-control" id="doctorPrice" placeholder="Nhập giá" min="0" required>
                            <small class="form-text text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Nhập giá khám của bác sĩ (VNĐ)">Giá phải là số dương.</small>
                        </div>
                        <div class="mb-3">
                            <label for="doctorBio" class="form-label">Bio</label>
                            <textarea class="form-control" id="doctorBio">{{ $doctor->bio ?? '' }}</textarea>
                        </div>
                        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
                        <script>
                            CKEDITOR.replace('doctorBio');

                            CKEDITOR.instances['doctorBio'].on('instanceReady', function() {
                                var existingBio = @json($doctor -> bio ?? '');
                                if (existingBio) {
                                    this.setData(existingBio);
                                }
                            });
                        </script>


                        <div class="mb-3">
                            <label for="doctorImage" class="form-label">Image</label>
                            <input type="file" class="form-control" id="doctorImage" accept="image/jpeg, image/png" onchange="previewImage(event)">
                            <img id="imagePreview" src="" alt="Image Preview" style="display: none; margin-top: 10px; max-width: 100%; height: auto;" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="doctorDetailsModal" tabindex="-1" aria-labelledby="doctorDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="doctorDetailsModalLabel">Doctor Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="doctorDetailsContent">
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function limitString(str, maxLength, suffix = '...') {
            if (str.length > maxLength) {
                return str.substring(0, maxLength) + suffix;
            }
            return str;
        }

        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0]; 

            if (file) {
                const reader = new FileReader(); 

                reader.onload = function(e) {
                    imagePreview.src = e.target.result; 
                    imagePreview.style.display = 'block'; 
                };

                reader.readAsDataURL(file); 
            } else {
                imagePreview.src = ''; 
                imagePreview.style.display = 'none'; 
            }
        }

        
        function showAddForm() {
            document.getElementById('doctorForm').reset();
            document.getElementById('doctorId').value = '';
            document.getElementById('modalTitle').textContent = 'Add New Doctor';
            let modal = new bootstrap.Modal(document.getElementById('addEditDoctorModal'));
            modal.show();
        }

        function viewDoctorDetails(id) {
            axios.get(`/admin/doctors/doctorsDetails/${id}`) 
                .then(response => {
                    if (response.data) {
                        let doctor = response.data.data;
                        let detailsHtml = `
                            <div class="d-flex align-items-start">
                                <img src="/upload/${doctor.user.image}" style="width: 100px; height: 100px; object-fit: cover;" alt="Doctor Image" class="me-3"> <!-- Ảnh đại diện bên trái -->
                                <div>
                                    <h5>Doctor Name: ${doctor.user.name}</h5>
                                    <p><strong>Phone:</strong> ${doctor.user.phone}</p>
                                    <p><strong>Email:</strong> ${doctor.user.email}</p>
                                    <p><strong>Address:</strong> ${doctor.user.address}</p>
                                    <p><strong>Specialty:</strong> ${doctor.specialty.name}</p>
                                    <p><strong>Bio:</strong> ${doctor.bio}</p>
                                </div>
                            </div>
                        `;

                        document.getElementById('doctorDetailsContent').innerHTML = detailsHtml; 
                        let modal = new bootstrap.Modal(document.getElementById('doctorDetailsModal'));
                        modal.show(); 
                    }
                })
                .catch(error => {
                    console.error('Error fetching doctor details', error);
                });
        }


        function showEditForm(id) {
            axios.get(`/admin/doctors/doctorsEdit/${id}`)
                .then(response => {
                    if (response.data) {
                        let doctor = response.data.data;
                        document.getElementById('doctorId').value = doctor.id;
                        document.getElementById('doctorName').value = doctor.user.name;
                        document.getElementById('doctorPhone').value = doctor.user.phone;
                        document.getElementById('doctorEmail').value = doctor.user.email;
                        document.getElementById('doctorPassword').value = '';
                        document.getElementById('doctorAddress').value = doctor.user.address;
                        document.getElementById('doctorSpecialty').value = doctor.specialty.id;
                        document.getElementById('doctorPrice').value = doctor.price;

                        CKEDITOR.instances['doctorBio'].setData(doctor.bio);

                        if (doctor.user.image) {
                            document.getElementById('imagePreview').src = `/upload/${doctor.user.image}`;
                            document.getElementById('imagePreview').style.display = 'block';
                        }

                        let modal = new bootstrap.Modal(document.getElementById('addEditDoctorModal'));
                        modal.show();
                    }
                })
                .catch(error => {
                    console.error('Error fetching doctor', error);
                });
        }


        document.getElementById('doctorForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let id = document.getElementById('doctorId').value;
            let name = document.getElementById('doctorName').value;
            let phone = document.getElementById('doctorPhone').value;
            let email = document.getElementById('doctorEmail').value;
            let password = document.getElementById('doctorPassword').value;
            let address = document.getElementById('doctorAddress').value;
            let specialty = document.getElementById('doctorSpecialty').value;
            let image = document.getElementById('doctorImage').files[0]; 
            let price = document.getElementById('doctorPrice').value;

            
            let bio = CKEDITOR.instances['doctorBio'].getData();

            let formData = new FormData();
            formData.append('name', name);
            formData.append('phone', phone);
            formData.append('email', email);
            formData.append('address', address);
            formData.append('specialty_id', specialty);
            formData.append('price', price);
            formData.append('bio', bio); 
            if (password) {
                formData.append('password', password); 
            }
            if (image) {
                formData.append('image', image); 
            }

            if (id) {
                formData.append('_method', 'PUT'); 
                axios.post(`/admin/doctors/doctorsUpdate/${id}`, formData)
                    .then(response => {
                        if (response.data.success) {
                            showAlert('Doctor updated successfully!', 'success');
                            updateDoctorRow(response.data.doctor);
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error updating doctor', error);
                        showAlert('Error updating doctor!', 'danger');
                    });
            } else {
                axios.post('/admin/doctors/doctorsAdd', formData)
                    .then(response => {
                        if (response.data.success) {
                            showAlert('Doctor added successfully!', 'success');
                            addDoctorRow(response.data.doctor);
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error adding doctor', error);
                        showAlert('Error adding doctor!', 'danger');
                    });
            }
            let modal = bootstrap.Modal.getInstance(document.getElementById('addEditDoctorModal'));
            modal.hide();
        });


        function addDoctorRow(doctor) {
            let tableBody = document.getElementById('doctorsTableBody');
            let newRow = `
            <tr id="doctor-row-${doctor.id}">
            <td>${doctor.id}</td>
            <td>${doctor.user.name}</td>
            <td>${doctor.specialty.name}</td>
            <td><img src="/upload/${doctor.user.image ? doctor.user.image : 'default_image.png'}" style="width: 50px; height: 50px;" alt="Doctor Image"></td>
            <td>${doctor.price}</td>
            <td>${doctor.user.email}</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="showEditForm(${doctor.id})">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteDoctor(${doctor.id})">Delete</button>
                <button class="btn btn-info btn-sm" onclick="viewDoctorDetails(${doctor.id})">View Details</button>
            </td>
        </tr>`;
            tableBody.insertAdjacentHTML('beforeend', newRow);
        }


        function updateDoctorRow(doctor) {
            console.log('Doctor object:', doctor); 
            let doctorRow = document.getElementById(`doctor-row-${doctor.id}`);
            if (doctorRow) {
                doctorRow.innerHTML = `
                <td>${doctor.id}</td>
                <td>${doctor.user.name}</td>
                <td>${doctor.specialty ? doctor.specialty.name : 'N/A'}</td> <!-- Kiểm tra specialty -->
                <td><img id="doctor-img-${doctor.id}" src="/upload/${doctor.user.image ? doctor.user.image : 'default_image.png'}" style="width: 50px; height: 50px;" alt="Doctor Image"></td>
                <td>${doctor.price}</td>
                <td>${doctor.user.email}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="showEditForm(${doctor.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteDoctor(${doctor.id})">Delete</button>
                    <button class="btn btn-info btn-sm" onclick="viewDoctorDetails(${doctor.id})">View Details</button>
                </td>`;
            } else {
                console.error('Doctor row not found:', `doctor-row-${doctor.id}`);
            }
        }

       
        function showAlert(message, type) {
            const alertMessage = document.getElementById('alertMessage');
            alertMessage.className = `alert alert-${type}`;
            alertMessage.innerHTML = message;
            alertMessage.classList.remove('d-none');
            setTimeout(() => {
                alertMessage.classList.add('d-none');
            }, 3000); 
        }

       
        function deleteDoctor(id) {
            if (confirm("Are you sure you want to delete this doctor?")) {
                axios.delete(`/admin/doctors/doctorsDestroy/${id}`)
                    .then(response => {
                        if (response.data.success) {
                            showAlert('Doctor deleted successfully!', 'success');
                            document.getElementById(`doctor-row-${id}`).remove(); 
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting doctor', error);
                        showAlert('Error deleting doctor!', 'danger');
                    });
            }
        }

        function filterBySpecialty() {
            let specialtyId = document.getElementById('specialtyFilter').value; 
            let input = document.getElementById('searchInput').value.toLowerCase(); 
            let rows = document.querySelectorAll('#doctorsTableBody tr'); 

            rows.forEach(row => {
                let rowSpecialtyId = row.getAttribute('data-specialty-id'); 
                let nameCell = row.getElementsByTagName('td')[1]; 
                let emailCell = row.getElementsByTagName('td')[4]; 

                let nameText = nameCell.textContent.toLowerCase(); 
                let emailText = emailCell.textContent.toLowerCase(); 

                if ((specialtyId === "" || rowSpecialtyId === specialtyId) &&
                    (nameText.indexOf(input) > -1 || emailText.indexOf(input) > -1)) {
                    row.style.display = ''; 
                } else {
                    row.style.display = 'none'; 
                }
            });
        }
    </script>
@endsection