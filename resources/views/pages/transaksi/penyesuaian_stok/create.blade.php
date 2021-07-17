@extends('layouts.template')
@section('page','Transaksi Penyesuaian Stok')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}"
                                class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="faktur">Faktur</label>
                            <input type="text" name="faktur" id="faktur" class="form-control" value="{{ $faktur }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="user">User</label>
                            <input type="text" name="user" id="user" class="form-control" value="{{ Auth::user()->nama }}"
                                readonly>
                            <input type="hidden" name="userid" id="userid" class="form-control" value="{{ Auth::user()->id }}"
                                readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box box-danger">
            <div class="box-body">
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="suplier">Kode Barang</label>
                            <input type="hidden" name="nama_barang" id="nama_barang" class="form-control" >
                                <select name="id_barang" id="id_barang" class="form-control select2-barang" style="width: 100%;height:auto">
                               <option></option>
                                </select>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="suplier">Jenis</label>
                            <select name="jenis" id="jenis" class="form-control" style="width: 100%;height:auto">
                               <option value="penambahan">Penambahan</option>
                               <option value="pengurangan">Pengurangan</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="jumlah">Jumlah Barang</label>
                            <input type="text" name="jumlah" id="jumlah" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control">
                        </div>


                            <button class="btn btn-warning pull-right addCart"><i class="fa fa-plus"></i> Tambah</button>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jenis</th>
                                        <th>Qty</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="loadCart">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary pull-right simpan"><i class="fa fa-check-square-o"></i>
                            Simpan</button>
                        <a href="{{ route('transaksi.penyesuaianStok.index') }}" class="btn btn-danger pull-right ml-2"><i
                                class="fa fa-window-close"></i> Kembali</a>
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
<script type="text/javascript">
    $(function() {
        //alert();
        var cart = [];
        if(localStorage.cart){
            cart = JSON.parse(localStorage.cart);
        }

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
        $('#id_barang').change(function(){
            // /alert();
            let url = `{{ route('getDataBarangSelect2') }}`;
            $.ajax({
                type: "POST",
                url: url,
                data:{ id_barang : $('#id_barang').val() },_token: '{{csrf_token()}}',
                dataType: "json",
                success: function (response) {
                 //  alert(response);
                   // console.log(response);
                     $("#nama_barang").val(response[0].nama);
                     $("#jumlah").val(1);
                    }
                })
        });


        $(document).on('click','#delete',function(){
            cart.splice($(this).data('i'),1);
            saveCart();
            showCart();
            loadKotak();
        });

        $('.addCart').click(function(){
           // alert();
            if($('#barang').val() != "" && $('#jumlah').val() != ""){
                addToCart();
            }else{
                Swal.fire("Error!","Barang atau jumlah belum diisi","error");
            }
        });

    function addToCart(){

            var kode_barang = $('#id_barang').val();
            var nama_barang = $('#nama_barang').val();
            var jumlah = $('#jumlah').val();
            var keterangan = $('#keterangan').val();
            var jenis = $('#jenis').val();

            const item = {
                kode_barang :kode_barang,
                nama_barang:nama_barang,
                jumlah:jumlah,
                keterangan:keterangan,
                jenis:jenis
            };

            cart.push(item);
            saveCart();
            showCart();

        $('#loadCart').html(row);
            loadKotak();
        }
        function saveCart(){

            if(window.localStorage){
                localStorage.cart = JSON.stringify(cart);
            }
        }

        function showCart(){

            if (cart.length == 0) {
                $("#loadCart").html(`<tr><td colspan="6">Data Tidak ada</td></tr>`);
                return;
            }
            var row = '';
            for (var i in cart){
                var item = cart[i];
                row +=   `<tr>
                                <td>${item.kode_barang}</td>
                                <td>${item.nama_barang}</td>
                                <td>${item.jenis}</td>
                                <td>${item.jumlah}</td>
                                <td>${item.keterangan}</td> <td><button id="delete" data-i="${i}" class="btn btn-xs btn-danger"><i
                                        class="fa fa-trash"></i></button></td>
                            </tr>`;

            }
            $('#loadCart').html(row);
            $('#jenis').val('');
            $('#nama_barang').val('');
            $('#jumlah').val('');
            $('#keterangan').val('');
            $('#id_barang').val(null).trigger('change');

        }

        $('.simpan').click(function(){

            if(cart.length == 0){
                Swal.fire("Error!","Data Keranjang masih kosong","error");
                return;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('transaksi.penyesuaianStok.store') }}",
                data: {
                    faktur : $('#faktur').val(),
                    data : cart,
                    tanggal: $('#tanggal').val(),
                    user: $('#userid').val(),
                    _token: '{{csrf_token()}}'
                },
                beforeSend:function(){
                    Swal.fire({
                        title: 'Loading .....',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        onOpen: () => {
                            Swal.showLoading()
                        }
                    })
                },
                dataType: "json",
                success: function (response) {

                    Swal.close();
                    if(response[0] == "success"){
                        Swal.fire(response[0],response[1],response[0]).then(()=>{
                            localStorage.removeItem('cart');
                            location.href = "{{ route('transaksi.penyesuaianStok.index') }}";
                        });
                    }else{
                        Swal.fire(response[0],response[1],response[0]);
                    }
                }
            });
        });

    })

</script>
@endpush
