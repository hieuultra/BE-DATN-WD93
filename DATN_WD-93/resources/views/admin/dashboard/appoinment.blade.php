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
                        {{-- <!-- <?php
                        foreach ($countsp as $c) {
                            extract($c);
                            echo ' <div class="card-body">' . $count_sp . ' Count_products</div>';
                        }
                        ?> --> --}}
                        <i class="fa-solid fa-box-open fa-2xl"></i>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="?act=list_pro">Xem thêm</a>
                            <div class="small text-white">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        {{-- <!-- <?php
                        foreach ($sum as $s) {
                            extract($s);
                            echo ' <div class="card-body">' . number_format($sum_total, 0, ',', '.') . '$ Total revenue</div>';
                        }
                        ?> --> --}}

                        <i class="fa-solid fa-money-bills fa-2xl"></i>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="?act=total_revenue">Xem thêm</a>
                            <div class="small text-white">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        {{-- <!-- <?php
                        foreach ($sum_user as $s) {
                            extract($s);
                            echo ' <div class="card-body">' . $sum_user . ' Customer</div>';
                        }
                        ?> --> --}}
                        <i class="fa-solid fa-user fa-2xl"></i>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="?act=order_sold">Xem thêm</a>
                            <div class="small text-white">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        {{-- <!-- <?php
                        foreach ($sum_quantity as $s) {
                            extract($s);
                            echo ' <div class="card-body">' . $quantity_pro . ' Products sold</div>';
                        }
                        ?> --> --}}
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="?act=sold">Xem thêm</a>
                            <div class="small text-white">
                                <i class="fas fa-angle-right"></i>
                            </div>
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
                            Doanh số
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
                    <div class="card mb-4" style=" display: flex;  justify-content: center;  align-items: center;">
                        <div class="card-header" style="width: 100%;">
                            <i class="fas fa-chart-pie me-1"></i>
                            Tổng lượt đặt lịch:
                        </div>
                        <div>
                            <select id="filterTime" class="form-select form-select-sm"
                                style="width: auto; margin-top: 10px">
                                <option value="day">Theo ngày</option>
                                <option value="week">Theo tuần</option>
                                <option value="month" selected>Theo tháng</option>
                                <option value="year">Theo năm</option>
                            </select>
                        </div>
                        <div class="card-body " id="ti-le-dat-lich">
                            <canvas id="reviewChart"></canvas>
                            <style>
                                #ti-le-dat-lich {
                                    width: 52.3%;
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </div>
            {{-- doanh so end --}}

            {{-- Row 2 --}}
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4" style="display: flex; justify-content: center; align-items: center;">
                        <div class="card-header" style="width: 100%;">
                            <i class="fas fa-chart-pie me-1"></i>
                            Số lượt đánh giá
                        </div>
                        <div>
                            <!-- Bộ lọc thời gian -->
                            <select id="filterTime2" class="form-select form-select-sm"
                                style="width: auto; margin-top: 10px">
                                <option value="day">Theo ngày</option>
                                <option value="week">Theo tuần</option>
                                <option value="month" selected>Theo tháng</option>
                                <option value="year">Theo năm</option>
                            </select>
                        </div>
                        <div class="card-body" id="ti-le-dat-lich2">
                            <!-- Biểu đồ -->
                            <canvas id="reviewChart2" width="400" height="400"></canvas>
                            <style>
                                #ti-le-dat-lich2 {
                                    width: 52.3%;
                                }
                            </style>
                        </div>
                    </div>

                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Lượt bình luận gần nhất
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
        // Thống kê đơn đặt
        const ctx = document.getElementById('reviewChart').getContext('2d');
        let reviewChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Khám thành công', 'Trong quá trình', 'Hủy lịch khám'],
                datasets: [{
                    data: [{{ $statsMonth['kham_hoan_thanh'] }},
                        {{ $statsMonth['chua_kham'] }}, {{ $statsMonth['khong_thanh_cong'] }}
                    ], // Dữ liệu ban đầu (theo tháng)
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });

        // Xử lý khi người dùng thay đổi bộ lọc
        document.getElementById('filterTime').addEventListener('change', function() {
            const filterValue = this.value;
            let newData;

            // Cập nhật dữ liệu tùy theo bộ lọc
            if (filterValue === 'day') {
                newData = [{{ $statsToday['kham_hoan_thanh'] }},
                    {{ $statsToday['chua_kham'] }},
                    {{ $statsToday['khong_thanh_cong'] }}
                ]; // Dữ liệu theo ngày
            } else if (filterValue === 'week') {
                newData = [{{ $statsWeek['kham_hoan_thanh'] }},
                    {{ $statsWeek['chua_kham'] }},
                    {{ $statsWeek['khong_thanh_cong'] }}
                ]; // Dữ liệu theo tháng
            } else if (filterValue === 'month') {
                newData = [{{ $statsMonth['kham_hoan_thanh'] }},
                    {{ $statsMonth['chua_kham'] }},
                    {{ $statsMonth['khong_thanh_cong'] }}
                ]; // Dữ liệu theo tháng
            } else if (filterValue === 'year') {
                newData = [{{ $statsYear['kham_hoan_thanh'] }},
                    {{ $statsYear['chua_kham'] }},
                    {{ $statsYear['khong_thanh_cong'] }}
                ]; // Dữ liệu theo năm
            }

            // Cập nhật dữ liệu biểu đồ
            reviewChart.data.datasets[0].data = newData;
            reviewChart.update();
        });
        // Kết thúc đơn hàng

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
        // Thống kê đánh giá
        const ctxReview2 = document.getElementById('reviewChart2').getContext('2d');
        let reviewChart2 = new Chart(ctxReview2, {
            type: 'pie',
            data: {
                labels: ['1 Sao', '2 Sao', '3 Sao', '4 Sao', '5 Sao'],
                datasets: [{
                    data: [{{ $reviewsToday[1] }},
                        {{ $reviewsToday[2] }},
                        {{ $reviewsToday[3] }},
                        {{ $reviewsToday[4] }},
                        {{ $reviewsToday[5] }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(54, 162, 235, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });

        // Xử lý khi người dùng thay đổi bộ lọc đánh giá
        document.getElementById('filterTime2').addEventListener('change', function() {
            const filterValue = this.value;
            let newData;

            // Cập nhật dữ liệu tùy theo bộ lọc
            if (filterValue === 'day') {
                newData = [{{ $reviewsToday[1] }},
                    {{ $reviewsToday[2] }},
                    {{ $reviewsToday[3] }},
                    {{ $reviewsToday[4] }},
                    {{ $reviewsToday[5] }}
                ];
            } else if (filterValue === 'week') {
                newData = [{{ $reviewsToday[1] }},
                    {{ $reviewsWeek[2] }},
                    {{ $reviewsWeek[3] }},
                    {{ $reviewsWeek[4] }},
                    {{ $reviewsWeek[5] }}
                ];
            } else if (filterValue === 'month') {
                newData = [{{ $reviewsMonth[1] }},
                    {{ $reviewsMonth[2] }},
                    {{ $reviewsMonth[3] }},
                    {{ $reviewsMonth[4] }},
                    {{ $reviewsMonth[5] }}
                ];
            } else if (filterValue === 'year') {
                newData = [{{ $reviewsYear[1] }},
                    {{ $reviewsYear[2] }},
                    {{ $reviewsYear[3] }},
                    {{ $reviewsYear[4] }},
                    {{ $reviewsYear[5] }}
                ];
            }

            // Cập nhật dữ liệu biểu đồ
            reviewChart2.data.datasets[0].data = newData;
            reviewChart2.update();
        });
    </script>
@endsection
