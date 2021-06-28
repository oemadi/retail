<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabang';
    public function barang()
    {
        return $this->hasMany(Barang::class, 'branch', 'id');
    }
}
