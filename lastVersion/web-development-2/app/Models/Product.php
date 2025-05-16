<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['weight', 'height', 'width', 'order_id'];

    // The product belongs to one order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


}
