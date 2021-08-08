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
@include('pages/report/logo')
		<?php
			
		$tglawal=date("Y/m/d",strtotime($tgl1));
		$tglakhir=date("Y/m/d",strtotime($tgl2));
		
		$tglawal_indo=date("d-m-Y",strtotime($tgl1));
		$tglakhir_indo=date("d-m-Y",strtotime($tgl2));
		?>

	<p style="margin-top:60px;line-height:5px;font-weight:bold;font-size:16px;">Rekap Pembayaran dari Customer</p> 
<p>Periode : <?= $tglawal_indo.' s/d '.$tglakhir_indo;?></p>
  <table width="100%" class="layout">
    <thead>
        <tr>
            <td>No.</td>
            <td>Faktur Bayar</td>
			<td>Customer</td>
			<td>Faktur Penjualan</td>
			<td>Tanggal Bayar</td>
			<td align="right">Jumlah Bayar</td>
			<td align="right">Sisa Hutang</td>
		
        </tr>
    </thead>
    <?php
	$no=0;
	$total=0;
	 foreach($data as $row ): $no++;
	 $total+=$row->sisa_hutang;
	 ?>
    <tr>
        <td><?php echo $no;?></td>
		<td><?php echo $row->id_bayar_hutang_customer;?></td>
		<td><?php echo $row->customer->nama;?></td>
		<td><?php echo $row->penjualan->faktur;?></td>
		<td><?php echo $row->tanggal_bayar;?></td>
		<td align="right"><?php echo number_format($row->jumlah_bayar,0,',','.');?></td>
		<td align="right"><?php echo number_format($row->sisa_hutang,0,',','.');?></td>
    </tr>
    <?php endforeach;?>
	   <tr>
        <td align="center" colspan="6">Total</td>
		<td align="right"><?php echo number_format($total,0,',','.');?></td>
		
    </tr>
</table>
	 <section class="sheet padding-10mm">

    </section>
</div>
</div>
