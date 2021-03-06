@extends('layouts.template')
@section('page','Barang')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>
                <h3 class="box-title">@yield('page')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        @error('penambahan_stok_masuk')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                        @if (Session::get('status'))
                        <div class="alert alert-{{ Session::get('status') }}">
                            {{Session::get('message')}}</div>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class=" box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="id_kategori" id="id_kategori" class="form-control select2-kategori" style="width: 100%;height:auto">
                                                </select>
                                            </td>

                                            <td>
                                                <select name="id_barang" id="id_barang" class="form-control select2-barang" style="width: 100%;height:auto">
                                                </select>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-success" style="width:100%" id="filter1"><i
                                                        class="fa fa-search"></i>
                                                    Filter</a>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                    </div>
                </div>
            </div>
                <a href=" {{ route('barang.create') }}" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Tambah
                    Data</a>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%"
                                id="example-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Barang</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Satuan</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Stok Awal</th>
                                        <th>Stok Masuk</th>
                                        <th>Stok Keluar</th>
                                        <th>Stok Penyesuaian Penambahan</th>
                                        <th>Stok Penyesuaian Pengurangan</th>
                                        <th>Stok Akhir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBarcode" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Kode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-2 mt-2">
                    <div class="col-md-12" id="contentShowBarcode"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahStokMasuk">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" method="POST" id="form-tambah-stok">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-mtsm">Tambah Stok Masuk</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" name="nama_barang" id="nama_barang" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stok_awal">Stok Awal</label>
                                <input type="text" name="stok_awal" id="stok_awal" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stok_keluar">Stok Keluar</label>
                                <input type="text" name="stok_keluar" id="stok_keluar" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stok_masuk">Stok Masuk</label>
                                <input type="number" name="stok_masuk" id="stok_masuk" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stok_akhir">Stok Akhir Saat Ini</label>
                                <input type="text" name="stok_akhir" id="stok_akhir" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="penambahan_stok_masuk">Penambahan Stok Masuk</label>
                                <input type="number" name="penambahan_stok_masuk" id="penambahan_stok_masuk"
                                    class="form-control" placeholder="Masukkan value penambahan stok" min="1"
                                    max="10000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah_stok_akhir">Jumlah Stok Akhir</label>
                                <input type="text" name="jumlah_stok_akhir" id="jumlah_stok_akhir" class="form-control"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


@endsection
@push('style')
@endpush
@push('script')
<!-- SlimScroll -->
<script type="text/javascript">
       $('#filter1').click(function(){
            $('#example-table').dataTable().fnDestroy();
            loadDataTable();
        });
        function loadDataTable(){
        var id_kategori = $("#id_kategori").val();
        var id_barang = $("#id_barang").val();
       // alert(id_kategori,id_barang);
       	$.fn.dataTable.ext.errMode = 'none';
        $('#example-table')
		.on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
    } )
		.dataTable({
           processing:true,
		   serverSide:true,
           searching:false,
           ajax:{
            url: "{{route('getDataMasterBarang')}}",
            type:"get",
            data:{id_kategori:id_kategori,id_barang:id_barang,_token: '{{csrf_token()}}'}
           },
		   columns:[
		    {"data": "id",
                 render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                 }
                },
           {data:'kode'},
		   {data:'nama'},
           {data:'kategori_id'},
           {data:'satuan_id'},
		   {data:'harga_beli'},
		   {data:'harga_jual'},
		   {data:'stok_awal'},
		   {data:'stok_masuk'},
           {data:'stok_keluar'},
           {data:'stok_penyesuaian_penambahan'},
           {data:'stok_penyesuaian_pengurangan'},
		   {data:'stok_akhir'},
		   {data: 'id',
            "render": function (data) {
            data1 = '<a href="/barang/' + data + '/edit" class="btn btn-sm btn-warning">Edit</a>';
			 data2 = '<a href="/barang/' + data + '/delete" class="btn btn-sm btn-danger" onclick="javascript:return confirm(\'Anda yakin?\');">Delete</a>';
			return data1+' '+data2;
            }
		   }
		   ]
        });
        }
    $(function() {
        loadDataTable();
        $(".select2-kategori").select2({
        ajax: {
        url: "{{ route('getDataKategoriSelect') }}",
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
        placeholder:"Kode/Nama Barang",
        });

    });
</script>
@endpush

