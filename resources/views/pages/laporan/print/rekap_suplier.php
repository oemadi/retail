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
	<div style="float:left;width:30%" >
    <img  style="float:left;width:50%;" src="<?php echo base_url().'assets/';?>ayam.jpg" >
	</div>
	
	<div style="float:right;width:70%;valign:middle" >
	<p style=";line-height:5px;font-weight:bold;font-size:18px;" align="left">CV. FERYPUTRA</p>
	<p style="line-height:5px;font-weight:bold;font-size:18px;" align="left">DAFTAR SUPLIER AYAM</p>
	</div>
	</div>
	<br>
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
            
            <td>Suplier</td>
			    <td>Kontak</td>
				    <td>HP</td>
		  <td>Alamat</td>
		<td>Piutang</td>
 
        </tr>
    </thead>
    <?php
    $no=0;
    $ttl_sisa=0;
    $suplier=$this->db->query("select * from suplier order by id")->result();
	 foreach($suplier as $row ): $no++;?>
    <tr>
        <td><?php echo $no;?></td>
    
		<td><?php echo $row->suplier;?></td>
		<td><?php echo $row->kontak;?></td>
		<td><?php echo $row->hp;?></td>
		<td><?php echo $row->alamat;?></td>
		<td align="right" style="padding-right:1%">
		<?php 
		$da = $this->db->query("
		select a.*,(a.jumlah_hutang-a.jumlah_bayar)-a.jumlah_retur as  sisa from
		(select a.*,case when c.jumlah_retur!='' then c.jumlah_retur else 0 end as jumlah_retur from
		(select a.id_suplier,a.jumlah_hutang,case when (b.jumlah_bayar!='') then b.jumlah_bayar else 0 end as jumlah_bayar 
		from
		(select a.id_suplier,sum(a.hutang)jumlah_hutang from pembelian a 
		where a.id_suplier='".$row->id."' group by a.id_suplier)a
		left join (
		select  a.id_suplier,sum(a.jumlah_bayar)jumlah_bayar from bayar_hutang a 
		where a.id_suplier='".$row->id."' group by a.id_suplier)b
		on a.id_suplier=b.id_suplier   where a.id_suplier='".$row->id."' )a
		
		left join (
		SELECT b.id_suplier,sum(a.jumlah_retur)jumlah_retur from retur_pembelian a
		INNER JOIN pembelian b ON a.id_pembelian=b.id_pembelian
		INNER JOIN suplier c ON b.id_suplier=c.id
		WHERE b.id_suplier='".$row->id."' GROUP BY b.id_suplier)c
		on a.id_suplier=c.id_suplier 
	   where a.id_suplier='".$row->id."')a
	   
	   ");
		$j=$da->num_rows();
		
		if($j>0){
			$r = $da->row();
			echo number_format($r->sisa,0,',','.');
		 
		}else{
			echo "0";		
		}
		
		$ttl_sisa=$ttl_sisa+$r->sisa;
		?>
		</td>
	  
    </tr>
    <?php endforeach;?>
    
        <tr>
        <td colspan="5">Total</td><td ><?php echo number_format($ttl_sisa,0,',','.');?></td>
        </tr>
</table>
	
</div>
</div>
