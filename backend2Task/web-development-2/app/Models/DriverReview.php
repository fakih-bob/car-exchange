<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverReview extends Model
{

    protected $fillable = [
        'client_id',
        'driver_id',
        'rating',
        'review',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

}
