
<div class="panel panel-default">
<div class="panel-body">

@include('pages/report/logo')
<p style="margin-top:60px;line-height:5px;font-weight:bold;font-size:16px;" align="left">TAGIHAN CUSTOMER PERCABANG</p>
<p>Cabang : <?= $cabang->nama;?></p>
  <table width="100%" class="layout">
    <thead>
        <tr>
            <td>No.</td>
			<td>Customer</td>
            <td>Faktur Penjualan</td>
			<td>Tanggal</td>
			<td>Jumlah Transaksi</td>
			<td align="right">Jumlah Bayar</td>
			<td align="right">Sisa Tagihan</td>

        </tr>
    </thead>
    <?php
	$no=0;
    $jumlah_bayar=0;
    $total_jumlah_bayar=0;
    $total_tagihan=0;
	 foreach($data as $row ): $no++;
	 ?>
    <tr>
        <td><?php echo $no;?></td>
		<td><?php echo $row->customer->nama;?></td>
		<td><?php echo $row->faktur;?></td>
		<td><?php echo $row->tanggal_penjualan;?></td>
		<td align="right"><?php echo number_format($row->total,0,',','.') ;?></td>
        <?php
        $jumlah_bayar=0;
        foreach($row->BayarHutangCustomer as $d ){
            $jumlah_bayar  += $d->jumlah_bayar;
           $total_jumlah_bayar += $jumlah_bayar;
        }
        $total_tagihan+=$row->total-$jumlah_bayar;
        ?>
        <td align="right"><?php echo number_format($jumlah_bayar,0,',','.');?></td>
        <td align="right"><?php echo number_format($row->total-$jumlah_bayar,0,',','.');?></td>
    </tr>
    <?php endforeach;?>
    <tr>
        <td align="center" colspan="5">Total</td>
		<td align="right"><?php echo number_format($total_jumlah_bayar,0,',','.');?></td>
        <td align="right"><?php echo number_format($total_tagihan,0,',','.');?></td>

    </tr>
</table>
	 <section class="sheet padding-10mm">

    </section>
</div>
</div>
