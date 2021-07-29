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
    <img  style="float:left;width:50%;" src="<?php echo base_url().'assets/';?>ayam.jpg" >
	</div>
	
	<div style="float:right;width:70%;valign:middle" >
	<p style=";line-height:5px;font-weight:bold;font-size:18px;" align="left">CV. FERYPUTRA</p>
	<p style="line-height:5px;font-weight:bold;font-size:18px;" align="left">DAFTAR TAGIHAN KE CUSTOMER</p>
	</div>
	</div>
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
<p>
<div style="float:left;width:60%">
<p>Customer : <?= $data->customer;?></p>
<p>Alamat : <?= $data->alamat;?></p>
<p>Kontak : <?= $data->kontak;?></p>
<p>HP : <?= $data->hp;?></p>
<p>Status : <?php if($status_lunas==1){ echo "Sudah Lunas"; }elseif($status_lunas==2){ echo "Belum Lunas";}else{ echo "Semua";} ?></p>
</div>
<div style="float:left;width:30%">

</div>
 </p>
  
  <table width="100%" class="layout">
  
    <thead>
        <tr>
            <td>No.</td>
            <td>ID Penjualan</td>
			<td>Tanggal</td>
			<td align="right">Jumlah <br> Transaksi</td>
			<td align="right">Hutang</td>
			<td>Jumlah <br> Bayar</td>
		    <td align="right">Sisa <br> Tagihan</td>
	 </tr>
    </thead>
	
      <?php
	    $no=0;


		
		$total_transaksi=0;
		$sisa_hutang=0;
	    $total_bayar=0;
		$total_sisa=0;
	 foreach($data2 as $row ): $no++;
	 
	 $total_transaksi = $total_transaksi+$row->total;
	 $sisa_hutang = $sisa_hutang+$row->hutang;
	 $total_bayar = $total_bayar+$row->total_bayar;
	 //$total_sisa = $total_sisa+($row->total-($row->hutang-$row->total_bayar));
	 
	 ?>
    <tr>
        <td><?php echo $no;?></td>
		<td><?php echo $row->id_penjualan;?></td>
		<td> <?= date("d-m-Y",strtotime($row->tanggal));?></td>
		<td align="right"><?php echo number_format($row->total,0,',','.');?></td>
		<td align="right"><?php echo number_format($row->hutang,0,',','.');?></td>
		<td align="right"><?php echo number_format($row->total_bayar,0,',','.');?></td>
		<td align="right"><?php
		if($row->hutang>0){
			if(($row->total-$row->total_bayar) >= 0){
		       echo number_format(round($row->total-($row->cash+$row->total_bayar)),0,',','.');
			   $total_sisa = $total_sisa+round($row->total-($row->cash+$row->total_bayar));
			}else{
				echo 0;
			}
		}else{
		echo 0;
		}
		?></td>
      </tr>
    <?php endforeach;?>
	 <tr>
        <td align="center" colspan="3">Total</td>
		<td align="right"><?php echo number_format($total_transaksi,0,',','.');?></td>
		<td align="right"><?php echo number_format($sisa_hutang,0,',','.');?></td>
		<td align="right"><?php echo number_format($total_bayar,0,',','.');?></td>
		<td align="right"><?php echo number_format($total_sisa,0,',','.');?></td>
		
    </tr>
</table>
	 <section class="sheet padding-10mm">

    </section>
</div>
</div>
