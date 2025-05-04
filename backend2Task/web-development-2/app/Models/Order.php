<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    // The order belongs to a user
    protected $fillable = ['cost', 'status', 'user_id','paid','distance'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    } 
    
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function driver()
{
    return $this->belongsTo(User::class, 'driver_id');
}

    
    public function Inbox()
    {
        return $this->hasOne(Inbox::class); 
    }
}
