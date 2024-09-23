@extends('_layouts.pages', [
    "title" => "Info Tukang"
])

@section('content')
    <div class="container-fluid page-header mb-5 py-5">
        <div class="container">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Info Tukang</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Beranda</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Halaman</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Info Tukang</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="text-uppercase">Info Tukang</h1>
                <h6 class="text-secondary text-uppercase">Dapatkan Info tentang tukang, Jenis Keahlian dan pemesanan</h6>
            </div>
            <div class="my-3">
                <div class="form-group">
                    <label for="">Pilih Kecamatan</label>
                    <select name="districts_id" id="districts_id" class="form-control rounded">
                        <option value="">- Pilih -</option>
                        @foreach ($districts as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr class="divide">
            <div class="row" id="append">
                
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            getTukang();

            $("#districts_id").change(function(e) {
                e.preventDefault();
                let districts_id = $(this).val()

                getTukang(districts_id)
            })

            function getTukang(districts_id = null) {
                $.ajax({
                    url: "{{url('/api/info-tukang')}}",
                    method: 'POST',
                    data: { districts_id: districts_id },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        let html = '';
                        $.each(data.data, function(index, value) {
                            html += `<div class="col-lg-6 mt-3">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-12 mb-2">
                                                <img src="${value.picture}" 
                                                    class="img-thumbnail" style="width: 200px; height: 200px;">
                                            </div>
                                            <div class="col-lg-8 col-sm-12">
                                                <table border="0" style="width: 100%;">
                                                    <tr class="mt-2" style="line-height: 1.2rem; font-size: 1rem;">
                                                        <td style="width: 25%; vertical-align: top; text-align: left;">
                                                            <b>Nama</b>
                                                        </td>
                                                        <td style="width: 10%; vertical-align: top; text-align: left;">:</td>
                                                        <td style="width: 65%;">${value.name}</td>
                                                    </tr>
                                                    <tr class="mt-2" style="line-height: 1.2rem; font-size: 1rem;">
                                                        <td style="width: 25%; vertical-align: top; text-align: left;">
                                                            <b>Bidang</b>
                                                        </td>
                                                        <td style="width: 10%; vertical-align: top; text-align: left;">:</td>
                                                        <td style="width: 65%;">
                                                            ${value.bidang.name}
                                                        </td>
                                                    </tr>
                                                    <tr class="mt-2" style="line-height: 1.2rem; font-size: 1rem;">
                                                        <td style="width: 25%; vertical-align: top; text-align: left;">
                                                            <b>Wilayah</b>
                                                        </td>
                                                        <td style="width: 10%; vertical-align: top; text-align: left;">:</td>
                                                        <td style="width: 65%;">${value.district.name}</td>
                                                    </tr>
                                                    <tr class="mt-2" style="line-height: 1.2rem; font-size: 1rem;">
                                                        <td style="width: 25%; vertical-align: top; text-align: left;">
                                                            <b>Sertifikat</b>
                                                        </td>
                                                        <td style="width: 10%; vertical-align: top; text-align: left;">:</td>
                                                        <td style="width: 65%;">
                                                            ${value.sertifikat}
                                                        </td>
                                                    </tr>
                                                    <tr class="mt-2" style="line-height: 1.2rem; font-size: 1rem;">
                                                        <td style="width: 25%; vertical-align: top; text-align: left;">
                                                            <b>No Telephone</b>
                                                        </td>
                                                        <td style="width: 10%; vertical-align: top; text-align: left;">:</td>
                                                        <td style="width: 65%;">
                                                                ${value.telp}
                                                        </td>
                                                    </tr>
                                                    <tr class="mt-2" style="line-height: 1.2rem; font-size: 1rem;">
                                                        <td style="width: 25%; vertical-align: top; text-align: left;">
                                                            <b>Email</b>
                                                        </td>
                                                        <td style="width: 10%; vertical-align: top; text-align: left;">:</td>
                                                        <td style="width: 65%;">
                                                            ${value.email}
                                                        </td>
                                                    </tr>
                                                    <tr style="line-height: 1.2rem; font-size: 1rem;">
                                                        <td colspan="3"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>`;
                        })
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