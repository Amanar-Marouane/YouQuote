<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypeResource;
use App\Http\Trait\HttpResponses;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return $this->success(TypeResource::collection(Type::all()));
    }
}
