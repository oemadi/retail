<div class="col-md-12">
    <div class="box box-danger">
        <div class=" box-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="20%">Tanggal Awal</td>
                                <td>
                                    <input title="tanggal transaksi" class="form-control datepicker-here" type="text"
                                        id="startdate" data-language="en" autocomplete="off"
                                        value="{{ date('d-m-Y') }}">
                                </td>
                               <td width="20%">Tanggal Akhir</td>

                                <td>
                                    <input title="tanggal transaksi" class="form-control datepicker-here" type="text"
                                        id="enddate" data-language="en" autocomplete="off" value="{{ date('d-m-Y') }}">
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
                {{-- <div class="col-md-6">
                    <div id="totalPiutang">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <h3>Total Pembelian</h3>
                                    </td>
                                    <td>
                                        <h3>@rupiah($total)</h3>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
