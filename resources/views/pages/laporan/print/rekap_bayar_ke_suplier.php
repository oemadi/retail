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
	<p style="line-height:5px;font-weight:bold;font-size:18px;" align="left">REKAP PEMBAYARAN KE SUPLIER AYAM</p>
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
		<?php
			
		$tglawal=date("Y/m/d",strtotime($tgl1));
		$tglakhir=date("Y/m/d",strtotime($tgl2));
		
		$tglawal_indo=date("d-m-Y",strtotime($tgl1));
		$tglakhir_indo=date("d-m-Y",strtotime($tgl2));
		?>


<p>Periode : <?= $tglawal_indo.' s/d '.$tglakhir_indo;?></p>
  <table width="100%" class="layout">
    <thead>
        <tr>
            <td>No.</td>
            <td>ID Bayar</td>
			<td>Suplier</td>
			<td>ID Pembelian</td>
			<td>Tanggal Bayar</td>
			<td align="right">Jumlah Bayar</td>
			<td align="right">Sisa Hutang</td>
		
        </tr>
    </thead>
    <?php
	$no=0;
	$bayar_hutang = $this->db->query("select a.*,b.suplier,c.id_pembelian id_beli 
		from bayar_hutang a 
		inner join suplier b on a.id_suplier=b.id 
		inner join pembelian c on a.id_pembelian=c.id 
		 WHERE DATE_FORMAT(a.tanggal_bayar,'%Y/%m/%d') BETWEEN '".$tglawal."' and '".$tglakhir."'
		")->result();	
		$total_jumlah_bayar=0;
		$total_sisa_hutang=0;
	 foreach($bayar_hutang as $row ): $no++;
	 $total_jumlah_bayar=$total_jumlah_bayar+$row->jumlah_bayar;
	 $total_sisa_hutang=$total_sisa_hutang+$row->sisa_hutang;
	 ?>
    <tr>
        <td><?php echo $no;?></td>
		<td><?php echo $row->id_bayar_hutang;?></td>
		<td><?php echo $row->suplier;?></td>
		<td><?php echo $row->id_beli;?></td>
		<td><?php echo $row->tanggal_bayar;?></td>
		<td align="right"><?php echo number_format($row->jumlah_bayar,0,',','.');?></td>
		<td align="right"><?php echo number_format($row->sisa_hutang,0,',','.');?></td>
    </tr>
    <?php endforeach;?>
	   <tr>
        <td align="center" colspan="5">Total</td>
		<td align="right"><?php echo number_format($total_jumlah_bayar,0,',','.');?></td>
		
    </tr>
</table>
	 <section class="sheet padding-10mm">

    </section>
</div>
</div>
