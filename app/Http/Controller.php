<?php

namespace MeuMicroframework\Http;

use MeuMicroframework\Debugger;
use MeuMicroframework\Helper\Response;

class Controller extends Debugger
{

    public function response($data, $status = 200)
    {
        $response = new Response();
        http_response_code($status);
        return $response->json($data);
    }
}