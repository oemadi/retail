
<div class="panel panel-default">
<div class="panel-body">
@include('pages/report/logo')

	<?php

		$tglawal=date("Y/m/d",strtotime($tgl1 ?? ''));
		$tglakhir=date("Y/m/d",strtotime($tgl2));

		$tglawal_indo=date("d-m-Y",strtotime($tgl1 ?? ''));
		$tglakhir_indo=date("d-m-Y",strtotime($tgl2));
		?>
<p>Cabang : <?= $cabang->nama;?></p>
<p>Periode : <?= $tglawal_indo.' s/d '.$tglakhir_indo;?></p>
  <table width="100%" class="layout">
    <thead>
        <tr>
            <td>No.</td>
            <td>Faktur Penjualan</td>
			<td>Customer</td>
			<td>Tanggal</td>
		    <td align="right" width="200">Penjualan</td>
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
		<td><?php echo $row->tanggal_penjualan;?></td>
        <td><?php echo $row->status;?></td>
        <td><?php echo $row->total;?></td>
        <td>
            <table  width="350px">
            <?php foreach($row->detail_penjualan as $detail ){ ?>
                <tr>
                    <td style="border:0mm" width="45%"> <?php echo $detail->barang->nama;?></td>
                    <td style="border:0mm"> <?php echo number_format(round($detail->jumlah_jual,1),1,',','.');?></td>
                    <td style="border:0mm" width="10%">x</td>
                    <td style="border:0mm;" width="20%"> <?php echo $detail->barang->harga_jual;?></td>
                    <td style="border:0mm" width="10%">:</td>
                    <td style="border:0mm"> <?php echo number_format(round($detail->subtotal,1),1,',','.');?></td>
                </tr>
               <?php } ?>

		  </table>
        </td>


	</tr>
    <?php } ?>

</table>
	 <section class="sheet padding-10mm">

    </section>
</div>
</div>
