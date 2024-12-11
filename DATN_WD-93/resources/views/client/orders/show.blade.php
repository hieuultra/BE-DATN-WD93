@extends('layout')
@section('titlepage', 'Instinct - Instinct Pharmacy System')
@section('title', 'Welcome')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .order-details {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .order-details h4 {
            margin-top: 0;
        }
        .order-details table {
            width: 100%;
            margin-bottom: 20px;
        }
        .order-details table th,
        .order-details table td {
            padding: 10px;
            text-align: left;
        }
        .order-details table thead th {
            background-color: #f2f2f2;
        }
    </style>

    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                <div class="order-details">
                    <h4>Chi tiết đơn hàng</h4>

                    {{-- Thông tin đơn hàng --}}
                    <div class="order-info">
                        <h5 class="text-center">Thông tin đơn hàng</h5>
                        <table>
                            <tr>
                                <th class="text-center">Mã đơn:</th>
                                <td class="text-danger text-center">{{ $bill->billCode }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Tên người nhận :</th>
                                <td class="text-center">{{ $bill->nameUser }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Thời gian đặt:</th>
                                <td class="text-center">{{ $bill->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Trạng thái:</th>
                                <td class="text-center">{{ $statusBill[$bill->status_bill] }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Trạng thái thanh toán:</th>
                                <td class="text-center">{{ $status_payment_method[$bill->status_payment_method] }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Địa chỉ nhận hàng:</th>
                                <td class="text-center">{{ $bill->addressUser }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Số điện thoại người nhận:</th>
                                <td class="text-center">{{ $bill->phoneUser }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Email người nhận:</th>
                                <td class="text-center">{{ $bill->emailUser }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Số tiền hàng:</th>
                                <td class="text-center">{{ number_format($bill->moneyProduct, 0, ',', '.') }}VND</td>
                            </tr>
                            <tr>
                                <th class="text-center">Tiền vận chuyển:</th>
                                <td class="text-center">40.000VND</td>
                            </tr>
                            <tr>
                                <th class="text-center">Giảm giá:</th>
                                <td class="text-center">- {{ number_format($bill->moneyShip, 0, ',', '.') }}VND</td>
                            </tr>
                            <tr>
                                <th class="text-center">Tổng:</th>
                                <td class="text-center">{{ number_format($bill->totalPrice, 0, ',', '.') }}VND</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Chi tiết sản phẩm --}}
                    <div class="order-items">
                        <h5>Sản phẩm</h5>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Loại</th>
                                    <th>Ảnh</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bill->order_detail as $detail)
                                    @php
                                        $product = $detail->product;
                                        $variant = $detail->productVariant; // Biến thể sản phẩm
                                         // Kiểm tra xem sản phẩm đã được đánh giá chưa
                                         $isRated = $detail->ratings->where('bill_id', $bill->id)->isNotEmpty();
                                    @endphp
                                    <tr>
                                        <td>{{ $product->idProduct }}</td>
                                        <td><a
                                                href="{{ route('productDetail', $detail->product_id) }}">{{ $product->name }}</a>
                                        </td>
                                        <td>{{ $variant->variantPackage->name ?? 'Không xác định' }}</td>
                                        <!-- Hiển thị loại sản phẩm -->
                                        <td><img class="img-fluid" src="{{ asset('upload/' . $product->img) }}"
                                                width="75px"></td>
                                        <td>{{ number_format($detail->unitPrice, 0, ',', '.') }}VND</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>{{ number_format($detail->totalMoney, 0, ',', '.') }}VND</td>
                                        @if ($bill->status_bill == $type_da_giao_hang && !$isRated)
                                        <th>
                                            <button class="btn btn-warning" onclick="openModal({{ $detail->product_id }})">Đánh giá</button>
                                        </th>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Nút quay lại --}}
                    <div class="mt-4">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Popup -->
<div id="ratingModal" class="modal" tabindex="-1" role="dialog" style="display:none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đánh giá sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ratingForm">
                    <input type="hidden" id="productId" name="product_id" value="">
                    <div class="form-group">
                        <label for="rating">Đánh giá:</label>
                        <select id="rating" name="rating" class="form-control">
                            <option value="1">1 Sao</option>
                            <option value="2">2 Sao</option>
                            <option value="3">3 Sao</option>
                            <option value="4">4 Sao</option>
                            <option value="5">5 Sao</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comment">Bình luận:</label>
                        <textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Mời bạn chia sẻ thêm cảm nhận...."></textarea>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="submitRating()">Gửi đánh giá</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Mở modal và thiết lập product_id
function openModal(productId) {
    document.getElementById('productId').value = productId;
    document.getElementById('ratingModal').style.display = 'block';
}

// Đóng modal
function closeModal() {
    document.getElementById('ratingModal').style.display = 'none';
}

// Gửi đánh giá bằng AJAX
function submitRating() {
    const productId = document.getElementById('productId').value;
    const rating = document.getElementById('rating').value;
    const comment = document.getElementById('comment').value;
    const billId = '{{ $bill->id }}'; // Lấy ID đơn hàng từ blade

    fetch('{{ route('submitRating') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ product_id: productId, rating, comment, bill_id: billId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: data.message,
                    confirmButtonText: 'OK',
                }).then(() => {
                    closeModal();
                    location.reload(); // Tải lại trang để cập nhật trạng thái
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Thông báo',
                    text: data.message,
                    confirmButtonText: 'OK',
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại!',
                confirmButtonText: 'OK',
            });
            console.error('Error:', error);
        });
}
</script>
@endsection
