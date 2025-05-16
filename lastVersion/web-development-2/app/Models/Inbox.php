<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'driver_id','message','type'];
    

   /*     public function orders()
    {
        return $this->belongsTo(Order::class);
    }*/
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function User()
{
    return $this->belongsTo(User::class, 'driver_id');
}

}
