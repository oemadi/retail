<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Return_penjualan extends Model
{
    protected $table = 'return_penjualan';
    public static function kodeFaktur()
    {
        $branch = Session::get('branch');
        $cek = Return_penjualan::where('branch',$branch)->get();
        if ($cek->count() > 0) {
            $transaksi = Return_penjualan::where('branch',$branch)->orderBy('id', 'DESC')->first();
            $nourut = (int) substr($transaksi->faktur, -8, 8);
            $nourut++;
            $char = "RPJ";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "RPJ"  . "00000001";
        }
        return $number;
    }
    public function detail_return_jual()
    {
        return $this->hasMany(Detail_return_jual::class, 'return_jual_id', 'id');
    }
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'id');
    }
    public function detail_penjualan()
    {
        return $this->hasMany(Detail_penjualan::class, 'penjualan_id', 'id');
    }
}
