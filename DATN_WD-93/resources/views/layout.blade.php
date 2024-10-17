<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>@yield('titlepage')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
      rel="stylesheet"
    />

    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />
    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }} " rel="stylesheet" />
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }} " rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/style1.css') }}" rel="stylesheet" />
  </head>

  <body>
    <!-- Topbar Start -->
    <div class="container-fluid">
      <div class="row bg-secondary py-1 px-xl-5">
        <marquee behavior="scroll" direction="left" scrollamount="5">
          <span style="font-size: 18px; color: red"
            >Free exchange for 30 days.</span
          >
        </marquee>
        <div class="col-lg-6 d-none d-lg-block">
          <div class="d-inline-flex align-items-center h-100">
            <a class="text-body mr-3" href="">About</a>
            <a class="text-body mr-3" href="">Contact</a>
            <a class="text-body mr-3" href="">Help</a>
            <a class="text-body mr-3" href="">FAQs</a>
          </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
          <div class="d-inline-flex align-items-center">
            <div class="btn-group">
              <button
                type="button"
                class="btn btn-sm btn-light dropdown-toggle"
                data-toggle="dropdown"
              >
                My Account
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <button class="dropdown-item" type="button">Sign in</button>
                <button class="dropdown-item" type="button">Sign up</button>
              </div>
            </div>
            <div class="btn-group mx-2">
              <button
                type="button"
                class="btn btn-sm btn-light dropdown-toggle"
                data-toggle="dropdown"
              >
                USD
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <button class="dropdown-item" type="button">EUR</button>
                <button class="dropdown-item" type="button">GBP</button>
                <button class="dropdown-item" type="button">CAD</button>
              </div>
            </div>
            <div class="btn-group">
              <button
                type="button"
                class="btn btn-sm btn-light dropdown-toggle"
                data-toggle="dropdown"
              >
                EN
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <button class="dropdown-item" type="button">FR</button>
                <button class="dropdown-item" type="button">AR</button>
                <button class="dropdown-item" type="button">RU</button>
              </div>
            </div>
          </div>
          <div class="d-inline-flex align-items-center d-block d-lg-none">
            <a href="" class="btn px-0 ml-2">
              <i class="fas fa-heart text-dark"></i>
              <span
                class="badge text-dark border border-dark rounded-circle"
                style="padding-bottom: 2px"
                >0</span
              >
            </a>
            <a href="" class="btn px-0 ml-2">
              <i class="fas fa-shopping-cart text-dark"></i>
              <span
                class="badge text-dark border border-dark rounded-circle"
                style="padding-bottom: 2px"
                >0</span
              >
            </a>
          </div>
        </div>
      </div>
      <div
        class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex"
      >
        <div class="col-lg-4">
          <a href="{{ route('home') }}" class="text-decoration-none">
            <span class="h1 text-uppercase text-primary bg-dark px-2"
              >Instinct</span
            >
            <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1"
              >Pharmacy</span
            >
          </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
          <form action="">
            <div class="input-group">
              <input
                type="text"
                class="form-control"
                placeholder="Search for products"
              />
              <div class="input-group-append">
                <span class="input-group-text bg-transparent text-primary">
                  <i class="fa fa-search"></i>
                </span>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-4 col-6 text-right">
          <p class="m-0">Customer Service</p>
          <h5 class="m-0">+012 345 6789</h5>
        </div>
      </div>
    </div>
    <!-- Topbar End -->

    @include('header')

    <main>
       @yield('content')
    </main>

    @include('footer')
<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"
><i class="fa fa-angle-double-up"></i
></a>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Contact Javascript File -->
<script src="mail/jqBootstrapValidation.min.js"></script>
<script src="mail/contact.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API = Tawk_API || {},
  Tawk_LoadStart = new Date();
(function () {
  var s1 = document.createElement("script"),
    s0 = document.getElementsByTagName("script")[0];
  s1.async = true;
  s1.src = "https://embed.tawk.to/66fa718e4cbc4814f7e0df96/1i914n53o";
  s1.charset = "UTF-8";
  s1.setAttribute("crossorigin", "*");
  s0.parentNode.insertBefore(s1, s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>

</html>
