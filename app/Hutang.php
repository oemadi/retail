<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Hutang extends Model
{
    protected $table = 'bayar_hutang';
    public static function kodeFaktur()
    {
        $branch = Session::get('branch');
        $cek = Hutang::all();
        if ($cek->count() > 0) {
            $hutang = Hutang::where('branch',$branch)->orderBy('id', 'DESC')->first();
            $nourut = (int) substr($hutang->faktur, -8, 8);
            $nourut++;
            $char = "BH";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "BH"  . "00000001";
        }
        return $number;
    }
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian', 'id');
    }
    public function suplier()
    {
        return $this->belongsTo(Suplier::class, 'id_suplier', 'id');
    }
}
