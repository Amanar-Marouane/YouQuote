<?php

namespace App\Http\Controllers;

use App\Http\Trait\HttpResponses;
use App\Models\{Favorite, Quote};
use Illuminate\Http\Request;
use App\Http\Resources\QuoteResource;

class FavoriteController extends Controller
{
    use HttpResponses;

    public function favorite(Request $request, $quote_id)
    {
        $quote = Quote::find($quote_id);
        if ($request->user()->hasFavorited($quote)) {
            Favorite::create([
                'user_id' => $request->user()->id,
                'quote_id' => (int) $quote_id
            ]);
            return $this->success(new QuoteResource($quote), 'Quote Has Been Added To Favorite Collection');
        }
        $favorite = Favorite::where('quote_id', $quote_id)
            ->where('user_id', $request->user()->id)
            ->first();
        $favorite->delete();
        return $this->success(new QuoteResource($quote), 'Quote Has Been Removed From Favorite Collection');
    }

    public function favorites(Request $request)
    {
        $quotes = $request->user()->favoriteQuotes;
        return $this->success(QuoteResource::collection($quotes), 'You\'re Favorite Quotes');
    }
}
