@extends('layouts.template')
@section('page','Kas')
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
                                                <td>Tanggal Awal</td>
                                                <td>
                                                    <input title="tanggal transaksi" class="form-control datepicker-here"
                                                        type="text" id="startdate" data-language="en" autocomplete="off"
                                                        value="{{ date('d-m-Y') }}">
                                                </td>
                                                <td>Tanggal Akhir</td>
                                                <td>
                                                    <input title="tanggal transaksi" class="form-control datepicker-here"
                                                        type="text" id="enddate" data-language="en" autocomplete="off"
                                                        value="{{ date('d-m-Y') }}">
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
        $('#example-table').dataTable();
        $("#startdate").datepicker({
            todayBtn: 1,
            format : 'dd-mm-yyyy',
            autoclose: true,
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#enddate').datepicker('setStartDate', minDate);
        });
        $("#enddate").datepicker({format : 'dd-mm-yyyy'}).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', maxDate);
        });

        $('.print').click(function(){

            tanggal_awal = $('#startdate').val();
            tanggal_akhir = $('#enddate').val();


            let url = `{{ url('report/kas/print?tanggal_awal=${tanggal_awal}&tanggal_akhir=${tanggal_akhir}') }}`;
            const parseResult = new DOMParser().parseFromString(url, "text/html");
            const parsedUrl = parseResult.documentElement.textContent;
            window.open(parsedUrl,'_blank');
        });

    });
</script>
@endpush
