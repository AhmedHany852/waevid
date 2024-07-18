<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{

    protected $table = 'social_media';
    protected $guarded = [];
    public function review()
    {
        return $this->morphMany('App\Models\Review', 'reviewable');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
