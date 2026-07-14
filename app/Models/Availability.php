<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Availability extends Model
{
    protected $fillable = [
        'boat_id',
        'date',
        'start_time',
        'end_time',
        'is_blocked',
    ];

    protected $casts = [
        'date' => 'date',
        'is_blocked' => 'boolean',
    ];

    public function boat(): BelongsTo
    {
        return $this->belongsTo(Boat::class);
    }
}
