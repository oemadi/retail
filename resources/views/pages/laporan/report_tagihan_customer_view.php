<div style="padding:20px">

<legend>Rekap Tagihan Ke Customer</legend>
<form class="form-horizontal" action="<?= base_url('laporan/report10');?>" method="post" enctype="multipart/form-data">
    
	
    <div class="form-group">
        <label class="col-lg-2 control-label">Customer </label>
        <div class="col-lg-5">
			<select  id="customer"  name="customer" style="width:100%" class="form-control select2-customer">

			<?php $data=$this->db->query("select * from customer order by customer");  foreach($data->result() as $row){ ?> 
			<option  value="<?= $row->id;?>"><?= $row->customer;?></option>
			<?php }  ?>
			</select>
        </div>
    </div>

	 <div class="form-group">
        <label class="col-lg-2 control-label">Status Lunas</label>
        <div class="col-lg-5">
			<select  id="status_lunas"  name="status_lunas" class="form-control">
			<option value="0">Semua</option>
			<option value="1">Sudah Lunas</option>
			<option value="2">Belum Lunas</option>
			</select>
        </div>
    </div>

	 <div class="form-group">
      <label class="col-lg-2 control-label"></label>
        <div class="col-lg-5">
             <p align="right">
        <button class="btn btn-primary"><i class="glyphicon glyphicon-hdd"></i> Proses</button>
    </p> 
        </div>
    </div>

		</form>


</div>
     	<script src="<?= base_url().'assets/select2/new/jquery.min.js';?>"></script>

	<script>
    $(function(){
		//alert();
		  $(".select2-customer").select2({
             
            });
			
    	$('#customer').on('change', function() { validate_aset(); });
	})
	
	function validate_aset(){
        var customer = $('#customer').val();
        //	 $('#progress_').show();  
			
		$.ajax({
		type	: "POST",
		url      : '<?php echo site_url('pembelian/cek_customer');?>',
		data	: "customer="+customer,
		dataType: "json",
		success	: function(data){
	
		}
	});
  
}
	</script>