@extends('layouts.template')
@section('page','Kas Per Cabang')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class=" box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <tbody>
										  <tr>
										   <td>Cabang</td>
												<td>
													<div class="form-group">
															<select name="id_cabang" id="id_cabang" class="form-control select2-cabang" style="width: 100%;height:auto">
														   <option></option>
															</select>

													</div>
												</td>
											</tr>
                                            <tr>
                                                <td>Tanggal Awal</td>
                                                <td>
                                                    <input title="tanggal transaksi" class="form-control datepicker-here"
                                                        type="text" id="startdate" data-language="en" autocomplete="off"
                                                        value="{{ date('Y-m-d') }}">
                                                </td>
                                                <td>Tanggal Akhir</td>
                                                <td>
                                                    <input title="tanggal transaksi" class="form-control datepicker-here"
                                                        type="text" id="enddate" data-language="en" autocomplete="off"
                                                        value="{{ date('Y-m-d') }}">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                   <button class="btn btn-primary print"><i class="fa fa-print"></i> Print</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('script')
<script>
    $(document).ready(function(){
		
        $(".select2-cabang").select2({
        ajax: {
        url: "{{ route('getDataCabangSelect') }}",
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

        placeholder:"Nama Cabang",
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

        $('.print').click(function(){

            tanggal_awal = $('#startdate').val();
            tanggal_akhir = $('#enddate').val();
			cabang = $('#id_cabang').val();

            let url = `{{ url('report/kasCabang/print?cabang=`+ cabang +`&tanggal_awal=${tanggal_awal}&tanggal_akhir=${tanggal_akhir}') }}`;
            const parseResult = new DOMParser().parseFromString(url, "text/html");
            const parsedUrl = parseResult.documentElement.textContent;
            window.open(parsedUrl,'_blank');
        });

    });
</script>
@endpush
