@extends('admin.layout')
@section('titlepage', '')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container">
    <h1>Lịch Làm Việc của Bác Sĩ: {{ $doctor->user->name }}</h1>
    <h3>Chuyên khoa: {{ $doctor->specialty->name }}</h3>

    @if($schedules->isEmpty())
        <p>Không có lịch làm việc nào được ghi nhận.</p>
    @else
        <div class="table-responsive">
            <table class="table table-striped" id="schedulesTable">
                <thead>
                    <tr>
                        <th>Ngày trong tuần</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th>Ngày</th>
                        <th>Có sẵn</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                        <tr id="schedule-row-{{ $schedule->id }}">
                            <td>{{ $schedule->dayOfWeek }}</td>
                            <td>{{ $schedule->startTime }}</td>
                            <td>{{ $schedule->endTime }}</td>
                            <td>{{ $schedule->date->format('d/m/Y') }}</td>
                            <td>{{ $schedule->isAvailable ? 'Có' : 'Không' }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editSchedule({{ $schedule->id }})">Sửa</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteSchedule({{ $schedule->id }})">Xóa</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Nút Thêm Lịch -->
    <button class="btn btn-primary mb-3" id="addScheduleBtn">Thêm Lịch</button>

    <!-- Form thêm lịch làm việc -->
    <div id="addScheduleForm" style="display: none;">
        <h3>Thêm Lịch Làm Việc</h3>
        <form id="scheduleForm">
            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
            <div class="mb-3">
                <label for="dayOfWeek" class="form-label">Ngày trong tuần</label>
                <input type="text" class="form-control" name="dayOfWeek" required>
            </div>
            <div class="mb-3">
                <label for="startTime" class="form-label">Thời gian bắt đầu</label>
                <input type="time" class="form-control" name="startTime" required>
            </div>
            <div class="mb-3">
                <label for="endTime" class="form-label">Thời gian kết thúc</label>
                <input type="time" class="form-control" name="endTime" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Ngày</label>
                <input type="date" class="form-control" name="date" required>
            </div>
            <div class="mb-3">
                <label for="isAvailable" class="form-label">Có sẵn</label>
                <select class="form-select" name="isAvailable" required>
                    <option value="1">Có</option>
                    <option value="0">Không</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
            <button type="button" class="btn btn-secondary" id="cancelAddBtn">Hủy</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Xử lý thêm lịch làm việc
    document.getElementById('scheduleForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        axios.post('/admin/doctors/doctor/scheduleAdd', formData)
            .then(response => {
                if (response.data.success) {
                    const schedule = response.data.schedule;
                    const row = `<tr id="schedule-row-${schedule.id}">
                        <td>${schedule.dayOfWeek}</td>
                        <td>${schedule.startTime}</td>
                        <td>${schedule.endTime}</td>
                        <td>${schedule.date}</td>
                        <td>${schedule.isAvailable ? 'Có' : 'Không'}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editSchedule(${schedule.id})">Sửa</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteSchedule(${schedule.id})">Xóa</button>
                        </td>
                    </tr>`;
                    document.querySelector('#schedulesTable tbody').insertAdjacentHTML('beforeend', row);
                    document.getElementById('addScheduleForm').style.display = 'none'; // Ẩn form sau khi thêm
                }
            })
            .catch(error => {
                console.error('Error adding schedule', error);
            });

    });

    document.getElementById('addScheduleBtn').addEventListener('click', function() {
        document.getElementById('addScheduleForm').style.display = 'block'; // Hiển thị form
        document.getElementById('scheduleForm').reset(); // Đặt lại form về trạng thái ban đầu
    });

    document.getElementById('cancelAddBtn').addEventListener('click', function() {
        document.getElementById('addScheduleForm').style.display = 'none'; // Ẩn form
    });

    function editSchedule(id) {
        // Gọi API để lấy thông tin lịch làm việc hiện tại
        axios.get(`/admin/doctors/doctor/scheduleEdit/${id}`)
            .then(response => {
                if (response.data) {
                    const schedule = response.data.schedule;
                    document.querySelector('input[name="dayOfWeek"]').value = schedule.dayOfWeek;
                    document.querySelector('input[name="startTime"]').value = schedule.startTime;
                    document.querySelector('input[name="endTime"]').value = schedule.endTime;
                    document.querySelector('input[name="date"]').value = schedule.date;
                    document.querySelector('select[name="isAvailable"]').value = schedule.isAvailable ? '1' : '0';

                    // Cập nhật form để sửa
                    document.getElementById('scheduleForm').onsubmit = function(e) {
                        e.preventDefault();
                        updateSchedule(id);
                    };
                }
            })
            .catch(error => {
                console.error('Error fetching schedule', error);
            });
    }

    function updateSchedule(id) {
        const formData = new FormData(document.getElementById('scheduleForm'));

        axios.put(`/admin/doctors/doctor/scheduleUpdate/${id}`, formData)
            .then(response => {
                if (response.data.success) {
                    const scheduleRow = document.getElementById(`schedule-row-${id}`);
                    scheduleRow.querySelector('td:nth-child(1)').innerText = formData.get('dayOfWeek');
                    scheduleRow.querySelector('td:nth-child(2)').innerText = formData.get('startTime');
                    scheduleRow.querySelector('td:nth-child(3)').innerText = formData.get('endTime');
                    scheduleRow.querySelector('td:nth-child(4)').innerText = formData.get('date');
                    scheduleRow.querySelector('td:nth-child(5)').innerText = formData.get('isAvailable') === '1' ? 'Có' : 'Không';
                    document.getElementById('addScheduleForm').style.display = 'none'; // Ẩn form sau khi cập nhật
                }
            })
            .catch(error => {
                console.error('Error updating schedule', error);
            });
    }

    function deleteSchedule(id) {
        if (confirm('Bạn có chắc chắn muốn xóa lịch làm việc này không?')) {
            axios.delete(`/admin/doctors/doctor/scheduleDestroy/${id}`)
                .then(response => {
                    if (response.data.success) {
                        const scheduleRow = document.getElementById(`schedule-row-${id}`);
                        scheduleRow.remove();
                    }
                })
                .catch(error => {
                    console.error('Error deleting schedule', error);
                });
        }
    }
</script>
@endsection
