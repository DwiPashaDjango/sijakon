@extends('_layouts.pages', [
    "title" => "Info Proyek"
])

@section('content')
    <div class="container-fluid page-header mb-5 py-5">
        <div class="container">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Info Proyek</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Beranda</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Halaman</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Info Proyek</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="text-uppercase">Info Proyek</h1>
            </div>
            <div class="my-3">
                <div class="form-group">
                    <input type="search" name="search" id="search" class="form-control" placeholder="Cari Proyek">
                </div>
                <div class="row mt-3">
                    <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <label for="">Pilih Sumber Proyek</label>
                            <select name="sumbers_id" id="sumbers_id" class="form-control rounded">
                                <option value="">- Pilih -</option>
                                @foreach ($sumberProyek as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group mb-3">
                            <label for="">Pilih Tahun Proyek</label>
                            <select name="years" id="years" class="form-control rounded">
                                <option value="">- Pilih -</option>
                                @php
                                    $currentYear = date('Y');
                                @endphp
                                @for ($i = 0; $i < 5; $i++)
                                    <option value="{{ $currentYear - $i }}">{{ $currentYear - $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h4 class="text-center mt-3">Sumber Dana <strong id="jenis_proyek"></strong></h4>
                        <h4 class="text-center" id="count_proyek"></h4>
                    </div>
                </div>
            </div>
            <hr class="divide">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Proyek</th>
                                <th class="text-center">Karyawan</th>
                                <th class="text-center">Lokasi</th>
                                <th class="text-center">Sumber</th>
                                <th class="text-center">Tgl Mulai</th>
                                <th class="text-center">Tgl Selesai</th>
                            </tr>
                        </thead>
                        <tbody id="append">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            let search = null;
            let sumbers_id = null;
            let years = null;

            getProyek();

            $("#jenis_proyek").html('Semua Proyek')

            $("#search").keyup(function() {
                let search = $(this).val()

                getProyek(search, sumbers_id, years);
            })

            $("#sumbers_id").change(function(e) {
                let sumbers_id = $(this).val();

                getProyek(search, sumbers_id, years);

                let sumber_name = $("#sumbers_id option:selected").text();

                if (sumbers_id === '') {
                    $("#jenis_proyek").html('Semua Proyek')
                } else {
                    $("#jenis_proyek").html(sumber_name)
                }
            })

            $("#years").change(function(e) {
                let years = $(this).val();
                getProyek(search, sumbers_id, years);
            })

            function getProyek(search = null, sumbers_id = null, years = null) {
                $.ajax({
                    url: "{{url('/api/info-proyek')}}",
                    method: 'POST',
                    data: { search: search, sumbers_id: sumbers_id, years: years },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);

                        $("#count_proyek").html(`(${data.count_proyek})`)
                        
                        let html = '';
                        let no = 1;
                        if (data.data.length > 0) {
                            $.each(data.data, function(index, value) {
                                html += `<tr>
                                            <td class="text-center">${no++}</td>
                                            <td>${value.nama}</td>
                                            <td class="text-center">${value.jml_karyawan}</td>
                                            <td class="text-center">${value.district.name}</td>
                                            <td class="text-center">${value.sumber_proyek.name}</td>
                                            <td class="text-center">${value.tgl_mulai}</td>
                                            <td class="text-center">${value.tgl_selesai}</td>
                                        </tr>`;
                            })
                        } else {
                            html += `<tr>
                                        <td colspan="7" class="text-center">Tidak Ada Data Proyek</td>
                                    </tr>`;
                        }
                        $("#append").html(html)
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            }
        });
    </script>
@endpush