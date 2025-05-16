<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ["is_verified", 'role', 'google_id', 'email', 'password', 'name', 'dob', 'phone'];

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    
    public function reviewsWritten()
{
    return $this->hasMany(DriverReview::class, 'client_id');
}

public function reviewsReceived()
{
    return $this->hasMany(DriverReview::class, 'driver_id');
}

}
