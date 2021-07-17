<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Gaji extends Model
{
    protected $table = 'gaji';
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }
    public static function kodeFaktur()
    {
        $branch = Session::get('branch');
        $cek = Gaji::where('branch',$branch)->get();
        if ($cek->count() > 0) {
            $gaji = Gaji::where('branch',$branch)->orderBy('id', 'DESC')->first();
            $nourut = (int) substr($gaji->faktur, -8, 8);
            $nourut++;
            $char = "PGJ";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "PGJ"  . "00000001";
        }
        return $number;
    }
}
