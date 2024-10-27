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
                <select class="form-select" name="specialty_id">
                    <option value="0">Choose Specialty</option>
                    @foreach($specialty as $vp)
                    @if ($vp->id == $doctor->specialty_id)
                    <option value="{{ $vp->id }}" selected>{{ $vp->name }}</option>
                @else
                <option value="{{ $vp->id }}">{{ $vp->name }}</option>
                @endif
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
                     placeholder="Leave a bio here" style="height: 100px" name="bio" >{{ $doctor->bio }}</textarea>
                     @error('bio')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Edit">
        <a href="{{ route('admin.specialties.specialtyDoctorList') }}">
            <input type="button" class="btn btn-primary" value="LIST_SPECIALTY_DOCTOR">
        </a>
    </form>
</div>

@endsection
