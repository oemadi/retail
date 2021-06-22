@extends('layouts.template')
@section('page','Stok Masuk')
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
                        @if (Session::get('status'))
                        <div class="alert alert-{{ Session::get('status') }}">
                            {{Session::get('message')}}</div>
                        @endif
                    </div>
                </div>
                <a href="{{ route('barang.masuk.create') }}" class="btn btn-primary mb-2"><i class="fa fa-plus"></i>
                    Tambah
                    Data</a>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%"
                                id="example-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Barcode</th>
                                        <th>Nama Barang</th>
                                        <th>Stok Masuk</th>
                                        <th>Tanggal</th>
                                        <th>Suplier</th>
                                        <th>Keterangan</th>
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


@endsection
@push('style')
@endpush
@push('script')
</script>
<!-- SlimScroll -->
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
		   ajax:"{{route('getDataStokMasuk')}}",
		   columns:[
		   {data:'id'},
		   {data:'barang_id'},
		   {data:'nama'},
   		   {data:'qty'},
		   {data:'tgl'},
		   {data:'suplier'},
		   {data:'keterangan'}
		   ]
        });
    });
</script>
@endpush