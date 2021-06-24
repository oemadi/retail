@extends('layouts.template')
@section('page','Transaksi Penjualan')
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
                            <input type="text" name="faktur" id="faktur" class="form-control" value="{{ $kodeFaktur }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="customer">Customer</label>
                                <select name="id_customer" id="id_customer" class="form-control select2-customer" style="width: 100%;height:auto">
                                </select>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <form id="formKasir">
                            <span class="radio">
                                Metode Pembayaran :
                                <label>
                                    <input type="radio" name="metode" id="metode1" value="tunai" checked="">
                                    Tunai
                                </label>

                                <label>
                                    <input type="radio" name="metode" id="metode2" value="kredit">
                                    Non Tunai
                                </label>
                            </span>
                        </form>
                    </div>
                    <div class="col-md-12 kotakTanggal" style="display: none">
                        <div class="form-group">
                            <label for="tanggal_tempo">Tanggal Jatuh Tempo</label>
                            <input type="date" name="tanggal_tempo" id="tanggal_tempo" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box box-danger">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="barang">Kode Barang</label>
                            <div class="input-group">
                                <input type="hidden" name="id_barang" id="id_barang">
                                <input type="hidden" name="hargabeli" id="hargabeli">
                                <input type="text" name="barang" id="barang" class="form-control" readonly>
                                <div class="input-group-addon showModalBarang" style="cursor: pointer;">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-warning pull-right addCart"><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box box-danger">
            <div class="box-body">
                <div align="right">
                    <h1><b><span id="grand_total2" style="font-size:36pt;">0</span></b></h1>
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
                                        <th>Harga Barang</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
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
                        <a href="{{ route('transaksi.penjualan.index') }}" class="btn btn-danger pull-right ml-2"><i
                                class="fa fa-window-close"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalcustomer" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Data customer</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable">
                                <thead>
                                    <th>Nama customer</th>
                                    <th>Alamat</th>
                                    <th>No HP</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    @foreach ($customer as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->no_hp }}</td>
                                        <td><button class="btn btn-warning btn-pilih-customer" data-id="{{ $item->id }}"
                                                data-ncustomer="{{ $item->nama }}">Pilih</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-window-close"></i>
                    Tutup</button>
            </div>
        </div>
    </div>
</div>

<div id="modalBarang" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Data customer</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable">
                                <thead>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Beli</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    @foreach ($barang as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->harga_beli }}</td>
                                        <td>{{ $item->stok_akhir }}</td>
                                        <td><button class="btn btn-warning btn-pilih-barang" data-id="{{ $item->id }}"
                                                data-nbarang="{{ $item->nama }}"
                                                data-hargabeli="{{ $item->harga_beli }}">Pilih</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-window-close"></i>
                    Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-selesai">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Transaksi Selesai</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td id="showTanggal"></td>
                                <td>Pelanggan</td>
                                <td>:</td>
                                <td id="showPelanggan"></td>
                            </tr>
                            <tr>
                                <td>Invoice</td>
                                <td>:</td>
                                <td id="showInvoice"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="table-after-transaksi"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cetak Struk</button>
                <a href="{{ route('transaksi.penjualan.create') }}"  class="btn btn-default">Selesai</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@push('style')
<link rel="stylesheet" href="{{  url('public/adminlte') }}/plugins/sweetalert2/dist/sweetalert2.css">
<link rel="stylesheet" href="{{url('public/adminlte')}}/bower_components/select2/dist/css/select2.min.css">

