<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'refresh_token',
        'id',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function hasLiked(Quote $quote)
    {
        return !$this->likes()->where('quote_id', $quote->id)->exists();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function hasFavorited(Quote $quote)
    {
        return !$this->favorites()->where('quote_id', $quote->id)->exists();
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function likedQuotes()
    {
        return $this->hasManyThrough(Quote::class, Like::class, 'user_id', 'id', 'id', 'quote_id');
    }

    public function favoriteQuotes()
    {
        return $this->hasManyThrough(Quote::class, Favorite::class, 'user_id', 'id', 'id', 'quote_id');
    }
}
