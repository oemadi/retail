@extends('layouts.template')
@section('page','Jabatan Pegawai')
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
                        @if (Session::has('status'))
                        <div class="alert alert-{{ Session::get('status') }}" role="alert">{{ Session::get('message') }}
                        </div>
                        @endif
                    </div>
                </div>
                <a href="{{ route('jabatan.create') }}" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Tambah
                    Data</a>
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Jabatan</th>
                                    <th>Gaji Pokok</th>
                                    <th>Lain - Lain</th>
                                    <th>Deskripsi</th>
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
@endsection
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
		   ajax:"{{route('getDataJabatan')}}",
		   columns:[
		   {data:'id'},
		   {data:'nama'},
   		   {data:'gaji_pokok'},
		   {data:'lain_lain'},
		   {data:'deskripsi'},
		   {data: 'id',
            "render": function (data) {
            data1 = '<a href="/jabatan/' + data + '/edit" class="btn btn-sm btn-warning">Edit</a>';
			 data2 = '<a href="/jabatan/' + data + '/delete" class="btn btn-sm btn-danger" onclick="javascript:return confirm(\'Anda yakin?\');">Delete</a>';
			return data1+' '+data2;
            }
		   }
		   ]
        });
    });
</script>
@endpush