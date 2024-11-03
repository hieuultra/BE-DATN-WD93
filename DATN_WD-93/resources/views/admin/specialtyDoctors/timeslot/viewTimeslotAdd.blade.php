@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">

    <h3>Thêm khung giờ khám cho bác sĩ {{ $doctor->user->name }}</h3>

    <form action="{{ route('admin.timeslot.timeslotAdd', $doctor->id) }}" method="POST">
        @csrf
        <!-- Day of the Week or Specific Date -->
        <div class="form-group">
            <label for="dayOfWeek">Chọn ngày trong tuần</label>
            <select name="dayOfWeek" class="form-control" id="dayOfWeek" required>
                <option value="Monday">Thứ hai</option>
                <option value="Tuesday">Thứ ba</option>
                <option value="Wednesday">Thứ tư</option>
                <option value="Thursday">Thứ năm</option>
                <option value="Friday">Thứ sáu</option>
                <option value="Saturday">Thứ bảy</option>
                <option value="Sunday">Chủ nhật</option>
            </select>
        </div>

        <!-- Specific Date (optional) -->
        <div class="form-group">
            <label for="date">Ngày cụ thể (nếu có)</label>
            <input type="date" name="date" class="form-control" id="date">
        </div>

        <!-- Start and End Time -->
        <div class="form-group">
            <label for="startTime">Thời gian bắt đầu</label>
            <input type="time" name="startTime" class="form-control" id="startTime" required>
        </div>

        <div class="form-group">
            <label for="endTime">Thời gian kết thúc</label>
            <input type="time" name="endTime" class="form-control" id="endTime" required>
        </div>

        <input type="submit" class="btn btn-primary mt-3" value="Thêm khung giờ">
        <a href="{{ route('admin.specialties.specialtyDoctorList') }}"> <input type="button" class="btn btn-primary mt-3" value="List Doctors"></a>
    </form>
</div>


@endsection
