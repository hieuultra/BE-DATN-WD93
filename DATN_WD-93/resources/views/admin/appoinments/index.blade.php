@extends('admin.layout')
@section('titlepage', '')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">LỊCH SỬ KHÁM BỆNH</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>

            <!-- Data -->
            <div class="card mb-4">

                {{-- hien thi tb success --}}

                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    DANH SÁCH LỊCH KHÁM
                </div>
                <div class="card-body">
                    {{-- Hiển thị thông báo --}}
                    <script>
                        @if (session('success'))
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: '{{ session('success') }}',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        @endif

                        @if (session('error'))
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: '{{ session('error') }}',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        @endif
                    </script>
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th class="text-center">Thời gian khám</th>
                                <th class="text-center" style="width:10%">Bác sĩ</th>
                                <th class="text-center">Thông tin ng đặt</th>
                                <th class="text-center">Trạng thái lịch khám</th>
                                <th class="text-center">Trạng thái thanh toán</th>
                                <th class="text-center">Đặt lúc</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listAppoinment as $item)
                                <tr>
                                    <td class="text">
                                        Ca: {{ $item->timeSlot->startTime }} -> {{ $item->timeSlot->endTime }}
                                        <br>
                                        Thứ: {{ $item->timeSlot->dayOfWeek }}
                                        <br>
                                        Ngày: {{ $item->appointment_date }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->doctor->title }} <br> {{ $item->doctor->user->name }}
                                    </td>
                                    <td class="">
                                        Tên: {{ $item->user->name }}
                                        <br>
                                        SĐT: {{ $item->user->phone }}
                                        <br>
                                        Email: {{ $item->user->email }}
                                    </td>
                                    <td class="text-center" style="color: dodgerblue; width: 150px">
                                        @if ($item->status_appoinment == 'kham_hoan_thanh' || $item->status_appoinment == 'huy_lich_hen')
                                            {{ $statusAppoinment[$item->status_appoinment] }}
                                        @else
                                            <form action="{{ route('admin.appoinments.update', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status_appoinment" class="form-select"
                                                    onchange="confirmSubmit(this)"
                                                    data-default-value="{{ $item->status_appoinment }}">
                                                    @foreach ($statusAppoinment as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ $key == $item->status_appoinment ? 'selected' : '' }}>
                                                            {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $statusPayment[$item->status_payment_method] }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->created_at->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.appoinments.show', $item->id) }}"
                                            class="btn btn-primary">Xem thêm</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </main>

    <script>
        function confirmSubmit(selectElement) {
            var form = selectElement.form;
            var selectedOption = selectElement.options[selectElement.selectedIndex].text;
            var defaultValue = selectElement.getAttribute('data-default-value');
            if (confirm('Thay đổi trạng thái thành "' + selectedOption + '" đúng không ? ')) {
                form.submit();
            } else {
                selectElement.value = defaultValue;
                return false;
            }
        }
    </script>


@endsection
