@extends('_layouts.pages', [
    "title" => "Tentang Kami"
])

@section('content')
    <div class="container-fluid page-header mb-5 py-5">
        <div class="container">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Tentang Kami</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Beranda</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Halaman</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Tentang Kami</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
             <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase">Tentang Kami</h6>
                    <h1 class="mb-2">AZRIL APRIANSYAH, ST, MT</h1>
                    <h4 class="mb-5">Kepala Dinas Cipta Karya dan Tata Ruang Kota Batam</h4>
                    <p class="mb-4">
                        " 
                        Kehadiran SIJAKON akan menjawab keinginan masyarakat terhadap kebutuhan akan Jasa Konstruksi yang tersertifikasi dan terpercaya <br> <br>
                        Hadirnya SIJAKON di tengah masyarakat kini yang menghadapi ketidakpastian ditengah situasi pandemi ini diharapkan dapat menjadikan solusi jitu bagi permasalahan-permasalahan yang ada khususnya terkait konstruksi bangunan, baik itu skala perumahan maupun bangunan besar. <br> <br>
                        Sulitnya mencari tukang yang dapat dipercaya dan bekerja sesuai dengan tanggung jawabnya menjadi latar belakang permasalahan yang perlu dicarikan solusinya. Untuk menjawab itu semua, maka kami Dinas Cipta Karya dan Tata Ruang Pemerintah Kota Batam yang berlokasi di sekupang Kota Batam ini menghadirkan SIJAKON tentunya untuk mengatasi persoalan-persoalan yang ada.
                        "
                    </p>
                </div>
                <div class="col-lg-6 pt-4" style="min-height: 600px;">
                    <div class="position-relative h-100 wow fadeInUp" data-wow-delay="0.5s">
                        <img class="position-absolute img-fluid" style="width: 100%; height: 600px" src="https://sijakon.batam.go.id/admin/api/kadis/9/photo" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    
@endpush