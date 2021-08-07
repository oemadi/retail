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
                <div class="col-md-12">
                    <div class=" box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="id_suplier" id="id_suplier" class="form-control select2-suplier" style="width: 100%;height:auto">
                                                </select>
                                            </td>
                                            <td>
                                                <select id="status" class="form-control">
                                                    <option value="all">Semua Status</option>
                                                    <option value="lunas">lunas</option>
                                                    <option value="hutang">belum lunas</option>
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
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    {{-- No.bayar_hutang	Suplier	ID Pembelian	Tanggal	Jumlah Bayar	Sisa Hutang	Aks? --}}
                                    <th>#</th>
                                    <th>Suplier</th>
                                    <th>Faktur Pembelian</th>
                                    <th>Hutang</th>
                                    <th>Pembayaran</th>
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
    $(document).ready(function(){
    //    / alert();
        loadDataTable();
        $(".select2-suplier").select2({
        ajax: {
        url: "{{ route('getDataSuplierSelect') }}",
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
        placeholder:"Nama Suplier",
        });

        $('#filter1').click(function(){
            $('#example-table').dataTable().fnDestroy();
            loadDataTable();
        });
    });
    function loadDataTable(){
        var id_suplier = $("#id_suplier").val();
        var id_status = $("#status").val();
        $.fn.dataTable.ext.errMode = 'none';
        $('#example-table')
		.on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
        } )
		.dataTable({
           processing:true,
		   serverSide:true,
		   ajax:{
               url:"{{route('getHutangSuplier')}}",
               type:"get",
               data:{id_suplier:id_suplier,id_status:id_status,_token: '{{csrf_token()}}'}
           },
		   columns:[
           {"data": "id",
                 render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                 }
           },
           {data:'suplier'},
           {data:'faktur_pembelian'},
           {data:'total_hutang'},
           {data:'total_pembayaran_hutang'},
           {data:'sisa_hutang'},
           {data: 'pembelian_id',
            "render": function (data) {
            data1 = '<a href="/transaksi/bayarSuplier/' + data + '/show" class="btn btn-sm btn-warning">View</a>';
			return data1;
            }
           }
		   ]
        });
    }
</script>
@endpush
  {{-- No.bayar_hutang	Suplier	ID Pembelian	Tanggal	Jumlah Bayar	Sisa Hutang	Aks? --}}
