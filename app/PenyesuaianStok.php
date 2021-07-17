<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class PenyesuaianStok extends Model
{
    protected $table = 'penyesuaian_stok';
    public static function kodeFaktur()
    {
        $branch = Session::get('branch');
        $cek = PenyesuaianStok::where('branch',$branch)->get();
        if ($cek->count() > 0) {
            $return = PenyesuaianStok::where('branch',$branch)->orderBy('id', 'DESC')->first();
            $nourut = (int) substr($return->faktur, -8, 8);
            $nourut++;
            $char = "SS";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "SS"  . "00000001";
        }
        return $number;
    }
}
