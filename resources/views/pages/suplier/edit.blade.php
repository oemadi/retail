@extends('layouts.template')
@section('page','Tambah Suplier')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>
                <h3 class="box-title">@yield('page')</h3>
            </div>
            <div class="box-body">
                <form action="{{ route('suplier.update',$suplier->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group @error('nama') has-error @enderror">
                                <label for="nama">Nama Suplier</label>
                                <input type="text" class="form-control" name="nama" id="nama"
                                    placeholder="Nama Suplier...." value="{{ $suplier->nama }}">
                                @error('nama')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group @error('kontak') has-error @enderror">
                                <label for="kontak">Kontak</label>
                                <input type="text" class="form-control" name="kontak" id="kontak"
                                    placeholder="Kontak Suplier...." value="{{ $suplier->kontak }}">
                                @error('kontak')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group @error('email') has-error @enderror">
                                <label for="email">Email *Optional</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Email Suplier...." value="{{ $suplier->email }}">
                                @error('email')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group @error('no_hp') has-error @enderror">
                                <label for="no_hp">No HP</label>
                                <input type="text" class="form-control" name="no_hp" id="no_hp"
                                    placeholder="No Hp Suplier...." value="{{ $suplier->no_hp }}">
                                @error('no_hp')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group @error('alamat') has-error @enderror">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control"
                                    placeholder="Alamat....">{{ $suplier->alamat }}</textarea>
                                @error('alamat')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" style="cursor:pointer"><i class="fa fa-save"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')

<script>
    $(document).ready(function(){
    //   /  $('#alamat').wysihtml5();
    });
</script>
@endpush
