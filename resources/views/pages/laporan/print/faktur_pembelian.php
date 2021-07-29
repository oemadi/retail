
<div class="panel panel-default">
<div class="panel-body">
  
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
	
 <style>
 * {
  box-sizing: border-box;
}

.box1 {
  float: left;
  width: 20%;
 
}
.box2 {
  float: left;
  width: 50%;
 
}
.box3 {
  float: left;
  width: 30%;
  paading-top:20px;
 
}
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}


  </style>	

<br>

  <div class="clearfix">
  <div class="box1" >
    <img  style="width:70%" src="<?php echo base_url().'assets/';?>ayam.jpg" >
  </div>
  <div class="box2" >
  <p style="line-height:5px;font-size:24px;font-weight:bold">CV.FERYPUTRA</p>
  <p  style="line-height:5px">DAGING AYAM</p>
  <p  style="line-height:5px;font-size:11px">Alamat : Jl. Urea 2 Kavling Kujang Blok Q No. 18 Beji Depok</p>
  <p  style="line-height:5px;font-size:11px">Telp. 0812 8845 7852 / 0857 1534 4141</p>
  </div>
  <div class="box3">
  <p style="line-height:5px">  <?= "Tanggal : ".date("d-m-Y",strtotime($suplier_tanggal));?></p>
  <p  style="line-height:20px">Kepada Yth : <?= $suplier.'<br>'.$suplier_alamat;?></p>
  </div>
</div>


<br>
<p  style="line-height:20px;font-weight:bold">No.PO : <?= $id_pembelian;?></p>
  <table width="100%" class="layout">
    <thead>
        <tr>
            <td>No.</td>
            <td align="left">Jenis 123</td>
			<td align="center">Jumlah</td>
			<td align="center">Keterangan</td>
			<td align="center">Harga</td>
			<td align="center">Sub Total</td>
		
        </tr>
    </thead>
    <?php
	$no=0;
	
	$total=0;	
	 foreach($detil_pembelian->result() as $row ): $no++;
	 $total=$total+($row->jumlah*$row->harga);
	 ?>
    <tr>
        <td><?php echo $no;?></td>
		<td><?php echo $row->jenis_ayam;?></td>
		<td align="right"><?php echo number_format($row->jumlah,1,',','.').' Kg';?></td>
			<td><?php echo $row->karung.' Q';?></td>
		<td align="right"><?php echo number_format($row->harga,0,',','.');?></td>
	    <td align="right"><?php echo number_format(($row->jumlah*$row->harga),0,',','.');?></td>
		
	</tr>
	 
    <?php endforeach;?>
	<tr>
	 <td align="right" colspan="5">Total</td>
	 <td align="right"><?php echo number_format(($total),0,',','.');?></td>
	</tr>
</table>
	  <div style="float:left;width:48%;height:150px;border:0px solid black;text-align:center;line-height:75px">Tanda Terima<br>(..............)</div>
           <div style="float:left;width:48%;height:150px;border:0px solid black;text-align:center;line-height:75px">Hormat kami<br>(..............)</div>
	 
</div>
</div>
