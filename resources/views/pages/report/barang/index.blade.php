@extends('layouts.template')
@section('page','Rekap Barang')
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

        $('.print').click(function(){


            let url = '{{ url("report/barang/print") }}';
            const parseResult = new DOMParser().parseFromString(url, "text/html");
            const parsedUrl = parseResult.documentElement.textContent;
            window.open(parsedUrl,'_blank');
        });

    });
</script>
@endpush
