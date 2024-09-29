<div class="container-fluid nav-bar bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white p-3 py-lg-0 px-lg-4">
        <a href="" class="navbar-brand d-flex align-items-center m-0 p-0 d-lg-none">
            <h1 class="text-primary m-0">SIJAKON</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav me-auto">
                <a href="{{route('home')}}" class="nav-item nav-link {{Request::routeIs('home') ? 'active' : ''}}">Beranda</a>
                <a href="{{route('tentang.kami')}}" class="nav-item nav-link {{Request::routeIs('tentang.kami') ? 'active' : ''}}">Tentang Kami</a>
                <a href="{{route('faq')}}" class="nav-item nav-link {{Request::routeIs('faq') ? 'active' : ''}}">FAQ</a>
                <a href="{{route('user.guide')}}" class="nav-item nav-link {{Request::routeIs('user.guide') ? 'active' : ''}}">User Manual</a>
            </div>
            <div class="mt-4 mt-lg-0 me-lg-n4 py-3 px-4 bg-primary d-flex align-items-center">
                <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white" style="width: 45px; height: 45px;">
                    <a href="{{route('auth.login')}}">
                        <i class="fa fa-sign-in-alt text-primary"></i>
                    </a>
                </div>
                <div class="ms-3">
                    <a href="{{route('auth.login')}}">
                        <h5 class="m-0 text-white">Login</h5>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>