@extends('admin.layout')
@section('titlepage', '')

@section('content')

    <!-- Right menu -->

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <style>
        form .form-group input {
            min-width: 180px;
        }
    </style>
    <main>
        <div class="container-fluid px-4">
            <h2 class="mt-4">Thống kê, tổng hợp về hoạt động người dùng</h2>
            <button class="btn" style="background-color: rgb(53, 150, 214)" onclick="window.history.back()">
                <h5 class="text-white">
                    < Trở về </h5>
            </button>
            <hr>
            <div class=" mt-4">
                <form method="GET" action="{{ route('admin.dashborad.user.search') }}" class=" mb-3">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="start_date" class="me-2 mb-0">Thời gian bắt đầu:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control form-control-sm"
                                value="{{ request('start_date') }}">
                            @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label for="end_date" class="me-2 mb-0">Thời gian kết thúc:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control form-control-sm""
                                value="{{ request('end_date') }}">
                            @error('end_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary" style="width:100%; height:100%">Tìm</button>
                        </div>
                    </div>
                </form>
            </div>
            <hr>
            <div class="mt-4">
                <div class="row g-3 mt-4">
                    <div class="col-md-4">
                        <div class="card d-flex flex-column">
                            <div class="card-header bg-primary">
                                <h5 class="text-white">Tổng đơn hàng mua thành công</h5>
                            </div>
                            <div class="card-body bg-black-50">
                                <h5 class="text-center">{{ $totalSuccessfulOrders }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card d-flex flex-column">
                            <div class="card-header" style="background-color: rgb(68, 173, 96)">
                                <h5 class="text-white">Tổng đơn hàng đang thực hiện</h5>
                            </div>
                            <div class="card-body bg-black-50">
                                <h5 class="text-center">{{ $totalRemainingOrders }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card d-flex flex-column">
                            <div class="card-header bg-warning">
                                <h5 class="text-white">Tổng đơn hàng bị hủy</h5>
                            </div>
                            <div class="card-body bg-black-50">
                                <h5 class="text-center">{{ $totalCanceledOrders }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <div class="card d-flex flex-column">
                            <div class="card-header bg-success">
                                <h5 class="text-white">Tổng lịch khám được đặt thành công</h5>
                            </div>
                            <div class="card-body bg-black-50">
                                <h5 class="text-center">{{ $totalSuccessfulAppointments }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card d-flex flex-column">
                            <div class="card-header" style="background-color: rgb(28, 139, 203)">
                                <h5 class="text-white">Tổng lịch khám đang tiến hành</h5>
                            </div>
                            <div class="card-body bg-black-50">
                                <h5 class="text-center">{{ $totalRemainingAppointments }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card d-flex flex-column">
                            <div class="card-header bg-danger">
                                <h5 class="text-white">Tổng lịch khám bị hủy</h5>
                            </div>
                            <div class="card-body bg-black-50">
                                <h5 class="text-center">{{ $totalCanceledAppointments }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Top 5 khách hàng mua hàng nhiều nhất
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Số đơn mua</th>
                                </tr>
                                @foreach ($topUsersByOrders as $item)
                                    <tr>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->user->email }}</td>
                                        <td>{{ $item->user->phone }}</td>
                                        <td class="text-center">{{ $item->total_orders }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Top 5 khách hàng hủy đơn hàng nhiều nhất
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Số đơn đã hủy</th>
                                </tr>
                                @foreach ($topUsersByCanceledOrders as $item)
                                    <tr>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->user->email }}</td>
                                        <td>{{ $item->user->phone }}</td>
                                        <td class="text-center">{{ $item->total_canceled }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            {{-- <canvas id="myAreaChart" width="100%" height="40"></canvas> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Tỉ lệ đặt lịch khám thành công và bị hủy
                        </div>
                        <div class="card-body">
                            <canvas id="orderRatesChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Tỉ lệ đơn hàng mua thành công và bị hủy
                        </div>
                        <div class="card-body">
                            <canvas id="appointmentRatesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            {{-- doanh so start --}}
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Top 5 khách hàng đặt lịch nhiều
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Số lần đặt và khám thành công</th>
                                </tr>
                                @foreach ($topUsersByAppointments as $item)
                                    <tr>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->user->email }}</td>
                                        <td>{{ $item->user->phone }}</td>
                                        <td class="text-center">{{ $item->total_appointments }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            {{-- <canvas id="myAreaChart" width="100%" height="40"></canvas> --}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Top 5 khách hàng hủy lịch nhiều
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Số lần hủy lịch khám</th>
                                </tr>
                                @foreach ($topUsersByCanceledAppointments as $item)
                                    <tr>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->user->email }}</td>
                                        <td>{{ $item->user->phone }}</td>
                                        <td class="text-center">{{ $item->total_canceled }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            {{-- <canvas id="myAreaChart" width="100%" height="40"></canvas> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- doanh so end --}}
        </div>
    </main>

    <script>
        // Dữ liệu cho biểu đồ tỷ lệ lịch khám
        const appointmentData = {
            labels: ['Tỷ lệ hủy lịch khám', 'Tỷ lệ thành công lịch khám', 'Tỷ lệ đang thực hiện lịch khám'],
            datasets: [{
                label: 'Tỷ lệ (%)',
                data: [{{ $appointmentCancelRate }}, {{ $appointmentSuccessRate }},
                    {{ $appointmentOngoingRate }}
                ], // Thêm tỷ lệ "đang thực hiện"
                backgroundColor: [
                    'rgba(255, 159, 64, 0.2)', // Màu cho tỷ lệ hủy lịch khám
                    'rgba(54, 162, 235, 0.2)', // Màu cho tỷ lệ thành công lịch khám
                    'rgba(75, 192, 192, 0.2)' // Màu cho tỷ lệ đang thực hiện lịch khám
                ],
                borderColor: [
                    'rgba(255, 159, 64, 1)', // Đường viền cho tỷ lệ hủy lịch khám
                    'rgba(54, 162, 235, 1)', // Đường viền cho tỷ lệ thành công lịch khám
                    'rgba(75, 192, 192, 1)' // Đường viền cho tỷ lệ đang thực hiện lịch khám
                ],
                borderWidth: 1
            }]
        };

        const appointmentConfig = {
            type: 'pie', // Đổi từ "bar" thành "pie" để tạo biểu đồ quạt
            data: appointmentData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + '%'; // Hiển thị tỷ lệ phần trăm trong tooltip
                            }
                        }
                    }
                }
            }
        };

        new Chart(
            document.getElementById('appointmentRatesChart'),
            appointmentConfig
        );

        // Dữ liệu cho biểu đồ tỷ lệ đơn hàng
        const data = {
            labels: ['Tỷ lệ hủy đơn', 'Tỷ lệ thành công', 'Tỷ lệ đang thực hiện đơn'],
            datasets: [{
                label: 'Tỷ lệ (%)',
                data: [{{ $cancelRate }}, {{ $successRate }},
                    {{ $ongoingRate }}
                ], // Thêm tỷ lệ "đang thực hiện"
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)', // Màu cho tỷ lệ hủy đơn
                    'rgba(75, 192, 192, 0.2)', // Màu cho tỷ lệ thành công đơn
                    'rgba(153, 102, 255, 0.2)' // Màu cho tỷ lệ đang thực hiện đơn
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)', // Đường viền cho tỷ lệ hủy đơn
                    'rgba(75, 192, 192, 1)', // Đường viền cho tỷ lệ thành công đơn
                    'rgba(153, 102, 255, 1)' // Đường viền cho tỷ lệ đang thực hiện đơn
                ],
                borderWidth: 1
            }]
        };

        const config = {
            type: 'pie', // Đổi từ "bar" thành "pie" để tạo biểu đồ quạt
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + '%'; // Hiển thị tỷ lệ phần trăm trong tooltip
                            }
                        }
                    }
                }
            }
        };

        new Chart(
            document.getElementById('orderRatesChart'),
            config
        );
    </script>

@endsection
