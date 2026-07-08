<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ["boat_id", "user_id", "rating", "comment"];

    public function boat()
    {
        return $this->belongsTo(Boat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
