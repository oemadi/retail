@extends('layouts.template')
@section('page','Return Penjualan')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class=" box-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Tanggal Awal</td>
                                    <td>
                                        <input title="tanggal transaksi" class="form-control datepicker-here"
                                            type="text" id="startdate" data-language="en" autocomplete="off">
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Akhir</td>

                                    <td>
                                        <input title="tanggal transaksi" class="form-control datepicker-here"
                                            type="text" id="enddate" data-language="en" autocomplete="off">
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
                    <div class="col-md-6">
                        <div id="totalPiutang">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h3>Total Return Penjualan</h3>
                                        </td>
                                        <td>
                                            <h3></h3>
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
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class=" box-header with-border">
                <i class="fa fa-bar-chart-o"></i>
                <h3 class="box-title">@yield('page')</h3>
            </div>
            <div class="box-body">
                <a href="{{ route('transaksi.return.penjualan.create') }}" class="btn btn-primary mb-2"><i
                        class="fa fa-shopping-basket"></i> Return Penjualan</a>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" id="example-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal Return</th>
                                        <th>Faktur Return</th>
                                        <th>Faktur Penjualan</th>
                                        <th>Customer</th>
                                        <th>Return Dibayar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-info" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Return Penjualan</h4>
            </div>
            <div class="modal-body bodyModal">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-print"><i class="fa fa-print"></i>
                    Print</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-window-close"></i>
                    Tutup</button>
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
        $.fn.dataTable.ext.errMode = 'none';
        $('#example-table')
		.on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
         })
		.dataTable({
           processing:true,
		   serverSide:true,
		   ajax:"{{route('getDataReturnPenjualan')}}",
		   columns:[
		    {"data": "id",
                 render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                 }
                },
           {data:'tanggal_return_jual'},
           {data:'faktur'},
           {data:'faktur_penjualan'},
		   {data:'customer'},
		   {data:'total_bayar'},
		   {data: 'id',
            "render": function (data) {
         	 data1 = '<a href="/transaksi/penjualan/' + data + '/faktur" target="_blank" class="btn btn-sm btn-primary fa fa-print" >&nbsp;Print</a>';
			return data1;
            }
		   }
		   ]

        });
    });
</script>
@endpush
