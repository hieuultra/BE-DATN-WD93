<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tên bệnh nhân</th>
                <th>Số điện thoại</th>
                <th>Lý do khám</th>
                <th>Ngày</th>
                <th>Thời gian</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doctors->timeSlot as $timeSlot)
            @foreach($timeSlot->appoinment as $appoinment)
            @if($appoinment->status_appoinment !== null)
            @php
            $formattedDateTime = \Carbon\Carbon::parse($timeSlot->date . ' ' . $timeSlot->startTime)->locale('vi')->isoFormat('dddd, D/MM/YYYY');
            @endphp
            <tr>
                <td>{{ $appoinment->user->name }}</td>
                <td>{{ $appoinment->user->phone }}</td>
                <td>{{ $appoinment->notes }}</td>
                <td>{{ $formattedDateTime }}</td>
                <td>
                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->startTime)->format('H:i') }} -
                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->endTime)->format('H:i') }}
                </td>
                <td>
                    @if($appoinment->status_appoinment === 'huy_lich_hen')
                    <span class="text-danger">Lịch hẹn đã bị hủy</span>
                    @elseif($appoinment->status_appoinment === 'da_xac_nhan')
                    <span class="text-success">Đã xác nhận</span>
                    @elseif($appoinment->status_appoinment === 'kham_hoan_thanh')
                    <span class="text-primary">Đã khám thành công</span>
                    @elseif($appoinment->status_appoinment === 'can_tai_kham')
                    <span class="text-warning">Cần tái khám</span>
                    @elseif($appoinment->status_appoinment === 'benh_nhan_khong_den')
                    <span class="text-info">Bệnh nhân vắng mặt</span>
                    @endif
                </td>
                <td>
                    @if($appoinment->status_appoinment === 'da_xac_nhan')
                    <div class="button-group">
                        @if($appoinment->meet_link)
                        <a href="{{ $appoinment->meet_link }}" target="_blank" class="btn custom-btn">Link Khám</a>
                        @else

                        @endif
                        <a href="#" class="btn action-link confirm" data-appointment-id="{{ $appoinment->id }}">Xác nhận đang khám</a>
                        <a href="#" class="btn action-link pending" data-user-id="{{ $appoinment->user_id }}" data-appointment-id="{{ $appoinment->id }}" data-doctor-id="{{ $doctor->id }}">Bệnh nhân chưa đến</a>
                    </div>
                    @elseif($appoinment->status_appoinment === 'kham_hoan_thanh' || $appoinment->status_appoinment === 'can_tai_kham')
                    <a href="#" class="appointment-history-link" data-appointment-id="{{ $appointment->id }}">Chi tiết hóa đơn</a>
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
            @endforeach
        </tbody>
    </table>
</div>