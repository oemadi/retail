<div class="panel panel-default">
    <div class="panel-body">
    @include('pages/report/logo')
        <div class="row">
            <div class="col-md-12">
<p style="margin-top:60px;line-height:5px;font-weight:bold;font-size:16px;" align="left">REKAP CUSTOMER</p>
<table width="100%" class="layout">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Customer</td>
                            <td>Kontak</td>
                            <td>HP</td>
                            <td>Alamat</td>
                            <td>Hutang</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php

                        @foreach ($data as $key => $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->kontak }}</td>
                            <td>{{ $row->no_hp }}</td>
                            <td>{{ $row->alamat }}</td>
                            <td align="right">
                            <?php
                            $sisaHutang=0;
                            foreach ($row->hutangCustomer  as $dataHutang){
                             $sisaHutang += $dataHutang->sisa_hutang;
                            }

                            ?>
                              @rupiah($sisaHutang)</td>
                        </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
