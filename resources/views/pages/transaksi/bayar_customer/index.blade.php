@extends('layouts.template')
@section('page','bayarCustomer')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class=" box-header with-border">
                <i class="fa fa-bar-chart-o"></i>
                <h3 class="box-title">@yield('page')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        @if (Session::has('status'))
                        <div class="alert alert-{{ Session::get('status') }}" role="alert">{{ Session::get('message') }}
                        </div>
                        @endif
                    </div>
                </div>
                <a href="{{ route('transaksi.bayarCustomer.create') }}" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Tambah
                    Data</a>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    {{-- No.bayar_hutang	Suplier	ID Pembelian	Tanggal	Jumlah Bayar	Sisa Hutang	Aks? --}}
                                    <th>#</th>
                                    <th>No.Bayar</th>
                                    <th>Customer</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Faktur Penjualan</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Sisa Hutang</th>
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
@endsection
@push('script')

<script type="text/javascript">
    $(function() {
		$.fn.dataTable.ext.errMode = 'none';
        $('#example-table')
		.on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
    } )
		.dataTable({
           processing:true,
		   serverSide:true,
		   ajax:"{{route('getDataBayarCustomer')}}",
		   columns:[
           {"data": "id",
                 render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                 }
           },
		   {data:'id_bayar_hutang_customer'},
           {data:'customer'},
           {data:'tanggal_bayar'},
           {data:'faktur_penjualan'},
           {data:'jumlah_bayar'},
           {data:'sisa_hutang'}
		   ]
        });
    });
</script>
@endpush
  {{-- No.bayar_hutang	Suplier	ID Pembelian	Tanggal	Jumlah Bayar	Sisa Hutang	Aks? --}}
