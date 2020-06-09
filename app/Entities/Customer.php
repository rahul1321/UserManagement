<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 'active',
    ];


    public function users(){
        return $this->hasMany(\App\User::class);
    }
}
