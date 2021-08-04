<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan</title>
    <link rel="stylesheet" href="{{ asset('adminlte') }}/bower_components/bootstrap/dist/css/bootstrap.css">
    <style>
        table {
         font-family: sans-serif;
         border: 7mm solid aqua;
         border-collapse: collapse;
        }
        table.table2 {
         border: 2mm solid aqua;
         border-collapse: collapse;
        }
        table.layout {
         border: 0mm solid black;
         border-collapse: collapse;
        }
        td.layout {
         text-align: center;
         border: 0mm solid black;
        }
        td {
         padding: 2mm;
         border: 0.2mm solid gray;
         vertical-align: middle;
        }
        td.redcell {
         border: 0mm solid red;
        }
        td.redcell2 {
         border: 0mm solid red;
        }

        /* DivTable.com */
        .divTable{
            display: table;
            width: 100%;
        }
        .divTableRow {
            display: table-row;
        }
        .divTableHeading {
            background-color: #EEE;
            display: table-header-group;
        }
        .divTableCell, .divTableHead {
            border: 1px solid #999999;
            display: table-cell;
            padding: 3px 10px;
        }
        .divTableHeading {
            background-color: #EEE;
            display: table-header-group;
            font-weight: bold;
        }
        .divTableFoot {
            background-color: #EEE;
            display: table-footer-group;
            font-weight: bold;
        }
        .divTableBody {
            display: table-row-group;
        }
        </style>
</head>


<body>
    <div class="containter">
        <div class="row">
            <div class="col-md-12">
                {{-- @include('pages.report.nama_toko') --}}
            </div>
        </div>
        <div class="row">
            <div style="float:left;width:30%" >
             {{-- <img  style="float:left;width:50%;" src="<?php echo base_url().'assets/';?>ayam.jpg" > --}}
            </div>

            <div style="float:right;width:70%;valign:middle" >
            <p style=";line-height:5px;font-weight:bold;font-size:18px;" align="left">CV. FERYPUTRA</p>
            <p style="line-height:5px;font-weight:bold;font-size:18px;" align="left">REKAP SALDO</p>
            </div>
            </div>
            <br>
        <div class="row">
            <div class="col-md-12">

<p>Periode : <?= request()->get('tanggal_awal').' s/d '.request()->get('tanggal_akhir');?></p>
<table width="100%" class="layout">
                    <thead>
                        <tr>
                            <th>Penjualan</th>
                            <th>Modal</th>
                            <th>Keuntungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $modal =0 ;
                        $penjualan =0;


                        foreach ($saldo as  $row){
                          foreach($row->detail_penjualan as $detail ){

                                $modal += ($detail->barang->harga_beli)*$detail->jumlah_jual;
                                $penjualan += $detail->harga*$detail->jumlah_jual;
                                }

                             ?>

                        <?php } ?>
                        <tr>
                            <td>@rupiah($penjualan)</td>
                            <td>@rupiah($modal)</td>
                            <td>@rupiah($penjualan-$modal)</td>
                        </tr>
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
        $(document).ready(function(){
            $('#spdpt').html($('#pdpt').html());
            $('#spgl').html($('#pgl').html());
            $('#ssld').html($('#sld').html());
            window.print();
        });
    </script>
</body>

</html>
