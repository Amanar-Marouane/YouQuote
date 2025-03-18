<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Http\Resources\QuoteResource;
use App\Http\Trait\HttpResponses;
use App\Models\Quote;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use HttpResponses;

    public function byTags(Request $request)
    {
        $tags = $request->validate([
            'tags' => 'array',
        ]);

        if (empty($tags)) {
            return $this->success(QuoteResource::collection(Quote::all()), 'Please Provide Some Tags For More Specific Search');
        }
        $quotes = Quote::tagQuotes(Arr::flatten($tags));
        return $this->success(QuoteResource::collection($quotes));
    }
}
