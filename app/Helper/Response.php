<?php

namespace MeuMicroframework\Helper;

class Response
{
    public function json($data)
    {
        //header('Content-Type: application/json');
        return json_encode($data);
    }
}