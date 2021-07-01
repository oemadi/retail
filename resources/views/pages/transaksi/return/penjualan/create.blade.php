@extends('layouts.template')
@section('page','Return Penjualan')
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="box box-danger">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="faktur">Faktur</label>
                            <input type="text" name="faktur" id="faktur" class="form-control" value="{{ $faktur }}"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control"
                                value="{{ date('Y-m-d') }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-danger">
            <div class=" box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="faktur_penjualan">Faktur Penjualan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="faktur_penjualan" id="faktur_penjualan">

                                <div class="input-group-addon showModalPenjualan" style="cursor:pointer">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tanggal_penjualan">Tanggal Penjualan</label>
                            <input type="text" name="tanggal_penjualan" id="tanggal_penjualan" class="form-control"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="customer">customer</label>
                            <input type="text" name="customer" id="customer" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box box-danger"">
            <div class=" box-body">
            <div align="right">
                <h1><b><span id="grand_total2" style="font-size:50pt;">0</span></b></h1>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class=" box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadDataPenjualan">
                                    <tr>
                                        <td colspan="6" class="text-danger">
                                            <center>Tidak ada data</center>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table style="background:#ccc;padding:5px;width:100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <input type="hidden" name="qty_detail" id="qty_detail">
                                            <input type="hidden" name="harga_hidden" id="harga_hidden">
                                            <span class="input-group-btn"><button class="btn " type="button">Kode Barang
                                                </button></span>
                                            <input class="form-control" type="text" id="kodeBarang" title="kode barang"
                                                readonly>

                                            <span class="input-group-btn"><button class="btn " type="button">Nama Barang
                                                </button></span>
                                            <input class="form-control" type="text" id="namaBarang" title="nama barang"
                                                readonly>


                                            <span class="input-group-btn"><button class="btn "
                                                    type="button">Qty</button></span>
                                            <input style="text-align:center" class="form-control" type="number" id="qty"
                                                title="jumlah barang">


                                            <span class="input-group-btn"><button class="btn btn-primary" type="button"
                                                    id="addCart"><i class="fa fa-check-square-o"></i>
                                                    Tambah</button></span>
                                        </div>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h3>Data Return</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover tableReturn">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Jumlah Dikembalikan</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                                <tbody id="loadDataReturn"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary pull-right btn-submit btn-store">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Data Penjualan</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="table_transaksi">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Invoice</th>
                                        <th>Penjualan</th>
                                        <th>Pembayaran</th>
                                        <th>Customer</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan as $key=>$item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tanggal_penjualan }}</td>
                                        <td>{{ $item->faktur }}</td>
                                        <td>@rupiah($item->total)</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->customer->nama }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm btn-pilih" data-id="{{ $item->id }}"
                                                data-faktur="{{ $item->faktur }}"
                                                data-tanggal="{{ $item->tanggal_penjualan }}"
                                                data-customer="{{ $item->customer->nama }}"><i
                                                    class="fa fa-check-square-o"></i>
                                                Pilih</button>
                                        </td>
                                    </tr>
                                    @endforeach
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
@endsection
@push('style')
<link rel="stylesheet" href="{{ url('public/adminlte') }}/plugins/sweetalert2/dist/sweetalert2.css">
@endpush
@push('script')
<script src="{{ url('public/adminlte') }}/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function(){
        var cart_return_penjualan = [];
        if(localStorage.cart_return_penjualan){
            cart_return_penjualan = JSON.parse(localStorage.cart_return_penjualan);
        }
        function showCart(){
            faktur_penjualan = $('#faktur_penjualan').val();
            if (cart_return_penjualan.length == 0) {
                $("#loadDataReturn").html(`<tr>
                    <td colspan="6">Data Tidak ada</td>
                </tr>`);
                return;
            }
            var row = '';
            for (var i in cart_return_penjualan){
                var item = cart_return_penjualan[i];
                if(faktur_penjualan == item.faktur_penjualan){
                    row += `<tr>
                        <td>${item.kode_barang}</td>
                        <td>${item.nama_barang}</td>
                        <td>${item.harga}</td>
                        <td>${item.jumlah_dikembalikan}</td>
                        <td>${item.subtotal}</td>
                        <td><button id="delete" data-i="${i}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td>
                    </tr>`;
                }
            }
            $('#loadDataReturn').html(row);
        }

        function saveCart(){
            if(window.localStorage){
                localStorage.cart_return_penjualan = JSON.stringify(cart_return_penjualan);
            }
        }

        function addCart(){

            var faktur_penjualan = $('#faktur_penjualan').val();
            var kode_barang = $('#kodeBarang').val();
            var nama_barang = $('#namaBarang').val();
            var jumlah_dikembalikan = $('#qty').val();
            var harga = $('#harga_hidden').val();

            for (i in cart_return_penjualan){
                if(cart_return_penjualan[i].faktur_penjualan == faktur_penjualan){
                    if(cart_return_penjualan[i].kode_barang == kode_barang){
                        cart_return_penjualan[i].jumlah_dikembalikan = parseInt(cart_return_penjualan[i].jumlah_dikembalikan) + parseInt(jumlah_dikembalikan);

                        cart_return_penjualan[i].subtotal = parseInt(cart_return_penjualan[i].harga) * parseInt(cart_return_penjualan[i].jumlah_dikembalikan);
                        showCart();
                        saveCart();
                        loadKotak();
                        return;
                    }
                }
            }
            const item = {
                faktur_penjualan:faktur_penjualan,
                kode_barang :kode_barang,
                nama_barang:nama_barang,
                jumlah_dikembalikan:jumlah_dikembalikan,
                harga:harga,
                subtotal:parseInt(jumlah_dikembalikan)*parseInt(harga)
            };
            cart_return_penjualan.push(item);
            saveCart();
            showCart();
            loadKotak();
        }
        $(document).on('click','#delete',function(){
            cart_return_penjualan.splice($(this).data('i'),1);
            saveCart();
            showCart();
            loadKotak();
        });

        function loadKotak(){
            if (cart_return_penjualan.length == 0) {
                $('#grand_total2').text(0);
                return;
            }
            var grandtotal = 0;
            for (var i in cart_return_penjualan){
                if($('#faktur_penjualan').val() == cart_return_penjualan[i].faktur_Penjualan){
                    grandtotal += cart_return_penjualan[i].subtotal;
                }
            }
            $('#grand_total2').text(grandtotal);
        }

        $('#table_Penjualan').dataTable();
        $('.showModalPenjualan').click(function(){
            $('#myModal').modal('show');
        });
        $(document).on('click','.btn-pilih',function(){
            $('#faktur_penjualan').val($(this).data('faktur'));
            $('#tanggal_penjualan').val($(this).data('tanggal'));
            $('#customer').val($(this).data('customer'));
            loadBarangPenjualan($(this).data('id'));
            $('#myModal').modal('hide');
            showCart();
            loadKotak();
        });
        function loadBarangPenjualan(penjualan_id){
            let url = "{{ route('transaksi.return.penjualan.load_barang',':id') }}";
            url = url.replace(":id",penjualan_id);
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (response) {
                    $('#loadDataPenjualan').html(response[1]);
                    $('#kodeBarang').val('');
                    $('#namaBarang').val('');
                    $('#qty').val(1);
                }
            });
        }
        $(document).on('click','.btn-pilih-barang',function(){
            const kode_barang = $(this).data('kbarang');
            const nama_barang = $(this).data('nbarang');
            const qty_detail = $(this).data('qty');
            $('#qty_detail').val(qty_detail);
            $('#kodeBarang').val(kode_barang);
            $('#namaBarang').val(nama_barang);
            $('#qty').val(1);
            $('#harga_hidden').val($(this).data('harga'));
        });
        $('#qty').keyup(function(){
            if($('#kodeBarang').val()!=""){
                if(parseInt($(this).val()) >= parseInt($('#qty_detail').val())){
                    $(this).val(0);
                    Swal.fire("Error!","Terlalu banyak barang yang direturn","error");
                }
            }else{
                Swal.fire("Error!","Barang belum dipilih","error");
            }
        });
        $('#addCart').click(function(){
            if($('#faktur_penjualan').val()!=""){
                if($('#kodeBarang').val() != "" && $('#namaBarang').val() && $('#qty').val()!=""){
                    if(cart_return_penjualan.length == 0){
                        addCart();
                        return;
                    }else{
                        for(i in cart_return_penjualan){
                            item = cart_return_penjualan[i];
                            if(item.faktur_Penjualan == $('#faktur_penjualan').val()){
                                if(item.kode_barang == $('#kodeBarang').val()){
                                    ini = parseInt(item.jumlah_dikembalikan) + parseInt($('#qty').val());
                                    console.log(ini);
                                    if(ini >= $('#qty_detail').val()){
                                        Swal.fire("Error!","Qty terlalu banyak!","error");
                                        return;
                                    }
                                }
                                addCart();
                                return;
                            }

                        }
                        addCart();
                    }
                }else{
                    Swal.fire("Error!","Form masih kosong","error");
                }
            }else{
                Swal.fire("Error!","Form Transaksi masih kosong","error");
            }
        });

        $('.btn-store').click(function(){
            faktur_Penjualan = $('#faktur_penjualan').val();
            faktur = $('#faktur').val();

            if(faktur_Penjualan != "" && cart_return_penjualan.length != 0){

                $.ajax({
                    type: "POST",
                    url: "{{ route('transaksi.return.penjualan.store') }}",
                    data: {
                        faktur_penjualan:faktur_penjualan,
                        faktur:faktur,
                        data : cart_return_penjualan,
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
                                localStorage.removeItem('cart_return_penjualan');
                                location.href = "{{ route('transaksi.return.penjualan.index') }}";
                            });
                        }else{
                            Swal.fire(response[0],response[1],response[0]);
                        }
                    }
                });
            }else{
                Swal.fire("Error!","Form Transaksi masih kosong","error");
            }
        });
    });
</script>
@endpush
