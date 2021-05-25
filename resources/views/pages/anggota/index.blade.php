@extends('layouts.template')
@section('page','anggota')
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
                <a href=" {{ route('anggota.create') }}" class="btn btn-primary mb-2"><i class="fa fa-plus"></i>
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
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No Hp</th>
                                        <th>Email</th>
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

@endsection
@push('style')
<link rel="stylesheet"
    href="{{ asset('adminlte') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endpush
@push('script')
<script src="{{ asset('adminlte') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('adminlte') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js">
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
		   ajax:"{{route('getDataAnggota')}}",
		   columns:[
		   {data:'id'},
		   {data:'nama'},
		   {data:'alamat'},
		   {data:'no_hp'},
		   {data:'email'},
		   {data: 'id',
            "render": function (data) {
            data1 = '<a href="/anggota/' + data + '/edit" class="btn btn-sm btn-warning">Edit</a>';
			 data2 = '<a href="/anggota/' + data + '/delete" class="btn btn-sm btn-danger" onclick="javascript:return confirm(\'Anda yakin?\');">Delete</a>';
			return data1+' '+data2;
            }
		   }
		   ]
        });
    });
</script>
@endpush
