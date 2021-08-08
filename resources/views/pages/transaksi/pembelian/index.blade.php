@extends('layouts.template')
@section('page','Pembelian')
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
                    <div class="col-md-4">
                        <a href="{{ route('transaksi.pembelian.create') }}" class="btn btn-primary"><i
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
                                            <th>No.Pembelian</th>
                                            <th>Suplier</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th></th>
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
                <h4 class="modal-title">Data Pembelian</h4>
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


        $("#startdate").datepicker({
            todayBtn: 1,
            format : 'yyyy-mm-dd',
            autoclose: true,
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#enddate').datepicker('setStartDate', minDate);
        });
        $("#enddate").datepicker({format : 'yyyy-mm-dd'}).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', maxDate);
        });
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
            url: "{{route('getDataPembelian')}}",
            type:"get",
            data:{id_suplier:id_suplier,id_status:id_status,_token: '{{csrf_token()}}'}
           },
		   columns:[
		    {"data": "id",
                 render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                 }
                },
           {data:'faktur'},
           {data:'suplier'},
		   {data:'tanggal_pembelian'},
		   {data:'total'},
           {data:'status'},
		    {data: 'id',
             "render": function (data) {
          	 data1 = '<a href="/transaksi/pembelian/' + data + '/faktur"  class="btn btn-sm btn-primary fa fa-print" >&nbsp;Print</a>';
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
