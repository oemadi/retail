@extends('layouts.template')
@section('page','Hutang Customer')
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
                                                <select name="id_customer" id="id_customer" class="form-control select2-customer" style="width: 100%;height:auto">
                                                </select>
                                            </td>
                                            <td>
                                                <select id="status" class="form-control">
                                                    <option value="all">Semua Transaksi</option>
                                                    <option value="tunai">tunai</option>
                                                    <option value="hutang">hutang</option>
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
                                    {{-- No.bayar_hutang	customer	ID Pembelian	Tanggal	Jumlah Bayar	Sisa Hutang	Aks? --}}
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Faktur Penjualan</th>
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
       $(document).ready(function(){

        loadDataTable();
        $(".select2-customer").select2({
        ajax: {
        url: "{{ route('getDataCustomerSelect') }}",
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
        placeholder:"Nama customer",
        });

        $('#filter1').click(function(){
            $('#example-table').dataTable().fnDestroy();
            loadDataTable();
        });

    });

    function loadDataTable(){
        var id_customer = $("#id_customer").val();
         var id_status = $("#status").val();
		$.fn.dataTable.ext.errMode = 'none';
        $('#example-table')
		.on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
        })
		.dataTable({
           processing:true,
		   serverSide:true,
		   ajax:{
               url:"{{route('getHutangCustomer')}}",
               type:"get",
               data:{id_customer:id_customer,id_status:id_status,_token: '{{csrf_token()}}'}
           },
		   columns:[
           {"data": "id",
                 render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                 }
           },
           {data:'customer'},
           {data:'faktur_penjualan'},
           {data:'total_hutang'},
           {data:'total_pembayaran_hutang'},
           {data:'sisa_hutang'},
           {data: 'penjualan_id',
            "render": function (data) {
            data1 = '<a href="/transaksi/bayarCustomer/' + data + '/show" class="btn btn-sm btn-warning">View</a>';
			return data1;
            }
           }
		   ]
        });
    }
</script>
@endpush
  {{-- No.bayar_hutang	customer	ID Pembelian	Tanggal	Jumlah Bayar	Sisa Hutang	Aks? --}}
