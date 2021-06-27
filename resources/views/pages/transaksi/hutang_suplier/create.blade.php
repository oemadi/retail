@extends('layouts.template')
@section('page','Input Bayar Customer')
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
                                            <label for="customer">Customer</label>
                                                <select name="id_customer" id="id_customer" class="select2-customer" style="width: 100%;height:100%">
                                                </select>

                                    </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="faktur_penjualan">No.Faktur Penjualan</label>
                                                <select name="faktur_penjualan" id="faktur_penjualan" class="select2-faktur-penjualan" style="width: 100%;height:100%">
                                                </select>

                                    </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gaji">Total Hutang</label>
                                            <input type="text" name="total_hutang" id="total_hutang" class="form-control" >
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
                                                    class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" align="right">
                                                <br>
                                                <button class="btn btn-primary" id="simpan"><i class="fa fa-save"></i> Simpan</button>
                                                <a href="{{ route('transaksi.penggajian.index') }}" class="btn btn-danger">Kembali</a>
                                        </div>
                                    </div>
                                    </div>
                </div>
                </div>

            </div>
        </div>
    </div>
</div>




<!-- /.modal -->
@endsection
@push('script')

<script>
    $(document).ready(function(){
        // alert();
      //  $('#example-table').dataTable();
      $(".select2-customer").select2({
        ajax: {
        url: "{{ route('getDataCustomer') }}",
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
        placeholder:"Nama Customer",
        });

        $(".select2-faktur-penjualan").select2({
       // let id_customer = $("#id_customer").val();
        ajax: {
        url: "{{ route('getDataFakturPenjualanSelect') }}",
        contentType: 'application/json',
        dataType: 'json',
        delay:50,
        type:"get",
        data: function(params) {
            return {
            search: params.term,id_customer: $("#id_customer").val(),_token: '{{csrf_token()}}'
            };
        },
        processResults: function(data) {
            return {
            results: data
            };
        },
        cache: true
        },
        placeholder:"Faktur Penjualan",
        });

        $('#faktur_penjualan').change(function(){
            let url = `{{ route('getDataFakturPenjualan') }}`;
            $.ajax({
                type: "POST",
                url: url,
                data:{ faktur_penjualan :  $('#faktur_penjualan').val(),_token: '{{csrf_token()}}', },
                dataType: "json",
                success: function (response) {
                   //console.log(response);
                   //alert(response);
                      $("#total_hutang").val(response[0].total);
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
            alert();
            if($('#id_pegawai').val() == ""){
                alert('Form masih kosong');
                return;
            }
            let url = `{{ route('transaksi.bayarCustomer.store') }}`;
            $.ajax({
                type: "POST",
                url: url,
                data:{
                    faktur : $('#faktur').val(),
                    tanggal : $('#tanggal').val(),
                    id_customer : $('#id_customer').val(),
                    id_penjualan : $('#faktur_penjualan').val(),
                    jumlah_bayar : $('#bayar_sekarang').val(),
                    sisa_hutang : $('#sisa_hutang').val(),
                    _token: '{{csrf_token()}}',
                },
                beforeSend:function(){
                },
                dataType: "json",
                success: function (response) {
                    Swal.close();
                    if(response[0]=="success"){
                        Swal.fire("Success","Sukses menggaji pegawai","success").then(()=>{
                            let url = `{{ route('transaksi.penggajian.slip',':id') }}`;
                            url  = url.replace(':id',response[1].faktur);
                            window.open(url,'_blank');
                            location.href = `{{ route('transaksi.penggajian.index') }}`;
                        });
                    }else{
                        Swal.fire("Error",response[1],"error").then(()=>{
                            location.href = `{{ route('transaksi.penggajian.index') }}`;
                        });
                    }
                }
            });
        });
    })
</script>
@endpush
