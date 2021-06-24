<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    public function hutang()
    {
        return $this->hasMany(Hutang::class, 'customer_id', 'id');
    }
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'customer_id', 'id');
    }

}
