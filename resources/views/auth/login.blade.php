@extends('_layouts.app', [
    "title" => "Login",
    "is_dashboard" => false
])

@push('css')
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <img src="{{asset('assets/images/icon-sijakon.png')}}" width="100" alt="" class="mb-3">
                        <h4 class="mb-4">{!! env("APP_NAME") !!}</h4>  
                        <h5 class="text-muted">Sistem Informasi Jasa Konstruksi.</h5>
                        <hr class="divide">
                    </div>
                    <div class="p-2 mt-4">
                        <form id="submit">

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" autofocus autocomplete="off" name="email" placeholder="Email Addres">
                                <small class="text-danger error" id="error-email"></small>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <label class="form-label" for="password-input">Password</label>
                                    </div>
                                </div>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5 password-input" name="password" placeholder="Enter password" id="password-input">
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                    <small class="text-danger error" id="error-password"></small>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection

@section('javascript')
    <script type="text/javascript">
        class Auth extends App {
            constructor() {
                super()
            }

            submit(e) {
                e.preventDefault()

                let formData = this.formData(`form#submit`)

                $(`form#submit .error`).html(``)

                this.api({
                    url: `/login-cek`,
                    method: `POST`,
                    data: formData,
                    success: e => {
                        console.log(e);
                        if (e.status == false) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning !',
                                text: e.message
                            })
                        } else {
                            window.location=`{{ route("dashboard") }}`
                        }
                    },
                    error: err => {
                        let error = err.message

                        $.each(error, function (index, value) {
                            $(`form#submit .error#error-${ index }`).html(value)
                        })

                        $(`form#submit input, form#submit button`).prop(`disabled`, false)
                    }
                })
            }
        }

        var auth = new Auth

        @if (Session::get("error"))
            auth.alertWarning(`{{ Session::get("error") }}`)
        @endif

        $(document).on(`submit`, `form#submit`, function(e) {
            auth.submit(e)
        })
    </script>
@endsection
