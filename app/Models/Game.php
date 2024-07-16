<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'photo','status'];

    public function orders()
    {
        return $this->morphMany('App\Models\OrderServiceGame', 'orderable');
    }
    public function review()
    {
        return $this->morphMany('App\Models\Review', 'reviewable');
    }

    // public function booking()
    // {
    //     return $this->hasMany(Booking::class);
    // }
}