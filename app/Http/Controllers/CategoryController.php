<?php

namespace App\Http\Controllers;

use App\Http\Trait\HttpResponses;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return $this->success([CategoryResource::collection(Category::all())]);
    }
}
