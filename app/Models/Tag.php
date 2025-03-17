<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tag', 'quote_id'];

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}
