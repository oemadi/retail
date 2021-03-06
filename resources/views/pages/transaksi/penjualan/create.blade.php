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
                            <input type="text" name="faktur" id="faktur" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="customer">Customer</label>
                                <select name="id_customer" id="id_customer" class="form-control select2-customer" style="width: 100%;height:auto">
                               <option></option>
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
                                    <input type="radio" name="metode" id="metode2" value="hutang">
                                    Hutang
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
    <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="barang">Kode Barang</label>
                            <input type="hidden" name="nama_barang" id="nama_barang" class="form-control" >
                                <select name="id_barang" id="id_barang" class="form-control select2-barang" style="width: 100%;height:auto">
                               <option></option>
                                </select>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="harga_barang">Harga</label>
                            <input type="text" name="harga_barang" id="harga_barang" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="jumlah">Jumlah (Boleh Koma) dlm Kg</label>
                            <input type="text" name="jumlah2" id="jumlah2" class="form-control">
                            <input type="hidden" name="jumlah" id="jumlah" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="karung">Karung (Boleh Koma)</label>
                            <input type="text" name="karung" id="karung" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-warning pull-right addCart"><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-body">
                <div align="right">
                    <h1><b><span id="grand_total2" style="font-size:30pt;">0</span></b></h1>
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
                                        <th>Nama Barang</th>
                                        <th>Harga Barang</th>
                                        <th>Qty</th>
                                        <th>Karung</th>
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
                        <input type="text" name="idPenjualan" id="idPenjualan" class="form-control">
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
                                <td>Faktur</td>
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
                <button type="button" class="btn btn-success printStruk" data-dismiss="modal">Cetak Struk</button>
                <a  class="btn btn-default newTrans">Selesai</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@push('style')
<link rel="stylesheet" href="{{  url('public/adminlte') }}/plugins/sweetalert2/dist/sweetalert2.css">

@endpush
@push('script')
<script src="{{ url('public/adminlte') }}/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">
    $(function() {
        var cart = [];
        newTransaction();

        $(".select2-customer").select2({
        ajax: {
        url: "{{ route('getDataCustomerSelect') }}",
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
                     $("#harga_barang").val(response[0].harga_jual);
                     $("#jumlah").val(1);
                    }
                })
        });

        $('.showModalCustomer').click(function(){
            //alert();
            $('#modalcustomer').modal('show');
        });
        $('.showModalBarang').click(function(){
            $('#modalBarang').modal('show');
        });
       // href="/transaksi/penjualan/' + data + '/faktur"

        $('.printStruk').click(function(){
             id_penjualan = $('#idPenjualan').val();
            //alert(id_penjualan);
            ///report/penjualan/printStruk?id_penjualan=`+id_penjualan+`

            let url =
            `{{ url('/report/penjualan/printStruk?id_penjualan=`+id_penjualan+`') }}`;

            const parseResult = new DOMParser().parseFromString(url, "text/html");
            const parsedUrl = parseResult.documentElement.textContent;
            window.open(parsedUrl,'_blank');
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

        $('.newTrans').click(function(){
            newTransaction();
        });
        $('#jumlah2').on("input",function(){
                var jml=$('#jumlah2').val();
				var hasil=jml.replace(",",".");
				$('#jumlah').val((hasil));
        })
        function newTransaction(){
            for (var i in cart){  var item = cart[i];  cart.splice(item); }
            showCart();
            loadKotak()
            resetFormTrans();
            getNewFaktur();
            $('#id_customer').val(null).trigger('change');
            $('#id_barang').val(null).trigger('change');
            $('#modal-selesai').modal('hide');
        }
        function resetFormTrans(){

            $('#id_barang').val('');
            $('#namabarang').val('');
            $('#hargajual').val('');
            $('#barang').val('');
            $('#harga_barang').val('');
            $('#jumlah').val('');
            $('#jumlah2').val('');
            $('#karung').val('');

        }
          function getNewFaktur(){
                $.ajax({
                            type: "get",
                            url: "{{ route('getKodeFakturJual') }}",
                            dataType: "json",
                            success: function (response) {
                                $('#faktur').val(response);
                            }

                    });
          }
          function addToCart(){

            var kode_barang = $('#id_barang').val();
            var nama_barang = $('#nama_barang').val();
            var jumlah = $('#jumlah').val();
            var harga = $('#harga_barang').val();
            var karung = $('#karung').val();
            // for (var i in cart){
            //     if(cart[i].kode_barang == kode_barang){
            //         cart[i].jumlah = parseInt(cart[i].jumlah)+parseInt(jumlah);
            //         cart[i].subtotal = parseInt(cart[i].harga) * parseInt(cart[i].jumlah);
            //         showCart();
            //         saveCart();
            //         return;
            //     }
            // }
            const item = {
                kode_barang :kode_barang,
                nama_barang:nama_barang,
                jumlah:jumlah,
                harga:harga,
                karung:karung,
                subtotal:parseFloat(jumlah)*parseFloat(harga)
            };

            cart.push(item);
            saveCart();
            showCart();
            resetFormTrans();

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
                var jumlah1 = item.jumlah;
                jumlah2 = jumlah1.replace(".",",");
                row +=   `<tr>
                                <td>${item.nama_barang}</td>
                                <td>${item.harga}</td>
                                <td>${jumlah2}</td>
                                <td>${item.karung}</td>
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
                $('#grand_total2').text(grandtotal);
            }
            resetFormTrans();

        }
        $('.simpan').click(function(){

            if($('#id_customer').val() == ""){
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
                        newTransaction();
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
            $('#idPenjualan').val(data.id);

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
