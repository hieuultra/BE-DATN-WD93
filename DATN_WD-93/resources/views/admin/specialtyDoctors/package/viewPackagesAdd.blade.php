@extends('admin.layout')
@section('titlepage','')

@section('content')

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Add Package</h1>
    <form action="{{ route('admin.packages.PackageAdd') }}" method="post" id="demoForm" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Phần bên phải -->
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Chuyên ngành</label>
                    <select class="form-select" name="specialty_id" id="specialty_id">
                        <option value="0">Choose Specialty</option>
                        @foreach($specialty as $vp)
                        <option value="{{ $vp->id }}">{{ $vp->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Tên dịch vụ khám</label>
                    <input type="text" class="form-control @error('hospital_name') is-invalid @enderror" name="hospital_name" placeholder="Tên dịch vụ khám">
                    @error('hospital_name')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Mô tả dịch vụ khám</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Mô tả dịch vụ khám"></textarea>
                    @error('description')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Ảnh</label>
                    <input type="file" class="form-control" name="image" onchange="showImage(event)">
                    <img id="imgCate" src="" alt="Image Product" style="width:150px; display: none">
                </div>
            </div>
        </div>
        {{-- Hàng thứ 2 --}}
        <div class="row">

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Địa chỉ khám</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Địa chỉ khám">
                    @error('address')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Giá dịch vụ khám</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" name="price" placeholder="Giá dịch vụ khám">
                    @error('price')
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

<script>
//hien thi image khi add
function showImage(event){
        const imgCate = document.getElementById('imgCate');
        const file =  event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(){
            imgCate.src = reader.result;
            imgCate.style.display = "block";
        }
        if(file){
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection