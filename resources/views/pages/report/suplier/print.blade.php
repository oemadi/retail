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
        <div class="row">
               @include('pages/report/logo')

        <div class="row">
            <div class="col-md-12">
<p style="margin-top:60px;line-height:5px;font-weight:bold;font-size:16px;" align="left">REKAP SUPLIER</p>
<table width="100%" class="layout">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Suplier</th>
                            <th>Kontak</th>
                            <th>HP</th>
                            <th>Alamat</th>
							<th>Email</th>
                            <th>Piutang</th>
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
							<td>{{ $row->email }}</td>
                            <td align="right">
                            <?php
                            $sisaHutang=0;
                            foreach ($row->hutangSuplier  as $dataHutang){
                             $sisaHutang += $dataHutang->sisa_hutang;
                            }
                           
                            ?>
                              @rupiah($sisaHutang)</td>
                        </tr>

                        @endforeach
                    </tbody>
                    <thead>

                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('adminlte') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('adminlte') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>

    </script>
</body>

</html>
