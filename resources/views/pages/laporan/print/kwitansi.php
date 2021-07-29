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
	<p style="font-weight:bold;font-size:18px" align="center">KWITANSI</p>
	
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
td.redcell {
 border: 0mm solid red;
}
td.redcell2 {
 border: 0mm solid red;
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
	
   <table width="100%" class="layout">
    <thead>
        <tr>
            <td>No.</td>
            
            <td>Customer</td>
			    <td>Kontak</td>
				    <td>HP</td>
					    <td>Alamat</td>
		
                 <td align="center">Hutang</td>
        
        </tr>
    </thead>
    <?php
 $no=0;
	 $customer=$this->db->query("select * from customer order by id")->result();
	 foreach($customer as $row ): $no++;
	 ?>
    <tr>
        <td><?php echo $no;?></td>
		<td><?php echo $row->customer;?></td>
		<td><?php echo $row->kontak;?></td>
		<td><?php echo $row->hp;?></td>
		<td><?php echo $row->alamat;?></td>
		<td align="right" style="padding-right:1%">
			<?php 
		$da = $this->db->query("
		select a.*,a.jumlah_hutang-a.jumlah_bayar sisa from
		(select a.id_customer,a.jumlah_hutang,case when (b.jumlah_bayar!='') then b.jumlah_bayar else 0 end as jumlah_bayar
		 from
		(select a.id_customer,sum(a.hutang)jumlah_hutang from penjualan a 
		where a.id_customer='".$row->id."' group by a.id_customer)a
		left join (
		select  a.id_customer,sum(a.jumlah_bayar)jumlah_bayar from bayar_hutang_customer a 
		where a.id_customer='".$row->id."'  group by a.id_customer)b
		on a.id_customer=b.id_customer
		where a.id_customer='".$row->id."' )a");
		$j=$da->num_rows();
		if($j>0){
			$r = $da->row();
			echo number_format($r->sisa,0,',','.');
		
		}else{
			echo "0";		
		}
		?>
        </td>
      
    </tr>
    <?php endforeach;?>
</table>
	 <section class="sheet padding-10mm">

    </section>
</div>
</div>
