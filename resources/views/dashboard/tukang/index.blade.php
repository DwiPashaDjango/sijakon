@extends('_layouts.app', [
    "title" => "Data Tukang",
    "is_dashboard" => true
])

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <a href="{{route('admin.tukang.create')}}" class="btn btn-primary"><i class="las la-plus-circle"></i> Tambah</a>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed table-bordered table-sm" id="users">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>No Telephone</th>
                                    <th>Bidang</th>
                                    <th>Wilayah</th>
                                    <th>Sertifikat</th>
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
        class Tukang extends App {
            constructor() {
                super()

                this.tukangs
            }

            get() {
                this.tukangs = $(`table#users`).laravelTable({
                    url: `${ this.baseUrl }/api/tukang`,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': this.authorization,
                    },
                    columns: [
                        {
                            data: null,
                            sort: false,
                            html: e => {
                                return `
                                    <img src="${e.picture}" width="60" class="img-thumbnail" alt="">
                                `
                            }
                        },
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
                                return e.bidang && e.bidang.name ? e.bidang.name : '-';
                            },
                        },
                        {
                            data: null,
                            sort: false,
                            html: e => {
                                return e.district && e.district.name ? e.district.name : '-';
                            }
                        },
                        {
                            data: `sertifikat`
                        },
                        @if(role("Admin"))
                            {
                                data: null,
                                sort: false,
                                html: e => {
                                    let roles = localStorage.getItem('roles');
                                    return `
                                        <div class="btn-group">
                                            <a href="{{url('dashboard/tukang/${e.id}/edit')}}" class="btn btn-primary btn-sm btn-icon"><i class="las la-edit"></i></a>
                                            <button class="btn btn-danger btn-sm btn-icon destroy" data-bs-name="${ e.name }" data-bs-id="${ e.id }"><i class="las la-trash"></i></button>
                                        </div>
                                    `
                                }
                            }
                        @endif
                    ]
                })
            }

            destroy(id) {
                this.api({
                    url: `/api/tukang/${ id }/destroy`,
                    method: `DELETE`,
                    success: e => {
                        this.tukangs.fresh()

                        this.alertSuccess(`Data berhasil dihapus!`)
                    }
                })
            }
        }

        var tukang = new Tukang

        tukang.get()

        $(document).on(`click`, `button.destroy`, function() {
            let id = $(this).data(`bs-id`)
            let name = $(this).data(`bs-name`)

            app.alertConfirm({
                title: `Apakah anda yakin?`,
                text: `Ingin menghapus ${ name }.`,
                isConfirmed: e => {
                    tukang.destroy(id)
                }
            })
        })
    </script>
@endsection
