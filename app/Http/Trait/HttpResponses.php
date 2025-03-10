<?php

namespace App\Http\Trait;

trait HttpResponses
{
    protected function success($data, $message = null, $code = 200)
    {
        return response([
            'status' => 'Request Has Been Send Successfully',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($data, $message = null, $code)
    {
        return response([
            'status' => 'Error Has Been occured',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
