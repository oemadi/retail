
<div class="panel panel-default">
<div class="panel-body">
  
	<div class="row">
	<div style="float:left;width:30%" >
    <img  style="float:left;width:50%;" src="<?php echo base_url().'assets/';?>ayam.jpg" >
	</div>
	
	<div style="float:right;width:70%;valign:middle" >
	<p style=";line-height:5px;font-weight:bold;font-size:18px;" align="left">CV. FERYPUTRA</p>
	<p style="line-height:5px;font-weight:bold;font-size:18px;" align="left">REKAP PENJUALAN AYAM</p>
	</div>
	</div>
	<br>
		
<style>

table.layout {
 border: 0mm solid black;
 border-collapse: collapse;\
 font-size:9px;
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
</style>
		<?php
			
		$tglawal=date("Y/m/d",strtotime($tgl1));
		$tglakhir=date("Y/m/d",strtotime($tgl2));
		$tglawal_indo=date("d-m-Y",strtotime($tgl1));
		$tglakhir_indo=date("d-m-Y",strtotime($tgl2));
		?>

<p>Periode : <?= $tglawal_indo.' s/d '.$tglakhir_indo;?></p>
  <table width="100%" class="layout">
        <tr>
            <td>No.</td>
            <td>ID Penjualan</td>
			<td>Customer</td>
			<td>Tanggal</td>
		    <td align="right"> Penjualan</td>
			<td align="right">Cash</td>
			<td align="right">Hutang</td>
		
        </tr>
  
    <?php

			$total1=0;
	$total2=0;
	$total3=0;
	$total4=0;
	$total5=0;
	$total_modal=0;
	$no=0;
	 $penjualan = $this->db->query("select a.*,b.customer from penjualan a  inner join customer b on a.id_customer=b.id
	 WHERE DATE_FORMAT(a.tanggal,'%Y/%m/%d') BETWEEN '".$tglawal."' and '".$tglakhir."'
	 order by a.id")->result();	
	 
	 foreach($penjualan as $row ){ 
	 $no++;
			   
			   $total3=$total3+$row->cash;
			   $total4=$total4+$row->hutang;
			   $total1=$total1+$row->total;
	 ?>
    <tr>
        <td><?php echo $no;?></td>
		<td><?php echo $row->id_penjualan;?></td>
		<td><?php echo 'ID Cus : '.$row->id_customer.'<br>'.$row->customer;?></td>
		<td><?php echo $row->tanggal;?></td>
		<td width="250px">
		<p>
		 <table width="100%">
		<?php	
	    $total_jual=0;
		$total_modal1=0;
		$detil = $this->db->query("select a.id_jenis_ayam,b.jenis_ayam,a.jumlah,a.harga,a.harga_modal
		from penjualan_detil a 
		inner join jenis_ayam b on a.id_jenis_ayam=b.id
	    WHERE a.id_penjualan='".$row->id_penjualan."' ORDER BY a.id")->result();	
		   foreach($detil as $r){
			   $total_modal = $total_modal+($r->jumlah*$r->harga_modal);
			   $total_modal1 = $total_modal1+($r->jumlah*$r->harga_modal);
			      $total_jual = $total_jual+($r->jumlah*$r->harga);
           ?>
		   <tr><td  align="left" style="border:0mm" width="150px"><?= $r->jenis_ayam;?></td>
		   <td width="80px" align="center" style="border:0mm; vertical-align: top;">
		   <?= number_format(round($r->jumlah,1),1,',','.');?></td>
		   <td  width="10px" align="center" style="border:0mm; vertical-align: top;" width="5">x</td>
		   <td width="120px" align="right" style="border:0mm; vertical-align: top;" >
		   <?= number_format(round($r->harga,0),0,',','.').'/'. number_format(round($r->harga_modal,0),0,',','.');?></td>
		   </tr>
		
		   <?php } ?>
			<tr> 
		   <td  colspan="3" style="border:0mm;text-align:left" >Jumlah: </td>
		   <td width="80"  style="border:0mm;vertical-align: top;text-align:right">
		   <?= number_format(round($row->total,1),1,',','.');?></td>
		   </tr>
		   <tr> 
		   <td  colspan="3" style="border:0mm;text-align:left" >Keuntungan: </td>
		   <td width="80"  style="border:0mm;vertical-align: top;text-align:right">
		   <?= number_format(round($total_jual-$total_modal1,1),1,',','.');?></td>
		   </tr>
		  </table>
		  </p>
		   <p align="center" style="width:100%;border-bottom:2px solid gray">Retur</p>
		  <p>
		 <table  width="350px">
		<?php
			$j_retur =0;
		$t_qty_retur =0;
		$detil_retur = $this->db->query("select a.id_jenis_ayam,b.jenis_ayam,a.jumlah,a.harga
		from retur_penjualan_detil a 
		inner join jenis_ayam b on a.id_jenis_ayam=b.id
	    WHERE a.id_penjualan='".$row->id_penjualan."' ORDER BY a.id");	
		   foreach($detil_retur->result() as $retur){
			   $j_retur=$j_retur+($retur->jumlah*$retur->harga);
			     $j_qty_retur=$j_qty_retur+$retur->jumlah;
			   
           ?>
		   <tr><td style="border:0mm" width="150px"><?= $retur->jenis_ayam;?></td>
		   <td  width="80px" style="border:0mm; vertical-align: top;">
		   <?= number_format(round($retur->jumlah,1),1,',','.');?></td>
		   <td  width="10px" style="border:0mm; vertical-align: top;" width="5">x</td>
		   <td   width="120px" align="right"   style="border:0mm; vertical-align: top;" >
		   <?= number_format(round($retur->harga,1),1,',','.');?></td>
		   </tr>
		  
		   <?php } 
			  
		   ?> 
		     <tr>
		   <td   width="120px" align="right"   style="border:0mm; vertical-align: top;" >
		   <?= number_format(round($j_retur,0),1,',','.');?></td>
		   </tr>
		  </table>
		   </p>
		  
		    <table  width="350px">
		    <tr> 
		   <td   width="215px" style="border:0mm;text-align:left" >Total: </td>
		   <td  width="150px" align="right"   style="border:0mm;vertical-align: top;text-align:right" >
		   <?= number_format((round($row->total,1)-round($j_retur,1)),1,',','.');?>
		   </td>
		   </tr>
		  </table>
		</td>
	

	    <td align="right"><?php echo number_format($row->cash,0,',','.');?></td>
		<td align="right"><?php echo number_format($row->hutang,0,',','.') ;?></td>
	</tr>
    <?php } ?>

	<tr>
	<td align="center" colspan="4">Total</td>
	<td align="right"><?php echo 'Sub Total : '.number_format($total1,0,',','.').'<br>'.
	'Retur : '.number_format($total5,0,',','.').'<br>'.
	'Grand Total : '.number_format($total1-$total5,0,',','.').'<br>'.
	'Modal : '.number_format($total_modal,0,',','.').'<br>'.
	'Keuntungan : '.number_format($total1-$total_modal,0,',','.').'<br>';
	
	?></td>
	
	
	    <td align="right"><?php echo number_format($total3,0,',','.');?></td>
		<td align="right"><?php echo number_format($total4,0,',','.') ;?></td>
		</tr>
</table>

</div>
</div>
