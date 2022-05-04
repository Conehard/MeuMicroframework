<?php

namespace MeuMicroframework\Helper;

class Exception extends Response
{
    public function forbidden()
    {
        //header("Status: 403 Forbidden");
        return $this->json(['message' => 'Forbidden'], 403);
    }
}