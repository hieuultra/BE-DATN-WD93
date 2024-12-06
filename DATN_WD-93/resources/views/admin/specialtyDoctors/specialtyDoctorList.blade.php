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
              <tbody>
                @foreach($specialty as $items)
                <tr @if($items->classification == 0) style="background-color: gray;" @endif>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{$items->name}}</td>
                  <td> <img src="{{ asset('upload/'.$items->image)  }}" width="150" height="90" alt=""></td>
                  <td class="text-center">
                    <a href="" class="btn btn-warning">
                      <form action="{{ route('admin.specialties.specialtyUpdateForm', $items->id) }}" method="GET">
                        <button style="background: none;  border: none; outline: none;" type="submit">
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                          </svg>
                        </button>
                      </form>
                    </a>
                    <!-- Thêm nút delete -->
                    <a href="" class="btn btn-danger">
                      <form action="{{ route('admin.specialties.specialtyDestroy', $items->id) }}" method="POST">
                        @csrf
                        <button style="background: none;  border: none; outline: none;" type="submit" onclick="return confirm('Bạn có chắc chắn muốn dừng hoạt động chuyên khoa này?')">
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
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
          {{ $specialty->links('pagination::bootstrap-4') }}
        </ul>
      </nav>
    </div>


    {{-- List Product Variant --}}
    <div class="row">
      {{-- Package --}}
      <div class="col">
        <div class="card mb-4">

          {{-- hien thi tb success --}}

          <div class="card-header d-flex justify-content-between">
            <div>
              <i class="fas fa-table me-1"></i>
              Danh sách bác sỹ
            </div>
            <a href="{{ route('admin.doctors.viewDoctorAdd') }}">
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
                  <th scope="col" style="width: 200px;">Số điện thoại</th>
                  <th scope="col">Địa chỉ</th>
                  <th scope="col">Chuyên khoa</th>
                  <th class="text-center" style="width: 190px;" scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody>

                @foreach($doctor as $d)
                @php
                $doc = $d->user;
                $docs = $d->specialty;
                $do = $d->clinic->first();
                @endphp
                <tr @if($doc->role == 'User') style="background-color: gray;" @endif>
                  <th scope="row">{{ $d->id }}</th>
                  <td>
                    {{$doc->name}}
                  </td>

                  <td>
                    <img src="{{ asset('upload/'.$doc->image)  }}" width="150" height="90" alt="">
                  </td>
                  <td>
                    {{$doc->phone}}
                  </td>
                   @if ($do)
                    <td> {{ $do->city }} </td>
                    @else
                       <td>Chưa có địa chỉ</td>
                    @endif
                  <td>{{$docs->name}}</td>
                  <td class="text-center">
                    <div @if($doc->role == 'User') style="display: none;" @endif>
                    <div class="time-icon">
                      <a href="{{ route('timeslot.doctor.schedule', $d->id) }}"><i class="fas fa-clock"></i></a>
                    </div>
                    <div class="time-icon">
                      <a style="text-decoration: none;" href="{{ route('admin.achievements.doctor.achievements', $d->id) }}">Thành tựu bác sĩ</a>
                    </div>
                    </div>

                    <a href="" class="btn btn-warning">
                      <form action="{{ route('admin.doctors.doctorUpdateForm', $d->id) }}" method="GET">
                        <button style="background: none;  border: none; outline: none;" type="submit">
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                          </svg>
                        </button>
                      </form>
                    </a>
                    <!-- Thêm nút delete -->
                    <a href="" class="btn btn-danger">
                      <form action="{{ route('admin.doctors.doctorDestroy', $d->id) }}" method="POST">
                        @csrf
                        <button style="background: none;  border: none; outline: none;" type="submit" onclick="return confirm('Bạn có chắc chắn muốn bác sỹ này nghỉ việc không?')">
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
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
      {{ $doctor->links('pagination::bootstrap-4') }}
    </div>

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
                    <!-- Thêm nút delete -->
                    <a href="" class="btn btn-danger">
                        <form action="{{ route('admin.packages.packageDestroy', $d->id) }}" method="POST">
                            @csrf
                            <button style="background: none;  border: none; outline: none;" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa dịch vụ khám này không?')">
                              <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
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
