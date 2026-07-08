<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        "boat_id",
        "customer_name",
        "customer_phone",
        "date",
        "start_time",
        "end_time",
        "pax",
        "status",
        "notes",
    ];

    public function boat()
    {
        return $this->belongsTo(Boat::class);
    }
}
