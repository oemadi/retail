<div style="padding:20px">

<legend>Periode Rekap Kas</legend>
<form class="form-horizontal" action="<?= base_url('laporan/report9');?>" method="post" enctype="multipart/form-data">
    
	
   <div class="form-group">
        <label class="col-lg-2 control-label">Tgl Awal </label>
        <div class="col-lg-5">
          <input type="date" id="tgl1" name="tgl1" class="form-control" required>
        </div>
    </div>
  <div class="form-group">
        <label class="col-lg-2 control-label">Tgl Akhir </label>
        <div class="col-lg-5">
            <input type="date" id="tgl2" name="tgl2" class="form-control" required>
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