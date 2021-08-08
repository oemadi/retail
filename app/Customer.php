<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    public function hutangCustomer()
    {
        return $this->hasMany(HutangCustomer::class, 'customer_id', 'id');
    }
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'customer_id', 'id');
    }

}
