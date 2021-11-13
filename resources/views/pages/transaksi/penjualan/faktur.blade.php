
<div class="panel panel-default">
    <div class="panel-body">
      <style>
    @font-face {
        font-family: 'DotMatrix';

        font-style: normal;

        src: url('public/fonts/DOTMATRI.TTF');

    }
    @font-face {
        font-family: 'DotMatrixBold',Calibri;
        font-style: normal;
        src: url('public/fonts/DOTMBold.TTF');


    }
    body{
         font-family: 'Calibri';
    }
    table.layout {
        font-family: 'Calibri';
        border-collapse: collapse;

    }
    td.layout {

     text-align: center;


     border-collapse: collapse;
    }
    td {

     border-collapse: collapse;
     padding: 1mm;
     border: 0.5mm solid gray;
     border-style:dashed;
     vertical-align: middle;
    }

    </style>
           <style type="text/css" media="print">
            @page
            {
                size: auto;   /* auto is the current printer page size */
                margin: 0mm;  /* this affects the margin in the printer settings */
                padding-top:0px;
                padding-bottom:100px;
                padding-left:20px;
                    padding-right:20px;
            }

            body
            {
                background-color:#FFFFFF;
                border: solid 1px black ;
                margin: 0px;  /* the margin on the content before printing */
                padding-top:10px;
                padding-bottom:50px;
                padding-left:20px;
                    padding-right:20px;
           }
        </style>
     <style>
     * {
      box-sizing: border-box;
    }

    .box1 {
      float: left;
      width: 18%;
      heightLauto;
      text-align:center;

    }
    .box2 {
      float: left;
      width: 50%;

    }
    .box3 {
      float: left;
      width: 30%;
      paading-top:0px;

    }
    .clearfix::after {
      content: "";
      clear: both;
      display: table;
    }


      </style>


    <br>

      <div class="clearfix">
       <div class="box1" >
        <img  style="width:50%;height:auto" src="{{url('public/asset_toko/ayam-gradasi.png')}}" >
      </div>
      <div class="box2" >
      <p style="line-height:5px;font-size:24px;font-weight:bold">CV.FERYPUTRA</p>
      <p  style="line-height:5px">DAGING AYAM</p>
      <p  style="line-height:5px;font-size:11px">Alamat : Jl. Urea 2 Kavling Kujang Blok Q No. 18 Beji Depok</p>
      <p  style="line-height:5px;font-size:11px">Telp. 0812 8845 7852 / 0857 1534 4141</p>
      </div>
      <div class="box3">
      <p style="line-height:5px">Tanggal : <?= date("d-m-Y",strtotime($atas->tanggal_penjualan));?></p>
      <p  style="line-height:20px">Kepada Yth : <?= $atas->namacustomer.'<br>'.$atas->alamat;?></p>
      </div>
    </div>


    <br>
    <p  style="line-height:0px;font-weight:bold">No.Faktur : <?= $atas->faktur;?></p>
      <table width="100%" class="layout">
        <thead>
            <tr>
                <td>No.</td>
                <td align="left">Jenis </td>
                <td align="center">Jumlah</td>
                <td align="center">Keterangan</td>
                <td align="center">Harga</td>
                <td align="center">Sub Total</td>

            </tr>
        </thead>
        <?php
        $no=0;

        $total=0;
         foreach($detail as $row ): $no++;
         $total= $total+$row->subtotal;
         ?>
        <tr>
            <td><?php echo $no;?></td>
            <td><?php echo $row->nama;?></td>
            <td align="right"><?php echo number_format($row->jumlah_jual,1,',','.').' Kg';?></td>
                <td align="right"><?php echo number_format($row->karung).' Q';?></td>
            <td align="right"><?php echo number_format($row->harga,0,',','.');?></td>
            <td align="right"><?php echo number_format(($row->subtotal),0,',','.');?></td>

        </tr>

        <?php endforeach;?>
        <tr>
         <td align="right" colspan="5">Total</td>
         <td align="right"><?php echo number_format(($total),0,',','.');?></td>
        </tr>
    </table>
          <div style="float:left;width:48%;height:150px;border:0px solid black;text-align:center;line-height:75px">Tanda Terima<br>(..............)</div>
               <div style="float:left;width:48%;height:150px;border:0px solid black;text-align:center;line-height:75px">Hormat kami<br>(..............)</div>

    </div>
    </div>
    <script>
    window.print();
    </script>
