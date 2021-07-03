@extends('layouts.template')
@section('page','Penggajian')
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
                <a href="{{ route('transaksi.penggajian.create') }}" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Tambah
                    Data</a>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Gaji</th>
                                    <th>Faktur</th>
                                    <th>Nama</th>
                                    <th>Total Gaji</th>
                                    <th>Potongan</th>
                                    <th>Gaji Bersih</th>
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
           searching:true,
		   ajax:{
               url:"{{route('getDataPenggajian')}}",
               type:"get"
           },
		   columns:[
            {"data": "id",
                 render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                 }
                },
		   {data:'tanggal_gaji'},
           {data:'faktur'},
           {data:'nama'},
           {data:'total_gaji'},
           {data:'potongan'},
           {data:'gaji_bersih'}
		   ]
        });
    });
</script>
@endpush
