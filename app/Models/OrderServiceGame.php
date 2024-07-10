<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderServiceGame extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function orderable()
    {
        return $this->morphTo();
    }
}
