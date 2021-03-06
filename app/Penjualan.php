<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
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
    public function BayarHutangCustomer()
    {
        return $this->hasMany(BayarHutangCustomer::class, 'id_penjualan', 'id');
    }
    public function return_penjualan()
    {
        return $this->hasOne(Return_penjualan::class, 'penjualan_id', 'id');
    }
    public static function kodeFaktur()
    {
        $branch = Session::get('branch');
        $cek = penjualan::where('branch',$branch)->get();
        if ($cek->count() > 0) {
            $penjualan = penjualan::where('branch',$branch)->orderBy('id', 'DESC')->first();
            $nourut = (int) substr($penjualan->faktur, -8, 8);
            $nourut++;
            $char = "FK";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "FK"  . "00000001";
        }
        return $number;
    }
    public function piutang()
    {
        return $this->hasOne(HutangCustomer::class, 'penjualan_id', 'id');
    }
}
