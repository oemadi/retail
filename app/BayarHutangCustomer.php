<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class BayarHutangCustomer extends Model
{
    protected $table = 'bayar_hutang_customer';
    public static function kodeFaktur()
    {
        $branch = Session::get('branch');
        $cek = BayarHutangCustomer::where('branch',$branch)->get();
        if ($cek->count() > 0) {
            $hutang = BayarHutangCustomer::where('branch',$branch)->orderBy('id', 'DESC')->first();
            $nourut = (int) substr($hutang->faktur, -8, 8);
            $nourut++;
            $char = "HC";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "HC"  . "00000001";
        }
        return $number;
    }
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Suplier::class, 'customer_id', 'id');
    }
}
