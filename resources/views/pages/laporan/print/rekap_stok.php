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
  
	

	<div class="row">
	<p style="font-weight:bold;font-size:18px" align="center">REKAP STOK DALAM KG</p>
	
	</div>
	
<style>
table {
 font-family: sans-serif;
 border: 7mm solid aqua;
 border-collapse: collapse;
}
table.table2 {
 border: 2mm solid aqua;
 border-collapse: collapse;
}
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


/* DivTable.com */
.divTable{
	display: table;
	width: 100%;
}
.divTableRow {
	display: table-row;
}
.divTableHeading {
	background-color: #EEE;
	display: table-header-group;
}
.divTableCell, .divTableHead {
	border: 1px solid #999999;
	display: table-cell;
	padding: 3px 10px;
}
.divTableHeading {
	background-color: #EEE;
	display: table-header-group;
	font-weight: bold;
}
.divTableFoot {
	background-color: #EEE;
	display: table-footer-group;
	font-weight: bold;
}
.divTableBody {
	display: table-row-group;
}
</style>
	
		<?php
	    $data_print=$this->db->query("
		 SELECT x.id,x.jenis_ayam,a.retur_jual,b.retur_beli,c.masuk,d.keluar from jenis_ayam x
				left join
		(SELECT a.id_jenis_ayam,sum(a.jumlah)retur_jual from retur_penjualan_detil a group by a.id_jenis_ayam)a 
		on x.id=a.id_jenis_ayam
		
			left join
		(SELECT a.id_jenis_ayam,sum(a.jumlah)retur_beli from retur_pembelian_detil a group by a.id_jenis_ayam)b
		on x.id=b.id_jenis_ayam
		
			left join
			(SELECT a.id_jenis_ayam,sum(a.jumlah)masuk from pembelian_detil a group by a.id_jenis_ayam)c 
			on x.id=c.id_jenis_ayam
			
		left join
		(SELECT a.id_jenis_ayam,sum(a.jumlah)keluar from penjualan_detil a group by a.id_jenis_ayam)d
		on x.id=d.id_jenis_ayam
		");	
		?>

	<table width="100%" class="layout">
      <thead>
        <tr >
          <td  width="3%" style="font-weight:bold;font-size:12px" align="center">No.</td>
		  <td width="7%" style="font-weight:bold;font-size:12px" align="center">Jenis </td>
		  <td width="13%" style="font-weight:bold;font-size:12px" align="center">Masuk (Dari Pembelian)</td>
		  <td width="13%" style="font-weight:bold;font-size:12px" align="center">Keluar (Dari Penjualan)</td>
		  <td width="13%" style="font-weight:bold;font-size:12px" align="center">Masuk (Dari Retur Jual)</td>
		  <td width="13%" style="font-weight:bold;font-size:12px" align="center">Keluar (Dari Retur Beli)</td>
		 <td width="13%" style="font-weight:bold;font-size:12px" align="center">Sisa Stok</td>
        </tr>
		</thead>	
	
	
		<tbody>
		<?php 
        $no = 0;
		$total1=0;
		$total2=0;
		$total3=0;
		$total4=0;
		$total5=0;
         foreach($data_print->result() as $item)
			   {
				   $no=$no+1;
		$total1=$item->masuk+$total1;
		$total2=$item->keluar+$total2;
		$total3=($item->masuk+$item->retur_jual)-($item->keluar+$item->retur_beli);
		$total4=$item->retur_jual+$total4;
		$total5=$item->retur_beli+$total5;
         ?>	
		<tr>

		<td  ><?php echo $no;?></td>
		<td  align="left" style="font-weight:;font-size:12px;vertical-align:top"><?php echo $item->jenis_ayam;?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php echo number_format($item->masuk,2,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($item->keluar,2,',','.');?></td>
	    <td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php echo number_format($item->retur_jual,2,',','.');?></td>
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php  echo number_format($item->retur_beli,2,',','.');?></td>
	   
		<td align="right"  style="font-weight:;font-size:12px;vertical-align:top"><?php echo number_format($total3,2,',','.');?></td>
		
		</tr>
		<?php
		  }
		?>
				
		<tr>

		<td colspan="2" align="center" >Total</td>
		<td  align="right"><?php echo number_format($total1,2,',','.');?></td>
		<td  align="right"><?php echo number_format($total2,2,',','.');?></td>
		<td  align="right"><?php echo number_format($total4,2,',','.');?></td>
		<td  align="right"><?php echo number_format($total5,2,',','.');?></td>
		<td  align="right"><?php echo number_format(
		($total1-$total2)+$total4-$total5
		,2,',','.');?></td></tr>
		</tbody>
	
		
	
    </table>
	 <section class="sheet padding-10mm">

    </section>
</div>
</div>