@endpush
@push('script')
<script src="{{ url('public/adminlte') }}/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="{{ url('public/adminlte') }}/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
    $(function() {
        //alert();
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

        var cart = [];
        if(localStorage.cart){
            cart = JSON.parse(localStorage.cart);
        }
       // alert();
        $(document).on('click','#minus',function(){
            minusCart($(this).data('kode'),$(this).data('i'));
        });
        $(document).on('click','#plus',function(){
            plusCart($(this).data('kode'),$(this).data('i'));
        });
        $('.showModalCustomer').click(function(){
            //alert();
            $('#modalcustomer').modal('show');
        });
        $('.showModalBarang').click(function(){
            $('#modalBarang').modal('show');
        });
        $(document).on('click','.btn-pilih-customer',function(){
            $('#customer').val($(this).data('ncustomer'));
            $('#id_customer').val($(this).data('id'));
            $('#modalcustomer').modal('hide');
        });
        $(document).on('click','#delete',function(){
            cart.splice($(this).data('i'),1);
            saveCart();
            showCart();
            loadKotak();
        });
        $(document).on('click','.btn-pilih-barang',function(){
            $('#id_barang').val($(this).data('id'));
            $('#barang').val($(this).data('id'));
            $('#hargabeli').val($(this).data('hargabeli'));
            $('#nama_barang').val($(this).data('nbarang'));
            $('#modalBarang').modal('hide');
        });
        $('#metode1').click(function(){
            $('.kotakTanggal').css({display:"none"})
        })
        $('#metode2').click(function(){
            $('.kotakTanggal').css({display:"block"})
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

            var kode_barang = $('#barang').val();
            var nama_barang = $('#nama_barang').val();
            var jumlah = $('#jumlah').val();
            var harga = $('#hargabeli').val();
            for (var i in cart){
                if(cart[i].kode_barang == kode_barang){
                    cart[i].jumlah = parseInt(cart[i].jumlah)+parseInt(jumlah);
                    cart[i].subtotal = parseInt(cart[i].harga) * parseInt(cart[i].jumlah);
                    showCart();
                    saveCart();
                    return;
                }
            }
            const item = {
                kode_barang :kode_barang,
                nama_barang:nama_barang,
                jumlah:jumlah,
                harga:harga,
                subtotal:parseInt(jumlah)*parseInt(harga)
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
        function minusCart(kode_barang,index){
            for (var i in cart){
                if(cart[i].kode_barang == kode_barang){
                    if(cart[i].jumlah == 1){
                        cart.splice(index,1);
                        loadKotak();
                    }else{
                        cart[i].jumlah = parseInt(cart[i].jumlah) - 1;
                        cart[i].subtotal = parseInt(cart[i].harga) * parseInt(cart[i].jumlah);
                    }
                    saveCart();
                    showCart();
                    loadKotak();
                    return;
                }
            }
        }
        function plusCart(kode_barang,i){
            for (var i in cart){
                if(cart[i].kode_barang == kode_barang){
                    cart[i].jumlah = parseInt(cart[i].jumlah) + 1;
                    cart[i].subtotal = parseInt(cart[i].harga) * parseInt(cart[i].jumlah);
                    saveCart();
                    showCart();
                    return;
                }
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
                                <td>${item.harga}</td>
                                <td><button id="minus" data-i="${i}" data-kode="${item.kode_barang}" class="btn btn-xs btn-default"><i class="fa fa-minus"></i></button> <span style="width:30px;padding:5px"> ${item.jumlah}</span> <button id="plus" data-i="${i}" data-kode="${item.kode_barang}" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></button></td>
                                <td>${item.subtotal}</td>
                                <td><button id="delete" data-i="${i}" class="btn btn-xs btn-danger"><i
                                        class="fa fa-trash"></i></button></td>
                            </tr>`;

            }
            $('#loadCart').html(row);
            loadKotak();
        }
        function loadKotak(){
            if (cart.length == 0) {
                $('#grand_total2').text(0);
                return;
            }
            var grandtotal = 0;
            for (var i in cart){
                grandtotal += cart[i].subtotal;
            }
            $('#grand_total2').text(grandtotal);
        }
        $('.simpan').click(function(){

            if($('#customer').val() == ""){
                Swal.fire("Error!","customer belum diisi","error");
                return;
            }
            if(cart.length == 0){
                Swal.fire("Error!","Data Keranjang masih kosong","error");
                return;
            }
            var status = "tunai";
            if(document.getElementById('metode2').checked){
                var status = "hutang";
                if($('#tanggal_tempo').val()==""){
                    Swal.fire("Error!","Tanggal jatuh tempo belum di isi","error");
                    return;
                }
            }
                //alert();
            $.ajax({
                type: "POST",
                url: "{{ route('transaksi.penjualan.store') }}",
                data: {
                    faktur : $('#faktur').val(),
                    customer_id : $('#id_customer').val(),
                    data : cart,
                    tempo: $('#tanggal_tempo').val(),
                    status:status, _token: '{{csrf_token()}}'
                },
                beforeSend:function(){
                    // Swal.fire({
                    //     title: 'Loading .....',
                    //     allowEscapeKey: false,
                    //     allowOutsideClick: false,
                    //     onOpen: () => {
                    //         Swal.showLoading()
                    //     }
                    // })
                },
                dataType: "json",
                success: function (response) {

                    if(response[0] == "berhasil"){
                        localStorage.removeItem('cart');
                        console.log(response);
                        modalTransaksi(response[1]);

                        // Swal.fire(response[0],response[1],response[0]).then(()=>{

                           // location.href = "{{ route('transaksi.penjualan.index') }}";

                        // });
                     }else{
                         Swal.fire(response[0],response[1],response[0]);

                    }
                }
            });
        });

        function modalTransaksi(data){
            $('#showTanggal').text(data.tanggal_penjualan);
            $('#showPelanggan').text(data.customer.nama);
            $('#showInvoice').text(data.faktur);

            var html = '';
            var subtotal = 0;
            data.detail_penjualan.forEach(function(item){
                html += `<tr><td>${item.barang.nama}</td><td>${item.barang.harga_jual}</td><td>${item.jumlah_jual}</td><td>${item.subtotal}</td></tr>`;
                subtotal += item.subtotal
            });
            html += `<tr><td colspan="3" align="center">Subtotal Barang</td><td>${subtotal}</td></tr>`;
            $('#table-after-transaksi').html(html);
            $('#modal-selesai').modal('show');
        }

    })

</script>
@endpush
