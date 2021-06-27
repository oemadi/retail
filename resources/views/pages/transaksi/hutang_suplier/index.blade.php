@extends('layouts.template')
@section('page','Hutang Suplier')
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

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    {{-- No.bayar_hutang	Suplier	ID Pembelian	Tanggal	Jumlah Bayar	Sisa Hutang	Aks? --}}
                                    <th>#</th>
                                    <th>Suplier</th>
                                    <th>Total Hutang</th>
                                    <th>Total Pembayaran</th>
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
		   ajax:"{{route('getHutangSuplier')}}",
		   columns:[
           {"data": "id",
                 render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                 }
           },
           {data:'suplier'},
           {data:'total_hutang'},
           {data:'total_pembayaran_hutang'},
           {data:'sisa_hutang'},
           {data: 'suplier_id',
            "render": function (data) {
            data1 = '<a href="/transaksi/bayarSuplier/' + data + '/show" class="btn btn-sm btn-warning">View</a>';
			return data1;
            }
           }
		   ]
        });
    });
</script>
@endpush
  {{-- No.bayar_hutang	Suplier	ID Pembelian	Tanggal	Jumlah Bayar	Sisa Hutang	Aks? --}}
