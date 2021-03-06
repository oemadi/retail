<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    protected $table = 'piutang';
    public static function kodeFaktur()
    {
        $branch = Session::get('branch');
        $cek = Piutang::where('branch',$branch)->get();
        if ($cek->count() > 0) {
            $piutang = Piutang::where('branch',$branch)->orderBy('id', 'DESC')->first();
            $nourut = (int) substr($piutang->faktur, -8, 8);
            $nourut++;
            $char = "PTG";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "PTG"  . "00000001";
        }
        return $number;
    }
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'id');
    }
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }
}
