<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boat extends Model
{
    protected $fillable = [
        "name",
        "type",
        "capacity",
        "description",
        "price_per_hour",
        "price_per_trip",
        "location",
        "status",
    ];

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
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
