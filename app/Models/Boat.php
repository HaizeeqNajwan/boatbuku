<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boat extends Model
{
    public function owner()
    {
        return $this->belongsTo(User::class, "owner_id");
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    } //
}
