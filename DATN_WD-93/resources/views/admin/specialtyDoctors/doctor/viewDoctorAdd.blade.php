@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Thêm mới bác sỹ</h1>
    <form action="{{ route('admin.doctors.doctorAdd') }}" method="post" id="demoForm">
        @csrf
        <div class="row">
            <!-- Phần bên trái -->
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Tài khoản bác sỹ</label>
                    <select class="form-select" name="user_id">
                        <option value="0">Không chọn tài khoản nào</option>
                        @foreach($user as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Phần bên phải -->
            <div class="col">
                <div class="mb-3">
                    <label for="classification" class="form-label">Loại chuyên khoa:</label>
                    <select class="form-select" name="classification" id="classification" onchange="filterSpecialty(this.value)">
                        <option value="">-- Chưa chọn loại chuyên khoa --</option>
                        <option value="chuyen_khoa" {{ request('classification') == 'chuyen_khoa' ? 'selected' : '' }}>Chuyên khoa</option>
                        <option value="kham_tu_xa" {{ request('classification') == 'kham_tu_xa' ? 'selected' : '' }}>Khám từ xa</option>
                    </select>
                </div>
            </div>

            <div class="col" id="specialty-container" style="display: none;">
                <div class="mb-3">
                    <label class="form-label">Chuyên khoa</label>
                    <select class="form-select" name="specialty_id" id="specialty_id">
                        <option value="0">Đóng chuyên khoa</option>
                        @foreach($specialty as $vp)
                        <option value="{{ $vp->id }}">{{ $vp->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Bằng cấp</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" name="title" placeholder="Bằng cấp">
                    @error('title')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Năm kinh nghiệm</label>
                    <input type="number" class="form-control @error('experience_years') is-invalid @enderror" value="{{ old('experience_years') }}" name="experience_years" placeholder="Năm kinh nghiệm">
                    @error('experience_years')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Chức vụ</label>
                    <input type="text" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}" name="position" placeholder="Chức vụ">
                    @error('position')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        {{-- Hàng thứ 2 --}}
        <div class="row">

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Quê quán</label>
                    <input type="text" class="form-control @error('workplace') is-invalid @enderror" value="{{ old('workplace') }}" name="workplace" placeholder="Quê quán">
                    @error('workplace')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Tuổi khám nhỏ nhất</label>
                    <input type="number" class="form-control @error('min_age') is-invalid @enderror" value="{{ old('min_age') }}" name="min_age" placeholder="Tuổi khám nhỏ nhất">
                    @error('min_age')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Giá khám</label>
                    <input type="number" class="form-control @error('examination_fee') is-invalid @enderror" value="{{ old('examination_fee') }}" name="examination_fee" placeholder="Giá khám">
                    @error('examination_fee')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <!-- Hàng thứ 3 -->
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Mô tả tiểu sử bác sỹ</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror"
                        id="doctorBio"
                        style="height: 100px"
                        name="bio"></textarea>

                    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
                    <script>
                        CKEDITOR.replace('doctorBio');
                    </script>
                    @error('bio')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row" id="clinic-address">
            <h2>Địa chỉ phòng khám</h2>
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Tên phòng khám</label>
                    <input type="text" class="form-control @error('clinic_name') is-invalid @enderror" name="clinic_name" placeholder="Tên phòng khám">
                    @error('clinic_name')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Thành phố</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" placeholder="Thành phố">
                    @error('city')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Địa chỉ cụ thể</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Địa chỉ cụ thể">
                    @error('address')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

</div>

<input type="submit" class="btn btn-primary" value="Add">
<a href="{{ route('admin.specialties.specialtyDoctorList') }}">
    <input type="button" class="btn btn-primary" value="LIST_SPECIALTY_DOCTOR">
</a>
</form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function filterSpecialty(classification) {
        if (!classification) {
            $('#specialty-container').hide();
        } else {
            $.ajax({
                url: "{{ route('admin.doctors.filterSpecialty') }}",
                type: 'GET',
                data: {
                    classification: classification
                },
                success: function(response) {
                    $('#specialty_id').empty();
                    $('#specialty_id').append('<option value="0">Đóng chuyên khoa</option>');
                    response.forEach(function(item) {
                        $('#specialty_id').append('<option value="' + item.id + '">' + item.name + '</option>');
                    });

                    $('#specialty-container').show();

                    if (classification === 'kham_tu_xa') {
                        $('#clinic-address').hide();
                    } else {
                        $('#clinic-address').show();
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra khi lọc chuyên khoa');
                }
            });
        }
    }

</script>
@endsection