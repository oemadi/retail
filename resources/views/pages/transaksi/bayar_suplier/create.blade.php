@extends('layouts.template')
@section('page','Input Bayar Suplier')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Faktur">Faktur Bayar</label>
                                            <input type="text" name="faktur" class="form-control" id="faktur" readonly
                                                style="cursor:no-drop" value="{{ $faktur }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal Bayar</label>
                                            <input type="text" name="tanggal" class="form-control" id="tanggal" readonly
                                                style="cursor:no-drop" value="{{ date('Y-m-d') }}">
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pengguna">Nama Pengguna</label>
                                            <input type="text" name="pengguna" class="form-control" id="pengguna"
                                                readonly style="cursor:no-drop" value="{{ Auth::user()->nama }}">
                                        </div>

                                    </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="suplier">suplier</label>
                                            <input type="hidden" name="id_suplier" id="id_suplier" class="form-control" value="{{$data->suplier_id}}" readonly>
                                            <input type="text" name="nama_suplier" id="nama_suplier" class="form-control" value="{{$data->suplier}}" readonly>

                                    </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="faktur_pembelian">No.Faktur Pembelian</label>
                                            <input type="text" name="faktur_pembelian_label" id="faktur_pembelian_label"  value="{{$data->faktur_pembelian}}" class="form-control" readonly >
                                            <input type="hidden" name="faktur_pembelian" id="faktur_pembelian"  value="{{$data->pembelian_id}}" class="form-control" >
                                    </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gaji">Total Hutang</label>
                                            <input type="text" name="total_hutang" id="total_hutang"  value="{{$data->sisa_hutang}}" class="form-control" readonly>
                                        </div>

                                    </div>
                                </div>
                    </div>
                    <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bayar_sekarang">Bayar Sekarang</label>
                                            <input type="text" name="bayar_sekarang" id="bayar_sekarang"
                                                class="form-control" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                                <label for="sisa_hutang">Sisa Hutang</label>
                                                <input type="text" name="sisa_hutang" id="sisa_hutang"
                                                value="{{$data->sisa_hutang}}"  class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" align="right">
                                                <br>
                                                <button class="btn btn-primary" id="simpan"><i class="fa fa-save"></i> Simpan</button>
                                                <a href="{{ route('transaksi.hutangSuplier.index') }}" class="btn btn-danger">Kembali</a>
                                        </div>
                                    </div>
                                    </div>
                </div>
                </div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0"
            width="100%">
            <thead>
                <tr>
                    <th>No.Bayar</th>
                    <th>Suplier</th>
                    <th>Tanggal Bayar</th>
                    <th>Faktur Pembelian</th>
                    <th>Jumlah Bayar</th>
                    <th>Sisa Hutang</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
</div>
</div>
</div>
</div>

<!-- /.modal -->
@endsection
@push('style')
<link rel="stylesheet" href="{{  url('public/adminlte') }}/plugins/sweetalert2/dist/sweetalert2.css">
@endpush
@push('script')
<script src="{{ url('public/adminlte') }}/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function(){
        loadTable();
      $(".select2-Suplier").select2({
        ajax: {
        url: "{{ route('getDataSuplier') }}",
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
        placeholder:"Nama Suplier",
        });

        $(".select2-faktur-pembelian").select2({
       // let id_Suplier = $("#id_Suplier").val();
        ajax: {
        url: "{{ route('getDataFakturPembelianSelect') }}",
        contentType: 'application/json',
        dataType: 'json',
        delay:50,
        type:"get",
        data: function(params) {
            return {
            search: params.term,id_suplier: $("#id_suplier").val(),_token: '{{csrf_token()}}'
            };
        },
        processResults: function(data) {
            return {
            results: data
            };
        },
        cache: true
        },
        placeholder:"Faktur Pembelian",
        });

        $('#faktur_pembelian').change(function(){
            let url = `{{ route('getDataFakturPembelian') }}`;
            $.ajax({
                type: "POST",
                url: url,
                data:{ faktur_pembelian :  $('#faktur_pembelian').val(),_token: '{{csrf_token()}}', },
                dataType: "json",
                success: function (response) {
                   //console.log(response);
                   //alert(response);
                   if((response[0].sisa_hutang)==null){
                      $("#total_hutang").val(response[0].total);
                      $("#sisa_hutang").val(response[0].total);
                   }else{
                      $("#total_hutang").val(response[0].sisa_hutang);
                      $("#sisa_hutang").val(response[0].sisa_hutang);
                   }
                    }
                })
        });
        $('#bayar_sekarang').keyup(function(){
            potongHutang();
        });
        function potongHutang(){
            const total = $('#total_hutang').val();
            const potongan = $('#bayar_sekarang').val();
            $('#sisa_hutang').val(total - potongan);
        }
        $('#simpan').click(function(){

            if($('#bayar_sekarang').val() == 0){
                alert('Form masih kosong');
                return;
            }
            let url = `{{ route('transaksi.bayarSuplier.store') }}`;
            $.ajax({
                type: "POST",
                url: url,
                data:{
                    faktur : $('#faktur').val(),
                    tanggal : $('#tanggal').val(),
                    id_suplier : $('#id_suplier').val(),
                    id_pembelian : $('#faktur_pembelian').val(),
                    jumlah_bayar : $('#bayar_sekarang').val(),
                    sisa_hutang : $('#sisa_hutang').val(),
                    _token: '{{csrf_token()}}',
                },
                dataType: "json",
                success: function (response) {

                    if(response.status=="success"){
                        $("#bayar_sekarang").val('');
                        $("#total_hutang").val('');
                        $("#sisa_hutang").val('');
                        $('#faktur_pembelian').val(null).trigger('change');
                        loadTable();
                        Swal.fire("Success","Sukses saving pembayaran","success");
                        location.reload();
                    }
                }
            });
        });



    })
    function loadTable(){
        $.fn.dataTable.ext.errMode = 'none';
        $('#example-table').dataTable().fnDestroy();
            $('#example-table')
            .dataTable({
                ordering: true,
                processing:true,
                serverSide:true,
            ajax:{
            url:"{{route('getDataBayarSuplier')}}",
            type:"get",
            data:{pembelian_id:$('#faktur_pembelian').val(),_token: '{{csrf_token()}}' }
            },
            columns:[
            {data:'id_bayar_hutang_suplier'},
            {data:'suplier'},
            {data:'tanggal_bayar'},
            {data:'faktur_pembelian'},
            {data:'jumlah_bayar'},
            {data:'sisa_hutang'}
            ]
            });
            }
</script>
@endpush
