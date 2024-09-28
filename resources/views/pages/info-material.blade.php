@extends('_layouts.pages', [
    "title" => "Info Material"
])

@section('content')
    <div class="container-fluid page-header mb-5 py-5">
        <div class="container">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Info Material</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Beranda</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Halaman</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Info Material</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="text-uppercase">Info Material</h1>
            </div>
            <div class="my-3">
                <div class="form-group mb-3">
                    <label for="">Pilih Sumber Data</label>
                    <select name="sumbers_id" id="sumbers_id" class="form-control rounded">
                        <option value="">- Pilih -</option>
                        @foreach ($sumberData as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="search" name="search" id="search" class="form-control" placeholder="Cari Material">
                </div>
            </div>
            <hr class="divide">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Material</th>
                                <th>Jenis</th>
                                <th>Sumber</th>
                                <th>Satuan</th>
                                <th>Harga</th>
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

            getMaterial();

            $("#search").keyup(function() {
                let search = $(this).val()

                getMaterial(search)
            })

            $("#sumbers_id").change(function(e) {
                let sumbers_id = $(this).val();

                getMaterial(sumbers_id)
            })

            function getMaterial(search = null, sumbers_id = null) {
                $.ajax({
                    url: "{{url('/api/info-material')}}",
                    method: 'POST',
                    data: { search: search, sumbers_id: sumbers_id },
                    dataType: 'json',
                    success: function(data) {
                        let html = '';
                        let no = 1;
                        if (data.data.length > 0) {
                            $.each(data.data, function(index, value) {
                                html += `<tr>
                                            <td>${no++}</td>
                                            <td>${value.nama}</td>
                                            <td>${value.jenis}</td>
                                            <td>${value.sumber_data.name}</td>
                                            <td>${value.satuan.name}</td>
                                            <td>${value.harga}</td>
                                        </tr>`;
                            })
                        } else {
                            html += `<tr>
                                        <td colspan="6">Tidak Ada Data Peralatan</td>
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