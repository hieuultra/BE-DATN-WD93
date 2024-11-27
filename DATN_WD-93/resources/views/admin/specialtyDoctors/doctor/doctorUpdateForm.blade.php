@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Cập nhật bác sỹ</h1>
    <form action="{{ route('admin.doctors.doctorUpdate') }}" method="post" id="demoForm">
        @csrf
        <input type="hidden" name="id" value="{{ $doctor->id }}">
        <div class="row">
            <!-- Phần bên trái -->
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Tài khoản bác sỹ</label>
                    <select class="form-select" name="user_id">
                        <option value="0">Choose Account</option>
                        @foreach($user as $p)
                        @if ($p->id == $doctor->user_id)
                        <option value="{{ $p->id }}" selected>{{ $p->name }}</option>
                        @else
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Phần bên phải -->
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Chuyên khoa bác sỹ</label>
                    <select class="form-select" name="specialty_id" id="specialty_id" onchange="checkClassification(this.value)">
                        <option value="0">Chọn chuyên khoa</option>
                        @foreach($specialty as $vp)
                        <option value="{{ $vp->id }}" data-classification="{{ $vp->classification }}"
                            @if ($vp->id == $doctor->specialty_id) selected @endif>
                            {{ $vp->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Bằng cấp</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{  $doctor->title }}" name="title">
                    @error('title')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Năm kinh nghiệm</label>
                    <input type="number" class="form-control @error('experience_years') is-invalid @enderror" value="{{  $doctor->experience_years }}" name="experience_years">
                    @error('experience_years')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Chức vụ</label>
                    <input type="text" class="form-control @error('position') is-invalid @enderror" value="{{  $doctor->position }}" name="position">
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
                    <input type="text" class="form-control @error('workplace') is-invalid @enderror" value="{{  $doctor->workplace }}" name="workplace">
                    @error('workplace')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Tuổi khám nhỏ nhất</label>
                    <input type="number" class="form-control @error('min_age') is-invalid @enderror" value="{{  $doctor->min_age }}" name="min_age">
                    @error('min_age')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Giá khám</label>
                    <input type="number" class="form-control @error('examination_fee') is-invalid @enderror" value="{{  $doctor->examination_fee }}" name="examination_fee">
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
                        name="bio">{{ $doctor->bio ?? '' }}</textarea>

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

        @if(empty($clinic) != 'Null')
        <div class="row" id="clinic-address">
            <h2>Địa chỉ phòng khám</h2>
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Tên phòng khám</label>
                    <input type="text" class="form-control @error('clinic_name') is-invalid @enderror" name="clinic_name" value="{{$clinic->clinic_name}}">
                    @error('clinic_name')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Thành phố</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{$clinic->city}}">
                    @error('city')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Địa chỉ cụ thể</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{$clinic->address}}">
                    @error('address')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        @endif

        @if(empty($clinic))
        <div class="row" id="clinic-address" style="display: none;">
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
        @endif
        <input type="submit" class="btn btn-primary" value="Lưu">
        <a href="{{ route('admin.specialties.specialtyDoctorList') }}">
            <input type="button" class="btn btn-primary" value="Quay lại">
        </a>
    </form>
</div>


<script>
    function checkClassification(specialtyId) {
        var selectedOption = document.querySelector(`#specialty_id option[value="${specialtyId}"]`);
        var classification = selectedOption ? selectedOption.getAttribute('data-classification') : null;

        var clinicAddressDiv = document.getElementById('clinic-address');
        if (classification === 'chuyen_khoa') {
            clinicAddressDiv.style.display = 'block';
        } else {
            clinicAddressDiv.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var specialtyId = document.getElementById('specialty_id').value;
        checkClassification(specialtyId);
    });
</script>
@endsection
