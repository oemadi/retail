<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;
    protected $table = 'barang';
   // public $incrementing = false;
    public static function kodeBarang()
    {
        $branch = Session::get('branch');
        $cek = Barang::where('branch',$branch)->get();
        if ($cek->count() > 0) {
            $peminjaman = Barang::where('branch',$branch)->orderBy('id', 'DESC')->withTrashed()->first();
            $nourut = (int) substr($peminjaman->id, -7, 7);
            $nourut++;
            $char = "BRG";
            $number = $char  .  sprintf("%07s", $nourut);
        } else {
            $number = "BRG"  . "0000001";
        }
        return $number;
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id', 'id');
    }
    public function detail_penjualan()
    {
        return $this->hasMany(Detail_penjualan::class, 'barang_id', 'id');
    }
}
