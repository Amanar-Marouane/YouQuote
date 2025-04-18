<?php

namespace App\Http\Controllers;

use App\Http\Requests\{QuoteStoreRequest, QuoteUpdateRequest};
use App\Http\Resources\QuoteResource;
use App\Http\Trait\HttpResponses;
use App\Models\{Quote, Tag, QuoteCategory, Type};
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use function PHPSTORM_META\map;

class QuoteController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::all();
        return $this->success(QuoteResource::collection($quotes));
    }

    public function find($column, $value)
    {
        $quotes = Quote::where($column, 'LIKE', `%$value%`)
            ->get();
        Quote::frenquecyInc($quotes);
        return $this->success(QuoteResource::collection($quotes));
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
            'user_id' => $request->user()->id,
        ]);

        $categories = array_map(fn($id) => ['category_id' => $id, 'quote_id' => $quote->id], $request->category_id);
        QuoteCategory::insert($categories);

        if (!empty($request->tags)) {
            $tags = array_map(fn($tag) => ['tag' => $tag, 'quote_id' => $quote->id], $request->tags);
            Tag::insert($tags);
        }
        return $this->success(new QuoteResource($quote), null, 201);
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
        $quote = Quote::find($id);
        if ($request->user()->cannot('update', $quote)) {
            return $this->error('', 'No Access', 401);
        }
        if (!$quote) return $this->error('', 'Not Found', 404);

        $updatedQuote = [];
        foreach (['author', 'quote'] as $key) {
            if ($request->$key) {
                $updatedQuote[$key] = $request->$key;
            }
        }
        $content = $request->except(['author', 'type', 'quote', 'user_id', 'category_id', 'tags']);
        $quote->update(array_merge($updatedQuote, ['content' => json_encode($content, true)]));

        $categories = $request->category_id;
        $data = [];
        foreach ($categories as $key => $value) {
            $data[] = ['category_id' => $value, 'quote_id' => $quote->id];
        }
        QuoteCategory::where('quote_id', $id)->delete();
        QuoteCategory::insert($data);

        $tags = [];
        $data = $request->tags ?? [];
        foreach ($data as $key => $value) {
            $tags[] = ['tag' => $value, 'quote_id' => $quote->id];
        }
        Tag::where('quote_id', $id)->delete();
        Tag::insert($tags);

        return $this->success(new QuoteResource($quote), 'The quote has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, string $id)
    {
        $quote = Quote::find($id);
        if (!$quote) return $this->error('', 'Not Found', 404);
        if ($request->user()->cannot('update', $quote)) {
            return $this->error('', 'No Access', 401);
        }
        $quote->delete();
        return $this->success('', 'The quote has been deleted');
    }

    public function random($limit)
    {
        $quotes = Quote::inRandomOrder()
            ->limit($limit)
            ->get();
        if ($quotes) {
            Quote::frenquecyInc($quotes);
        }
        return $this->success(QuoteResource::collection($quotes));
    }

    public function wordsCount($count)
    {
        $quotes = Quote::whereRaw('LENGTH(TRIM(REGEXP_REPLACE(quote, "[^a-zA-Z0-9 ]", ""))) - LENGTH(REPLACE(REGEXP_REPLACE(quote, "[^a-zA-Z0-9 ]", ""), " ", "")) + 1 <= ?', [$count])
            ->get();
        if ($quotes) {
            Quote::frenquecyInc($quotes);
        }
        return $this->success(QuoteResource::collection($quotes));
    }

    public function popular()
    {
        $quotes = Quote::orderBy('frequency', 'desc')
            ->limit(10)
            ->get();
        return $this->success(QuoteResource::collection($quotes), 'Top ' . count($quotes) . ' Popular Quotes');
    }

    public function pending()
    {
        $pendingQuotes = Quote::withoutGlobalScopes()
            ->where('status', 'Pending')
            ->get();
        return $this->success(QuoteResource::collection($pendingQuotes), 'Pending Quotes');
    }

    public function valid($quote_id)
    {
        $quote = Quote::withoutGlobalScopes()
            ->find($quote_id);
        if (!$quote) {
            return $this->error(null, 'No Quote Found', 404);
        }
        if ($quote->status == 'Valid') {
            return $this->error(null, 'Quote Already Has Been Validated', 403);
        }
        $quote->status = 'Valid';
        $quote->save();
        return $this->success(new QuoteResource($quote), 'Quote Has Been Validated');
    }
}
