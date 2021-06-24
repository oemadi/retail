<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function detail_penjualan()
    {
        return $this->hasMany(Detail_penjualan::class, 'penjualan_id', 'id');
    }
    public function return_penjualan()
    {
        return $this->hasOne(Return_penjualan::class, 'penjualan_id', 'id');
    }
    public static function kodeFaktur()
    {
        $cek = penjualan::all();
        if ($cek->count() > 0) {
            $penjualan = penjualan::orderBy('id', 'DESC')->first();
            $nourut = (int) substr($penjualan->faktur, -8, 8);
            $nourut++;
            $char = "TRK";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "TRK"  . "00000001";
        }
        return $number;
    }
}
