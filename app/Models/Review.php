<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(AppUsers::class);
    }
    public function reviewable()
    {
        return $this->morphTo();
    }
    protected $casts = [
        'user_id' => 'integer',
        'rating' => 'double',

    ];

}