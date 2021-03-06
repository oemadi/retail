<div class="col-md-12">
    <div class="box box-danger">
        <div class=" box-body">
            <div class="row">
                <div class="col-md-4">
                        <div class="form-group">
                            <label for="customer">Customer</label>
                                <select name="id_customer" id="id_customer" class="form-control select2-customer" style="width: 100%;height:auto">
                               <option value="0">--Pilih Customer--</option>
                                </select>

                        </div>
                        <div class="form-group">
                            <label for="customer">Status</label>
                                <select  id="status_lunas"  name="status_lunas" class="form-control">
                                <option value="0">Semua</option>
                                <option value="lunas">Sudah Lunas</option>
                                <option value="hutang">Belum Lunas</option>
                                </select>

                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary print"><i class="fa fa-print"></i> Print</button>

                        </div>


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

        placeholder:"Nama Customer",
        });
    })
    </script>
@endpush
