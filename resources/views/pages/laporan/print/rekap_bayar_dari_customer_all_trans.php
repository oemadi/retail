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
	<p style="line-height:5px;font-weight:bold;font-size:18px;" align="left">DAFTAR PEMBAYARAN DARI CUSTOMER</p>
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
			<td>Customer</td>
			<td align="right">Jumlah Bayar</td>
			<td align="right">Sisa Hutang</td>
	 </tr>
    </thead>
      <?php
	$no=0;
	 $bayar_hutang_customer = $this->db->query("select a.*,b.customer,
		c.id_penjualan id_jual from bayar_hutang_customer a 
		inner join customer b on a.id_customer=b.id 
		inner join penjualan c on a.id_penjualan=c.id
		
		")->result();	
		
		$total_jumlah_bayar=0;
		$total_sisa_hutang=0;
	
	 
	 
	 foreach($bayar_hutang_customer as $row ): $no++;
	 
	 $total_jumlah_bayar=$total_jumlah_bayar+$row->jumlah_bayar;
	 $total_sisa_hutang=$total_sisa_hutang+$row->sisa_hutang;
	 ?>
    <tr>
        <td><?php echo $no;?></td>
		<td><?php echo $row->customer;?></td>
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
