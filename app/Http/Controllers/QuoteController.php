<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteStoreRequest;
use App\Http\Trait\HttpResponses;
use App\Models\Quote;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
        $type = Type::where('type', $request->type)
            ->first();
        $quote = Quote::create([
            'author' => $request->author,
            'quote' => $request->quote,
            'type_id' => $type->id,
            'content' => json_encode($request->except(['author', 'quote', 'type']), true),
        ]);
        return $this->success($quote);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
