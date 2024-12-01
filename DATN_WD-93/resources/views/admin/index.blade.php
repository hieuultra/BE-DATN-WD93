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
                <li class="breadcrumb-item active">Thống kê, tổng hợp</li>
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
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Area Chart Example
                        </div>
                        <div class="card-body">
                            <canvas id="myAreaChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Bar Chart Example
                        </div>
                        <div class="card-body">
                            <canvas id="myBarChart" width="100%" height="40"></canvas>
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
                            Doanh số bán hàng
                            <canvas id="salesChart" width="400" height="200"></canvas>
                        </div>
                        <div class="card-body">
                            <canvas id="myAreaChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            {{-- doanh so end --}}
        </div>
    </main>

    <script>
        // Dữ liệu mẫu cho biểu đồ
        const salesData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Sales',
                data: [1000, 1500, 1200, 1800, 2000, 1700],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Lấy thẻ canvas và vẽ biểu đồ doanh số
        const salesChartCanvas = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesChartCanvas, {
            type: 'line',
            data: salesData,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endsection
