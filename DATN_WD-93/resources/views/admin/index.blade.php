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
                            <a class="small text-white stretched-link" href="{{ route('admin.dashborad.user') }}">Thống kê khách hàng</a>
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
                            <a class="small text-white stretched-link" href="{{ route('admin.dashborad.revenue') }}">Thống kê Doanh Thu</a>
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
        </div>
    </main>

@endsection
