@extends('admin.layout')
@section('titlepage', '')

@section('content')

    <!-- Right menu -->

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Thống kê, tổng hợp</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Đặt lịch khám</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">

                        <i class="fa-solid fa-user fa-2xl"></i>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('admin.dashborad.user') }}">Thống kê
                                khách hàng</a>
                            <div class="small text-white">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">


                        <i class="fa-solid fa-money-bills fa-2xl"></i>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link"
                                href="{{ route('admin.dasboard.appointment') }}">Thống kê đặt lịch khám</a>
                            <div class="small text-white">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">

                        <i class="fa-solid fa-box-open fa-2xl"></i>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('admin.dashborad.revenue') }}">Thống
                                kê Doanh Thu</a>
                            <div class="small text-white">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">

                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="?act=sold">Xem thêm</a>
                            <div class="small text-white">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- doanh so start --}}
            <hr>
            <div class=" mt-4 mb-5">
                <form method="GET" action="{{ route('admin.dasboard.appointmentSreach') }}" class=" mb-3">
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
                            <input type="date" id="end_date" name="end_date" class="form-control form-control-sm"
                                value="{{ request('end_date') }}">
                            @error('end_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary mt-3" style="width:100%; height:80%">Lọc</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row mb-2" style=" display: flex;  justify-content: center;  align-items: center;">
                <div class="col-xl-6">
                    <div class="card mb-4" style=" display: flex;  justify-content: center;  align-items: center;">
                        <div class="card-header" style="width: 100%; background-color: rgba(160, 255, 65, 0.758)">
                            <i class="fas fa-chart-area me-1"></i>
                            Tổng doanh số:
                        </div>
                        <div class="card-body " id="ti-le-dat-lich">
                            <h2>{{ number_format($totalRevenue, 0, ',', '.') }}đ</h2>
                        </div>
                    </div>
                </div>
            </div>
            {{-- doanh so end --}}

            {{-- Row 2 --}}
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            So sánh doanh số
                        </div>
                        <div style="display: flex; justify-content: center; width: 100%;">
                            <select id="filterSalesTime" class="form-select form-select-sm"
                                style="width: auto; margin-top: 10px">
                                <option value="day">Theo tuần</option>
                                <option value="month" selected>Theo tháng</option>
                                <option value="year">Theo năm</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Lượt đánh giá gần nhất
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Ảnh</th>
                                        <th>Tên</th>
                                        <th>Nội dung</th>
                                        <th>Sao</th>
                                        <th>Ngày</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $stt = 1; ?>
                                    @foreach ($latestReviews as $data)
                                        <tr>
                                            <td>{{ $stt++ }}</td>
                                            <td>
                                                <img src="{{ asset('upload/' . $data->user['image']) }}" width="50"
                                                    height="50">
                                            </td>
                                            <td class="ellipsis">{{ $data->user['name'] }}</td>
                                            <td>{{ $data['comment'] }}</td>
                                            <td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($data['rating'] >= $i)
                                                        <span style="color: gold;">&#9733;</span>
                                                    @else
                                                        <span>&#9734;</span>
                                                    @endif
                                                @endfor
                                            </td>
                                            <td>{{ $data['created_at'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 3 --}}
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Top bác sỹ khám nhiều
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Ảnh</th>
                                        <th>Tên</th>
                                        <th>Lượt khám</th>
                                        <th>Thành công</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $stt = 1; ?>
                                    @foreach ($dataDoctors as $data)
                                        <tr>
                                            <td>{{ $stt++ }}</td>
                                            <td>
                                                <img src="{{ asset('upload/' . $data['doctor_image']) }}"
                                                    alt="{{ $data['doctor_image'] }}" width="50" height="50">
                                            </td>
                                            <td class="ellipsis">{{ $data['doctor_name'] }}</td>
                                            <td>{{ $data['appointments_count'] }}</td>
                                            <td>{{ $data['completed_appointments_count'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Lượt khám theo khoa
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Ảnh</th>
                                        <th>Chuyên khoa</th>
                                        <th>Lượt khám</th>
                                        <th>Thành công</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $stt = 1; ?>
                                    @foreach ($appointmentsData as $data)
                                        <tr>
                                            <td>{{ $stt++ }}</td>
                                            <td>
                                                <img src="{{ asset('upload/' . $data['specialty_image']) }}"
                                                    alt="{{ $data['specialty_name'] }}" width="65" height="50">
                                            </td>
                                            <td class="ellipsis">{{ $data['specialty_name'] }}</td>
                                            <td>{{ $data['appointments_count'] }}</td>
                                            <td>{{ $data['completed_appointments_count'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <style>
        .ellipsis {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
    <script>
        // Biểu đồ doanh số bán hàng
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctxSales, {
            type: 'line',
            data: {
                labels: ['1', '2', '3', '4', '5', '6', '7', '8',
                    '9', '10', '11', '12'
                ], // Dữ liệu theo tháng
                datasets: [{
                    label: 'Doanh số',
                    data: [{{ $revenueMonth[0] }}, {{ $revenueMonth[1] }}, {{ $revenueMonth[2] }},
                        {{ $revenueMonth[3] }}, {{ $revenueMonth[4] }}, {{ $revenueMonth[5] }},
                        {{ $revenueMonth[6] }}, {{ $revenueMonth[7] }}, {{ $revenueMonth[8] }},
                        {{ $revenueMonth[9] }}, {{ $revenueMonth[10] }}, {{ $revenueMonth[11] }}
                    ], // Dữ liệu ví dụ theo tháng
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Dữ liệu ví dụ cho từng bộ lọc
        const salesData = {
            day: [{{ $revenueWeek[0] }}, {{ $revenueWeek[1] }}, {{ $revenueWeek[2] }},
                {{ $revenueWeek[3] }}, {{ $revenueWeek[4] }}, {{ $revenueWeek[5] }},
                {{ $revenueWeek[6] }}
            ], // Dữ liệu theo ngày
            month: [{{ $revenueMonth[0] }}, {{ $revenueMonth[1] }}, {{ $revenueMonth[2] }},
                {{ $revenueMonth[3] }}, {{ $revenueMonth[4] }}, {{ $revenueMonth[5] }},
                {{ $revenueMonth[6] }}, {{ $revenueMonth[7] }}, {{ $revenueMonth[8] }},
                {{ $revenueMonth[9] }}, {{ $revenueMonth[10] }}, {{ $revenueMonth[11] }},
            ], // Dữ liệu theo tháng
            year: [0, 0, 0, {{ $revenueYear[0] }}] // Dữ liệu theo năm
        };

        // Xử lý khi người dùng thay đổi bộ lọc
        document.getElementById('filterSalesTime').addEventListener('change', function() {
            const filterValue = this.value;
            let newData, newLabels;

            // Cập nhật dữ liệu và nhãn dựa trên bộ lọc
            if (filterValue === 'day') {
                newData = salesData.day;
                newLabels = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật']; // Ngày (ví dụ)
            } else if (filterValue === 'month') {
                newData = salesData.month;
                newLabels = ['1', '2', '3', '4', '5', '6', '7', '8',
                    '9', '10', '11', '12'
                ]; // Tháng
            } else if (filterValue === 'year') {
                newData = salesData.year;
                newLabels = ['2021', '2022', '2023', '2024']; // Năm
            }

            // Cập nhật dữ liệu và nhãn trên biểu đồ
            salesChart.data.labels = newLabels;
            salesChart.data.datasets[0].data = newData;
            salesChart.update();
        });
    </script>
@endsection
