<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'photo','status'];



    // public function booking()
    // {
    //     return $this->hasMany(Booking::class);
    // }
}

