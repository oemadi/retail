@extends('layouts.template')
@section('page','Penyesuaian Stok')
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

                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('transaksi.penyesuaianStok.create') }}" class="btn btn-primary"><i
                                class="fa fa-shopping-basket"></i> Tambah</a>
                    </div>
                </div>
                <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%"
                                    id="example-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Faktur</th>
                                            <th>Tanggal</th>
                                            <th>User</th>
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
</div>

<div id="modal-info" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Data Penyesuaian Stok</h4>
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
@push('script')
<script>
    $(document).ready(function(){
        loadDataTable();

    });
        $('#filter1').click(function(){
            $('#example-table').dataTable().fnDestroy();
            loadDataTable();
        });

        function loadDataTable(){
         var id_suplier = $("#id_suplier").val();
         var id_status = $("#status").val();

         $.fn.dataTable.ext.errMode = 'none';

       $('#example-table')

		.dataTable({
           processing:true,
		   serverSide:true,
		   ajax:{
            url: "{{route('getDataPenyesuaianStok')}}",
            type:"get"
           },
		   columns:[
		    {"data": "id",
                 render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                 }
                },
           {data:'faktur'},
		   {data:'tanggal'},
		   {data:'user'},
		   {data: 'id',
            "render": function (data) {
         	 data1 = '<a href="/report/penyesuaianStok/print?id='+ data +'"  class="btn btn-sm btn-primary fa fa-eye" >&nbsp;View</a>';
			return data1;
            }
		   }
		   ]

        });

        // if ( ! dataTablePembelian.rows().count(); ) {
        //     alert( 'Empty table' );
        // }
        }
        // $("#startdate").datepicker({
        //     todayBtn: 1,
        //     format : 'yyyy-mm-dd',
        //     autoclose: true,
        // }).on('changeDate', function (selected) {
        //     var minDate = new Date(selected.date.valueOf());
        //     $('#enddate').datepicker('setStartDate', minDate);
        // });
        // $("#enddate").datepicker({format : 'yyyy-mm-dd'}).on('changeDate', function (selected) {
        //     var maxDate = new Date(selected.date.valueOf());
        //     $('#startdate').datepicker('setEndDate', maxDate);
        // });
        // $(document).on('click','.aksi',function(){
        //     const id = $(this).data('id');
        //     let url = `{{ route('transaksi.pembelian.load_modal',':id') }}`;
        //     url = url.replace(":id",id);
        //     const parseResult = new DOMParser().parseFromString(url, "text/html");
        //     const parsedUrl = parseResult.documentElement.textContent;
        //     $('.bodyModal').load(parsedUrl);
        //     $('#modal-info').modal('show');
        // })
        // $('.btn-print').click(function(){
        //     print();
        // });
        // function print() {
        //     printJS({
        //         printable: 'printArea',
        //         type: 'html',
        //         targetStyles: ['*']
        //     })
        // }

</script>
@endpush
