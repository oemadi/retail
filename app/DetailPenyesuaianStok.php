<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPenyesuaianStok extends Model
{
    protected $table = 'detail_penyesuaian_stok';
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
}
