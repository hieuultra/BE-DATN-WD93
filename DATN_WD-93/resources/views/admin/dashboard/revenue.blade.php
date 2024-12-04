@extends('admin.layout')
@section('titlepage', '')

@section('content')

    <!-- Right menu -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        form .form-group input {
            min-width: 180px;
        }
        .overlay {
            display: none; /* Ẩn overlay mặc định */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Màu mờ */
            z-index: 999;
        }
        /* Style cho Popup */
        .popup {
            display: none; /* Ẩn popup mặc định */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            z-index: 1000;

        }
        /* Nút đóng Popup */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 30px;
            cursor: pointer;
        }
    </style>
    <main>
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between">
                <h2 class="mt-4">Thống kê doanh thu bán hàng</h2>
                <h2 class="mt-4" id="timeNow">{{$currentTimeInTimezone}}</h2>
            </div>
            <button class="btn" style="background-color: rgb(53, 150, 214)" onclick="window.history.back()">
                <h5 class="text-white">Trở về </h5>
            </button>
            <hr>
            <div class=" mt-4">
                    <div class="row">
                        <h2>Thống Kê Doanh Thu</h2>
                        <div class="col-md-5">
                            <label for="start_date" class="me-2 mb-0">Thời gian bắt đầu:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-5">
                            <label for="end_date" class="me-2 mb-0">Thời gian kết thúc:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" id="btnRevenue_price" style="width:100%; height:100%">Tìm</button>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col">
                            <div class="card d-flex flex-column">
                                <div class="card-header bg-success">
                                    <h5 class="text-white">Doanh Thu Tháng Này</h5>
                                </div>
                                <div class="card-body bg-black-50">
                                    <h5 class="">{{ number_format($moneyProducts, 0, ',', '.') }} VNĐ</h5>
                                    <div class="d-flex">
                                        <p style="color: gray;">So với tháng trước:</p>
                                        <p class="ms-2" style="color: {{$color}}">
                                            {{$message}}
                                        </p>
                                    </div>
                                    <a href="" class="analysisRevenue" style="margin: 0px; padding: 0px;">
                                        Xem phân tích
                                    </a>
                                </div>

                            </div>
                        </div>
                        <div class="col">
                            <div class="card d-flex flex-column">
                                <div class="card-header" style="background-color: rgb(28, 139, 203)">
                                    <h5 class="text-white">SL Khách Mua Hàng Tháng Này</h5>
                                </div>
                                <div class="card-body bg-black-50">
                                    <h5>{{$uniqueUserIds}}</h5>
                                    <div class="d-flex">
                                        <p style="color: gray;">So với tháng trước:</p>
                                        <p class="ms-2" style="color: {{$color2}}">
                                            {{$message2}}
                                        </p>
                                    </div>
                                    <a href="" class="analysisNbBuys" style="margin: 0px; padding: 0px;">
                                        Xem phân tích
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div>
                                        <i class="fas fa-chart-area me-1"></i>
                                        TOP 5 Sản Phẩm Bán Chạy
                                    </div>
                                    <div class="row mt-2 mb-2">
                                        <div class="col-md-5">
                                            <label for="start_date" class="me-2 mb-0">Thời gian bắt đầu:</label>
                                            <input type="date" id="start_date_product"  class="form-control form-control-sm" value="{{ request('start_date') }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="end_date" class="me-2 mb-0">Thời gian kết thúc:</label>
                                            <input type="date" id="end_date_product"  class="form-control form-control-sm" value="{{ request('end_date') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-primary" id="btnRevenue_sale" style="width:100%; height:100%">Tìm</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="productTableSale " class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên SP</th>
                                                <th>Hình ảnh</th>
                                                <th>SL Bán</th>
                                            </tr>
                                        </thead>

                                        <tbody id="tbody" >

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div>
                                        <i class="fas fa-chart-area me-1"></i>
                                        Sản Phẩm Tồn Kho
                                    </div>
                                    <div class="row mt-2 mb-2">
                                        <div class="col-md-5">
                                            <label for="start_date" class="me-2 mb-0">Thời gian bắt đầu:</label>
                                            <input type="date" id="start_date_product_nonesale"  class="form-control form-control-sm" value="{{ request('start_date') }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="end_date" class="me-2 mb-0">Thời gian kết thúc:</label>
                                            <input type="date" id="end_date_product_nonesale"  class="form-control form-control-sm" value="{{ request('end_date') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-primary" id="btnRevenue_noneSale" style="width:100%; height:100%">Tìm</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="tbodySaleNone2">
                                    <table id="productTableSaleNone" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên SP</th>
                                                <th>Hình ảnh</th>
                                                <th>SL Bán</th>
                                            </tr>
                                        </thead>

                                        <tbody id="tbodySaleNone">

                                        </tbody>

                                    </table>
                                    {{-- <canvas id="myAreaChart" width="100%" height="40"></canvas> --}}
                                </div>


                            </div>
                        </div>
                    </div>
            </div>
            <hr>
            <!-- Overlay -->
            <div id="overlay" class="overlay"></div>

            <!-- Popup -->
            <div id="popup" class="popup">
                <div class="popup-content">
                    <span id="closePopupBtn" class="close-btn">&times;</span>
                    <h2>Thông Báo !</h2>
                    <p id="validate" style="color: red"></p>
                </div>
            </div>
            {{-- Popup doanh thu --}}
            <div id="popupRevenue" class="popup" style="width: 430px;">
                <div class="popup-content" >
                    <span id="closePopupBtnRevenue" class="close-btn">&times;</span>
                    <h2>Thống Kê Doanh Thu </h2>
                    <div class="d-flex">
                        <p id="startDate" style="margin-right: 5px; font-weight: bold;"></p> tới <p style="margin-left: 5px; font-weight: bold;" id="endDate"></p>
                    </div>
                    {{-- Dữ liệu doanh thu trả về --}}
                    <div>
                        <div class="d-flex">
                            <p>Doanh Thu: </p>
                            <p style="margin-left: 10px; color: red" id="moneyProductsPopup"></p>
                        </div>
                        <div class="d-flex">
                            <p>Số đơn hàng thành công: </p>
                            <p style="margin-left: 10px; color: green" id="orderSuccess"></p>
                        </div>
                        <div class="d-flex">
                            <p>Tỉ lệ thành công </p>
                            <p style="margin-left: 10px; color: green" id="percentSuccess"></p>
                        </div>
                        <div class="d-flex">
                            <p>Số đơn hàng hủy: </p>
                            <p style="margin-left: 10px; color: red" id="orderFail"></p>
                        </div>
                        <div class="d-flex">
                            <p>Tỉ lệ hủy </p>
                            <p style="margin-left: 10px; color: red" id="percentFail"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        var time_now = $('#timeNow').html();
        //doanh thu theo thời gian
        $(document).ready(function () {
            // tìm kiếm doanh thu, sl người mua theo thời gian
            $("#btnRevenue_price").click(function (e) {
                e.preventDefault();
                let start_date = $("#start_date").val();
                let end_date = $("#end_date").val();
                if (start_date === '' && end_date === '') {
                    $('#validate').text('');
                    $('#overlay').fadeIn();
                    $('#popup').fadeIn();
                    $('#validate').text('Vui lòng nhập đầy đủ ngày bắt đầu và ngày kết thúc.');
                    return;
                }
                // Chuyển đổi các chuỗi thời gian thành đối tượng Date
                let timeNow = new Date(time_now);
                let endDate = new Date(end_date);
                let startDate = new Date(start_date);
                if (!(endDate > timeNow) && (!(startDate > timeNow))) {
                    $.ajax({
                        type: "post",
                        url: "ajax-revenues",
                        data: {
                            startDate:start_date,
                            endDate:end_date,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "JSON",
                        success: function (response) {
                            $('#startDate').text(response.start_date);
                            $('#endDate').text(response.end_date);
                            $('#moneyProductsPopup').text(response.moneyProductsPopup);
                            $('#orderSuccess').text(response.orderCountSuccess + ' đơn');
                            $('#orderFail').text(response.orderCountFail + ' đơn');
                            $('#percentSuccess').text(response.percentSuccess + ' %');
                            $('#percentFail').text(response.percentFail + ' %');
                            $('#overlay').fadeIn();
                            $('#popupRevenue').fadeIn();

                        }
                    });



                } else {
                    $('#validate').text('');
                    $('#overlay').fadeIn();
                    $('#popup').fadeIn();
                    $('#validate').text('Vui lòng kiểm tra lại thời gian bắt đầu và kết thúc');
                }



            });
            // close thông báo
            $('#closePopupBtn').click(function() {
                $('#overlay').fadeOut();
                $('#popup').fadeOut();
                $('#popupRevenue').fadeOut();
                $('#start_date').val('');
                $('#end_date').val('');
                //
                $('#start_date_product').val('');
                $('#end_date_product').val('');
                //
                $('#start_date_product_nonesale').val('');
                $('#end_date_product_nonesale').val('');
            });
            // close popup thống kê
            $('#closePopupBtnRevenue').click(function() {
                $('#overlay').fadeOut();
                $('#popupRevenue').fadeOut();
                $('#start_date').val('');
                $('#end_date').val('');
                //
                $('#start_date_product').val('');
                $('#end_date_product').val('');
                //
                $('#start_date_product_nonesale').val('');
                $('#end_date_product_nonesale').val('');
            });
            // tìm kiếm số sản phẩm bán chạy theo thời gian
            $("#btnRevenue_sale").click(function (e) {
                e.preventDefault();
                let start_date = $("#start_date_product").val();
                let end_date = $("#end_date_product").val();
                if (start_date === '' && end_date === '') {
                    $('#validate').text('');
                    $('#overlay').fadeIn();
                    $('#popup').fadeIn();
                    $('#validate').text('Vui lòng nhập đầy đủ ngày bắt đầu và ngày kết thúc.');
                    return;
                }
                let timeNow = new Date(time_now);
                let endDate = new Date(end_date);
                let startDate = new Date(start_date);
                if (!(endDate > timeNow) && (!(startDate > timeNow))) {
                    $.ajax({
                        type: "post",
                        url: "ajax-revenuesProductSale",
                        data: {
                            startDate:start_date,
                            endDate:end_date,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "JSON",
                        success: function (response) {
                             // Xóa dữ liệu cũ trong tbody
                            $('#tbody').empty();

                            // Duyệt qua danh sách sản phẩm và thêm vào bảng
                            $.each(response.topProducts, function(index, product) {
                                var row = '<tr>' +
                                            '<td>' + (index + 1) + '</td>' +
                                            '<td>' + product.product_name + '</td>' +
                                            '<td><img src="/upload/' + product.product_img + '" width="70" alt="' + product.name + '"></td>' +
                                            '<td>' + product.total_quantity + '</td>' +
                                        '</tr>';
                                $('#tbody').append(row);
                            });

                        }
                    });
                    console.log(start_date);
                    console.log(end_date);
                } else {
                    $('#overlay').fadeIn();
                    $('#popup').fadeIn();
                    $('#validate').text('Vui lòng kiểm tra lại thời gian bắt đầu và kết thúc');
                }
            });
            // tìm kiếm sản phẩm tồn kho theo thời gian
            $("#btnRevenue_noneSale").click(function (e) {
                e.preventDefault();
                let start_date = $("#start_date_product_nonesale").val();
                let end_date = $("#end_date_product_nonesale").val();
                if (start_date === '' && end_date === '') {
                    $('#validate').text('');
                    $('#overlay').fadeIn();
                    $('#popup').fadeIn();
                    $('#validate').text('Vui lòng nhập đầy đủ ngày bắt đầu và ngày kết thúc.');
                    return;
                }
                let timeNow = new Date(time_now);
                let endDate = new Date(end_date);
                let startDate = new Date(start_date);
                if (!(endDate > timeNow) && (!(startDate > timeNow))) {
                    $.ajax({
                        type: "post",
                        url: "ajax-revenuesProductSaleNone",
                        data: {
                            startDate:start_date,
                            endDate:end_date,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "JSON",
                        success: function (response) {
                             // Xóa dữ liệu cũ trong tbody
                            $('#tbodySaleNone').empty();
                            $('#tbodySaleNone2').css({
                                "height": "368px",
                                "overflow": "auto",
                                "width": "auto",
                                "border": "1px solid #ccc"
                            });
                            // Duyệt qua danh sách sản phẩm và thêm vào bảng
                            $.each(response.uniqueProducts, function(index, product) {
                                var row = '<tr>' +
                                            '<td>' + (index + 1) + '</td>' +
                                            '<td>' + product.name + '</td>' +
                                            '<td><img src="/upload/' + product.img + '" width="70" alt="' + product.name + '"></td>' +
                                            '<td>' + '0' + '</td>' +
                                        '</tr>';
                                $('#tbodySaleNone').append(row);
                            });

                        }
                    });
                } else {
                    $('#overlay').fadeIn();
                    $('#popup').fadeIn();
                    $('#validate').text('Vui lòng kiểm tra lại thời gian bắt đầu và kết thúc');
                }
            });
            //Bảng phân tích doanh thu
            $(".analysisRevenue").click(function (e) {
                e.preventDefault();
                alert('vào')
            });
            //Bảng phân tích sl người mua
            $(".analysisNbBuys").click(function (e) {
                e.preventDefault();
                alert('vào')
            });
        });
    </script>

@endsection
