<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function meters()
    {
        return $this->hasMany(Meter::class);
    }
}
