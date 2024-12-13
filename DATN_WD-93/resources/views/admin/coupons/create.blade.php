@extends('admin.layout')
@section('titlepage', '')

@section('content')

    <div class="container-fluid mt-4 px-4">
        <h2>Thêm mã giảm giá</h2>

        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="code">Mã giảm giá</label>
                <input type="text" name="code" class="form-control" id="code" required>
                @error('code')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- Cập nhập thêm giảm giá --}}
            <div class="form-group">
                <label for="type">Loại</label>
                <select name="type" class="form-control" id="type" required>
                    <option value="fixed" selected>Giảm theo giá trị mặc định</option>
                    <option value="percentage">Giảm theo %</option>
                </select>
                @error('is_active')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="value">Giá trị</label>
                <input type="number" name="value" class="form-control" id="value" required>
                @error('value')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="min_order_value">Giá trị đơn hàng tối thiểu</label>
                <input type="number" name="min_order_value" class="form-control" id="min_order_value" required>
                @error('min_order_value')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="max_discount">Giảm giá tối đa</label>
                <input type="number" name="max_discount" class="form-control" id="max_discount">
                @error('max_discount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="expiry_date">Ngày hết hạn</label>
                <input type="date" name="expiry_date" class="form-control" id="expiry_date" required>
                @error('expiry_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="usage_limit">Số lượt đổi</label>
                <input type="number" name="usage_limit" class="form-control" id="usage_limit" required>
                @error('usage_limit')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="points_required">Số điểm yêu cầu</label>
                <input type="number" name="points_required" class="form-control" id="points_required">
                @error('points_required')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="is_active">Trạng thái</label>
                <select name="is_active" class="form-control" id="is_active">
                    <option value="1">Đang hoạt động</option>
                    <option value="0">Không hoạt động</option>
                </select>
                @error('is_active')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-2">Thêm</button>
            <a href="{{ route('admin.coupons.index') }}">
                <input type="button" class="btn btn-secondary mt-2" value="Danh sách mã giảm giá">
            </a>
        </form>
    </div>
    <script>
        document.getElementById('type').addEventListener('change', function() {
            const valueInput = document.getElementById('value');
            const maxDiscountInput = document.getElementById('max_discount');

            // Nếu là giảm theo % thì đặt giới hạn max = 99
            if (this.value === 'percentage') {
                valueInput.setAttribute('max', 99);
                maxDiscountInput.removeAttribute('disabled'); // Bật lại max_discount
            } else {
                // Nếu là giảm cố định thì không cần max
                valueInput.removeAttribute('max');
                maxDiscountInput.setAttribute('disabled', true); // Vô hiệu hóa max_discount
                maxDiscountInput.value = ''; // Xóa giá trị nếu không cần
            }
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            const type = document.getElementById('type').value;
            const value = document.getElementById('value').value;
            const maxDiscountInput = document.getElementById('max_discount').value;

            // Kiểm tra nếu giảm theo % và giá trị vượt quá 99
            if (type === 'percentage' && parseInt(value) > 99) {
                alert('Giá trị giảm theo % không được lớn hơn 99');
                event.preventDefault(); // Ngừng việc gửi form
                return;
            }

            // Kiểm tra nếu là giảm cố định mà max_discount có giá trị
            if (type === 'fixed' && maxDiscountInput.trim() !== '') {
                alert('Giảm theo giá trị cố định không cần nhập giá trị giảm giá tối đa');
                event.preventDefault(); // Ngừng việc gửi form
                return;
            }
        });

        // Khi tải trang, tự động kiểm tra trạng thái của max_discount
        document.addEventListener('DOMContentLoaded', function() {
            const type = document.getElementById('type').value;
            const maxDiscountInput = document.getElementById('max_discount');

            if (type === 'fixed') {
                maxDiscountInput.setAttribute('disabled', true);
                maxDiscountInput.value = ''; // Xóa giá trị nếu không cần
            } else {
                maxDiscountInput.removeAttribute('disabled');
            }
        });
    </script>
@endsection
