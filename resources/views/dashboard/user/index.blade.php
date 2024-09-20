@extends('_layouts.app', [
    "title" => "Data Pengguna",
    "is_dashboard" => true
])

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <a href="{{route('admin.pengguna.create')}}" class="btn btn-primary"><i class="las la-plus-circle"></i> Tambah</a>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed table-bordered table-sm" id="users">
                            <thead>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>No Telephone</th>
                                    <th>Kecamatan</th>
                                    <th>Alamat</th>
                                    @if (role("Admin"))
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        class User extends App {
            constructor() {
                super()

                this.users
            }

            get() {
                this.users = $(`table#users`).laravelTable({
                    url: `${ this.baseUrl }/api/user`,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': this.authorization,
                    },
                    columns: [
                        {
                            data: `name`
                        },
                        {
                            data: `username`
                        },
                        {
                            data: `email`
                        },
                        {
                            data: `telp`
                        },
                        {
                            data: null,
                            sort: false,
                            html: e => {
                                return e.district && e.district.name ? e.district.name : '-';
                            }
                        },
                        {
                            data: `alamat`
                        },
                        @if(role("Admin"))
                            {
                                data: null,
                                sort: false,
                                html: e => {
                                    let roles = localStorage.getItem('roles');
                                    return `
                                        <div class="btn-group">
                                            <a href="{{url('dashboard/pengguna/${e.id}/edit')}}" class="btn btn-primary btn-sm btn-icon"><i class="las la-edit"></i></a>
                                            <button class="btn btn-danger btn-sm btn-icon destroy" data-bs-name="${ e.name }" data-bs-id="${ e.id }"><i class="las la-trash"></i></button>
                                        </div>
                                    `
                                }
                            }
                        @endif
                    ]
                })
            }

            _clearForm() {
                $(`form#submit input[type=radio]`).prop(`checked`, false)
                $(`form#submit input[type=text]`).val(``)
                $(`form#submit .error`).html(``)
            }

            submit(e) {
                e.preventDefault()

                let action = $(`div#action [name=action]`).val()
                let id = $(`div#action [name=id]`).val()

                let formData = this.formData(`form#submit`)

                let url = `/api/user/store`

                if (action == `update`) {
                    url = `/api/user/${ id }/update`
                    formData.append(`_method`, `PUT`)
                }

                $(`form#submit input, form#submit button`).prop(`disabled`, true)

                this.api({
                    url: url,
                    method: `POST`,
                    data: formData,
                    success: e => {
                        this.alertSuccess(`Data berhasil disimpan!`)

                        this._clearForm()
                        this.users.fresh()

                        $(`div#action`).modal(`hide`)

                        $(`form#submit input, form#submit button`).prop(`disabled`, false)
                    },
                    error: err => {
                        let error = err.message

                        $(`form#submit .error`).html(``)

                        if (error.constructor === Object) {
                            $.each(error, function (index, value) {
                                $(`form#submit .error#error-${ index }`).html(value)
                            })
                        }

                        $(`form#submit input, form#submit button`).prop(`disabled`, false)
                    }
                })
            }

            show(id) {
                this.api({
                    url: `/api/user/${ id }/show`,
                    success: e => {
                        let data = e.data

                        $(`form#submit [name='role_id'][value='${ data.roles[0].id }']`).prop(`checked`, true)
                        $(`form#submit [name='sites'][value='${ data.sites}']`).prop(`checked`, true)
                        $(`form#submit [name=name]`).val(data.name)
                        $(`form#submit [name=email]`).val(data.email)
                        $(`form#submit [name=username]`).val(data.username)
                        $(`form#submit [name=sites]`).val(data.sites)
                    }
                })
            }

            destroy(id) {
                this.api({
                    url: `/api/user/${ id }/destroy`,
                    method: `DELETE`,
                    success: e => {
                        this.users.fresh()

                        this.alertSuccess(`Data berhasil dihapus!`)
                    }
                })
            }
        }

        var user = new User

        user.get()

        $(document).on(`click`, `[data-bs-dismiss="modal"]`, function() {
            user._clearForm()
        })

        $(document).on(`submit`, `form#submit`, function(e) {
            user.submit(e)
        })

        $(document).on(`click`, `button.destroy`, function() {
            let id = $(this).data(`bs-id`)
            let name = $(this).data(`bs-name`)

            app.alertConfirm({
                title: `Apakah anda yakin?`,
                text: `Ingin menghapus ${ name }.`,
                isConfirmed: e => {
                    user.destroy(id)
                }
            })
        })
    </script>
@endsection
