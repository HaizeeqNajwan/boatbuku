<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerProfile extends Model
{
    protected $fillable = [
        "user_id",
        "slug",
        "bio",
        "whatsapp",
        "bank_name",
        "bank_acc",
        "verified",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
