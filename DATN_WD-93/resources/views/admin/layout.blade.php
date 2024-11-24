<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<title>Dashboard</title>
<!-- Thêm thư viện Chart.js từ CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Thêm thư viện DataTables từ CDN -->
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('layoutAdmin/css/styles2.css') }}">
</head>
<body>
<header>
    <h1>@yield('titlepage')</h1>
</header>

@include('admin.header')

<div id="layoutSidenav">
 <!-- Left menu -->
 <div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('admin') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Bảng điều khiển
                </a>

                <!--  -->
                <div class="sb-sidenav-menu-heading">Giao diện</div>

                <!-- Category -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCate" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-columns"></i>
                    </div>
                    Danh mục
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>

                <div class="collapse" id="collapseCate" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('admin.categories.categoriesList') }}">Danh sách danh mục</a>
                        <a class="nav-link" href="{{ route('admin.categories.viewCateAdd') }}">Thêm danh mục</a>
                    </nav>
                </div>

                 {{-- <!-- Variant Product -->
                 <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVariantProduct" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-columns"></i>
                    </div>
                    Variant Product
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                  </a>

                  <div class="collapse" id="collapseVariantProduct" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                      <nav class="sb-sidenav-menu-nested nav">
                          <a class="nav-link" href="{{ route('admin.variantPackages.variantPackageList') }}">List Variant Package</a>
                          <a class="nav-link" href="">Add Variant</a>
                      </nav>
                  </div> --}}

                <!-- Product -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProduct" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-columns"></i>
                    </div>
                    Sản phẩm
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>

                <div class="collapse" id="collapseProduct" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('admin.products.productList') }}">Danh sách sản phẩm</a>
                        <a class="nav-link" href="{{ route('admin.products.viewProAdd') }}">Thêm sản phẩm</a>
                    </nav>
                </div>

                 <!-- Variant Product -->
                 <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVariantProduct" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-columns"></i>
                    </div>
                    Biến thể sản phẩm
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                  </a>

                  <div class="collapse" id="collapseVariantProduct" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                      <nav class="sb-sidenav-menu-nested nav">
                          <a class="nav-link" href="{{ route('admin.variantPros.variantProList') }}">Danh sách biến thể</a>
                          <a class="nav-link" href="{{ route('admin.variantPros.variantProList') }}">Danh sách sản phẩm biến thể</a>
                      </nav>
                  </div>

                      <!-- specialty doctor -->
                 <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsespecialties" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-columns"></i>
                    </div>
                   Danh sách chuyên ngành
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                  </a>

                  <div class="collapse" id="collapsespecialties" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                      <nav class="sb-sidenav-menu-nested nav">
                          <a class="nav-link" href="{{ route('admin.specialties.specialtyDoctorList') }}">Danh sách chuyên ngành</a>
                      </nav>
                  </div>

                <!-- back to web -->
                <a class="nav-link collapsed" href="{{ route('home') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-columns"></i>
                    </div>
                    Quay lại website
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>

                  <!-- bill -->
      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsebill" aria-expanded="false" aria-controls="collapseLayouts">
        <div class="sb-nav-link-icon">
          <i class="fas fa-columns"></i>
        </div>
        Đơn hàng
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>

      <div class="collapse" id="collapsebill" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
          <a class="nav-link" href="{{ route('admin.bills.index') }}">Danh sách đơn hàng</a>
        </nav>
      </div>

                   <!-- account -->
    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAccount" aria-expanded="false" aria-controls="collapseLayouts">
        <div class="sb-nav-link-icon">
          <i class="fas fa-columns"></i>
        </div>
        Tài khoản
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>

      <div class="collapse" id="collapseAccount" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
          <a class="nav-link" href="{{ route('admin.users.userList') }}">Danh sách tài khoản</a>
          <a class="nav-link" href="{{ route('admin.users.viewUserAdd') }}">Thêm tài khoản</a>
        </nav>
      </div>

      <!-- blog -->
      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsebl" aria-expanded="false" aria-controls="collapseLayouts">
        <div class="sb-nav-link-icon">
          <i class="fas fa-newspaper"></i>
        </div>
        Tin tức
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>

      <div class="collapse" id="collapsebl" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
          <a class="nav-link" href="{{route('admin.topics.index')}}">Chuyên đề</a>
          <a class="nav-link" href="{{route('admin.blogs.index')}}">Bài viết</a>
        </nav>
      </div>


      <!-- brand -->
      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBrand" aria-expanded="false" aria-controls="collapseLayouts">
        <div class="sb-nav-link-icon">
          <i class="fas fa-columns"></i>
        </div>
        Thương hiệu
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>

      <div class="collapse" id="collapseBrand" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
          <a class="nav-link" href="{{route('admin.brands.index')}}">Danh sách thương hiệu</a>
          <a class="nav-link" href="{{route('admin.brands.create')}}">Thêm thương hiệu</a>
        </nav>
      </div>


      <!-- comment -->
      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseComment" aria-expanded="false" aria-controls="collapseLayouts">
        <div class="sb-nav-link-icon">
          <i class="fas fa-columns"></i>
        </div>
        Mã giảm giá
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>

      <div class="collapse" id="collapseComment" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
          <a class="nav-link" href="{{ route('admin.coupons.index') }}">Danh sách mã giảm giá</a>
          <a class="nav-link" href="{{ route('admin.coupons.create') }}">Thêm mã giảm giá</a>
        </nav>
      </div>
      <!-- feedback -->
      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsefb" aria-expanded="false" aria-controls="collapseLayouts">
        <div class="sb-nav-link-icon">
          <i class="fas fa-columns"></i>
        </div>
        Danh sách đánh giá
        <div class="sb-sidenav-collapse-arrow">
          <i class="fas fa-angle-down"></i>
        </div>
      </a>

      <div class="collapse" id="collapsefb" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="{{route('admin.reviews.listReviews')}}">Danh sách đánh giá</a>
        </nav>
      </div>
            </div>
    </nav>
</div>
<div id="layoutSidenav_content">
    <main>
        @yield('content')
     </main>
     @include('admin.footer')
</div>
</div>



 <!-- Js -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
 <script src="{{ asset('layoutAdmin/js/scripts.js') }}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
 <script src="{{ asset('layoutAdmin/asset/chart-area-demo.js') }}"></script>
 <script src="{{ asset('layoutAdmin/asset/chart-bar-demo.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
 <script src="{{ asset('layoutAdmin/js/datatables-simple-demo.js') }}"></script>
</body>
</html>
