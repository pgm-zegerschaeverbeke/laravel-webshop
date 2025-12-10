<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name', 'is_admin'
    ];

    protected $hidden = ['password', 'remember_token'];

    // nodig voor filament interface
    public function getFilamentName(): string
    {
        return $this->getFullName();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    // Relationships
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getFullName(): string
    {
        $fullName = trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
        return $fullName ?: $this->name;
    }

    // kijkt of user een bepaald product als favoriet heeft
    public function hasFavorite(Product $product): bool
    {
        return $this->favorites()->where('product_id', $product->id)->exists();
    }

    // wisselt favoriet status van product, als product al favoriet is dan verwijderen, als niet favoriet is dan toevoegen
    public function toggleFavorite(Product $product): bool
    {
        // als product al favoriet is dan verwijderen
        if ($this->hasFavorite($product)) {
            $this->favorites()->detach($product->id);
            return false;
        } 
        // als niet favoriet is dan toevoegen
        else {
            $this->favorites()->attach($product->id);
            return true;
        }
    }

    // geeft count van favorieten terug
    public function getFavoriteCount(): int
    {
        return $this->favorites()->count();
    }

    // ophalen van alle favorieten van een user die beschikbaar zijn
    public function getAvailableFavorites()
    {
        return $this->favorites()
            ->available()
            // eager loading van gerelateerde product images, category en brand
            ->with(['images', 'category', 'brand'])
            ->get();
    }
}

