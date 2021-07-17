<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class HutangCustomer extends Model
{
    protected $table = 'hutang_customer';
    public static function kodeFaktur()
    {
        $branch = Session::get('branch');
        $cek = HutangCustomer::all();
        if ($cek->count() > 0) {
            $hutang = HutangCustomer::where('branch',$branch)->orderBy('id', 'DESC')->first();
            $nourut = (int) substr($hutang->faktur, -8, 8);
            $nourut++;
            $char = "HCS";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "HCS"  . "00000001";
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
