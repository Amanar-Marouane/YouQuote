<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['author', 'type_id', 'quote', 'content', 'user_id'];

    protected static function booted()
    {
        static::addGlobalScope('valid', function (Builder $builder) {
            $builder->where('status', 'Valid');
        });
    }

    public function categories()
    {
        return $this->hasManyThrough(Category::class, QuoteCategory::class, 'quote_id', 'id', 'id', 'category_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public static function frenquecyInc($quotes)
    {
        foreach ($quotes as $quote) {
            $quote->frequency++;
            $quote->save();
        }
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public static function tagQuotes(array $tags)
    {
        return Quote::join('tags', 'tags.quote_id', '=', 'quotes.id')
            ->whereIn('tags.tag', $tags)
            ->select('quotes.*')
            ->get();
    }

    public function isLiked(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function isFavorited(User $user)
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}
