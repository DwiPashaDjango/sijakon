
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-bs-theme="light" data-layout-width="fluid" data-layout-position="fixed" data-layout-style="default" data-sidebar-visibility="show">
<head>

    <meta charset="utf-8" />
    <title>{{ $title }} | {!! env("APP_NAME") !!}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Aplikasi manajemen sparepart." name="description" />
    <meta content="{{ env("APP_COPYRIGHT") }}" name="author" />
    <meta content="{{ env("APP_URL") }}" name="baseUrl">
    <meta content="Bearer {{ Session::get("authorization") }}" name="authorization">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset("") }}assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="{{ asset("") }}assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset("") }}assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset("") }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset("") }}assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset("") }}assets/css/custom.min.css" rel="stylesheet" type="text/css" />

    <!-- Sweet Alert css-->
    <link href="{{ asset("") }}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset("") }}assets/libs/laravel_table/css/laravel_table.bootstrap-5.2.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> --}}
    @yield('css')

</head>

<body>

    @if ($is_dashboard)
        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <x-dashboard.navbar />
            </header>

            <!-- ========== App Menu ========== -->
            <div class="app-menu navbar-menu">
                <x-dashboard.sidebar />
            </div>
            <!-- Left Sidebar End -->
            <!-- Vertical Overlay-->
            <div class="vertical-overlay"></div>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">{{ $title }}</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">{{ $title }}</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        @yield('content')

                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © {!! env("APP_NAME") !!}.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by {{ env("APP_COPYRIGHT") }}
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->

        <x-dashboard.modal id="profile" class="">
            <form id="update-profile">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label for="picture" class="form-label">Foto</label>
                            <input type="file" name="picture" id="picture" class="form-control picture">
                            <small class="text-danger error" id="error-picture"></small>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label for="name" class="form-lab">Nama</label>
                            <input type="text" name="name" id="name" class="form-control name" autocomplete="off" placeholder="Nama">
                            <small class="text-danger error" id="error-na"></small>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control email" autocomplete="off" placeholder="Email">
                            <small class="text-danger error" id="error"></small>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-gro">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control password" autocomplete="off" placeholder="Password">
                            <small class="text-danger error" id="error-password"></small>
                        </div>
                    </div>
                    <div class="col-lg-12 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary ">Simpan</button>
                    </div>
                </div>
            </form>
        </x-dashboard.modal>
    @else
        <div class="auth-page-wrapper pt-5">
            <!-- auth page content -->
            <div class="auth-page-content">
                <div class="container">
                    @yield('content')
                </div>
                <!-- end container -->
            </div>
            <!-- end auth page content -->

            <!-- footer -->
            <footer class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <p class="mb-0 text-muted">&copy;
                                    <script>document.write(new Date().getFullYear())</script> {{ env("APP_COPYRIGHT") }}. Crafted with <i class="mdi mdi-heart text-danger"></i> by {!! env("APP_NAME") !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        </div>
        <!-- end auth-page-wrapper -->
    @endif

    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="{{ asset("") }}assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset("") }}assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset("") }}assets/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset("") }}assets/libs/feather-icons/feather.min.js"></script>
    <script src="{{ asset("") }}assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{{ asset("") }}assets/js/plugins.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- apexcharts -->
    <script src="{{ asset("") }}assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- password-addon init -->
    <script src="{{ asset("") }}assets/js/pages/password-addon.init.js"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset("") }}assets/libs/sweetalert2/sweetalert2.min.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> --}}

    <!-- App js -->
    <script src="{{ asset("") }}assets/js/app.js"></script>

    <script src="{{ asset("") }}assets/libs/laravel_table/js/laravel_table.js"></script>

    <script src="{{ asset("") }}assets/js/main.js"></script>

    @if ($is_dashboard)
        <script type="text/javascript">
            class Main extends App {
                constructor() {
                    super()
                }

                show() {
                    this.api({
                        url: `/api/auth/show-account`,
                        success: e => {
                            let data = e.data
                            localStorage.setItem('roles', data.roles[0].name);
                            $(`#show-account`).html(`
                                <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="d-flex align-items-center">
                                        <img class="rounded-circle header-profile-user" src="${ data.picture }" alt="${ data.name } avatar">
                                        <span class="text-start ms-xl-2">
                                            <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">${ data.name }</span>
                                            <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">${ data.roles[0].name }</span>
                                        </span>
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <h6 class="dropdown-header">Selamat datang ${ data.name }!</h6>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#profile" data-bs-title="Pengaturan Profil" data-bs-id="" data-bs-action="update"><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Pengaturan Profil</span></a>
                                    <a class="dropdown-item" id="logout" href="javascript:;"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                                </div>
                            `)

                            $(`form#update-profile [name=name]`).val(data.name)
                            $(`form#update-profile [name=email]`).val(data.email)
                            $("#users_id").val(data.id)
                            $("#users_daily").val(data.name)
                        }
                    })
                }

                _clearForm() {
                    $(`form#update-profile input`).val(``)
                    $(`form#update-profile .error`).html(``)
                }

                updateProfile(e) {
                    e.preventDefault()

                    let formData = this.formData(`form#update-profile`)
                    formData.append(`_method`, `PUT`)

                    $(`form#update-profile .error`).html(``)

                    $(`form#update-profile input, form#update-profile button`).prop(`disabled`, true)

                    this.api({
                        url: `/api/update-profile`,
                        method: `POST`,
                        data: formData,
                        content_type: `multipart/form-data`,
                        success: e => {
                            this.alertSuccess(`Data berhasil disimpan!`)

                            main._clearForm()
                            main.show()

                            $(`div#profile`).modal(`hide`)

                            $(`form#update-profile input, form#update-profile button`).prop(`disabled`, false)
                        },
                        error: err => {
                            let error = err.message

                            $.each(error, function (index, value) {
                                $(`form#update-profile .error#error-${ index }`).html(value)
                            })

                            $(`form#update-profile input, form#update-profile button`).prop(`disabled`, false)
                        }
                    })
                }

                logout() {
                    this.api({
                        url: `/logout`,
                        method: `POST`,
                        success: e => {
                            localStorage.removeItem('roles')
                            window.location=`{{ route("auth.login") }}`
                        }
                    })
                }
            }

            var main = new Main

            main.show()

            $(document).on(`click`, `[data-bs-toggle=modal]`, function() {
                let target = $(this).data(`bs-target`)
                let title = $(this).data(`bs-title`)
                let action = $(this).data(`bs-action`)
                let id = $(this).data(`bs-id`)

                $(`.modal${ target } .modal-title`).html(title)
                $(`.modal${ target } input[name=action]`).val(action)
                $(`.modal${ target } input[name=id]`).val(id)
            })

            $(document).on(`click`, `#logout`, function() {
                main.logout()
            })

            $(document).on(`submit`, `form#update-profile`, function(e) {
                main.updateProfile(e)
            })

            $(document).on(`click`, `.modal#profile [data-bs-dismiss=modal]`, function() {
                main._clearForm()
            })
        </script>
    @endif

    @yield('javascript')
</body>
</html>
