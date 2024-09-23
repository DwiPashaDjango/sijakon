@extends('_layouts.app', [
    "title" => "Data Peralatan",
    "is_dashboard" => true
])

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#action" data-bs-title="Tambah Data Peralatan" data-bs-action="create" data-bs-id=""><i class="las la-plus-circle"></i> Tambah</button>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed table-bordered table-sm" id="equipment">
                            <thead>
                                <tr>
                                    <th>Nama Peralatan</th>
                                    <th>Jenis</th>
                                    <th>Sumber</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
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
                        <label for="sumbers_id" class="form-label">Sumber Data</label>
                        <select name="sumbers_id" id="sumbers_id" class="form-control sumbers_id">
                            <option value="">- Pilih -</option>
                        </select>
                        <small class="text-danger error" id="error-sumbers_id"></small>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Peralatan</label>
                        <input type="text" name="nama" id="nama" class="form-control nama" autocomplete="off" placeholder="Nama Peralatan">
                        <small class="text-danger error" id="error-nama"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="jenis" class="form-label">Jenis</label>
                        <input type="text" name="jenis" id="jenis" class="form-control jenis" autocomplete="off" placeholder="Jenis Peralatan">
                        <small class="text-danger error" id="error-jenis"></small>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="satuans_id" class="form-label">Satuan</label>
                        <select name="satuans_id" id="satuans_id" class="form-control satuans_id">
                            <option value="">- Pilih -</option>
                        </select>
                        <small class="text-danger error" id="error-satuans_id"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="harga" class="form-label">Harga Peralatan</label>
                        <input type="text" name="harga" id="harga" class="form-control harga" autocomplete="off" placeholder="Harga Peralatan">
                        <small class="text-danger error" id="error-harga"></small>
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
        class Equipment extends App {
            constructor() {
                super()

                this.equipments
            }
            
            sumberData() {
                this.apiSelect2({
                    url: '/api/sumber-data/select2',
                    element: `form#submit [name=sumbers_id]`,
                })
            }
            
            satuans() {
                this.apiSelect2({
                    url: '/api/satuan/select2',
                    element: `form#submit [name=satuans_id]`,
                })
            }

            get() {
                this.equipments = $(`table#equipment`).laravelTable({
                    url: `${ this.baseUrl }/api/equipment`,
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
                            data: `jenis`
                        },
                        {
                            data: `sumber_data.name`
                        },
                        {
                            data: `satuan.name`
                        },
                        {
                            data: `harga`
                        },
                        @if(role("Admin"))
                            {
                                data: null,
                                sort: false,
                                html: e => {
                                    return `
                                        <div class="btn-group">
                                            <a class="btn btn-primary btn-sm btn-icon update" href="javascript:;" data-bs-toggle="modal" data-bs-target="#action" data-bs-action="update" data-bs-title="Edit Peralatan" data-bs-id="${ e.id }"><i class="ri-edit-2-line"></i></a>
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

                let url = `/api/equipment/store`

                if (action == `update`) {
                    url = `/api/equipment/${ id }/update`
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
                        this.equipments.fresh()

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
                    url: `/api/equipment/${ id }/show`,
                    success: e => {
                        let data = e.data

                        $(`form#submit [name=nama]`).val(data.nama)
                        $(`form#submit [name=jenis]`).val(data.jenis)
                        $(`form#submit [name=harga]`).val(data.harga)
                        $(`form#submit [name='sumbers_id']`).html(`<option value="${ data.sumber_data.id }" selected>${ data.sumber_data.name }</option>`);
                        $(`form#submit [name='satuans_id']`).html(`<option value="${ data.satuan.id }" selected>${ data.satuan.name }</option>`);
                    }
                })
            }

            destroy(id) {
                this.api({
                    url: `/api/equipment/${ id }/destroy`,
                    method: `DELETE`,
                    success: e => {
                        this.equipments.fresh()

                        this.alertSuccess(`Data berhasil dihapus!`)
                    }
                })
            }
        }

        var equipment = new Equipment

        equipment.get()
        equipment.sumberData()
        equipment.satuans()

        $(document).on(`submit`, `form#submit`, function(e) {
            equipment.submit(e)
        })

        $(document).on(`click`, `.update`, function() {
            let id = $(this).data(`bs-id`)

            equipment.show(id)
        })

        $(document).on(`click`, `button.destroy`, function() {
            let id = $(this).data(`bs-id`)
            let name = $(this).data(`bs-name`)

            app.alertConfirm({
                title: `Apakah anda yakin?`,
                text: `Ingin menghapus ${ name }.`,
                isConfirmed: e => {
                    equipment.destroy(id)
                }
            })
        })
    </script>
@endsection