<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Return_pembelian extends Model
{
    protected $table = 'return_pembelian';
    public static function kodeFaktur()
    {
        $branch = Session::get('branch');
        $cek = Return_pembelian::where('branch',$branch)->get();
        if ($cek->count() > 0) {
            $return = Return_pembelian::where('branch',$branch)->orderBy('id', 'DESC')->first();
            $nourut = (int) substr($return->faktur, -8, 8);
            $nourut++;
            $char = "RPM";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "RPM"  . "00000001";
        }
        return $number;
    }
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'id');
    }
    public function detail_return_pembelian()
    {
        return $this->hasMany(Detail_return_pembelian::class, 'return_beli_id', 'id');
    }
}
