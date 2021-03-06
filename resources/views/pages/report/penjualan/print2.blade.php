
<div class="panel panel-default">
<div class="panel-body">
@include('pages/report/logo')
	<?php

		$tglawal=date("Y/m/d",strtotime($tgl1 ?? ''));
		$tglakhir=date("Y/m/d",strtotime($tgl2));

		$tglawal_indo=date("d-m-Y",strtotime($tgl1 ?? ''));
		$tglakhir_indo=date("d-m-Y",strtotime($tgl2));
		?>
<div class="row" style="padding-top:10px;">
    <p style="margin-top:60px;line-height:5px;font-weight:bold;font-size:14px;" align="left">REKAP PENJUALAN</p>
<p style="line-height:5px;">Periode : <?= $tglawal_indo.' s/d '.$tglakhir_indo;?></p>
</div>
  <table class="layout" width="100%">
    <thead>
        <tr>
            <td>No.</td>
            <td>Faktur Penjualan</td>
			<td>Customer</td>
			<td>Tanggal</td>
		    <td align="right" >Penjualan</td>
			<td align="center">Total </td>
            <td align="center">Detail </td>

        </tr>
    </thead>
    <?php
    $no=1;
	 foreach($penjualan as $row ){
    ?>
    <tr>
        <td><?php echo $no++;?></td>
		<td><?php echo $row->faktur;?></td>
		<td><?php echo $row->customer->nama;?></td>
		<td><?php echo tanggal_indo($row->tanggal_penjualan);?></td>
        <td><?php echo $row->status;?></td>
        <td align="right"><?php echo format_angka($row->total);?></td>
        <td>
            <table  width="100%">
            <?php foreach($row->detail_penjualan as $detail ){ ?>
                <tr>
                    <td style="border:0mm" width="10px" align="center"> <?php echo $detail->barang->nama;?></td>
                    <td style="border:0mm" width="10px" align="center"> <?php echo number_format(round($detail->jumlah_jual,1),1,',','.');?></td>
                    <td style="border:0mm" width="10px" align="center">x</td>
                    <td style="border:0mm;" width="10px" align="center"> <?php echo $detail->barang->harga_jual;?></td>
                    <td style="border:0mm" width="10px" align="center">:</td>
                    <td style="border:0mm" width="10px" align="right"><?php echo format_angka($detail->subtotal);?></td>
                </tr>
               <?php } ?>

		  </table>
        </td>


	</tr>
    <?php } ?>

</table>

</div>
</div>
