<div class="col-md-12">
    <div class="box box-danger">
        <div class=" box-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <tbody>
						  <tr>
                           <td>Cabang</td>
                                <td>
                                    <div class="form-group">
											<select  name="id_cabang" id="id_cabang" class="form-control select2-cabang" style="width: 100%;height:auto">
										   <option value="0">--Pilih Cabang--</option>
											</select>

									</div>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Awal</td>
                                <td>
                                    <input title="tanggal transaksi" class="form-control datepicker-here" type="text"
                                        id="startdate" data-language="en" autocomplete="off"
                                        value="{{ date('d-m-Y') }}">
                                </td>
                                <td>
                                    <select id="status" class="form-control">
                                        <option value="0">Semua Transaksi</option>
                                        <option value="tunai">Tunai</option>
                                        <option value="hutang">Hutang</option>
                                        <option value="lunas">Lunas</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Akhir</td>

                                <td>
                                    <input title="tanggal transaksi" class="form-control datepicker-here" type="text"
                                        id="enddate" data-language="en" autocomplete="off" value="{{ date('d-m-Y') }}">
                                </td>

                                {{-- <td>
                                    <a href="#" class="btn btn-success" style="width:100%" id="filter1"><i
                                            class="fa fa-search"></i>
                                        Filter</a>
                                </td> --}}
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
@push('script')
<script type="text/javascript">
    $(function() {

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
    })
    </script>
@endpush
