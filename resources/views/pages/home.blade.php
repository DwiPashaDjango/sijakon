@extends('_layouts.pages', [
    "title" => "Beranda"
])

@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="https://sijakon.batam.go.id/admin/api/banner/14/photo" alt="" style="height: 500px; object-fit: cover;">
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="https://sijakon.batam.go.id/admin/api/banner/19/photo" alt="" style="height: 500px; object-fit: cover;">
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Fact Start -->
    <div class="container-fluid bg-dark my-5 py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 text-center wow fadeIn" data-wow-delay="0.7s">
                    <i class="fa fa-wrench fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                    <p class="text-white mb-0">Jumlah Tenaga Kerja</p>
                </div>
                <div class="col-md-6 col-lg-4 text-center wow fadeIn" data-wow-delay="0.5s">
                    <i class="fa fa-users fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                    <p class="text-white mb-0">Jumlah Badan Usaha</p>
                </div>
                <div class="col-md-6 col-lg-4 text-center wow fadeIn" data-wow-delay="0.3s">
                    <i class="fa fa-users-cog fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                    <p class="text-white mb-0">Jumlah Proyek</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 col-md-6 service-item-top wow fadeInUp" data-wow-delay="0.1s">
                    <div class="overflow-hidden">
                        <img class="img-fluid w-100 h-100" src="https://sijakon.batam.go.id/img/Banner-Sijakon-Tukang.9af527c7.png" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-between bg-light p-4">
                        <h5 class="text-truncate me-3 mb-0">Info Tukang</h5>
                        <a class="btn btn-square btn-outline-primary border-2 border-white flex-shrink-0" href="{{route('info.tukang')}}"><i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 service-item-top wow fadeInUp" data-wow-delay="0.3s">
                    <div class="overflow-hidden">
                        <img class="img-fluid w-100 h-100" src="https://sijakon.batam.go.id/img/Banner-Sijakon-BdanUsaha.f799577e.png" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-between bg-light p-4">
                        <h5 class="text-truncate me-3 mb-0">Info Badan Usaha</h5>
                        <a class="btn btn-square btn-outline-primary border-2 border-white flex-shrink-0" href=""><i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 service-item-top wow fadeInUp" data-wow-delay="0.5s">
                    <div class="overflow-hidden">
                        <img class="img-fluid w-100 h-100" src="https://sijakon.batam.go.id/img/Banner-Sijakon-Peralatan.841a4d06.png" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-between bg-light p-4">
                        <h5 class="text-truncate me-3 mb-0">Info Peralatan</h5>
                        <a class="btn btn-square btn-outline-primary border-2 border-white flex-shrink-0" href=""><i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 service-item-top wow fadeInUp" data-wow-delay="0.5s">
                    <div class="overflow-hidden">
                        <img class="img-fluid w-100 h-100" src="https://sijakon.batam.go.id/img/Banner-Sijakon-Material.63131360.png" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-between bg-light p-4">
                        <h5 class="text-truncate me-3 mb-0">Info Material</h5>
                        <a class="btn btn-square btn-outline-primary border-2 border-white flex-shrink-0" href=""><i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 service-item-top wow fadeInUp" data-wow-delay="0.5s">
                    <div class="overflow-hidden">
                        <img class="img-fluid w-100 h-100" src="https://sijakon.batam.go.id/img/Banner-Sijakon-Proyek-Landscape.17484ce6.png" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-between bg-light p-4">
                        <h5 class="text-truncate me-3 mb-0">Info Proyek</h5>
                        <a class="btn btn-square btn-outline-primary border-2 border-white flex-shrink-0" href=""><i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase">Tentang Kami</h6>
                    <h1 class="mb-4">Kami adalah barisan orang introvert</h1>
                    <p class="mb-4">Apapun kegiatan diluar sana, kami tidak akan minat, karena memang kami adalah orang orang introvert yang malas untuk bergaul dengan orang lain</p>
                    <p class="fw-medium text-primary"><i class="fa fa-check text-success me-3"></i>Tukang Mantab</p>
                    <p class="fw-medium text-primary"><i class="fa fa-check text-success me-3"></i>Jasa Apapun Bagus</p>
                    <p class="fw-medium text-primary"><i class="fa fa-check text-success me-3"></i>Siap Melayani Sepenuh Hati </p>
                    <div class="bg-primary d-flex align-items-center p-4 mt-5">
                        <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 60px; height: 60px;">
                            <i class="fa fa-phone-alt fa-2x text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <p class="fs-5 fw-medium mb-2 text-white">Keadaan darurat</p>
                            <h3 class="m-0 text-secondary">+6281234567890</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pt-4" style="min-height: 500px;">
                    <div class="position-relative h-100 wow fadeInUp" data-wow-delay="0.5s">
                        <img class="position-absolute img-fluid w-100 h-100" src="{{asset('pages')}}/img/about-1.jpg" alt="">
                        {{-- <img class="position-absolute start-0 bottom-0 img-fluid bg-white pt-2 pe-2 w-50 h-50" src="{{asset('pages')}}/img/about-2.jpg" style="object-fit: cover;" alt=""> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
@endsection