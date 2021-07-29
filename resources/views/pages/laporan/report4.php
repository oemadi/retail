<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.2.1.pack.js"></script>


<style type="text/css">
tbl {
	font-size: 9px;
}
.tbl {
	font-size: 10px;
}
.judul{
	text-align:center;
	font-size:20px;
	font-weight:bold;
</style>
<div class="panel panel-default">
<div class="panel-body">
     <div class="panel-heading">
        	 	<legend>Bukti Service CV.Trans Marindra Utama</legend>
 
<p></p>
		    <div class="form-horizontal">
		<div class="col-md-6">
		 <div class="form-group">
        <label class="col-lg-4 control-label">Tanggal Awal</label>
        <div class="col-lg-4">
            <input type="text" id="tglawal"   class="form-control">
        </div>
		</div>
		
		 
		</div>
		<div class="col-md-6">
		<div class="form-group">
        <label class="col-lg-4 control-label">Tanggal Akhir</label>
        <div class="col-lg-4">
            <input type="text" id="tglakhir"   class="form-control">
        </div>
		</div>
			  </div>
			  
		<div class="col-md-8">
		<div class="form-group">
            <label class="col-lg-3 control-label">Instansi</label>
            <div class="col-lg-8">
                     <select name="customer" class="form-control" id="customer">
                            <option value="">SEMUA</option>
                            <?php 
							$dt=$this->db->query("select * from customer  
							  order by id")->result();
							foreach($dt as $dt):?>
                            <option value="<?php echo $dt->id;?>"><?php echo $dt->customer;?></option>
                            <?php endforeach;?>
             </select>
            </div>
			 
			 
               
         
			</div>
		 </div>
		 <div class="col-md-8">
		<div class="form-group">
            <label class="col-lg-3 control-label">Gedung</label>
            <div class="col-lg-8">
                     <select name="gedung" class="form-control" id="gedung">
                            <option value="">SEMUA</option>
                            <?php 
							$dt=$this->db->query("select gedung from unit_bagian group by gedung 
							  order by gedung")->result();
							foreach($dt as $dt):?>
                            <option value="<?php echo $dt->gedung;?>"><?php echo $dt->gedung;?></option>
                            <?php endforeach;?>
             </select>
            </div>
			 
			 
               
         
			</div>
		 </div>
				<div class="col-md-8">
		<div class="form-group">
            <label class="col-lg-3 control-label">Unit / Bagian</label>
            <div class="col-lg-8">
                     <select name="unit_bagian" class="form-control" id="unit_bagian">
                          <option value="">SEMUA</option>
                         
             </select>
            </div>
			 
			 
               
         
			</div>
		 </div>
			<div class="col-md-8">
		<div class="form-group">
            <label class="col-lg-3 control-label">Jenis</label>
            <div class="col-lg-8">
                     <select name="jenis" class="form-control" id="jenis">
                           <option value="">SEMUA</option>
                            <?php 
							$dt=$this->db->query("select * from jenis  
							  order by id")->result();
							foreach($dt as $dt):?>
                            <option value="<?php echo $dt->id;?>"><?php echo $dt->jenis;?></option>
                            <?php endforeach;?>
             </select>
            </div>
			 
			 
               
         
			</div>
		 </div>
		 	<div class="col-md-8">
		<div class="form-group">
            <label class="col-lg-3 control-label">Status </label>
            <div class="col-lg-8">
                     <select name="status" class="form-control" id="status">
                            <option value="">SEMUA</option>
                            <?php 
							$dt=$this->db->query("select * from status_perbaikan  
							  order by id")->result();
							foreach($dt as $dt):?>
                            <option value="<?php echo $dt->id;?>"><?php echo "Selesai : ". $dt->status_perbaikan;?></option>
                            <?php endforeach;?>
             </select>
            </div>
			 
			 
               
         
			</div>
 </div>
  		<div class="col-md-8">
		<div class="form-group">
            <label class="col-lg-3 control-label">Petugas</label>
            <div class="col-lg-8">
                     <select name="petugas" class="form-control" id="petugas">
                            <option value="">SEMUA</option>
                            <?php 
							$dt=$this->db->query("select * from users  
							  order by id")->result();
							foreach($dt as $dt):?>
                            <option value="<?php echo $dt->nama;?>"><?php echo $dt->nama;?></option>
                            <?php endforeach;?>
             </select>
            </div>
			 
			 
               
         
			</div>
		 </div>
<p>
		
		<button id="print" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i> Print</button>
		</p><p>
			
		</p>
		  <div class="form-group">
	 <label class="col-lg-2 control-label"></label>
	<div class="col-lg-8">
	<div id='progress_' style='display:none'>
       <img src="https://automata.co.id/pemeliharaan/assets/progress_3.gif" style="width:60px;height:60px" />
</div>
    <div id="detil_part_" name="detil_part_"></div>
	</div>
    </div>
<div id="tampil">
</div>
<script>
 

    $(function(){
	//alert('tes');
	
	
			$("#tglawal").datepicker({format:'dd-mm-yyyy'});
				$('#tglawal').on('changeDate', function(ev){ $(this).datepicker('hide');	});
				$("#tglakhir").datepicker({format:'dd-mm-yyyy'});
				$('#tglakhir').on('changeDate', function(ev){ $(this).datepicker('hide');	});
			
	})
	</script>
<script>
	 $("#customer").change(function(){ 
		var id_customer=$("#customer").val();
            
            $.ajax({
                url:"<?php echo site_url('barang_masuk/unit_bagian');?>",
                type:"POST",
                data:"id_customer="+id_customer,
                cache:false,
					dataType: "json",
                success:function(data){
                    $("#unit_bagian").html(data.sub_customer);
                }
            });
        })
   
</script>

<script>
    $(function(){

	      $("#print").click(function(){
				 $('#progress_').show();  
			 var tglawal=$("#tglawal").val();
			 var tglakhir=$("#tglakhir").val();
			  var jenis=$("#jenis").val();
			  var customer=$("#customer").val();
			  var unit_bagian=$("#unit_bagian").val();
			  var gedung=$("#gedung").val();
			   var status=$("#status").val();
			      var petugas=$("#petugas").val();
           $.ajax({
                url:"<?php echo site_url('laporan/sett');?>",
                type:"post",
                data:"tglawal="+tglawal+"&tglakhir="+tglakhir+"&jenis="+jenis+"&customer="+customer+"&unit_bagian="+unit_bagian+"&gedung="+gedung+"&status="+status
				+"&petugas="+petugas,
					
                cache:false,
                success:function(html){
				 $('#progress_').hide();  
                 window.location.href='<?php echo site_url('laporan/print4_tagihan');?>';
                }
            })
        });
	 	        $("#export_excel").click(function(){
				 $('#progress_').show();  
			 var tglawal=$("#tglawal").val();
			 var tglakhir=$("#tglakhir").val();
			  var jenis=$("#jenis").val();
			  var customer=$("#customer").val();
			  var unit_bagian=$("#unit_bagian").val();
			  var gedung=$("#gedung").val();
			   var status=$("#status").val();
           $.ajax({
                url:"<?php echo site_url('laporan/sett');?>",
                type:"post",
                data:"tglawal="+tglawal+"&tglakhir="+tglakhir+"&jenis="+jenis+"&customer="+customer+"&unit_bagian="+unit_bagian+"&gedung="+gedung+"&status="+status,
					
                cache:false,
                success:function(html){
				 $('#progress_').hide();  
                 window.location.href='<?php echo site_url('laporan/report4_excel');?>';
                }
            })
        });
		
      
    })
</script>