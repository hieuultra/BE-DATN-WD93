<div class="appointments mt-3">
    <h5>Lịch hẹn chờ xác nhận</h5>
    <div id="appointments-grid" class="appointments-grid">
        @foreach($doctor->timeSlot as $timeSlot)
            @foreach($timeSlot->appoinment as $appoinment)
                @if($appoinment->status_appoinment === 'cho_xac_nhan')
                    @php
                        $formattedDateTime = \Carbon\Carbon::parse($timeSlot->date . ' ' . $timeSlot->startTime)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                    @endphp
                    <div class="appointment-item">
                        <p>Ngày: {{ $formattedDateTime }}</p>
                        <p>Thời gian: {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} - 
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}
                        </p>
                        <p class="text-warning">Đang chờ xác nhận</p>

                        <form action="{{ route('admin.doctors.appointments.confirm', $appoinment->id) }}" method="POST" class="confirm-form">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">Xác nhận</button>
                        </form>
                    </div>
                @endif
            @endforeach
        @endforeach
    </div>

    <h5>Lịch hẹn yêu cầu hủy</h5>
    <div id="appointments-grid-huy" class="appointments-grid">
        @foreach($doctorhuy->timeSlot as $timeSlot)
            @foreach($timeSlot->appoinment as $appoinment)
                @if($appoinment->status_appoinment === 'yeu_cau_huy')
                    @php
                        $formattedDateTime = \Carbon\Carbon::parse($timeSlot->date . ' ' . $timeSlot->startTime)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                    @endphp
                    <div class="appointment-item">
                        <p>Ngày: {{ $formattedDateTime }}</p>
                        <p>Thời gian: {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} - 
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}
                        </p>
                        <p class="text-danger">Yêu cầu hủy</p>
                        <p>Lý do hủy: {{$appoinment->notes}}</p>

                        <form action="{{ route('admin.doctors.appointments.confirmhuy', $appoinment->id) }}" method="POST" class="confirm-form-huy">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                        </form>
                    </div>
                @endif
            @endforeach
        @endforeach
    </div>
</div>
