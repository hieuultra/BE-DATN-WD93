@extends('admin.layout')
@section('titlepage','')

@section('content')
 <!-- Quill css -->
 <link href="{{ asset('assets/admin/libs/quill/quill.core.js') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('assets/admin/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('assets/admin/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
 {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">


<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Add Products Variant</h1>
    <form action="{{ route('admin.productVariant.variantProductAdd') }}" method="post" id="demoForm">
        @csrf
        <div class="row">
            <!-- Phần bên trái -->
           <div class="col">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <select class="form-select" name="id_product">
                    <option value="0">Choose Products</option>
                    @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
           </div>
            <!-- Phần bên phải -->
            <div class="col">
               <div class="mb-3">
                <label class="form-label">Variant Products</label>
                <select class="form-select" name="id_variant">
                    <option value="0">Choose Variant Products</option>
                    @foreach($variantPackages as $vp)
                    <option value="{{ $vp->id }}">{{ $vp->name }}</option>
                    @endforeach
                </select>
            </div>
            </div>
        </div>
        {{-- Hàng thứ 2 --}}
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" class="form-control" value="{{ old('price') }}" name="price" placeholder="Price">
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control" value="{{ old('quantity') }}" name="quantity" placeholder="Quantity">
                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Add">
        <a href="{{ route('admin.variantPros.variantProList') }}">
            <input type="button" class="btn btn-primary" value="LIST_PRO_VARIANT">
        </a>
    </form>
</div>
@endsection