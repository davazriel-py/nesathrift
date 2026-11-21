<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_SOLD      = 'sold';

    public const CONDITIONS = [
        'baru'         => 'Baru',
        'seperti_baru' => 'Seperti Baru',
        'layak_pakai'  => 'Layak Pakai',
    ];

    public const LOCATIONS = [
        'ketintang'   => 'Kampus Ketintang',
        'lidah_wetan' => 'Kampus Lidah Wetan',
        'lainnya'     => 'Sekitar Kos / Lainnya',
    ];

    protected $fillable = [
        'user_id', 'category_id', 'title', 'description', 'price',
        'condition', 'campus_location', 'image_path',
        'status', 'buyer_id', 'sold_price', 'sold_at',
    ];

    protected function casts(): array
    {
        return [
            'price'      => 'integer',
            'sold_price' => 'integer',
            'sold_at'    => 'datetime',
        ];
    }

    /* ---------- Relasi ---------- */

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function wishlistedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }

    /* ---------- Scopes ---------- */

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    public function scopeSold(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_SOLD);
    }

    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        return $query->when($keyword, fn ($q) => $q->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        }));
    }

    public function scopeFilterCategory(Builder $query, ?string $categorySlug): Builder
    {
        return $query->when($categorySlug, fn ($q) =>
            $q->whereHas('category', fn ($c) => $c->where('slug', $categorySlug)));
    }

    public function scopeFilterLocation(Builder $query, ?string $location): Builder
    {
        return $query->when($location, fn ($q) => $q->where('campus_location', $location));
    }

    public function scopePriceBetween(Builder $query, ?int $min, ?int $max): Builder
    {
        return $query
            ->when($min, fn ($q) => $q->where('price', '>=', $min))
            ->when($max, fn ($q) => $q->where('price', '<=', $max));
    }

    /* ---------- Helper & Accessor ---------- */

    public function isSold(): bool
    {
        return $this->status === self::STATUS_SOLD;
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::get(fn () => 'Rp ' . number_format($this->price, 0, ',', '.'));
    }

    protected function formattedSoldPrice(): Attribute
    {
        return Attribute::get(fn () => $this->sold_price
            ? 'Rp ' . number_format($this->sold_price, 0, ',', '.')
            : null);
    }

    protected function conditionLabel(): Attribute
    {
        return Attribute::get(fn () => self::CONDITIONS[$this->condition] ?? $this->condition);
    }

    protected function locationLabel(): Attribute
    {
        return Attribute::get(fn () => self::LOCATIONS[$this->campus_location] ?? $this->campus_location);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => Storage::disk('public')->url($this->image_path));
    }

    protected function whatsappChatUrl(): Attribute
    {
        return Attribute::get(function () {
            $number = $this->seller?->whatsapp;
            if (! $number) {
                return null;
            }
            $text = "Halo, saya tertarik dengan barang \"{$this->title}\" ({$this->formatted_price}) "
                  . 'di NesaThrift. Apakah masih tersedia?';

            return 'https://wa.me/' . $number . '?text=' . rawurlencode($text);
        });
    }

    protected function soldInfo(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->isSold() || ! $this->buyer) {
                return null;
            }
            return "Terjual kepada: {$this->buyer->name} ({$this->buyer->masked_email}) pada "
                 . $this->sold_at->translatedFormat('d F Y');
        });
    }
}