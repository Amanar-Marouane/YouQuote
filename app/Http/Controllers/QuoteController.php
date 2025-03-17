<?php

namespace App\Http\Controllers;

use App\Http\Requests\{QuoteStoreRequest, QuoteUpdateRequest};
use App\Http\Resources\QuoteResource;
use App\Http\Trait\HttpResponses;
use App\Models\Category;
use App\Models\Quote;
use App\Models\QuoteCategory;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class QuoteController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = QuoteResource::collection(Quote::all());
        return $this->success($quotes);
    }

    public function find($column, $value)
    {
        $quotes = Quote::where($column, $value)
            ->get();
        Quote::frenquecyInc($quotes);
        return $this->success(new QuoteResource($quotes));
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
            'content' => $request->only($typesColumns[$request->type]),
            'user_id' => $request->user()->id,
        ]);
        $categories = $request->category_id;
        $data = [];
        foreach ($categories as $key => $value) {
            $data[] = ['category_id' => $value, 'quote_id' => $quote->id];
        }
        QuoteCategory::insert($data);
        return $this->success(new QuoteResource($quote));
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
        $content = $request->except(['author', 'type', 'quote', 'user_id', 'category_id']);
        $quote->update(array_merge($updatedQuote, ['content' => $content]));

        $categories = $request->category_id;
        $data = [];
        foreach ($categories as $key => $value) {
            $data[] = ['category_id' => $value, 'quote_id' => $quote->id];
        }
        QuoteCategory::where('quote_id', $id)->delete();
        QuoteCategory::insert($data);
        return $this->success(new QuoteResource($quote), 'The quote has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, string $id)
    {
        $quote = Quote::find($id);
        if ($request->user()->cannot('update', $quote)) {
            return $this->error('', 'No Access', 401);
        }
        if (!$quote) return $this->error('', 'Not Found', 404);
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
        return $this->success(QuoteResource::collection($quotes), 'Top 10 Popular Quotes');
    }
}
