@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Add Doctor</h1>
    <form action="{{ route('admin.doctors.doctorUpdate') }}" method="post" id="demoForm">
        @csrf
        <input type="hidden" name="id" value="{{ $doctor->id }}">
        <div class="row">
            <!-- Phần bên trái -->
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Name</label>
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
                    <label class="form-label">Specialty Doctor</label>
                    <select class="form-select" name="specialty_id" id="specialty_id" onchange="checkClassification(this.value)">
                        <option value="0">Choose Specialty</option>
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
                    <label class="form-label">Degree</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{  $doctor->title }}" name="title" placeholder="Degree">
                    @error('title')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Experience_years</label>
                    <input type="number" class="form-control @error('experience_years') is-invalid @enderror" value="{{  $doctor->experience_years }}" name="experience_years" placeholder="Experience_years">
                    @error('experience_years')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Position work</label>
                    <input type="text" class="form-control @error('position') is-invalid @enderror" value="{{  $doctor->position }}" name="position" placeholder="Position">
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
                    <label class="form-label">Workplace</label>
                    <input type="text" class="form-control @error('workplace') is-invalid @enderror" value="{{  $doctor->workplace }}" name="workplace" placeholder="Workplace">
                    @error('workplace')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Age of examination</label>
                    <input type="number" class="form-control @error('min_age') is-invalid @enderror" value="{{  $doctor->min_age }}" name="min_age" placeholder="Age of examination">
                    @error('min_age')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Examination_fee</label>
                    <input type="number" class="form-control @error('examination_fee') is-invalid @enderror" value="{{  $doctor->examination_fee }}" name="examination_fee" placeholder="Examination_fee">
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
                    <label class="form-label">Doctor Bio</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror"
                        placeholder="Leave a bio here" style="height: 100px" name="bio">{{ $doctor->bio }}</textarea>
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
                    <label class="form-label">clinic name</label>
                    <input type="text" class="form-control @error('clinic_name') is-invalid @enderror" name="clinic_name" value="{{$clinic->clinic_name}}">
                    @error('clinic_name')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">city</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{$clinic->city}}">
                    @error('city')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">address</label>
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
                    <label class="form-label">clinic name</label>
                    <input type="text" class="form-control @error('clinic_name') is-invalid @enderror" name="clinic_name" placeholder="clinic name">
                    @error('clinic_name')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">city</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" placeholder="city">
                    @error('city')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="address">
                    @error('address')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        @endif
        <input type="submit" class="btn btn-primary" value="Edit">
        <a href="{{ route('admin.specialties.specialtyDoctorList') }}">
            <input type="button" class="btn btn-primary" value="LIST_SPECIALTY_DOCTOR">
        </a>
    </form>
</div>


<script>
    function checkClassification(specialtyId) {
        var selectedOption = document.querySelector(`#specialty_id option[value="${specialtyId}"]`);
        var classification = selectedOption ? selectedOption.getAttribute('data-classification') : null;

        var clinicAddressDiv = document.getElementById('clinic-address');

        // If classification is 'chuyen_khoa', show the clinic address section
        if (classification === 'chuyen_khoa') {
            clinicAddressDiv.style.display = 'block';
        } else {
            clinicAddressDiv.style.display = 'none';
        }
    }

    // Automatically check classification on page load based on the preselected specialty
    document.addEventListener('DOMContentLoaded', function() {
        var specialtyId = document.getElementById('specialty_id').value;
        checkClassification(specialtyId);
    });
</script>
@endsection