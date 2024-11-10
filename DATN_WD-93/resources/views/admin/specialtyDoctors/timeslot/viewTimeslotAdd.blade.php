@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h3>Thêm khung giờ khám cho bác sĩ {{ $doctor->user->name }}</h3>

    <form action="{{ route('admin.timeslot.timeslotAdd', $doctor->id) }}" method="POST">
        @csrf

        <!-- Day of the Week -->
        <label>Day of Week:</label>
        <input type="text" name="dayOfWeek" placeholder="e.g., Monday">

        <!-- Specific Dates -->
        <div id="date-container">
            <label>Specific Date:</label>
            <input type="date" name="date[0][date]" required>
            <div class="time-slots">
                <!-- Time slots for the first date -->
                <label>Start Time:</label>
                <input type="time" name="date[0][timeslots][0][startTime]" required>
                <label>End Time:</label>
                <input type="time" name="date[0][timeslots][0][endTime]" required>
            </div>
        </div>
        <button type="button" onclick="addDate()">Add Another Date</button>

        <button type="submit">Save Time Slots</button>
    </form>

    <!-- JavaScript to Dynamically Add Dates and Time Slots -->
    <script>
        let dateIndex = 1;
        let timeslotIndex = 1;

        // Add another date with its own time slots
        function addDate() {
            const container = document.getElementById('date-container');
            const newDate = document.createElement('div');
            newDate.classList.add('date-group');
            newDate.innerHTML = `
                <label>Specific Date:</label>
                <input type="date" name="date[${dateIndex}][date]" required>
                <div class="time-slots">
                    <label>Start Time:</label>
                    <input type="time" name="date[${dateIndex}][timeslots][0][startTime]" required>
                    <label>End Time:</label>
                    <input type="time" name="date[${dateIndex}][timeslots][0][endTime]" required>
                </div>
                <button type="button" onclick="addTimeslot(${dateIndex})">Add Another Time Slot</button>
            `;
            container.appendChild(newDate);
            dateIndex++;
        }

        // Add another time slot for a specific date
        function addTimeslot(dateIdx) {
            const dateGroup = document.querySelector(`.date-group:nth-child(${dateIdx + 1}) .time-slots`);
            const newTimeslot = document.createElement('div');
            newTimeslot.innerHTML = `
                <label>Start Time:</label>
                <input type="time" name="date[${dateIdx}][timeslots][${timeslotIndex}][startTime]" required>
                <label>End Time:</label>
                <input type="time" name="date[${dateIdx}][timeslots][${timeslotIndex}][endTime]" required>
            `;
            dateGroup.appendChild(newTimeslot);
            timeslotIndex++;
        }
    </script>

</div>
@endsection
