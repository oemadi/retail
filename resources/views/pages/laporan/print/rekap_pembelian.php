
<div class="panel panel-default">
<div class="panel-body">
  
	<div class="row">
	<div style="float:left;width:30%" >
    <img  style="float:left;width:50%;" src="<?php echo base_url().'assets/';?>ayam.jpg" >
	</div>
	
	<div style="float:right;width:70%;valign:middle" >
	<p style=";line-height:5px;font-weight:bold;font-size:18px;" align="left">CV. FERYPUTRA</p>
	<p style="line-height:5px;font-weight:bold;font-size:18px;" align="left">REKAP PEMBELIAN AYAM</p>
	</div>
	</div>
	<br>
	
<style>

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
            <td>ID Pembelian</td>
			<td>Suplier</td>
			<td>Tanggal</td>
		    <td align="right" width="200">Pembelian</td>
			<td align="center">Total Qty</td>
			<td align="right">Cash</td>
			<td align="right">Hutang</td>
		
        </tr>
    </thead>
    <?php
		//var_dump($tglawal_indo);
	//	die();
	$no=0;
	$total1=0;
	$total2=0;
	$total3=0;
	$total4=0;
	$total5=0;
	 $pembelian = $this->db->query("select a.*,sum(b.jumlah)qty,d.jumlah_retur,c.suplier from pembelian a 
	 inner join pembelian_detil b on a.id_pembelian=b.id_pembelian 
	 inner join suplier c on a.id_suplier=c.id
	 left join retur_pembelian d on a.id_pembelian=d.id_pembelian
	 WHERE DATE_FORMAT(a.tanggal,'%Y/%m/%d') BETWEEN '".$tglawal."' and '".$tglakhir."'
	GROUP BY a.id_pembelian ")->result();	
		
	 foreach($pembelian as $row ): $no++;
	 $total1=$total1+$row->total;
			   $total2=$total2+$row->qty;
			   $total3=$total3+$row->cash;
			   $total4=$total4+$row->hutang;
			    $total5=$total5+$row->jumlah_retur;
	 
	 ?>
    <tr>
        <td><?php echo $no;?></td>
		<td><?php echo $row->id_pembelian;?></td>
		<td><?php echo $row->suplier;?></td>
		<td><?php echo $row->tanggal;?></td>
		<td align="centers">
		<p>
		 <table  width="350px">
		<?php
		$detil = $this->db->query("select a.id_jenis_ayam,b.jenis_ayam,a.jumlah,a.harga
		from pembelian_detil a 
		inner join jenis_ayam b on a.id_jenis_ayam=b.id
	    WHERE a.id_pembelian='".$row->id_pembelian."' ORDER BY a.id")->result();	
		   foreach($detil as $r){
			   
			   
           ?>
		  
		   <tr><td style="border:0mm" width="45%"><?= $r->jenis_ayam;?></td>
		   <td  align="right" style="border:0mm; vertical-align: top;" width="20%">
		   <?= number_format(round($r->jumlah,1),1,',','.');?></td>
		   <td  style="border:0mm; vertical-align: top;" width="5">x</td>
		   <td  align="right" style="border:0mm; vertical-align: top;" width="20%">
		   <?= number_format(round($r->harga,1),1,',','.');?></td>
		   </tr>
		 
		   
		   
		   <?php } ?>
		   <tr> 
		   <td  style="border:0mm;text-align:left" width="20%">Jumlah : </td>
		   <td  colspan="3"  style="border:0mm;vertical-align: top;text-align:right" width="20%">
		   <?= number_format(round($row->total,1),1,',','.');?></td>
		   </tr>
	
		  </table>
		</p>
	
		<hr >Retur</hr>
			
		  <p>
		  
		 <table border=0 width="350px">
		<?php
			$j_retur =0;
		$t_qty_retur =0;
		$detil_retur = $this->db->query("select a.id_jenis_ayam,b.jenis_ayam,a.jumlah,a.harga
		from retur_pembelian_detil a 
		inner join jenis_ayam b on a.id_jenis_ayam=b.id
	    WHERE a.id_pembelian='".$row->id_pembelian."' ORDER BY a.id");	
		   foreach($detil_retur->result() as $retur){
			   $j_retur=$j_retur+($retur->jumlah*$retur->harga);
			   $j_qty_retur=$j_qty_retur+$retur->jumlah;
			   
           ?>
		   <tr><td style="border:0mm" width="150px"><?= $retur->jenis_ayam;?></td>
		   <td  width="80px" style="border:0mm; vertical-align: top;">
		   <?= number_format(round($retur->jumlah,1),1,',','.');?></td>
		   <td  width="10px" style="border:0mm; vertical-align: top;" width="5">x</td>
		   <td  align="right" width="120px" align="right"   style="border:0mm; vertical-align: top;" >
		   <?= number_format(round($retur->harga,1),1,',','.');?></td>
		   </tr>
		   <?php } 
			  
		   ?> 
		     <tr>
		   <td align="right"  width="150px" align="right"   style="border:0mm; vertical-align: top;" >
		   <?= number_format(round($j_retur,0),1,',','.');?></td>
		   </tr>
		  </table>
		   </p>
		   
		    <table  width="350px">
		    <tr> 
		   <td   width="200px" style="border:0mm;text-align:left" >Total: </td>
		   <td  width="150px" align="right"   style="border:0mm;vertical-align: top;text-align:right" >
		   <?= number_format((round($row->total,1)-round($j_retur,1)),1,',','.');?>
		   </td>
		   </tr>
		  </table>
		</td>
		
		<td align="right"><?php echo number_format($row->qty,1,',','.');?></td>
	    <td align="right"><?php echo number_format($row->cash,0,',','.');?></td>
		<td align="right"><?php echo number_format($row->hutang,0,',','.') ;?></td>
	</tr>
    <?php endforeach;?>
	<tr>
	<td align="center" colspan="4">Total</td>
	<td align="right"><?php echo 'Sub Total : '.number_format($total1,0,',','.').'<br>'.
	'Retur : '.number_format($total5,0,',','.').'<br>'.
	'Grand Total : '.number_format($total1-$total5,0,',','.');?></td>
	<td align="right"><?php echo number_format($total2,0,',','.');?></td>
	    <td align="right"><?php echo number_format($total3,0,',','.');?></td>
		<td align="right"><?php echo number_format($total4,0,',','.') ;?></td>
		</tr>
</table>
	 <section class="sheet padding-10mm">

    </section>
</div>
</div>
