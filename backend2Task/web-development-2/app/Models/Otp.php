<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = ['code', 'expires_at', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
