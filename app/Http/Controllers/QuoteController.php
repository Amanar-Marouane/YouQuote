<?php

namespace App\Http\Controllers;

use App\Http\Requests\{QuoteStoreRequest, QuoteUpdateRequest};
use App\Http\Trait\HttpResponses;
use App\Models\Quote;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(Quote::all());
    }

    public function find($column, $value)
    {
        return $this->success(
            Quote::where($column, $value)
                ->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(QuoteStoreRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuoteStoreRequest $request)
    {
        $typesColumns = [
            'Book' => ['year', 'publisher'],
            'Article' => ['page_range', 'issue', 'volume', 'year'],
            'Website' => ['url'],
        ];

        $type = Type::where('type', $request->type)
            ->first();
        $quote = Quote::create([
            'author' => $request->author,
            'quote' => $request->quote,
            'type_id' => $type->id,
            'content' => json_encode($request->only($typesColumns[$request->type]), true),
        ]);
        return $this->success($quote);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuoteUpdateRequest $request, string $id)
    {
        if (Auth::id() != (int)$request->user_id) {
            return $this->error('', 'No Access', 401);
        }
        $quote = Quote::find($id);
        if (!$quote) return $this->error('', 'Not Found', 404);

        $updatedQuote = [];
        foreach (['author', 'quote'] as $key) {
            if ($request->$key) {
                $updatedQuote[$key] = $request->$key;
            }
        }
        $content = $request->except(['author', 'type', 'quote', 'user_id']);
        $quote->update(array_merge($updatedQuote, ['content' => $content]));
        return $this->success($quote, 'The quote has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if (Auth::id() != (int)$request->user_id) {
            return $this->error('', 'No Access', 401);
        }
        $quote = Quote::find($id);
        $quote->delete();
        return $this->success('', 'The quote has been deleted');
    }

    public function random($limit)
    {
        $quotes = Quote::inRandomOrder()
            ->limit($limit)
            ->pluck('quote');
        return $this->success($quotes);
    }

    public function wordsCount($count)
    {
        $quotes = Quote::whereRaw('LENGTH(TRIM(REGEXP_REPLACE(quote, "[^a-zA-Z0-9 ]", ""))) - LENGTH(REPLACE(REGEXP_REPLACE(quote, "[^a-zA-Z0-9 ]", ""), " ", "")) + 1 >= ?', [$count])
            ->pluck('quote');
        return $this->success($quotes);
    }
}
