<?php

namespace App\Models;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Model;

class Pricing_model extends Model
{
    protected $fillable = [
        'driver_id',
        'short_distance_limit',
        'short_distance_price',
        'long_distance_rate',
        'per_volume_rate',
        'per_weight_rate',
    ];
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
