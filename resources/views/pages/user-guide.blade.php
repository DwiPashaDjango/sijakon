@extends('_layouts.pages', [
    "title" => "User Manual"
])

@section('content')
    <div class="container-fluid page-header mb-5 py-5">
        <div class="container">
            <h1 class="display-3 text-white mb-3 animated slideInDown">User Manual</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Beranda</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Halaman</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">User Manual</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp mb-3" data-wow-delay="0.1s">
                <h1 class="text-uppercase mb-3">User Manual</h1>
            </div>
            
            <div class="mt-3">
                <embed src="{{asset('user-guide.pdf')}}" style="width: 100%; height: 800px" type="">
            </div>
        </div>
    </div>
@endsection

@push('js')
    
@endpush