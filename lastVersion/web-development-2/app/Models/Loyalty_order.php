<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loyalty_order extends Model
{
    protected $fillable = [
        'client_id',
        'order_id',
    ];
}
