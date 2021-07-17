<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class BayarHutangSuplier extends Model
{
    protected $table = 'bayar_hutang_suplier';
    public static function kodeFaktur()
    {
        $branch = Session::get('branch');
        $cek = BayarHutangSuplier::where('branch',$branch)->get();
        if ($cek->count() > 0) {
            $hutang = BayarHutangSuplier::where('branch',$branch)->orderBy('id', 'DESC')->first();
            $nourut = (int) substr($hutang->faktur, -8, 8);
            $nourut++;
            $char = "HS";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "HS"  . "00000001";
        }
        return $number;
    }
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'id');
    }
    public function Suplier()
    {
        return $this->belongsTo(Suplier::class, 'pembelian_id', 'id');
    }
}
