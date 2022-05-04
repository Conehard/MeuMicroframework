<?php

namespace MeuMicroframework\Database;

use MeuMicroframework\Debugger;

class Migration extends Debugger
{
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }
}