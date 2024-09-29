@extends('_layouts.pages', [
    "title" => "Beranda"
])

@push('css')
    <style>
    </style>
@endpush    

@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div class="owl-carousel header-carousel">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="https://sijakon.batam.go.id/admin/api/banner/14/photo" alt="" style="height: 500px;">
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="https://sijakon.batam.go.id/admin/api/banner/19/photo" alt="" style="height: 500px;">
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
                        <a class="btn btn-square btn-outline-primary border-2 border-white flex-shrink-0" href="{{route('info.badan.usaha')}}"><i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 service-item-top wow fadeInUp" data-wow-delay="0.5s">
                    <div class="overflow-hidden">
                        <img class="img-fluid w-100 h-100" src="https://sijakon.batam.go.id/img/Banner-Sijakon-Peralatan.841a4d06.png" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-between bg-light p-4">
                        <h5 class="text-truncate me-3 mb-0">Info Peralatan</h5>
                        <a class="btn btn-square btn-outline-primary border-2 border-white flex-shrink-0" href="{{route('info.peralatan')}}"><i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 service-item-top wow fadeInUp" data-wow-delay="0.5s">
                    <div class="overflow-hidden">
                        <img class="img-fluid w-100 h-100" src="https://sijakon.batam.go.id/img/Banner-Sijakon-Material.63131360.png" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-between bg-light p-4">
                        <h5 class="text-truncate me-3 mb-0">Info Material</h5>
                        <a class="btn btn-square btn-outline-primary border-2 border-white flex-shrink-0" href="{{route('info.material')}}"><i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 service-item-top wow fadeInUp" data-wow-delay="0.5s">
                    <div class="overflow-hidden">
                        <img class="img-fluid w-100 h-100" src="https://sijakon.batam.go.id/img/Banner-Sijakon-Proyek-Landscape.17484ce6.png" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-between bg-light p-4">
                        <h5 class="text-truncate me-3 mb-0">Info Proyek</h5>
                        <a class="btn btn-square btn-outline-primary border-2 border-white flex-shrink-0" href="{{route('info.proyek')}}"><i class="fa fa-arrow-right"></i></a>
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
                    <h1 class="mb-2">AZRIL APRIANSYAH, ST, MT</h1>
                    <h4 class="mb-5">Kepala Dinas Cipta Karya dan Tata Ruang Kota Batam</h4>
                    <p class="mb-4" style="word-break: break-all">
                        " 
                        Kehadiran SIJAKON akan menjawab keinginan masyarakat terhadap kebutuhan akan Jasa Konstruksi yang tersertifikasi dan terpercaya <br>
                        Hadirnya SIJAKON di tengah masyarakat kini yang menghadapi ketidakpastian ditengah situasi pandemi ini diharapkan dapat menjadikan solusi jitu bagi permasalahan-permasalahan yang ada khususnya terkait konstruksi bangunan, baik itu skala perumahan maupun bangunan besar. <br>
                        Sulitnya mencari tukang yang dapat dipercaya dan bekerja sesuai dengan tanggung jawabnya menjadi latar belakang permasalahan yang perlu dicarikan solusinya. Untuk menjawab itu semua, maka kami Dinas Cipta Karya dan Tata Ruang Pemerintah Kota Batam yang berlokasi di sekupang Kota Batam ini menghadirkan SIJAKON tentunya untuk mengatasi persoalan-persoalan yang ada.
                        "
                    </p>
                </div>
                <div class="col-lg-6 pt-4" style="min-height: 500px;">
                    <div class="position-relative h-100 wow fadeInUp" data-wow-delay="0.5s">
                        <img class="position-absolute img-fluid" style="width: 100%; height: 500px" src="https://sijakon.batam.go.id/admin/api/kadis/9/photo" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <h1 class="mb-2">POPULASI TENAGA KERJA KONSTRUKSI</h1>
            <h4 class="mb-4">Data pertumbuhan Tenaga Kerja Konstruksi di Kota Batam</h4>
            <div class="my-3">
                 <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    <!-- About End -->
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var districtNames = {!! json_encode($districts->pluck('name')) !!};
        var tukangCounts = {!! json_encode($districts->pluck('tukang_count')) !!};

        var ctx = document.getElementById('myChart').getContext('2d');
        var districtTukangChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: districtNames,
                datasets: [{
                    label: 'Jumlah Tenaga Kerja Per Kecamatan',
                    data: tukangCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>

@endpush