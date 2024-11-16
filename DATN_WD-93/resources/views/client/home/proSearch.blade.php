@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')

<style>
    #img {
        height: 300px;
        width: 100%;
    }
</style>
<!-- Products Start -->
<div class="container-fluid pt-5">
    <!-- Title -->
    <div class="text-center mb-4">
        <h2 class="section-title px-5">
            <span class="px-2">Products</span>
        </h2>
    </div>

    <!-- Search & sort -->
    <div class="row px-xl-5 pb-3">
        <!-- Search & sort -->
        <div class="col-12 pb-1">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <!-- Search -->
                <form action="index.php?act=search_pro" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search by name" name="kyw" />
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <!-- <i class="fa fa-search"></i> -->
                                <input type="submit" class="btn btn-primary" value="SEARCH" name="search">
                            </span>
                        </div>
                    </div>
                </form>
                <!-- Sort -->
                <div class="dropdown ml-4">
                    <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort by
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                        <a class="dropdown-item" href="#">Latest</a>
                        <a class="dropdown-item" href="#">Popularity</a>
                        <a class="dropdown-item" href="#">Best Rating</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row px-xl-5 pb-3">
        <!-- Product -->
        @foreach ($products as $item)
        @php $tt = $item['price'] - (($item['price']  * $item['discount']) / 100); @endphp
        <!-- Product 5 -->
      <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <div class="product-item bg-light mb-4">
          <div class="product-img position-relative overflow-hidden">
            <img
              class="img-fluid w-100"
              src="{{ asset('upload/'.$item->img) }}"
              alt=""
            />
            <div class="product-action">
              <a class="btn btn-outline-dark btn-square" href="{{ route('cart.listCart') }}"
                ><i class="fa fa-shopping-cart"></i
              ></a>
              <a class="btn btn-outline-dark btn-square" href=""
                ><i class="far fa-heart"></i
              ></a>
              <a class="btn btn-outline-dark btn-square" href=""
                ><i class="fa fa-sync-alt"></i
              ></a>
              <a class="btn btn-outline-dark btn-square" href="{{ route('productDetail', $item->id) }}"
                ><i class="fa fa-search"></i
              ></a>
            </div>
          </div>
          <div class="text-center py-4">
            <a class="h6 text-decoration-none text-truncate" href="{{ route('productDetail', $item->id) }}" style="max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
              > {{ $item->name }}</a
            >
            <div
              class="d-flex align-items-center justify-content-center mt-2"
            >
              <h5 class="text-danger">{{ number_format($tt, 0, ",", ".") }} $</h5>
              <h6 class="text-muted ml-2"><del>{{ number_format($item->price, 0, ',', '.') }} $</del></h6>
            </div>
            <div
              class="d-flex align-items-center justify-content-center mb-1"
            >
            @php
            $averageRating = round($item->review_avg_rating ?? 0); // làm tròn số sao, mặc định 0 nếu không có
            $reviewCount = $item->review_count ?? 0; // mặc định 0 nếu không có
        @endphp

        @for ($i = 1; $i <= 5; $i++)
            <small class="fa fa-star {{ $i <= $averageRating ? 'text-primary' : '' }} mr-1"></small>
        @endfor

        <small>({{ $reviewCount }})</small>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
</div>
<!-- Products End -->

@endsection
