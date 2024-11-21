<style>
    .icon-container {
    align-items: center;
    text-decoration: none;
    font-size: 15px;
    color: #ffffff;
}

.icon-container i {
    font-size: 1rem;
    margin-right: 5px; /* Khoảng cách giữa icon và badge */
}

.badge-label {
    align-items: center;
    color: #ffffff;
    font-weight: 300;
}

.badge-count {
    background-color: #ddd;
    color: #333;
    border-radius: 50%;
    padding: 4px 4px;
    font-weight: bold;
}

</style>
<!-- Navbar Start -->
<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
      <div class="col-lg-3 d-none d-lg-block">
        <a
          class="btn d-flex align-items-center justify-content-between bg-primary w-100"
          data-toggle="collapse"
          href="#navbar-vertical"
          style="height: 65px; padding: 0 30px"
        >
          <h6 class="text-dark m-0">
            <i class="fa fa-bars mr-2"></i>Danh Mục
          </h6>
          <i class="fa fa-angle-down text-dark"></i>
        </a>
        <nav
          class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
          id="navbar-vertical"
          style="width: calc(100% - 30px); z-index: 999"
        >
          <div class="navbar-nav w-100">
                @foreach ($categories as $category)
                <a href="{{ route('productsByCategoryId', $category->id) }}" class="dropdown-item">{{ $category->name }}</a>
                @endforeach
          </div>
        </nav>
      </div>
      <div class="col-lg-9">
        <nav
          class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0"
        >
          <a href="{{ route('home') }}" class="text-decoration-none d-block d-lg-none">
            <span class="h1 text-uppercase text-dark bg-light px-2"
              >Multi</span
            >
            <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1"
              >Shop</span
            >
          </a>
          <button
            type="button"
            class="navbar-toggler"
            data-toggle="collapse"
            data-target="#navbarCollapse"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div
            class="collapse navbar-collapse justify-content-between"
            id="navbarCollapse"
          >
            <div class="navbar-nav mr-auto py-0">
              <a href="{{ route('home') }}" class="nav-item nav-link active">Trang Chủ</a>
              <a href="{{ route('products') }}" class="nav-item nav-link">Tất Cả Sản Phẩm</a>
              <a href="{{ route('appoinment.index') }}" class="nav-item nav-link">Đặt Lịch Khám</a>
              <div class="nav-item dropdown">
                <a
                  href="#"
                  class="nav-link dropdown-toggle"
                  data-toggle="dropdown"
                  >Tiện Ích<i class="fa fa-angle-down mt-1"></i
                ></a>
                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                  <a href="{{ route('contact') }}" class="dropdown-item">Liên Hệ</a>
                  <a href="{{ route('about') }}" class="dropdown-item">Giới Thiệu</a>
                </div>
              </div>
              <a href="{{route('blog.index')}}" class="nav-item nav-link">Tin tức</a>
            </div>
            <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                <a href="{{ route('cart.listCart') }}" class="btn icon-container px-0 ml-3">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge-label">
                        <span class="badge-count">{{ \App\Models\Cart::where('user_id', Auth::id())->withCount('items')->first()->items_count ?? 0 }}</span>
                        Giỏ hàng
                    </span>
                </a>
                <a href="{{ route('orders.index') }}" class="btn icon-container px-0 ml-3">
                    <i class="fas fa-file-invoice-dollar text-primary"></i>
                    <span class="badge-label">
                        <span class="badge-count">{{ $orderCount }}</span>
                        Kiểm tra đơn hàng
                    </span>
                </a>
                <a href="" class="btn icon-container px-0 ml-3">
                    <i class="fas fa-bell" style="color: #ffd43b"></i>
                    <span class="badge-label">
                        <span class="badge-count">0</span>
                        Thông báo
                    </span>
                </a>
                @if(auth()->check())
                    <a href="{{ route('account') }}" class="btn icon-container px-0 ml-3">
                        <i class="fas fa-user" style="color: #ffd43b"></i>
                        <span class="badge-label">Tài khoản</span>
                    </a>
                @else
                    <a href="{{ route('viewLogin') }}" class="btn icon-container px-0 ml-3">
                        <i class="fas fa-user" style="color: #ffd43b"></i>
                        <span class="badge-label">Đăng nhập</span>
                    </a>
                @endif
            </div>

          </div>
        </nav>
      </div>
    </div>
  </div>
  <!-- Navbar End -->