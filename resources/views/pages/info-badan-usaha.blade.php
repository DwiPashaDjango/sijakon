@extends('_layouts.pages', [
    "title" => "Info Badan Usaha"
])

@section('content')
    <div class="container-fluid page-header mb-5 py-5">
        <div class="container">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Info Badan Usaha</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Beranda</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Halaman</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Info Badan Usaha</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="text-uppercase">Info Badan Usaha</h1>
                <h6 class="text-secondary text-uppercase">Informasi tentang Badan Usaha Jasa Konstruksi</h6>
            </div>
            <div class="my-3">
                <div class="form-group">
                    <input type="search" name="search" id="search" class="form-control" placeholder="Cari Badan Usaha">
                </div>
            </div>
            <hr class="divide">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Badan Usaha</th>
                                <th>Alamat Badan Usaha</th>
                                <th>Nomor Telephone</th>
                                <th>Email</th>
                                <th>NIB</th>
                                <th>Nama PJBU</th>
                                <th>Jenis Usaha</th>
                                <th>Kode Subklasifikasi KBLI</th>
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

            getBadanUsaha();

            $("#search").keyup(function() {
                let search = $(this).val()

                getBadanUsaha(search)
            })

            function getBadanUsaha(search = null) {
                $.ajax({
                    url: "{{url('/api/info-badan-usaha')}}",
                    method: 'POST',
                    data: { search: search },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data.data);
                        let html = '';
                        let no = 1;
                        if (data.data.length > 0) {
                            $.each(data.data, function(index, value) {
                                html += `<tr>
                                            <td>${no++}</td>
                                            <td>${value.name}</td>
                                            <td>${value.alamat}</td>
                                            <td>${value.telp}</td>
                                            <td>${value.email}</td>
                                            <td>${value.nib}</td>
                                            <td>${value.pjbu}</td>
                                            <td>${value.jenis}</td>
                                            <td>${value.kode_sublifikasi}</td>
                                        </tr>`;
                            })
                        } else {
                            html += `<tr>
                                        <td colspan="9">Tidak Ada Data Badan Usaha</td>
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