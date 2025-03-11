<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = ['author', 'type_id', 'quote', 'content'];

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
