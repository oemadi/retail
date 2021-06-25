@extends('layouts.template')
@section('page','Kas')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Tanggal Awal</td>
                                    <td>
                                        <input title="tanggal transaksi" class="form-control datepicker-here"
                                            type="text" id="startdate" data-language="en" autocomplete="off"
                                            value="{{ date('Y-m-d') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Akhir</td>

                                    <td>
                                        <input title="tanggal transaksi" class="form-control datepicker-here"
                                            type="text" id="enddate" data-language="en" autocomplete="off"
                                            value="{{ date('Y-m-d') }}">
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
                    <div class="col-md-6">

                        <div id="kotak-total">
                            @include('pages.laporan.kas.kotak_total')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('transaksi.kas.create') }}" class="btn btn-primary mb-3"><i
                                class="fa fa-plus"></i>
                            Tambah Kas</a>
                        <a href="#" class="btn btn-warning mb-3" id="refresh"><i class="fa fa-refresh"></i>
                            Refresh</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                           <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" id="example-table">
							<thead>
								<tr>
									<th>#</th>
									<th>Tanggal</th>
									<th>Faktur</th>
									<th>Jenis</th>
									<th>Pendapatan</th>
									<th>Pengeluaran</th>
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
<link rel="stylesheet"
<link rel="stylesheet"
    href="{{ asset('adminlte') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@endpush
@push('script')
<script src="{{ asset('adminlte') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
</script>
</script>
<script>
    $(document).ready(function(){
		$('#example-table').DataTable().destroy();
		cekData();

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

        $('#filter1').click(function(){
				$('#example-table').DataTable().destroy();
				cekData();
				loadKotakAtas("custom",$('#startdate').val(),$('#enddate').val());
        });

		function cekData(){
		   $.fn.dataTable.ext.errMode = 'none';
		   var  awal = $('#startdate').val();
		   var  akhir = $('#enddate').val();

       $('#example-table')
		.dataTable({
           processing:true,
		   serverSide:true,
		     ajax : {
			 url:"{{route('getDataKas')}}",
			 type:"get",
			 data:{
			  awal:awal,akhir:akhir
			 }
			},

		   columns:[
           {"data": "id",
                 render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                 }
                },
		   {data:'tanggal'},
   		   {data:'faktur'},
		   {data:'jenis'},
		   {data:'pemasukan'},
		   {data:'pengeluaran'},
		   {data:'keterangan'}

		   ]
        });
		}

        function loadKotakAtas(filter,tanggal_awal="all",tanggal_akhir="all"){
           let url = `{{ url('/transaksi/kas/loadKotak?filter=`+filter+`&tanggal_awal=`+tanggal_awal+`&tanggal_akhir=`+tanggal_akhir+`') }}`;
            const parseResult = new DOMParser().parseFromString(url, "text/html");
            const parsedUrl = parseResult.documentElement.textContent;
            $('#kotak-total').load(parsedUrl);
        }
        $("#refresh").click(function(){
            loadTable("all");
            loadKotakAtas("all")
        });
    });
</script>
@endpush
