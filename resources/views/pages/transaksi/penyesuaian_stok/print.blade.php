
 @include('pages/report/logo')
    <br><br><br><br>
    <p  style="line-height:5px;font-weight:bold">No.Penyesuaian : <?= $data->faktur;?></p>
    <p  style="line-height:5px;font-weight:bold">Tanggal : <?= $data->tanggal;?></p>
	<p  style="line-height:5px;font-weight:bold">User Aplikasi : <?= $data->UserPenyesuaianStok->nama;?></p>
      <table width="100%" class="layout">
        <thead>
            <tr>
                <td>No.</td>
                <td align="left">Jenis Penyesuaian</td>
                <td align="left">Barang</td>
                <td align="right">Jumlah</td>
                <td align="left">Keterangan</td>

            </tr>
        </thead>
        <?php
        $no=0;

        $total=0;
         foreach($data->DetailPenyesuaianStok as $row ): $no++;

         ?>
        <tr>
            <td><?php echo $no;?></td>
            <td><?php echo $row->jenis;?></td>
            <td><?php echo $row->barang->nama;?></td>
            <td align="right"><?php echo $row->jumlah.' Kg';?></td>
            <td><?php echo $row->keterangan;?></td>

        </tr>

        <?php endforeach;?>

    </table>
          <div style="float:left;width:48%;height:150px;border:0px solid black;text-align:center;line-height:75px"><br></div>
               <div style="float:left;width:48%;height:150px;border:0px solid black;text-align:center;line-height:75px">Mengetahui,<br>(..............)</div>

    </div>
    </div>
