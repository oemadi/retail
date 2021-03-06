<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    protected $table = 'suplier';
    public function hutangSuplier()
    {
        return $this->hasMany(HutangSuplier::class, 'suplier_id', 'id');
    }
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'suplier_id', 'id');
    }
}
