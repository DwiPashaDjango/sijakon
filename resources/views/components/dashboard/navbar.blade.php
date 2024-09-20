<div class="layout-width">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box horizontal-logo d-flex align-items-center">
                <a href="{{ route("dashboard") }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset("") }}assets/images/icon-sijakon.png" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset("") }}assets/images/icon-sijakon.png" alt="" height="50">
                    </span>
                </a>

                <a href="{{ route("dashboard") }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset("") }}assets/images/icon-sijakon.png" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <div class="d-flex">
                            <img src="{{ asset("") }}assets/images/icon-sijakon.png" alt="" height="50">
                            <h4 class="text-white gap-5 mt-3">{!! env("APP_NAME") !!}</h4>
                        </div>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                <span class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
        </div>

        <div class="d-flex align-items-center">

            <div class="ms-1 header-item d-none d-sm-flex">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                    <i class='bx bx-fullscreen fs-22'></i>
                </button>
            </div>

            {{-- <div class="ms-1 header-item d-none d-sm-flex">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                    <i class='bx bx-moon fs-22'></i>
                </button>
            </div> --}}

            <div class="dropdown ms-sm-3 header-item topbar-user" id="show-account">
                <div class="text-white px-3">Memuat data ...</div>
            </div>
        </div>
    </div>
</div>
