<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $role  // 'owner' or 'customer'
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
#[Fillable(["name", "email", "password", "phone", "role"])]
#[Hidden(["password", "remember_token"])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The "booted" method is called when the model is created.
     * Automatically create an OwnerProfile if the user registers as an owner.
     */
    protected static function booted(): void
    {
        static::created(function (User $user) {
            if ($user->role === "owner") {
                // Create a profile with a unique slug
                $slug = Str::slug($user->name . "-" . $user->id);
                // Ensure uniqueness (just in case)
                $originalSlug = $slug;
                $counter = 1;
                while (OwnerProfile::where("slug", $slug)->exists()) {
                    $slug = $originalSlug . "-" . $counter++;
                }
                OwnerProfile::create([
                    "user_id" => $user->id,
                    "slug" => $slug,
                ]);
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
            "role" => "string", // explicit cast, though not strictly needed
        ];
    }

    /* ===== Relationships ===== */

    /**
     * Get the boats owned by this user (if they are an owner).
     */
    public function boats()
    {
        return $this->hasMany(Boat::class, "owner_id");
    }

    /**
     * Get the owner profile associated with the user (only for owners).
     */
    public function profile()
    {
        return $this->hasOne(OwnerProfile::class);
    }

    /* ===== Role helpers ===== */

    /**
     * Check if the user is an owner.
     */
    public function isOwner(): bool
    {
        return $this->role === "owner";
    }

    /**
     * Check if the user is a customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === "customer";
    }

    /* ===== Additional accessors (optional) ===== */

    /**
     * Get the slug from the owner profile (convenience method).
     * Returns null if the user is not an owner or has no profile.
     */
    public function getSlugAttribute(): ?string
    {
        return $this->profile?->slug;
    }

    /**
     * Get the verified status from the owner profile (convenience).
     */
    public function getVerifiedAttribute(): bool
    {
        return $this->profile?->verified ?? false;
    }
}
