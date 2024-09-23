    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('') }}assets/images/icon-sijakon.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('') }}assets/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('') }}assets/images/icon-sijakon.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('') }}assets/images/logo-light.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('dashboard/master-data*') ? 'active' : '' }}" href="#master_data" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="master_data">
                        <i class="ri-folder-open-line"></i> <span data-key="t-master_datas">Master Data</span>
                    </a>
                    <div class="collapse menu-dropdown" id="master_data">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('admin.pengguna*') ? 'active' : '' }}" href="{{route('admin.pengguna')}}">
                                    <i class="ri-user-5-line"></i> <span data-key="t-users">Data Pengguna</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('admin.tukang*') ? 'active' : '' }}" href="{{route('admin.tukang')}}">
                                    <i class="ri-user-3-line"></i> <span data-key="t-users">Data Tukang</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('admin.bidang*') ? 'active' : '' }}" href="{{route('admin.bidang')}}">
                                    <i class="ri-building-4-line"></i>
                                    <span data-key="t-users">Data Bidang</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('admin.district*') ? 'active' : '' }}" href="{{ route('admin.district') }}">
                                    <i class="ri-map-2-line"></i>
                                    <span data-key="t-users">Data Kecamatan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('admin.sumber-data') ? 'active' : '' }}" href="{{ route('admin.sumber-data') }}">
                                    <i class="ri-file-3-line"></i>
                                    <span data-key="t-users">Sumber Data</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.badan-usaha') ? 'active' : '' }}" href="{{route('admin.badan-usaha')}}">
                        <i class="ri-home-4-line"></i> <span data-key="t-dashboards">Data Badan Usaha</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::routeIs('admin.equipment') ? 'active' : '' }}" href="{{route('admin.equipment')}}">
                        <i class="ri-stack-line"></i> <span data-key="t-dashboards">Data Peralatan</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>