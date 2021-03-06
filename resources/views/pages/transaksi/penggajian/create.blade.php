@extends('layouts.template')
@section('page','Input Penggajian')
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
                                            <label for="Faktur">Faktur</label>
                                            <input type="text" name="faktur" class="form-control" id="faktur" readonly
                                                style="cursor:no-drop" value="{{ $faktur }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal Penggajian</label>
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
                                            <label for="pegawai">Pegawai</label>
                                                <select name="id_pegawai" id="id_pegawai" class="select2-pegawai" style="width: 100%;height:100%">
                                                </select>

                                    </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="no_telp">No Telp</label>
                                            <input type="text" name="no_telp" id="no_telp" class="form-control"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gaji">Gaji</label>
                                            <input type="text" name="gaji" id="gaji" class="form-control" >
                                        </div>

                                    </div>
                                </div>
                    </div>
                    <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="potongan_gaji">Potongan Gaji</label>
                                            <input type="text" name="potongan_gaji" id="potongan_gaji"
                                                class="form-control" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                                <label for="gaji_bersih">Gaji Bersih</label>
                                                <input type="text" name="gaji_bersih" id="gaji_bersih"
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

@endsection
@push('style')
<link rel="stylesheet" href="{{  url('public/adminlte') }}/plugins/sweetalert2/dist/sweetalert2.css">
@endpush
@push('script')
<script src="{{ url('public/adminlte') }}/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function(){
        // alert();
      //  $('#example-table').dataTable();
      $(".select2-pegawai").select2({
        ajax: {
        url: "{{ route('getDataPegawaiSelect') }}",
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

        placeholder:"Nama Pegawai",
        });
        $('#id_pegawai').change(function(){
            let url = `{{ route('getDataPegawaiSelect2') }}`;
            $.ajax({
                type: "POST",
                url: url,
                data:{ id_pegawai : $('#id_pegawai').val() },_token: '{{csrf_token()}}',
                dataType: "json",
                success: function (response) {
                   // console.log(response);
                     $("#gaji").val(response[0].gaji);
                     $("#no_telp").val(response[0].no_telp);
                     $("#gaji_bersih").val(response[0].gaji);
                    }
                })
        });
        $('#gaji').keyup(function(){
            potongGaji();
        });
        $('#potongan_gaji').keyup(function(){
            potongGaji();
        });
        function potongGaji(){
            const gaji = $('#gaji').val();
            const potongan = $('#potongan_gaji').val();
            $('#gaji_bersih').val(gaji - potongan);
        }
        $('#simpan').click(function(){

            if($('#id_pegawai').val()==""){
                alert('Form masih kosong');
                return;
            }
            //alert();
            let url = `{{ route('transaksi.penggajian.store') }}`;
            $.ajax({
                type: "POST",
                url: url,
                data:{
                    faktur : $('#faktur').val(),
                    tanggal : $('#tanggal').val(),
                    id_pegawai : $('#id_pegawai').val(),
                    gaji : $('#gaji').val(),
                    potongan : $('#potongan_gaji').val(),
                    gaji_bersih : $('#gaji').val(),
                    _token: '{{csrf_token()}}'
                },
                dataType: "json",
                success: function (response) {

                    if(response.status == "berhasil"){
                        $('#gaji').val(0);
                        $('#potongan_gaji').val(0);
                        $('#gaji').val(0);
                        $('#gaji_bersih').val(0);
                        $('#no_telp').val(0);
                        $('#id_pegawai').val(null).trigger('change');
                        Swal.fire("Success","Sukses menggaji pegawai","success");
                      //alert('Saving success');
                        }
                    }
            });
        });
    })
</script>
@endpush
