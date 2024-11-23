@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')
<style>
    .container {
    color: #FFFFFF;
}

.doctor-info {
    background-color: #333;
    padding: 20px;
    border-radius: 10px;
}

.doctor-header {
    display: flex;
    align-items: center;
}

.doctor-photo {
    width: 120px;
    height: auto;
    border-radius: 10px;
    margin-right: 15px;
}

.doctor-details h4 {
    color: #FFD700; /* Gold color for "Yêu thích" badge */
}

.appointment-schedule {
    background-color: #444;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
}

.date-selector select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.time-slots {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
}

.time-slot {
    background-color: #555;
    color: #FFF;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    width: 45%;
    text-align: center;
    margin-bottom: 10px;
}

.clinic-info {
    text-align: left;
    font-size: 0.9em;
    color: #DDD;
}

.details-link {
    color: #1E90FF;
    text-decoration: none;
}

</style>
<div class="container mt-5">
    <!-- Doctor Information Section -->
    <div class="row">
        @foreach($doctors as $doctor)
        <div class="col-md-8 doctor-info">
            <div class="doctor-header">
                <!-- Access each doctor's user property correctly here -->
                <img src="{{ asset('upload/' . $doctor->user->image) }}" alt="{{ $doctor->name }}" class="doctor-photo">

                <div class="doctor-details">
                    <h4>{{ $doctor->title }} {{ $doctor->user->name }}</h4>
                    <p>Bác sĩ có {{ $doctor->experience_years }} năm kinh nghiệm</p>
                    <p>{{ $doctor->position }}, {{ $doctor->workplace }}</p>
                    @isset($doctor->min_age)
                    <p>Bác sĩ nhận khám từ {{ $doctor->min_age }} tuổi trở lên</p>
                @endisset
                    <p><i class="fas fa-map-marker-alt"></i>{{ $doctor->user->address }}</p>
                </div>
            </div>
            <p class="doctor-description">
                {{ $doctor->description }}
            </p>
        </div>

        <!-- Appointment Schedule Section -->
        <div class="col-md-4 appointment-schedule">
            <h5>Lịch khám</h5>
            <div class="date-selector">
                <select>
                <!-- Tự động điền các tùy chọn ngày -->
                    <option value="2024-10-31">Chủ nhật - 3/11</option>
                <!-- Thêm ngày nếu cần -->
                </select>
            </div>

            <!-- Time Slots -->
            <div class="time-slots">
                {{-- @foreach($timeSlots as $slot) --}}
                    {{-- <button class="time-slot">{{ $slot->time_start }} - {{ $slot->time_end }}</button> --}}
                    <button class="time-slot">07:00 - 07:30</button>
                {{-- @endforeach --}}
            </div>

            <!-- Clinic Address and Fee -->
            <div class="clinic-info mt-4">
                <p><strong>Địa chỉ khám:</strong> {{ $doctor->workplace }}</p>
                <p><strong>Giá khám:</strong> 500,000đ</p>
                <a href="#" class="details-link">Xem chi tiết</a>
            </div>
        </div>
        @endforeach
    </div>
</div>


@endsection