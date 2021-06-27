<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HutangSuplier extends Model
{
    protected $table = 'hutang_suplier';
    public static function kodeFaktur()
    {
        $cek = HutangSuplier::all();
        if ($cek->count() > 0) {
            $hutang = HutangSuplier::orderBy('id', 'DESC')->first();
            $nourut = (int) substr($hutang->faktur, -8, 8);
            $nourut++;
            $char = "HCS";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "HCS"  . "00000001";
        }
        return $number;
    }
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'id');
    }
    public function suplier()
    {
        return $this->belongsTo(Suplier::class, 'suplier_id', 'id');
    }
}
