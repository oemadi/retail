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
	<p style="line-height:5px;font-weight:bold;font-size:18px;" align="left">REKAP KAS KELUAR</p>
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
            <td>Keterangan</td>
			<td>Tanggal</td>
			<td align="right">Jumlah Bayar</td>
		</tr>
    </thead>
    <?php
	$no=0;
	$kas_keluar = $this->db->query("select a.*
		from kas_keluar a 
		WHERE DATE_FORMAT(a.tanggal,'%Y/%m/%d') BETWEEN '".$tglawal."' and '".$tglakhir."'
		")->result();	
		$total=0;
	 foreach($kas_keluar as $row ): $no++;
	 $total=$total+$row->jumlah;
	 ?>
    <tr>
        <td><?php echo $no;?></td>
		<td><?php echo $row->nama;?></td>
		<td><?php echo date("d-m-Y",strtotime($row->tanggal));?></td>
		<td align="right"><?php echo number_format($row->jumlah,0,',','.');?></td>
    </tr>
    <?php endforeach;?>
	   <tr>
        <td align="center" colspan="3">Total</td>
		<td align="right"><?php echo number_format($total,0,',','.');?></td>
		
    </tr>
</table>
	 <section class="sheet padding-10mm">

    </section>
</div>
</div>
