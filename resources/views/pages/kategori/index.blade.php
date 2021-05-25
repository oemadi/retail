@extends('layouts.template')
@section('page','Kategori Barang')
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
                <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Tambah
                    Data</a>
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategori as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->nama }}</td>
                                    <td>
                                        <a href="{{ route("kategori.edit",$row->id) }}"
                                            class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="{{ route("kategori.destroy",$row->id) }}"
                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>

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
@endsection
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
		   ajax:"{{route('getDataKategori')}}",
		   columns:[
		   {data:'id'},
		   {data:'nama'},
		   {data: 'id',
            "render": function (data) {
            data1 = '<a href="/kategori/' + data + '/edit" class="btn btn-sm btn-warning">Edit</a>';
			 data2 = '<a href="/kategori/' + data + '/delete" class="btn btn-sm btn-danger" onclick="javascript:return confirm(\'Anda yakin?\');">Delete</a>';
			return data1+' '+data2;
            }
		   }
		   ]
        });
    });
</script>
@endpush