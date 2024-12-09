@extends('admin.layout')
@section('titlepage','')

@section('content')
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">


<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Danh sách lịch làm việc của bác sỹ tháng {{ $currentMonth }}/{{ $currentYear }}</h3>
            <a href="{{ route('admin.specialties.specialtyDoctorList') }}">
                <input type="button" class="btn btn-primary" value="Quay lại">
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mb-0" id="doctorsTable">
                    <thead class="">
                        <tr>
                            <th class="text-center">STT</th>
                            <th>Tên bác sĩ</th>
                            <th>Chuyên khoa</th>
                            <th class="text-center">Số giờ làm việc còn sẵn</th>
                            <th class="text-center">Số lịch khám đã đặt trong tháng</th>
                            <th>Thêm lịch làm việc cho bác sỹ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leastAvailableDoctors as $index => $doctor)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $doctor->user->name }}</td>
                            <td>{{ $doctor->specialty->name }}</td>
                            <td class="text-center 
                                @if($doctor->available_times_count <= 10) bg-danger text-white 
                                @elseif($doctor->available_times_count > 10 && $doctor->available_times_count <= 20) bg-warning text-white 
                                @else bg-success text-white 
                                @endif
                            ">
                                {{ $doctor->available_times_count }}
                            </td>
                            <td class="text-center 
                                @if($doctor->booked_appointments_count <= 10) bg-danger text-white 
                                @elseif($doctor->booked_appointments_count > 10 && $doctor->booked_appointments_count <= 60) bg-warning text-white 
                                @else bg-success text-white 
                                @endif
                            ">
                                {{ $doctor->booked_appointments_count }}
                            </td>
                            <td>
                                <a href="{{ route('admin.timeslot.timeslotList', $doctor->id) }}" style="text-decoration: none;">Quản lý lịch làm việc</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Không có dữ liệu nào để hiển thị</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Khởi tạo DataTables với phân trang mỗi trang hiển thị 8 bác sĩ
        $('#doctorsTable').DataTable({
            "pageLength": 8, // Số lượng bác sĩ hiển thị mỗi trang
            "lengthChange": false, // Tắt thay đổi số lượng bản ghi mỗi trang
            "searching": true, // Cho phép tìm kiếm trong bảng
            "ordering": true, // Cho phép sắp xếp các cột
            "info": true, // Hiển thị thông tin về số bản ghi
            "paging": true, // Bật phân trang
            "language": {
                "paginate": {
                    "previous": "Trước",
                    "next": "Sau"
                },
                "info": "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ bác sĩ"
            }
        });
    });
</script>
@endsection