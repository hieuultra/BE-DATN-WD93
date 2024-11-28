@extends('admin.layout')
@section('titlepage', '')

@section('content')

    <div class="container-fluid mt-4 px-4">
        <h2>Sửa mã giảm giá</h2>

        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Đảm bảo gửi request PUT -->

            <div class="form-group">
                <label for="code">Mã giảm giá</label>
                <input type="text" name="code" class="form-control" id="code" value="{{ old('code', $coupon->code) }}"
                    required>
                @error('code')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Loại</label>
                <select name="type" class="form-control" id="type" required>
                    <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Giảm theo giá trị mặc định
                    </option>
                    <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Giảm theo %</option>
                </select>
                @error('is_active')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="value">Giá trị</label>
                <input type="number" name="value" class="form-control" id="value"
                    value="{{ old('value', $coupon->value) }}" required>
                @error('value')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="min_order_value">Giá trị đơn hàng tối thiểu</label>
                <input type="number" name="min_order_value" class="form-control" id="min_order_value"
                    value="{{ old('min_order_value', $coupon->min_order_value) }}" required>
                @error('min_order_value')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="expiry_date">Ngày hết hạn</label>
                <input type="date" name="expiry_date" class="form-control" id="expiry_date"
                    value="{{ old('expiry_date', $coupon->expiry_date) }}" required>
                @error('expiry_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="usage_limit">Số lần sử dụng</label>
                <input type="number" name="usage_limit" class="form-control" id="usage_limit"
                    value="{{ old('usage_limit', $coupon->usage_limit) }}" required>
                @error('usage_limit')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_active">Trạng thái</label>
                <select name="is_active" class="form-control" id="is_active">
                    <option value="1" {{ $coupon->is_active == 1 ? 'selected' : '' }}>Đang hoạt động</option>
                    <option value="0" {{ $coupon->is_active == 0 ? 'selected' : '' }}>Không hoạt động</option>
                </select>
                @error('is_active')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.coupons.index') }}">
                <input type="button" class="btn btn-secondary" value="Danh sách mã giảm giá">
            </a>
        </form>
    </div>
    <script>
        document.getElementById('type').addEventListener('change', function() {
            const valueInput = document.getElementById('value');
            if (this.value === 'percentage') {
                valueInput.setAttribute('max', 99);
            } else {
                valueInput.removeAttribute('max');
            }
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            const type = document.getElementById('type').value;
            const value = document.getElementById('value').value;

            if (type === 'percentage' && parseInt(value) > 99) {
                alert('Giá trị giảm theo % không được lớn hơn 99');
                event.preventDefault();
            }
        });
    </script>

@endsection
