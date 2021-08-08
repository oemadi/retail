
<div class="panel panel-default">
<div class="panel-body">
  @include('pages/report/logo')

	<?php

		$tglawal=date("Y/m/d",strtotime($tgl1 ?? ''));
		$tglakhir=date("Y/m/d",strtotime($tgl2));

		$tglawal_indo=date("d-m-Y",strtotime($tgl1 ?? ''));
		$tglakhir_indo=date("d-m-Y",strtotime($tgl2));
		?>
 <p style="margin-top:60px;line-height:5px;font-weight:bold;font-size:16px;">Rekap Pembelian</p>       
<p>Periode : <?= $tglawal_indo.' s/d '.$tglakhir_indo;?></p>
  <table width="100%" class="layout">
    <thead>
        <tr>
            <td>No.</td>
            <td>Faktur Pembelian</td>
			<td>Suplier</td>
			<td>Tanggal</td>
		    <td align="right" >Pembelian</td>
			<td align="center">Total </td>
            <td align="center">Detail </td>

        </tr>
    </thead>
    <?php
    $no=1;
	 foreach($pembelian as $row ){
    ?>
    <tr>
        <td><?php echo $no++;?></td>
		<td><?php echo $row->faktur;?></td>
		<td><?php echo $row->suplier->nama;?></td>
		<td><?php echo $row->tanggal_pembelian;?></td>
        <td><?php echo $row->status;?></td>
        <td><?php echo $row->total;?></td>
        <td>
            <table  >
            <?php foreach($row->detail_pembelian as $detail ){ ?>
                <tr>
                    <td style="border:0mm" > <?php echo $detail->barang->nama;?></td>
                    <td style="border:0mm"> <?php echo number_format(round($detail->jumlah_beli,1),1,',','.');?></td>
                    <td style="border:0mm" >x</td>
                    <td style="border:0mm;" > <?php echo $detail->barang->harga_beli;?></td>
                    <td style="border:0mm" >:</td>
                    <td style="border:0mm"> <?php echo number_format(round($detail->subtotal,1),1,',','.');?></td>
                </tr>
               <?php } ?>

		  </table>
        </td>


	</tr>
    <?php } ?>

</table>
</div>
</div>
