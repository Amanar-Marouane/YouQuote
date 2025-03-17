<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['author', 'type_id', 'quote', 'content', 'user_id'];

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
}
