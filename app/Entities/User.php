<?php

namespace App\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'customer_id','active', 'phone_number','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {

    }


    public function routeNotificationForNexmo($notification)
    {
        return $this->phone_number;
    }


    public function customer(){
        return $this->belongsTo(\App\Entities\Customer::class);
    }

    protected static function booted()
    {
        static::created(function ($user) {
            $user->notify(new \App\Notifications\VerifyEmailNotification);
        });
    }

    public function isOwner(){
        return $this->role === 1;
    }

    public function isEditor(){
        return $this->role === 2;
    }

    public function isFollower(){
        return $this->role === 3;
    }
}
