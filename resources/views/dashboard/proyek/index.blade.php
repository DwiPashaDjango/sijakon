@extends('_layouts.app', [
    "title" => "Data Proyek",
    "is_dashboard" => true
])

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#action" data-bs-title="Tambah Data Proyek" data-bs-action="create" data-bs-id=""><i class="las la-plus-circle"></i> Tambah</button>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed table-bordered table-sm" id="proyek">
                            <thead>
                                <tr>
                                    <th>Nama Proyek</th>
                                    <th>Karyawan</th>
                                    <th>Lokasi</th>
                                    <th>Sumber</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
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
                        <label for="sumbers_id" class="form-label">Sumber Proyek</label>
                        <select name="sumbers_id" id="sumbers_id" class="form-control sumbers_id">
                            <option value="">- Pilih -</option>
                        </select>
                        <small class="text-danger error" id="error-sumbers_id"></small>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Proyek</label>
                        <input type="text" name="nama" id="nama" class="form-control nama" autocomplete="off" placeholder="Nama Material">
                        <small class="text-danger error" id="error-nama"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="jml_karyawan" class="form-label">Jumlah Karyawan</label>
                        <input type="text" name="jml_karyawan" id="jml_karyawan" class="form-control jml_karyawan" autocomplete="off" placeholder="Jumlah Karyawan">
                        <small class="text-danger error" id="error-jml_karyawan"></small>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="districts_id" class="form-label">Lokasi</label>
                        <select name="districts_id" id="districts_id" class="form-control districts_id">
                            <option value="">- Pilih -</option>
                        </select>
                        <small class="text-danger error" id="error-districts_id"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="tgl_mulai" class="form-label">Tanggal Mulai Proyek</label>
                        <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control tgl_mulai" autocomplete="off" placeholder="tgl_mulai Material">
                        <small class="text-danger error" id="error-tgl_mulai"></small>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="tgl_selesai" class="form-label">Tanggal Selesai Proyek</label>
                        <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control tgl_selesai" autocomplete="off" placeholder="tgl_selesai Material">
                        <small class="text-danger error" id="error-tgl_selesai"></small>
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
        class Proyek extends App {
            constructor() {
                super()

                this.proyeks
            }
            
            sumberProyek() {
                this.apiSelect2({
                    url: '/api/sumber-proyek/select2',
                    element: `form#submit [name=sumbers_id]`,
                })
            }
            
            district() {
                this.apiSelect2({
                    url: '/api/district/select2',
                    element: `form#submit [name=districts_id]`,
                })
            }

            get() {
                this.proyeks = $(`table#proyek`).laravelTable({
                    url: `${ this.baseUrl }/api/proyek`,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': this.authorization,
                    },
                    columns: [
                        {
                            data: `nama`
                        },
                        {
                            data: `jml_karyawan`
                        },
                        {
                            data: `district.name`
                        },
                        {
                            data: `sumber_proyek.name`
                        },
                        {
                            data: `tgl_mulai`
                        },
                        {
                            data: `tgl_selesai`
                        },
                        @if(role("Admin"))
                            {
                                data: null,
                                sort: false,
                                html: e => {
                                    return `
                                        <div class="btn-group">
                                            <a class="btn btn-primary btn-sm btn-icon update" href="javascript:;" data-bs-toggle="modal" data-bs-target="#action" data-bs-action="update" data-bs-title="Edit Proyek" data-bs-id="${ e.id }"><i class="ri-edit-2-line"></i></a>
                                            <button class="btn btn-danger btn-sm btn-icon destroy" data-bs-name="${ e.nama }" data-bs-id="${ e.id }"><i class="las la-trash"></i></button>
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

                let url = `/api/proyek/store`

                if (action == `update`) {
                    url = `/api/proyek/${ id }/update`
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
                        this.proyeks.fresh()

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
                    url: `/api/proyek/${ id }/show`,
                    success: e => {
                        let data = e.data

                        $(`form#submit [name=nama]`).val(data.nama)
                        $(`form#submit [name=jml_karyawan]`).val(data.jml_karyawan)
                        $(`form#submit [name=tgl_mulai]`).val(data.tgl_mulai)
                        $(`form#submit [name=tgl_selesai]`).val(data.tgl_selesai)
                        $(`form#submit [name='sumbers_id']`).html(`<option value="${ data.sumber_proyek.id }" selected>${ data.sumber_proyek.name }</option>`);
                        $(`form#submit [name='districts_id']`).html(`<option value="${ data.district.id }" selected>${ data.district.name }</option>`);
                    }
                })
            }

            destroy(id) {
                this.api({
                    url: `/api/proyek/${ id }/destroy`,
                    method: `DELETE`,
                    success: e => {
                        this.proyeks.fresh()

                        this.alertSuccess(`Data berhasil dihapus!`)
                    }
                })
            }
        }

        var proyek = new Proyek

        proyek.get()
        proyek.sumberProyek()
        proyek.district()

        $(document).on(`submit`, `form#submit`, function(e) {
            proyek.submit(e)
        })

        $(document).on(`click`, `.update`, function() {
            let id = $(this).data(`bs-id`)

            proyek.show(id)
        })

        $(document).on(`click`, `button.destroy`, function() {
            let id = $(this).data(`bs-id`)
            let name = $(this).data(`bs-name`)

            app.alertConfirm({
                title: `Apakah anda yakin?`,
                text: `Ingin menghapus ${ name }.`,
                isConfirmed: e => {
                    proyek.destroy(id)
                }
            })
        })
    </script>
@endsection