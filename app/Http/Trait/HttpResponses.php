<?php

namespace App\Http\Trait;

trait HttpResponses
{
    protected function success($data, $message = null, $code = 200, $cookies = [])
    {
        $response = response([
            'status' => 'Request Has Been Sent Successfully',
            'message' => $message,
            'data' => $data,
        ], $code);

        foreach ($cookies as $key => $value) {
            $response->withCookie(cookie($key, $value, 1440, null, null, true, true));
        }

        return $response;
    }

    protected function error($data, $message = null, $code, $cookies = [])
    {
        $response = response([
            'status' => 'Error Has Occurred',
            'message' => $message,
            'data' => $data,
        ], $code);

        foreach ($cookies as $key => $value) {
            $response->withCookie(cookie($key, $value, 1440, null, null, true, true));
        }

        return $response;
    }
}
