<div class="appointments mt-3">

    <!-- Lịch hẹn chờ xác nhận -->
    <h5>Lịch khám đang chờ duyệt</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Ngày</th>
                    <th>Thời gian</th>
                    <th>Người khám</th>
                    <th>Lý do khám</th>
                    <th>Link Khám bệnh</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="appointments-list">
                @foreach($doctor->timeSlot as $timeSlot)
                    @foreach($timeSlot->appoinment as $appoinment)
                        @if($appoinment->status_appoinment === 'cho_xac_nhan')
                            @php
                                $formattedDateTime = \Carbon\Carbon::parse($timeSlot->date . ' ' . $timeSlot->startTime)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                            @endphp
                            <tr class="appointment-item" data-appointment-id="{{ $appoinment->id }}">
                                <td>{{ $formattedDateTime }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}
                                </td>
                                <td>{{ $appoinment->user->name }}</td>
                                <td>{{ $appoinment->notes }}</td>
                                <td>
                                    @if($appoinment->meet_link)
                                        <a href="{{ $appoinment->meet_link }}" target="_blank">Link Khám bệnh</a>
                                    @else
                                        Không có link
                                    @endif
                                </td>
                                <td class="text-warning">Đang chờ xác nhận</td>
                                <td>
                                    <form action="{{ route('appoinment.appointments.confirm', $appoinment->id) }}" method="POST" class="confirm-form">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Xác nhận</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Lịch hẹn yêu cầu hủy -->
    <h5 class="mt-5">Lịch hẹn khách hàng đang yêu cầu hủy</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Ngày</th>
                    <th>Thời gian</th>
                    <th>Người khám</th>
                    <th>Lý do hủy</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctorhuy->timeSlot as $timeSlot)
                    @foreach($timeSlot->appoinment as $appoinment)
                        @if($appoinment->status_appoinment === 'yeu_cau_huy')
                            @php
                                $formattedDateTime = \Carbon\Carbon::parse($timeSlot->date . ' ' . $timeSlot->startTime)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
                            @endphp
                            <tr>
                                <td>{{ $formattedDateTime }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}
                                </td>
                                <td>{{ $appoinment->user->name }}</td>
                                <td>{{ $appoinment->notes }}</td>
                                <td class="text-danger">Yêu cầu hủy</td>
                                <td>
                                    <form action="{{ route('appoinment.appointments.confirmhuy', $appoinment->id) }}" method="POST" class="confirm-form-huy">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Xác nhận hủy</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
