<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{$title}} - Sistem Informasi Jasa Kontruksi</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('pages')}}/lib/animate/animate.min.css" rel="stylesheet">
    <link href="{{asset('pages')}}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{asset('pages')}}/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('pages')}}/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('pages')}}/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    @include('components.pages.topbar')
    <!-- Topbar End -->


    <!-- Navbar Start -->
    @include('components.pages.navbar')
    <!-- Navbar End -->
    
    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <center>
                        <img src="{{asset('assets/images/icon-sijakon.png')}}" class="text-center" width="150" alt="">
                    </center>
                    <h4 class="text-light mb-4 text-center">Sijakon</h4>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Alamat</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>0778 - 8014354</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>disciptakaru@batam.go.id</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Menu</h4>
                    <a class="btn btn-link" href="">Beranda</a>
                    <a class="btn btn-link" href="">Tentang Kami</a>
                    <a class="btn btn-link" href="">FAQ</a>
                    <a class="btn btn-link" href="">User Manual</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Syarat & Ketentuan</h4>
                    <a class="btn btn-link" href="">Terms</a>
                    <a class="btn btn-link" href="">Kebijakan Privasi</a>
                    <a class="btn btn-link" href="">Pusat Bantuan</a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#"></a>{!! env("APP_NAME") !!}, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        {{ env("APP_COPYRIGHT") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('pages')}}/lib/wow/wow.min.js"></script>
    <script src="{{asset('pages')}}/lib/easing/easing.min.js"></script>
    <script src="{{asset('pages')}}/lib/waypoints/waypoints.min.js"></script>
    <script src="{{asset('pages')}}/lib/counterup/counterup.min.js"></script>
    <script src="{{asset('pages')}}/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="{{asset('pages')}}/lib/tempusdominus/js/moment.min.js"></script>
    <script src="{{asset('pages')}}/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="{{asset('pages')}}/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    </script>
    @stack('js')

    <!-- Template Javascript -->
    <script src="{{asset('pages')}}/js/main.js"></script>
</body>

</html>