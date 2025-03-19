<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeResource;
use App\Http\Resources\QuoteResource;
use App\Http\Trait\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Like;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LikeController extends Controller
{
    use HttpResponses;
    use AuthorizesRequests;
    public function like(Request $request, $quote_id)
    {
        $quote = Quote::find($quote_id);
        if ($request->user()->hasLiked($quote)) {
            like::create([
                'user_id' => $request->user()->id,
                'quote_id' => (int) $quote_id
            ]);
            return $this->success(new QuoteResource($quote), 'You Liked This Quote');
        }
        $like = like::where('quote_id', $quote_id)
            ->where('user_id', $request->user()->id)
            ->first();
        $like->delete();
        return $this->success(new QuoteResource($quote), 'You Unliked This Quote');
    }

    public function likes(Request $request)
    {
        $quotes = $request->user()->likedQuotes;
        return $this->success(QuoteResource::collection($quotes), 'You\'re liked Quotes');
    }
}
