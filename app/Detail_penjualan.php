<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_penjualan extends Model
{
    protected $table = 'detail_penjualan';

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id','penjualan_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
}
