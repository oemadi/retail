@extends('layouts.template')
@section('page','Rekap Barang')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-body">
                <div class="row">

                        <div class="col-md-12">
                            <div class=" box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="id_kategori" id="id_kategori" class="form-control select2-kategori" style="width: 100%;height:auto">
                                                        <option value="all">Semua</option>
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <select name="id_barang" id="id_barang" class="form-control select2-barang" style="width: 100%;height:auto">
                                                        <option value="all">Semua</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary print"><i class="fa fa-print"></i> Print</button>

                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>

                </div>
            </div>

@endsection

@push('script')
<script>
    $(document).ready(function(){
        $(".select2-kategori").select2({
        ajax: {
        url: "{{ route('getDataKategoriSelect2') }}",
        contentType: 'application/json',
        dataType: 'json',
        delay:50,
        type:"get",
        data: function(params) {
            return {
            search: params.term,_token: '{{csrf_token()}}'
            };
        },
        processResults: function(data) {
            return {
            results: data
            };
        },
        cache: true
        },
        placeholder:"Nama Kategori",
        });

        $(".select2-barang").select2({
        ajax: {
        url: "{{ route('getDataBarang') }}",
        contentType: 'application/json',
        dataType: 'json',
        delay:50,
        type:"get",
        data: function(params) {
            return {
            search: params.term,_token: '{{csrf_token()}}'
            };
        },
        processResults: function(data) {
            return {
            results: data
            };
        },
        cache: true
        },
        placeholder:"Nama Barang",
        });

        $('.print').click(function(){
            id_kategori = $('#id_kategori').val();
            id_barang = $('#id_barang').val();
            let url =
            `{{ url('report/barang/print?id_kategori=`+id_kategori+`&id_barang=`+id_barang+`') }}`;
            const parseResult = new DOMParser().parseFromString(url, "text/html");
            const parsedUrl = parseResult.documentElement.textContent;
            window.open(parsedUrl,'_blank');
        });

    });
</script>
@endpush
