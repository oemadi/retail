
<div class="panel panel-default">
<div class="panel-body">

	<div class="row">
	<div style="float:left;width:30%" >
    {{-- <img  style="float:left;width:50%;" src="<?php echo base_url().'assets/';?>ayam.jpg" > --}}
	</div>

	<div style="float:right;width:70%;valign:middle" >
	<p style=";line-height:5px;font-weight:bold;font-size:18px;" align="left">CV. FERYPUTRA</p>
	<p style="line-height:5px;font-weight:bold;font-size:18px;" align="left">REKAP PENJUALAN</p>
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

		$tglawal=date("Y/m/d",strtotime($tgl1 ?? ''));
		$tglakhir=date("Y/m/d",strtotime($tgl2));

		$tglawal_indo=date("d-m-Y",strtotime($tgl1 ?? ''));
		$tglakhir_indo=date("d-m-Y",strtotime($tgl2));
		?>

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
