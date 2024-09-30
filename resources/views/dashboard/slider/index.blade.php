@extends('_layouts.app', [
    "title" => "Data Slider",
    "is_dashboard" => true
])

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#action" data-bs-title="Tambah Slider" data-bs-action="create" data-bs-id=""><i class="las la-plus-circle"></i> Tambah</button>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed table-bordered table-sm" id="district">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
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

    <x-dashboard.modal id="action" class="modal-sm">
        <form id="submit">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="image" class="form-label">Gambar</label>
                        <input type="file" name="image" id="image" class="form-control image" autocomplete="off">
                        <small class="text-danger error" id="error-image"></small>
                    </div>
                </div>
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
        class Slider extends App {
            constructor() {
                super()

                this.sliders
            }

            get() {
                this.sliders = $(`table#district`).laravelTable({
                    url: `${ this.baseUrl }/api/sliders`,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': this.authorization,
                    },
                    columns: [
                        {
                            data: null,
                            sort: null,
                            html: e => {
                                return `<img src="{{asset('${e.image}')}}" width="100" class="img-thumbnail" alt="">`
                            }
                        },
                        @if(role("Admin"))
                            {
                                data: null,
                                sort: false,
                                html: e => {
                                    let roles = localStorage.getItem('roles');
                                    return `
                                        <div class="btn-group">
                                            <a class="btn btn-primary btn-sm btn-icon update" href="javascript:;" data-bs-toggle="modal" data-bs-target="#action" data-bs-action="update" data-bs-title="Edit Slider" data-bs-id="${ e.id }"><i class="ri-edit-2-line"></i></a>
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

                let url = `/api/sliders/store`

                if (action == `update`) {
                    url = `/api/sliders/${ id }/update`
                    formData.append(`_method`, `PUT`)
                }

                $(`form#submit input, form#submit button`).prop(`disabled`, true)

                this.api({
                    url: url,
                    method: `POST`,
                    data: formData,
                    content_type: `multipart/form-data`,
                    success: e => {
                        this.alertSuccess(`Data berhasil disimpan!`)

                        this._clearForm()
                        this.sliders.fresh()

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
                    url: `/api/sliders/${ id }/show`,
                    success: e => {
                        let data = e.data
                    }
                })
            }

            destroy(id) {
                this.api({
                    url: `/api/sliders/${ id }/destroy`,
                    method: `DELETE`,
                    success: e => {
                        this.sliders.fresh()

                        this.alertSuccess(`Data berhasil dihapus!`)
                    }
                })
            }
        }

        var slider = new Slider

        slider.get()

        $(document).on(`submit`, `form#submit`, function(e) {
            slider.submit(e)
        })

        $(document).on(`click`, `.update`, function() {
            let id = $(this).data(`bs-id`)

            slider.show(id)
        })

        $(document).on(`click`, `button.destroy`, function() {
            let id = $(this).data(`bs-id`)
            let name = $(this).data(`bs-name`)

            app.alertConfirm({
                title: `Apakah anda yakin?`,
                text: `Ingin menghapus data ini?.`,
                isConfirmed: e => {
                    slider.destroy(id)
                }
            })
        })
    </script>
@endsection