<style type="text/css">

.tbl {
	color: #333;
	border: 1px solid #666;

}

.tbl th{
	color: #333;


}

.tbl td {
	color: #333;
	border-top: 1px solid #666;



}


</style>
<div class="panel panel-default">
<div class="panel-body">


	<div class="row">
	<div style="float:left;width:30%" >
     {{-- <img  style="float:left;width:50%;" src="<?php echo base_url().'assets/';?>ayam.jpg" > --}}
	</div>

	<div style="float:right;width:70%;valign:middle" >
	<p style=";line-height:5px;font-weight:bold;font-size:18px;" align="left">CV. FERYPUTRA</p>
	<p style="line-height:5px;font-weight:bold;font-size:18px;" align="left">TAGIHAN CUSTOMER</p>
	</div>
	</div>
	<br>

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



<p>CUSTOMER : <?= $cus->nama;?></p>
  <table width="100%" class="layout">
    <thead>
        <tr>
            <td>No.</td>
            <td>Faktur Penjualan</td>
			<td>Tanggal</td>
			<td>Jumlah Transaksi</td>
			<td align="right">Jumlah Bayar</td>
			<td align="right">Sisa Tagihan</td>

        </tr>
    </thead>
    <?php
	$no=0;
    $total_tagihan=0;
	 foreach($data as $row ): $no++;
	 ?>
    <tr>
        <td><?php echo $no;?></td>
		<td><?php echo $row->faktur;?></td>
		<td><?php echo $row->tanggal_penjualan;?></td>
		<td align="right"><?php echo number_format($row->total,0,',','.') ;?></td>
        <?php
        $jumlah_bayar=0;
        foreach($row->BayarHutangCustomer as $d ){
           $jumlah_bayar+= $d->jumlah_bayar;
        }
        $total_tagihan+=$row->total-$jumlah_bayar;
        ?>
        <td align="right"><?php echo number_format($jumlah_bayar,0,',','.');?></td>
        <td align="right"><?php echo number_format($row->total-$jumlah_bayar,0,',','.');?></td>
    </tr>
    <?php endforeach;?>
	   <tr>
        <td align="center" colspan="5">Total</td>
		<td align="right"><?php echo number_format($total_tagihan,0,',','.');?></td>

    </tr>
</table>
	 <section class="sheet padding-10mm">

    </section>
</div>
</div>
