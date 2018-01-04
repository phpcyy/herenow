<?php

namespace Controller;

use Http\Response;

class Controller
{
    public function error($code, $message){
        return new Response([
            "code" => $code,
            "message" => $message
        ]);
    }

    public function success($data = [], string $message = "", int $code = 0)
    {
        return new Response([
            "code" => $code,
            "message" => $message,
            "data" => $data
        ]);
    }
}