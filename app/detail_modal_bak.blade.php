@extends('layouts.dashboard')
@section('content')

    <div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Detail PMS</h4>
      </div>
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
          <li><a href="#">Dashboard</a></li>
          <li class="active">Detail PMS</li>
        </ol>
      </div>
    </div>
	     <form class="form-horizontal" method="post" action="{{route('update_tindakan', $data->id)}}" enctype="multipart/form-data">
			  {{ csrf_field() }}
     <div class="row">
        <div class="col-sm-6">
          <div class="white-box">

			    <input type="hidden" id="idx" class="form-control" value="{{$data->id}}"  >
             <div class="form-group">
                  <label class="col-md-12">Code</label>
                      <div class="col-md-12">
                       <input type="text" class="form-control" value="{{$data->kode}}-{{$data->referensi}}"  disabled="">
                  </div>
                </div>

             <div class="form-group" >
                 <div class="col-md-12" >
                   <label class="col-md-12">Cost Estimation</label>
                    <input type="text" class="form-control" value="{{$data->price}}"  disabled="">
               </div>
             </div>
             <div class="form-group">
                <label class="col-md-12">Date Action</label>
                  <div class="col-md-12">
                   <input type="text" class="form-control" name="tanggal" value="{{$data->tanggal}}"   disabled="">
                 </div>
            </div>
			<div class="form-group">
                <label class="col-md-12">Officer</label>
                  <div class="col-md-12">
                   <input type="text" class="form-control" name="tanggal" value="{{$data->petugas}}"   disabled="">
                 </div>
            </div>

            <div class="form-group">
                <label class="col-md-12">Condition</label>
                    <div class="col-md-12">
                     <select name="id_kondisi" class="form-control "  disabled="">
                       <option value="0">-Choose-</option>
                         @foreach($kondisi as $key)
                        <option <?php if($key->id == $data->id_kondisi){ echo "selected='selected'";} ?> value="{{$key->id}}">{{$key->kondisi}}</option>
                        @endforeach
                      </select>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="col-sm-6">
          <div class="white-box">

             <div class="form-group" >
                 <div class="col-md-12" >
                   <label class="col-md-12">Interval</label>
                    <input type="text" class="form-control" value="{{$data->periode}}"  disabled="">
             </div>
             </div>
               <div class="form-group" id="job-ref" >
                 <label class="col-md-12">Job Reference</label>
                  <div class="col-md-12">
                    <textarea  id="job_desk" name="job_desk" class="summernote"><?= nl2br($data->job_desk); ?></textarea>
                </div>
              </div>
             <div class="form-group">
                <label class="col-md-12">Action</label>
                  <div class="col-md-12">
                   <textarea  id="tindakan"  name="tindakan" class="summernote2" >{{nl2br($data->tindakan)}}</textarea>
                </div>
             </div>
			 <div class="form-group">
                <label class="col-md-12">Approved By</label>
                  <div class="col-md-12">
                   <input type="text" class="form-control" name="tanggal" value="{{$data->approved_by}}"   disabled="">
                 </div>
            </div>
			  <div class="form-actions">
                          <div style="float: left;padding-left: 10px" >
                          <button type="submit" class="btn btn-primary btn-outline btn-rounded"> <i class="fa fa-check"></i> Save</button>
                          <a class="btn btn-primary btn-outline btn-rounded" href="{{route('listAction')}}">Close</a></div>
                          </div>
                          <br>

            </div>
          </div>
       </div>
 </form>
    <div class="white-box">
       <div class="row">
           <div class="col-md-3">
                <div class="form-group">
               <label class="col-md-12">Image</label>
                 <a class="thumbnail" href="#">
                  <img @if($data->photo) src="{{ asset('storage/app/gallery/image/'.$data->photo) }}" @else src="{{ asset('public/images/no-image-available.jpg') }}"  @endif style="width: 200px; height: auto;">
                </a>
           </div>
             </div>

		    <div class="col-md-3">
                <div class="form-group">
               <label class="col-md-12">Image</label>
                 <a class="thumbnail" href="#">
                  <img @if($data->photo2) src="{{ asset('storage/app/gallery/image/'.$data->photo2) }}" @else src="{{ asset('public/images/no-image-available.jpg') }}"  @endif style="width: 200px; height: auto;">
                </a>
           </div>
             </div>
		     <div class="col-md-3">
                <div class="form-group">
               <label class="col-md-12">Image</label>
                 <a class="thumbnail" href="#">
                  <img @if($data->photo3) src="{{ asset('storage/app/gallery/image/'.$data->photo3) }}" @else src="{{ asset('public/images/no-image-available.jpg') }}"  @endif style="width: 200px; height: auto;">
                </a>
           </div>
             </div>

           <div class="col-md-3">
              <div class="form-group">
                <label class="col-md-12">Video</label>
                 @if($data->video)
                   <div class="col-md-10">
                    <video width="400" height="240" controls>
                    <source @if($data->video) src="{{ asset('storage/app/gallery/image/'.$data->video) }}" type="video/webm"  @endif  >
                   </div>
                   @else
                    <div class="col-md-10">
                    <img width="100%" height="auto" src="{{ asset('storage/app/gallery/image/no-video-available.png') }}" >
                   </div>
                  @endif
                </div>
             </div>
          </div>
       </div>


<div class="modal fade" id="imgmodal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{$data->kode}}-{{$data->referensi}}"</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img style="width:100%;height:auto;" src="" id="show-img">
      </div>

    </div>
  </div>
</div>
<script type="text/javascript">
    $(function () {

        $("img").click(function(){
           var img=$(this).attr('src');
             $("#show-img").attr('src',img);
             $("#imgmodal").modal('show');
        });

   $('.summernote').summernote({
            height: 150,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false,              // set focus to editable area after initializing summernote
            toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                  ]
        });
		  $('.summernote2').summernote({
            height: 150,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false,              // set focus to editable area after initializing summernote
            toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                  ]
        });

        $('.inline-editor').summernote({
            airMode: true
        });


});
</script>
@endsection
