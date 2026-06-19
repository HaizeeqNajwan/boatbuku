<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function boat()
    {
        return $this->belongsTo(Boat::class);
    }
}
