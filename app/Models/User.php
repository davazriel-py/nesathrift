<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const EMAIL_DOMAIN = '@mhs.unesa.ac.id';

    protected $fillable = [
        'name', 'email', 'nim', 'faculty', 'study_program',
        'whatsapp', 'avatar', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'otp_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at'    => 'datetime',
            'otp_sent_at'       => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /* ---------- Relasi ---------- */

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function purchasedProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'buyer_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wishlists')->withTimestamps();
    }

    /* ---------- Helper ---------- */

    public function hasVerifiedOtp(): bool
    {
        return $this->email_verified_at !== null;
    }

    public function canResendOtp(int $cooldownSeconds = 60): bool
    {
        return $this->otp_sent_at === null
            || $this->otp_sent_at->diffInSeconds(now()) >= $cooldownSeconds;
    }

    // Email tersensor: da***@mhs.unesa.ac.id
    protected function maskedEmail(): Attribute
    {
        return Attribute::get(function () {
            [$local, $domain] = explode('@', $this->email);
            return substr($local, 0, 2) . str_repeat('*', max(strlen($local) - 2, 3)) . '@' . $domain;
        });
    }

    protected function whatsappUrl(): Attribute
    {
        return Attribute::get(fn () => $this->whatsapp ? 'https://wa.me/' . $this->whatsapp : null);
    }
}