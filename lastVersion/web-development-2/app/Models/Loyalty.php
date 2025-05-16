<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Loyalty extends Model
{
    protected $fillable = [
        'client_id',
        'total_kilometers',
        'points',
        'balance',
    ];
    public function client(){
        return $this->belongsTo('App\Models\Client');
    }
}
