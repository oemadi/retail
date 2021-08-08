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
		<p style="margin-top:60px;line-height:5px;font-weight:bold;font-size:16px;" align="left">REKAP PENGGAJIAN KARYAWAN</p>
 <p>Periode : {{ request()->get('bulan') }} -  {{ request()->get('tahun') }}</p>
        <div class="row">
            <div class="col-md-12">
                <table width="100%" class="layout">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pegawai</th>
                            <th>Gaji Bulan</th>
                            <th>Tanggal</th>
                            <th>Faktur</th>
                            <th>Gaji </th>
                            <th>Potongan Gaji</th>
                            <th>Gaji Bersih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $total=0;
                        @endphp
                        @foreach ($penggajian as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->pegawai->nama }}</td>
                            <td>{{ Carbon\Carbon::parse($item->tanggal_gaji)->format('M-Y') }}</td>
                            <td>{{ $item->tanggal_gaji }}</td>
                            <td>{{ $item->faktur }}</td>
                            <td align="right">@rupiah($item->pegawai->gaji)</td>
                            <td align="right">@rupiah($item->potongan)</td>
                            <td align="right">@rupiah($item->gaji_bersih)</td>
                        </tr>
                        @php
                        $total += $item->gaji_bersih;
                        @endphp
                        @endforeach
                    </tbody>
                    <thead>
                        <td colspan="7">
                            <center><b>Total Gaji</b></center>
                        </td>
                        <td align="right" id="ttlpgj">@rupiah($total)</td>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('adminlte') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('adminlte') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#sttlpgj').html($('#ttlpgj').html());
            window.print();
        });
    </script>
</body>

</html>
