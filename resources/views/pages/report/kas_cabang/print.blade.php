<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan</title>
    <link rel="stylesheet" href="{{ asset('adminlte') }}/bower_components/bootstrap/dist/css/bootstrap.css">

</head>


<body>
    <div class="containter">
      @include('pages/report/logo')
        <div class="row">
            <div class="col-md-12">
<p style="margin-top:60px;line-height:5px;font-weight:bold;font-size:16px;" align="left">REKAP KAS PER CABANG</p>
<p>Periode : <?= request()->get('tanggal_awal').' s/d '.request()->get('tanggal_akhir');?></p>
<table width="100%" class="layout">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Tanggal</td>
                            <td>Faktur</td>
                            <td>Jenis</td>
                            <td>Pendapatan</td>
                            <td>Pengeluaran</td>
                            <td>Keterangan</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $pemasukan =0 ;
                        $pengeluaran =0;
                        @endphp
                        @foreach ($kas as $key => $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ tanggal_indo($row->tanggal) }}</td>
                            <td>{{ $row->faktur }}</td>
                            <td>{{ $row->jenis }}</td>
                            <td align="right"><?php echo format_angka($row->pemasukan);?></td>
                            <td align="right"><?php echo format_angka($row->pengeluaran);?></td>
                            <td>{{ $row->keterangan }}</td>
                        </tr>
                        @php
                        $pemasukan +=$row->pemasukan;
                        $pengeluaran +=$row->pengeluaran;
                        @endphp
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <td colspan="6">
                                <center><b>Total Pemasukan</b></center>
                            </td>
                            <td><b id="pdpt">@rupiah($pemasukan)</b></td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <center><b>Total Pengeluaran</b></center>
                            </td>
                            <td><b id="pgl">@rupiah($pengeluaran)</b></td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <center><b>Total Saldo</b></center>
                            </td>
                            <td><b id="sld">@rupiah($pemasukan - $pengeluaran)</b></td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('adminlte') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('adminlte') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#spdpt').html($('#pdpt').html());
            $('#spgl').html($('#pgl').html());
            $('#ssld').html($('#sld').html());
            window.print();
        });
    </script>
</body>

</html>
