@extends('_layouts.app', [
    "title" => "Data Badan Usaha",
    "is_dashboard" => true
])

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#action" data-bs-title="Tambah Badan Usaha" data-bs-action="create" data-bs-id=""><i class="las la-plus-circle"></i> Tambah</button>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed table-bordered table-sm" id="district">
                            <thead>
                                <tr>
                                    <th>Nama Badan Usaha</th>
                                    <th>Alamat Badan Usaha</th>
                                    <th>No Telephone</th>
                                    <th>Email</th>
                                    <th>NIB</th>
                                    <th>Nama PJBU</th>
                                    <th>Jenis Usaha</th>
                                    <th>Kualifikasi</th>
                                    <th>Kode Sublifikasi KBLI</th>
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

    <x-dashboard.modal id="action" class="modal-lg">
        <form id="submit">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Badan Usaha</label>
                        <input type="text" name="name" id="name" class="form-control name" autocomplete="off" placeholder="Nama Badan Usaha">
                        <small class="text-danger error" id="error-name"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="alamat" class="form-label">Alamat Badan Usaha</label>
                        <input type="text" name="alamat" id="alamat" class="form-control alamat" autocomplete="off" placeholder="Alamat Badan Usaha">
                        <small class="text-danger error" id="error-alamat"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control email" autocomplete="off" placeholder="Email Addres">
                        <small class="text-danger error" id="error-email"></small>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="telp" class="form-label">No Telephone</label>
                        <input type="text" name="telp" id="telp" class="form-control telp" autocomplete="off" placeholder="No Telephone">
                        <small class="text-danger error" id="error-telp"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="nib" class="form-label">NIB</label>
                        <input type="text" name="nib" id="nib" class="form-control nib" autocomplete="off" placeholder="NIB">
                        <small class="text-danger error" id="error-nib"></small>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="pjbu" class="form-label">Nama PJBU</label>
                        <input type="text" name="pjbu" id="pjbu" class="form-control pjbu" autocomplete="off" placeholder="Nama PJBU">
                        <small class="text-danger error" id="error-pjbu"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="jenis" class="form-label">Jenis Badan Usaha</label>
                        <textarea name="jenis" id="jenis" cols="30" rows="2" class="form-control jenis"></textarea>
                        <small class="text-danger error" id="error-jenis"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="kualifikasi" class="form-label">Kualifikasi</label>
                        <textarea name="kualifikasi" id="kualifikasi" cols="30" rows="2" class="form-control kualifikasi"></textarea>
                        <small class="text-danger error" id="error-kualifikasi"></small>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="kode_sublifikasi" class="form-label">Kode Sublifikasi</label>
                        <textarea name="kode_sublifikasi" id="kode_sublifikasi" cols="30" rows="2" class="form-control kode_sublifikasi"></textarea>
                        <small class="text-danger error" id="error-kode_sublifikasi"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary ">Simpan</button>
                </div>
            </div>
        </form>
    </x-dashboard.modal>
@endsection

@section('javascript')
    <script type="text/javascript">
        class BadanUsaha extends App {
            constructor() {
                super()

                this.badanUsahas
            }

            get() {
                this.badanUsahas = $(`table#district`).laravelTable({
                    url: `${ this.baseUrl }/api/badan-usaha`,
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
                            data: `alamat`
                        },
                        {
                            data: `telp`
                        },
                        {
                            data: `email`
                        },
                        {
                            data: `nib`
                        },
                        {
                            data: `pjbu`
                        },
                        {
                            data: `jenis`
                        },
                        {
                            data: `kualifikasi`
                        },
                        {
                            data: `kode_sublifikasi`
                        },
                        @if(role("Admin"))
                            {
                                data: null,
                                sort: false,
                                html: e => {
                                    let roles = localStorage.getItem('roles');
                                    return `
                                        <div class="btn-group">
                                            <a class="btn btn-primary btn-sm btn-icon update" href="javascript:;" data-bs-toggle="modal" data-bs-target="#action" data-bs-action="update" data-bs-title="Edit Badan Usaha" data-bs-id="${ e.id }"><i class="ri-edit-2-line"></i></a>
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
                $(`form#submit input`).val(``)
                $(`form#submit .error`).html(``)
            }

            submit(e) {
                e.preventDefault()

                let action = $(`div#action [name=action]`).val()
                let id = $(`div#action [name=id]`).val()

                let formData = this.formData(`form#submit`)

                let url = `/api/badan-usaha/store`

                if (action == `update`) {
                    url = `/api/badan-usaha/${ id }/update`
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
                        this.badanUsahas.fresh()

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
                    url: `/api/badan-usaha/${ id }/show`,
                    success: e => {
                        let data = e.data

                        $(`form#submit [name=id]`).val(data.id)
                        $(`form#submit [name=name]`).val(data.name)
                        $(`form#submit [name=alamat]`).val(data.alamat)
                        $(`form#submit [name=telp]`).val(data.telp)
                        $(`form#submit [name=email]`).val(data.email)
                        $(`form#submit [name=nib]`).val(data.nib)
                        $(`form#submit [name=pjbu]`).val(data.pjbu)
                        $(`form#submit [name=jenis]`).val(data.jenis)
                        $(`form#submit [name=kualifikasi]`).val(data.kualifikasi)
                        $(`form#submit [name=kode_sublifikasi]`).val(data.kode_sublifikasi)
                    }
                })
            }

            destroy(id) {
                this.api({
                    url: `/api/badan-usaha/${ id }/destroy`,
                    method: `DELETE`,
                    success: e => {
                        this.badanUsahas.fresh()

                        this.alertSuccess(`Data berhasil dihapus!`)
                    }
                })
            }
        }

        var badanUsaha = new BadanUsaha

        badanUsaha.get()

        $(document).on(`submit`, `form#submit`, function(e) {
            badanUsaha.submit(e)
        })

        $(document).on(`click`, `.update`, function() {
            let id = $(this).data(`bs-id`)

            badanUsaha.show(id)
        })

        $(document).on(`click`, `button.destroy`, function() {
            let id = $(this).data(`bs-id`)
            let name = $(this).data(`bs-name`)

            app.alertConfirm({
                title: `Apakah anda yakin?`,
                text: `Ingin menghapus ${ name }.`,
                isConfirmed: e => {
                    badanUsaha.destroy(id)
                }
            })
        })
    </script>
@endsection