@extends('admin.layout')
@section('titlepage','')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container">
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <h1>Lịch Làm Việc của Bác Sĩ: {{ $doctor->user->name }}</h1>
    <h3>Chuyên khoa: {{ $doctor->specialty->name }}</h3>

    <!-- Nút Thêm Lịch -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEditScheduleModal" onclick="showAddForm()">Thêm Lịch</button>
    @if($schedules->isEmpty())
    <p>Không có lịch làm việc nào được ghi nhận.</p>
    @else
    <div class="table-responsive">
        @php
        $daysOfWeek = [
        0 => 'Chủ nhật',
        1 => 'Thứ 2',
        2 => 'Thứ 3',
        3 => 'Thứ 4',
        4 => 'Thứ 5',
        5 => 'Thứ 6',
        6 => 'Thứ 7'
        ];
        @endphp

        @foreach ($daysOfWeek as $dayIndex => $dayName)
        @php
        $filteredSchedules = $schedules->filter(function($schedule) use ($dayIndex) {
        return $schedule->dayOfWeek == $dayIndex;
        });
        @endphp

        @if ($filteredSchedules->count() > 0)
        <h3>{{ $dayName }}</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ca</th>
                    <th>Thời gian bắt đầu</th>
                    <th>Thời gian kết thúc</th>
                    <th>Ngày</th>
                    <th>Có sẵn</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filteredSchedules as $schedule)
                @if($schedule->isAvailable == 0)

                @else
                @php
                $formattedDate = \Carbon\Carbon::parse($schedule->date)
                ->locale('vi')
                ->isoFormat('dddd, D/MM/YYYY');
                $startTime = \Carbon\Carbon::parse($schedule->startTime);
                $shift = $startTime->hour < 12 ? 'Ca sáng' : 'Ca chiều' ;
                    @endphp
                    <tr id="schedule-row-{{ $schedule->id }}">
                    <td>{{ $shift }}</td>
                    <td>{{ $schedule->startTime }}</td>
                    <td>{{ $schedule->endTime }}</td>
                    <td>{{ $formattedDate }}</td>
                    <td>{{ $schedule->isAvailable ? 'Có' : 'Không' }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-btn"
                            data-id="{{ $schedule->id }}"
                            data-day="{{ $schedule->dayOfWeek }}"
                            data-start="{{ $schedule->startTime }}"
                            data-end="{{ $schedule->endTime }}"
                            data-date="{{ $schedule->date }}"
                            data-available="{{ $schedule->isAvailable }}">Sửa</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $schedule->id }}">Xóa</button>
                    </td>
                    </tr>
                    @endif
                    @endforeach
            </tbody>
        </table>

        @else
        <h3>{{ $dayName }}</h3>
        <p>Không có lịch làm việc nào cho ngày này.</p>
        @endif
        @endforeach
    </div>

    @endif

    <div class="modal fade" id="addEditScheduleModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Thêm Lịch Làm Việc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.timeslot.scheduleAdd') }}" method="POST">
                        @csrf
                        <input type="hidden" id="scheduleId" name="id">
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                        <!-- Chọn thứ làm việc -->
                        <div class="mb-3">
                            <label class="form-label">Chọn Thứ Làm Việc Trong Tháng</label>
                            <div id="daySelection">
                                @php
                                use Carbon\Carbon;
                                $currentDate = Carbon::now()->startOfMonth();
                                @endphp

                                @for ($monthOffset = 0; $monthOffset < 3; $monthOffset++)
                                    @php
                                    $dateForMonth = $currentDate->copy()->addMonths($monthOffset);
                                    $daysInMonth = $dateForMonth->daysInMonth;
                                    @endphp
 
                                    <h5>{{ $dateForMonth->locale('vi')->isoFormat('MMMM, YYYY') }}</h5>

                                    @for ($day = 1; $day <= $daysInMonth; $day++)
                                        @php
                                        $date = Carbon::createFromDate($dateForMonth->year, $dateForMonth->month, $day);
                                        $dayOfWeek = $date->locale('vi')->isoFormat('dddd');
                                        $isPast = $date->isPast();
                                        $isToday = $date->isToday();
                                        @endphp
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input day-checkbox" type="checkbox" 
                                                id="day{{ $date->format('Ymd') }}" 
                                                name="days[]" 
                                                value="{{ $dayOfWeek }} {{ $date->format('d/m/Y') }}" 
                                                @if($isPast) disabled @endif 
                                                data-date="{{ $date->format('Y-m-d') }}">
                                            
                                            <label class="form-check-label" for="day{{ $date->format('Ymd') }}"
                                                @if($isPast) style="color:red;"
                                                @elseif($isToday) style="color:blue;"
                                                @endif>
                                                {{ $dayOfWeek }} ({{ $date->format('d/m/Y') }})
                                            </label>
                                        </div>
                                    @endfor
                                @endfor
                            </div>


                        </div>

                        <div class="mb-3" id="shiftSelection" style="display: none;">
                            <label class="form-label">Chọn Ca Làm Việc</label>
                            <div id="shiftsContainer"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="isAvailable" class="form-label">Có sẵn</label>
                            <select class="form-select" id="isAvailable" name="isAvailable">
                                <option value="1">Có</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Form chỉnh sửa ẩn -->
    <div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editScheduleModalLabel">Chỉnh sửa lịch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editScheduleForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_schedule_id" name="id">

                        <div class="mb-3">
                            <label for="edit_dayOfWeek" class="form-label">Chọn Thứ và Ngày trong Tháng</label>
                            <select class="form-control" id="edit_dayOfWeek" name="dayOfWeek">
                                @for($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                    $date=Carbon::createFromDate($currentDate->year, $currentDate->month, $day);
                                    $dayOfWeek = $date->dayOfWeek;
                                    if ($date->isToday() || $date->isFuture()) {
                                    @endphp
                                    @if(empty($daysOfWeek) != 'Null')
                                    <option value="{{$dayOfWeek}}" data-date="{{ $date->format('Y-m-d') }}">
                                        {{ $daysOfWeek[$dayOfWeek] }} ({{ $date->format('d/m/Y') }})
                                    </option>
                                    @endif
                                    @php
                                    }
                                    @endphp
                                    @endfor
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edit_date" class="form-label">Ngày</label>
                            <input type="text" class="form-control" id="edit_date" name="date" readonly>
                        </div>


                        <div class="mb-3">
                            <label for="edit_startTime" class="form-label">Chọn Thời gian Bắt đầu</label>
                            <select class="form-control" id="edit_startTime" name="startTime">
                                <option value="08:00:00">Ca 1 Sáng (08:00) -> (08:30)</option>
                                <option value="09:00:00">Ca 2 Sáng (09:00) -> (09:30)</option>
                                <option value="10:00:00">Ca 3 Sáng (10:00) -> (10:30)</option>
                                <option value="13:30:00">Ca 1 Chiều (13:30) -> (14:00)</option>
                                <option value="14:30:00">Ca 2 Chiều (14:30) -> (15:00)</option>
                                <option value="15:30:00">Ca 3 Chiều (15:30) -> (16:00)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edit_endTime" class="form-label">Thời gian Kết thúc</label>
                            <input type="text" class="form-control" id="edit_endTime" name="endTime" readonly>
                        </div>


                        <div class="mb-3">
                            <label for="edit_isAvailable" class="form-label">Có sẵn</label>
                            <select class="form-select" id="edit_isAvailable" name="isAvailable">
                                <option value="1">Có</option>
                                <option value="0">Không</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dayOfWeekSelect = document.getElementById('edit_dayOfWeek');
            const dateInput = document.getElementById('edit_date');
            dayOfWeekSelect.addEventListener('change', function() {
                const selectedOption = dayOfWeekSelect.options[dayOfWeekSelect.selectedIndex];
                const selectedDate = selectedOption.getAttribute('data-date');
                dateInput.value = selectedDate;
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const startTimeSelect = document.getElementById('edit_startTime');
            const endTimeInput = document.getElementById('edit_endTime');
            const timeMapping = {
                '08:00:00': '08:30:00',
                '09:00:00': '09:30:00',
                '10:00:00': '10:30:00',
                '11:00:00': '11:30:00',
                '13:30:00': '14:00:00',
                '14:30:00': '15:00:00',
                '15:30:00': '16:00:00',
                '16:30:00': '17:00:00'
            };

            startTimeSelect.addEventListener('change', function() {
                const selectedStartTime = startTimeSelect.value;
                const correspondingEndTime = timeMapping[selectedStartTime];
                endTimeInput.value = correspondingEndTime;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const dayCheckboxes = document.querySelectorAll('.day-checkbox');
            const shiftsContainer = document.getElementById('shiftsContainer');
            const shiftSelection = document.getElementById('shiftSelection');
            dayCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    updateShiftSelection();
                });
            });

            function updateShiftSelection() {
                shiftsContainer.innerHTML = '';
                let anyDaySelected = false;
                dayCheckboxes.forEach(function(dayCheckbox) {
                    if (dayCheckbox.checked) {
                        anyDaySelected = true;
                        const dayLabel = dayCheckbox.nextElementSibling.innerText;
                        const dayValue = dayCheckbox.value;
                        const shiftHtml = `
                            <div class="mb-3">
                                <label class="form-label">${dayLabel}</label>
                                <div class="mb-2">
                                    <strong>Ca Sáng</strong>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="shifts[${dayValue}][]" value="8:00-8:30">
                                    <label class="form-check-label">Ca 1 (8:00 - 8:30)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="shifts[${dayValue}][]" value="9:00-9:30">
                                    <label class="form-check-label">Ca 2 (9:00 - 9:30)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="shifts[${dayValue}][]" value="10:00-10:30">
                                    <label class="form-check-label">Ca 3 (10:00 - 10:30)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="shifts[${dayValue}][]" value="11:00-11:30">
                                    <label class="form-check-label">Ca 4 (11:00 - 11:30)</label>
                                </div>
                                <div class="mt-3 mb-2">
                                    <strong>Ca Chiều</strong>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="shifts[${dayValue}][]" value="13:30-14:00">
                                    <label class="form-check-label">Ca 1 (13:30-14:00)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="shifts[${dayValue}][]" value="14:30-15:00">
                                    <label class="form-check-label">Ca 2 (14:30-15:00)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="shifts[${dayValue}][]" value="15:30-16:00">
                                    <label class="form-check-label">Ca 3 (15:30-16:00)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="shifts[${dayValue}][]" value="16:30-17:00">
                                    <label class="form-check-label">Ca 4 (16:30-17:00)</label>
                                </div>
                            </div>`;
                        shiftsContainer.insertAdjacentHTML('beforeend', shiftHtml);
                    }
                });
                shiftSelection.style.display = anyDaySelected ? 'block' : 'none';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-btn');
            const editScheduleModal = new bootstrap.Modal(document.getElementById('editScheduleModal'));

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const scheduleId = this.getAttribute('data-id');
                    const dayOfWeek = this.getAttribute('data-day');
                    const startTime = this.getAttribute('data-start');
                    const endTime = this.getAttribute('data-end');
                    const date = this.getAttribute('data-date');
                    const isAvailable = this.getAttribute('data-available');

                    document.getElementById('edit_schedule_id').value = scheduleId;
                    document.getElementById('edit_dayOfWeek').value = dayOfWeek;
                    document.getElementById('edit_startTime').value = startTime;
                    document.getElementById('edit_endTime').value = endTime;
                    document.getElementById('edit_date').value = date;
                    document.getElementById('edit_isAvailable').value = isAvailable ? '1' : '0';
                    editScheduleModal.show();
                });
            });

            const editScheduleForm = document.getElementById('editScheduleForm');
            editScheduleForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const scheduleId = document.getElementById('edit_schedule_id').value;
                const dayOfWeek = document.getElementById('edit_dayOfWeek').value;
                const selectedDate = document.querySelector('#edit_dayOfWeek option:checked').getAttribute('data-date');
                const startTime = document.getElementById('edit_startTime').value;
                const endTime = document.getElementById('edit_endTime').value;
                const isAvailable = document.getElementById('edit_isAvailable').value;

                const formData = {
                    dayOfWeek: dayOfWeek,
                    date: selectedDate,
                    startTime: startTime,
                    endTime: endTime,
                    isAvailable: isAvailable
                };

                console.log('dayOfWeek:', dayOfWeek);
                console.log('scheduleId:', scheduleId);
                console.log('startTime:', startTime);
                console.log('endTime:', endTime);
                console.log('isAvailable:', isAvailable);

                axios.put(`/admin/timeslot/scheduleUpdate/${scheduleId}`, formData)
                    .then(response => {
                        editScheduleModal.hide();
                        alert(response.data.message);
                        window.location.reload();
                    })
                    .catch(error => {
                        alert('Đã xảy ra lỗi: ' + error.response.data.message);
                    });
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const scheduleId = this.getAttribute('data-id');

                    if (confirm('Bạn có chắc chắn muốn xóa lịch làm việc này không?')) {
                        axios.delete(`/admin/timeslot/scheduleDestroy/${scheduleId}`)
                            .then(response => {
                                const row = document.getElementById('schedule-row-' + scheduleId);
                                row.remove();
                                alert(response.data.message);
                            })
                            .catch(error => {
                                alert('Đã xảy ra lỗi: ' + error.response.data.message);
                            });
                    }
                });
            });
        });



        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
    @endsection