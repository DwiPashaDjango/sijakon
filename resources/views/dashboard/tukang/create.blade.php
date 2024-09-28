@extends('_layouts.app', [
    "title" => "Tambah Tukang",
    "is_dashboard" => true
])

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <a href="{{route('admin.pengguna')}}" class="btn btn-primary"><i class="las la-arrow-left"></i> Kembali</a>
        </div>
        <form id="submit">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Data Tukang</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="name" class="form-label">Nama Tukang</label>
                                    <input type="text" name="name" id="name" class="form-control" autocomplete="off" placeholder="Nama Tukang">
                                    <small class="text-danger error" id="error-name"></small>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" autocomplete="off" placeholder="Username">
                                    <small class="text-danger error" id="error-username"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" name="nik" id="nik" class="form-control" autocomplete="off" placeholder="No Induk Kewarganegaraan">
                                    <small class="text-danger error" id="error-nik"></small>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="tmp_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tmp_lahir" id="tmp_lahir" class="form-control" autocomplete="off" placeholder="Tempat Lahir">
                                    <small class="text-danger error" id="error-tmp_lahir"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" autocomplete="off" placeholder="Email">
                                    <small class="text-danger error" id="error-email"></small>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="telp" class="form-label">No Telephone</label>
                                    <input type="text" name="telp" id="telp" class="form-control" autocomplete="off" placeholder="Nomor Telephone">
                                    <small class="text-danger error" id="error-telp"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="picture" class="form-label">Foto</label>
                                    <input type="file" name="picture" id="picture" class="form-control">
                                    <small class="text-danger error" id="error-picture"></small>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="sertifikat" class="form-label">Sertifikat</label>
                                    <input type="text" name="sertifikat" id="sertifikat" class="form-control">
                                    <small class="text-danger error" id="error-sertifikat"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="bidangs_id" class="form-label">Bidang</label>
                                    <select name="bidangs_id" id="bidangs_id" class="form-control">
                                        <option value="">- Pilih -</option>
                                    </select>
                                    <small class="text-danger error" id="error-bidangs_id"></small>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label for="districts_id" class="form-label">Wilayah</label>
                                    <select name="districts_id" id="districts_id" class="form-control">
                                        <option value="">- Pilih -</option>
                                    </select>
                                    <small class="text-danger error" id="error-districts_id"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea name="alamat" id="alamat" cols="30" rows="2" class="form-control" placeholder="Alamat"></textarea>
                                    <small class="text-danger error" id="error-alamat"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" autocomplete="off" placeholder="Password">
                                    <small class="text-danger error" id="error-password"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-end gap-2 p-3">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('javascript')
    <script type="text/javascript">
        class CreateTukang extends App {
            constructor() {
                super()

                this.tukangs
            }

            bidang() {
                this.apiSelect2({
                    element: `form#submit [name=bidangs_id]`,
                    url: `/api/bidang/select2`
                });
            }

            district() {
                this.apiSelect2({
                    element: `form#submit [name=districts_id]`,
                    url: `/api/district/select2`
                });
            }

            _clearForm() {
                $(`form#submit input[type=radio]`).prop(`checked`, false)
                $(`form#submit input[type=text]`).val(``)
                $(`form#submit .error`).html(``)
            }

            submit(e) {
                e.preventDefault()

                let formData = this.formData(`form#submit`)

                let url = `/api/tukang/store`

                $(`form#submit input, form#submit button`).prop(`disabled`, true)

                this.api({
                    url: url,
                    method: `POST`,
                    data: formData,
                    content_type: `multipart/form-data`,
                    success: e => {
                        this.alertSuccess(`Data berhasil disimpan!`)

                        window.location.href = "{{route('admin.tukang')}}"

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
        }

        var tukang = new CreateTukang

        tukang.bidang()
        tukang.district()

        $(document).on(`submit`, `form#submit`, function(e) {
            tukang.submit(e)
        })
    </script>
@endsection
