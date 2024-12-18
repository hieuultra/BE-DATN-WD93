@extends('admin.layout')
@section('titlepage','')

@section('content')
<style>
  .time-icon {
    font-size: 24px;
    /* Adjust size */
    color: #333;
    /* Adjust color */
    cursor: pointer;
  }
</style>
<main>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Chuyên khoa + Bác sỹ</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Bảng điều khiển</li>
    </ol>

    <!-- Data -->
    <div class="row">
      {{-- Package --}}
      <div class="col">
        <div class="card mb-4">

          {{-- hien thi tb success --}}

          <div class="card-header d-flex justify-content-between">
            <div>
              <i class="fas fa-table me-1"></i>
              Danh sách chuyên khoa
            </div>
            <a href="{{ route('admin.specialties.viewSpecialtyAdd') }}">
              <input type="submit" class="btn btn-primary" name="them" value="Thêm">
            </a>
          </div>
          <div class="card-body">
            {{-- Hiển thị thông báo --}}
            @if (session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>

            @endif

            <form method="GET" action="{{ route('admin.specialties.specialtyDoctorList') }}" class="mb-3">
              <label for="classification">Lọc theo Phân loại:</label>
              <select name="classification" id="classification" onchange="this.form.submit()">
                <option value="">-- Tất cả --</option>
                <option value="chuyen_khoa" {{ request('classification') == 'chuyen_khoa' ? 'selected' : '' }}>Chuyên khoa</option>
                <option value="kham_tu_xa" {{ request('classification') == 'kham_tu_xa' ? 'selected' : '' }}>Khám từ xa</option>
                <option value="tong_quat" {{ request('classification') == 'tong_quat' ? 'selected' : '' }}>Khám tổng quát</option>
              </select>
            </form>

            <table class="table">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Tên</th>
                  <th scope="col">Ảnh</th>
                  <th class="text-center" scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody id="specialtyTableBody">
                @foreach($specialty as $items)
                <tr @if($items->classification == 0) style="background-color: gray;" @endif>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $items->name }}</td>
                  <td><img src="{{ asset('upload/'.$items->image) }}" width="150" height="90" alt=""></td>
                  <td class="text-center">
                    <a href="" class="btn btn-warning">
                      <form action="{{ route('admin.specialties.specialtyUpdateForm', $items->id) }}" method="GET">
                        <button style="background: none; border: none; outline: none;" type="submit">
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                          </svg>
                        </button>
                      </form>
                    </a>
                    @if($items->classification != 0)
                    <a href="" class="btn btn-danger">
                      <form action="{{ route('admin.specialties.specialtyDestroy', $items->id) }}" method="POST">
                        @csrf
                        <button style="background: none; border: none; outline: none;" type="submit" onclick="return confirm('Bạn có chắc chắn muốn dừng hoạt động chuyên khoa này?')">
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                          </svg>
                        </button>
                      </form>
                    </a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <!-- Vùng hiển thị các nút phân trang -->
            <div id="paginationControls" class="mt-3"></div>
          </div>
        </div>
      </div>
    </div>

    <script>
      const rowsPerPage = 4;
      const tableBody = document.getElementById('specialtyTableBody');
      const paginationControls = document.getElementById('paginationControls');
      const rows = Array.from(tableBody.getElementsByTagName('tr'));

      let currentPage = 1;

      function displayPage(page) {
        const startIndex = (page - 1) * rowsPerPage;
        const endIndex = page * rowsPerPage;
        rows.forEach((row, index) => {
          row.style.display = (index >= startIndex && index < endIndex) ? '' : 'none';
        });
      }


      function createPaginationControls() {
        const totalPages = Math.ceil(rows.length / rowsPerPage);
        paginationControls.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
          const button = document.createElement('button');
          button.textContent = i;
          button.className = 'btn btn-primary mx-1';
          button.addEventListener('click', () => {
            currentPage = i;
            displayPage(currentPage);
            updateActiveButton();
          });
          paginationControls.appendChild(button);
        }

        updateActiveButton();
      }

      function updateActiveButton() {
        const buttons = paginationControls.getElementsByTagName('button');
        Array.from(buttons).forEach((button, index) => {
          if (index === currentPage - 1) {
            button.classList.add('active');
          } else {
            button.classList.remove('active');
          }
        });
      }

      createPaginationControls();
      displayPage(currentPage);
    </script>

    <div class="row">
      <div class="col">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between">
            <div>
              <i class="fas fa-table me-1"></i> Danh sách bác sỹ
            </div>
            <a href="{{ route('admin.doctors.viewDoctorAdd') }}">
              <input type="submit" class="btn btn-primary" name="them" value="Thêm mới bác sỹ">
            </a>
            <a href="{{ route('admin.timeslot.timdoctorlist') }}" style="text-decoration: none;">
               Quản lý lịch làm việc của bác sỹ
            </a>
          </div>
          <div class="card-body">
            {{-- Search Input --}}
            <div class="mb-3">
              <input type="text" id="doctorSearch" class="form-control" placeholder="Tìm bác sỹ theo họ hoặc tên..." onkeyup="searchDoctor()">
            </div>

            <table class="table">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col" style="width: 280px;">Tên</th>
                  <th scope="col" style="width: 220px;">Ảnh</th>
                  <th scope="col" style="width: 200px;">Số điện thoại</th>
                  <th scope="col">Địa chỉ</th>
                  <th scope="col">Chuyên khoa</th>
                  <th class="text-center" style="width: 190px;" scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody id="doctorTableBody">
                @foreach($doctor as $d)
                @php
                $doc = $d->user;
                $docs = $d->specialty;
                $do = $d->clinic->first();
                @endphp
                <tr @if($doc->role == 'User') style="background-color: gray;" @endif>
                  <th scope="row">{{ $d->id }}</th>
                  <td id="doctor">{{ $doc->name }}</td>
                  <td><img src="{{ asset('upload/'.$doc->image) }}" width="150" height="90" alt=""></td>
                  <td>{{ $doc->phone }}</td>
                  <td>@if ($do) {{ $do->city }} @else Chưa có địa chỉ @endif</td>
                  <td>{{ $docs->name }}</td>
                  <td class="text-center">

                    <a href="" class="btn btn-warning">
                      <form action="{{ route('admin.doctors.doctorUpdateForm', $d->id) }}" method="GET">
                        <button style="background: none; border: none; outline: none;" type="submit">
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                          </svg>
                        </button>
                      </form>
                    </a>
                    @if($doc->role != 'User')
                    <a href="" class="btn btn-danger">
                      <form action="{{ route('admin.doctors.doctorDestroy', $d->id) }}" method="POST">
                        @csrf
                        <button style="background: none; border: none; outline: none;" type="submit" onclick="return confirm('Bạn có chắc chắn muốn bác sỹ này nghỉ việc không?')">
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                          </svg>
                        </button>
                      </form>
                    </a>
@endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            <div id="doctorPaginationControls" class="mt-3"></div>
          </div>
        </div>
      </div>
    </div>

    <script>
      const rowsPerPageDoctor = 4;
      const doctorTableBody = document.getElementById('doctorTableBody');
      const doctorSearchInput = document.getElementById('doctorSearch');
      const doctorPaginationControls = document.getElementById('doctorPaginationControls');
      let currentPageDoctor = 1;

      function searchDoctor() {
        const query = doctorSearchInput.value.toLowerCase().trim();
        const queryWords = query.split(' ').filter(Boolean); 
        const rows = Array.from(doctorTableBody.getElementsByTagName('tr'));

        if (!query) {
          rows.forEach(row => row.style.display = '');
          displayPageDoctor(currentPageDoctor, rows);
          createPaginationControlsDoctor(rows);
          return;
        }

        let exactMatches = [];
        let partialMatches = [];

        rows.forEach(row => {
          const doctorNameElement = row.querySelector('td#doctor');
          if (!doctorNameElement) return;

          const doctorName = doctorNameElement.textContent.toLowerCase().trim();
          if (doctorName === query) {
            exactMatches.push(row);
          }
         
          else if (queryWords.every(word => doctorName.includes(word))) {
            partialMatches.push(row);
          } else {
            row.style.display = 'none'; 
          }
        });

        const filteredRows = [...exactMatches, ...partialMatches]; 

        if (filteredRows.length === 0) {
         
          rows.forEach(row => row.style.display = 'none');
          doctorPaginationControls.innerHTML = ''; 
          if (!document.getElementById('noResultsRow')) {
            const noResultsRow = document.createElement('tr');
            noResultsRow.id = 'noResultsRow';
            noResultsRow.innerHTML = `
        <td colspan="7" class="text-center text-danger">Không tìm thấy bác sĩ nào</td>
      `;
            doctorTableBody.appendChild(noResultsRow);
          }
        } else {
          if (document.getElementById('noResultsRow')) {
            document.getElementById('noResultsRow').remove();
          }
          rows.forEach(row => row.style.display = 'none'); 
          filteredRows.forEach(row => row.style.display = ''); 
          createPaginationControlsDoctor(filteredRows);
          displayPageDoctor(1, filteredRows);
        }
      }

      function displayPageDoctor(page, rows) {
        const startIndex = (page - 1) * rowsPerPageDoctor;
        const endIndex = page * rowsPerPageDoctor;

        rows.forEach((row, index) => {
          row.style.display = (index >= startIndex && index < endIndex) ? '' : 'none';
        });
      }

      function createPaginationControlsDoctor(rows) {
        const totalPages = Math.ceil(rows.length / rowsPerPageDoctor);
        doctorPaginationControls.innerHTML = '';

        if (totalPages <= 1) {
          return;
        }

        for (let i = 1; i <= totalPages; i++) {
          const button = document.createElement('button');
          button.textContent = i;
          button.classList.add('btn', 'btn-sm', 'btn-primary', 'mx-1');
          button.onclick = () => {
            currentPageDoctor = i;
            displayPageDoctor(i, rows);
          };
          doctorPaginationControls.appendChild(button);
        }
      }

      function initializePaginationDoctor() {
        const rows = Array.from(doctorTableBody.getElementsByTagName('tr'));
        createPaginationControlsDoctor(rows);
        displayPageDoctor(currentPageDoctor, rows);
      }

      initializePaginationDoctor();
    </script>





    {{-- List Product Variant --}}
    <div class="row">
      {{-- Package --}}
      <div class="col">
        <div class="card mb-4">

          {{-- hien thi tb success --}}

          <div class="card-header d-flex justify-content-between">
            <div>
              <i class="fas fa-table me-1"></i>
              Danh sách dịch vụ khám
            </div>
            <a href="{{ route('admin.packages.viewPackagesAdd') }}">
              <input type="submit" class="btn btn-primary" name="them" value="Thêm">
            </a>
          </div>
          <div class="card-body">
            {{-- Hiển thị thông báo --}}
            @if (session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
            @endif
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col" style="width: 280px;">Tên</th>
                  <th scope="col" style="width: 220px;">Ảnh</th>
                  <th scope="col">Địa chỉ</th>
                  <th scope="col">Chuyên khoa</th>
                  <th scope="col">Giá</th>
                  <th class="text-center" style="width: 190px;" scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody>

                @foreach($package as $d)
                @php
                $pacs = $d->specialty;
                @endphp
                <tr>
                  <th scope="row">{{ $d->id }}</th>
                  <td>
                    {{$d->hospital_name}}
                  </td>

                  <td>
                    <img src="{{ asset('upload/'.$d->image)  }}" width="150" height="90" alt="">
                  </td>
                  <td>
                    {{$d->address}}
                  </td>
                  <td>
                    {{$pacs->name}}
                  </td>
                  <td>
                    {{ number_format($d->price,0,',','.') }}VND
                  </td>
                  <td class="text-center">
                    <div class="time-icon">
                      <a href="{{ route('timeslot.showPackages', $d->id) }}"><i class="fas fa-clock"></i></a>
                    </div>
                    <div class="time-icon">
                      <a style="text-decoration: none;" href="{{ route('admin.medicalPackages.medicalPackages', $d->id) }}">Danh mục khám</a>
                    </div>

                    <a href="" class="btn btn-warning">
                      <form action="{{ route('admin.packages.packageUpdateForm', $d->id) }}" method="GET">
                        <button style="background: none;  border: none; outline: none;" type="submit">
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                          </svg>
                        </button>
                      </form>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div style="display: flex; justify-content: center; margin-top: 20px;">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          {{ $package->links('pagination::bootstrap-4') }}
        </ul>
      </nav>
    </div>

</main>

@endsection