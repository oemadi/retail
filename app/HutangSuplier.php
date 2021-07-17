<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class HutangSuplier extends Model
{
    protected $table = 'hutang_suplier';
    public static function kodeFaktur()
    {
        $branch = Session::get('branch');
        $cek = HutangSuplier::where('branch',$branch)->get();
        if ($cek->count() > 0) {
            $hutang = HutangSuplier::where('branch',$branch)->orderBy('id', 'DESC')->first();
            $nourut = (int) substr($hutang->faktur, -8, 8);
            $nourut++;
            $char = "PS";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "PS"  . "00000001";
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
