<?php

namespace App\Http\Controllers;

use App\Http\Trait\HttpResponses;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return $this->success([
            'data' => 'Yeey this is data',
        ], 'Hole From Morrococ');
    }
}
