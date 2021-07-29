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
	<p style="line-height:5px;font-weight:bold;font-size:18px;" align="left">REKAP SALDO</p>
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
		//$tglawal='2020/04/01';
		//$tglakhir='2020/08/01';
		
		//var_dump($tgl1,$tgl2);
		//die();
			$pembelian =$this->db->query("
		SELECT sum(a.jumlah*a.harga)pembelian from pembelian_detil a 
		INNER JOIN pembelian b ON 
		a.id_pembelian=b.id_pembelian
		WHERE DATE_FORMAT(b.tanggal,'%Y/%m/%d') BETWEEN '".$tglawal."' and '".$tglakhir."'
		")->row()->pembelian;	
		
	    $penjualan=$this->db->query("
		SELECT sum(a.jumlah*a.harga)penjualan,sum(a.jumlah*a.harga_modal) harga_modal from penjualan_detil a 
		INNER JOIN penjualan b ON 
		a.id_penjualan=b.id_penjualan
		WHERE DATE_FORMAT(b.tanggal,'%Y/%m/%d') BETWEEN '".$tglawal."' and '".$tglakhir."'
		")->row();	
		$modal = $penjualan->harga_modal;
		$penjualan = $penjualan->penjualan;

		
		$return_jual=$this->db->query("
		SELECT sum(a.jumlah_retur)jumlah_retur from retur_penjualan a 
		INNER JOIN penjualan b ON 
		a.id_penjualan=b.id_penjualan
		WHERE DATE_FORMAT(b.tanggal,'%Y/%m/%d') BETWEEN '".$tglawal."' and '".$tglakhir."'
		")->row()->jumlah_retur;	
			
		$return_beli=$this->db->query("
		SELECT sum(a.jumlah_retur)return_beli from retur_pembelian a 
		INNER JOIN pembelian b ON 
		a.id_pembelian=b.id_pembelian
		WHERE DATE_FORMAT(b.tanggal,'%Y/%m/%d') BETWEEN '".$tglawal."' and '".$tglakhir."'
		")->row()->return_beli;	
			
			
	    $pembayaran_customer=$this->db->query("
		SELECT sum(a.jumlah_bayar)pembayaran_customer from bayar_hutang_customer a 
		WHERE DATE_FORMAT(a.tanggal_bayar,'%Y/%m/%d') BETWEEN '".$tglawal."' and '".$tglakhir."'
		")->row()->pembayaran_customer;	
		
		$pembayaran_kesuplier=$this->db->query("
		SELECT sum(a.jumlah_bayar)pembayaran_kesuplier from bayar_hutang a 
		WHERE DATE_FORMAT(a.tanggal_bayar,'%Y/%m/%d') BETWEEN '".$tglawal."' and '".$tglakhir."'
		")->row()->pembayaran_kesuplier;
		
		 $kas_keluar=$this->db->query("
	   SELECT sum(a.jumlah)kas_keluar from kas_keluar a 
		WHERE DATE_FORMAT(a.tanggal,'%Y/%m/%d') BETWEEN '".$tglawal."' and '".$tglakhir."'
		")->row()->kas_keluar;	
		
		?>
		
<p>Periode : <?= $tglawal_indo.' s/d '.$tglakhir_indo;?></p>
	<table width="100%" class="layout">
      <thead>
        <tr >
		<td width="13%" style="font-weight:bold;font-size:12px" align="center">Penjualan</td>
		<td width="13%" style="font-weight:bold;font-size:12px" align="center">Retur Penjualan</td>
         <td width="13%" style="font-weight:bold;font-size:12px" align="center">Pembelian</td>
		<td width="13%" style="font-weight:bold;font-size:12px" align="center">Retur Pembelian</td>  
		  <td width="13%" style="font-weight:bold;font-size:12px" align="center">Kas Keluar</td>
		    <td width="13%" style="font-weight:bold;font-size:12px" align="center">Pembayaran Ke Suplier</td>
			  <td width="13%" style="font-weight:bold;font-size:12px" align="center">Pembayaran dari Customer</td>
		  <td width="13%" style="font-weight:bold;font-size:12px" align="center">Saldo</td>
		    <td width="13%" style="font-weight:bold;font-size:12px" align="center">Pembelian-Penjualan</td>
        </tr>
		</thead>	
	
		<tbody>
		
		<tr>

		
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($penjualan,0,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($return_jual,0,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($pembelian,0,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($return_beli,0,',','.');?></td>
		
	    <td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php echo number_format($kas_keluar,0,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php echo number_format($pembayaran_kesuplier,0,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php echo number_format($pembayaran_customer,0,',','.');?></td>
		    <td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php echo number_format(((($pembayaran_customer+$penjualan)-$return_jual)-($pembelian+$kas_keluar)-$return_beli),0,',','.');?></td>
			<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($pembelian-$penjualan,0,',','.');?></td>
		</tr>
		</tbody>
	
    </table>
	
	<br>
		<table width="100%" class="layout">
      <thead>
        <tr >
		<td width="13%" style="font-weight:bold;font-size:12px" align="center">Penjualan</td>
		<td width="13%" style="font-weight:bold;font-size:12px" align="center">Retur Penjualan</td>
         <td width="13%" style="font-weight:bold;font-size:12px" align="center">Pembelian</td>
		<td width="13%" style="font-weight:bold;font-size:12px" align="center">Retur Pembelian</td>  
		  <td width="13%" style="font-weight:bold;font-size:12px" align="center">Kas Keluar</td>
		    <td width="13%" style="font-weight:bold;font-size:12px" align="center">Pembelian-Penjualan<br>-Kas Keluar</td>
        </tr>
		</thead>	
	
		<tbody>
		
		<tr>

		
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($penjualan,0,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($return_jual,0,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($pembelian,0,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($return_beli,0,',','.');?></td>
		
	    <td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php echo number_format($kas_keluar,0,',','.');?></td>
		    
			<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format((($pembelian-$return_beli)-($penjualan-$return_jual))-$kas_keluar,0,',','.');?></td>
		</tr>
		</tbody>
	
    </table>
	
	<br>
	<table width="100%" class="layout">
      <thead>
        <tr >
		<td width="13%" style="font-weight:bold;font-size:12px" align="center">Penjualan</td>
		<td width="13%" style="font-weight:bold;font-size:12px" align="center">Modal </td>
		<td width="13%" style="font-weight:bold;font-size:12px" align="center">Keuntungan Kotor</td>  
			<td width="13%" style="font-weight:bold;font-size:12px" align="center">Kas Keluar</td> 
		<td width="13%" style="font-weight:bold;font-size:12px" align="center">Keuntungan Bersih</td>  
		
        </tr>
		</thead>	
	
		<tbody>
		
		<tr>

		
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($penjualan,0,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($modal,0,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($penjualan-$modal,0,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($kas_keluar,0,',','.');?></td>
			<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($penjualan-$modal-$kas_keluar,0,',','.');?></td>
		
			</tr>
		</tbody>
	
    </table>
	 <section class="sheet padding-10mm">

    </section>
</div>
</div>
