<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'anggota_id', 'id');
    }
    public function piutang()
    {
        return $this->hasMany(Piutang::class, 'anggota_id', 'id');
    }
}
