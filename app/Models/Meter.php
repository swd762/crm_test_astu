<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    use HasFactory;

    protected $fillable = ['meters_previous', 'meters_last',];


    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
