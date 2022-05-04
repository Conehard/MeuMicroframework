<?php

namespace MeuMicroframework\Http\Controllers;


use MeuMicroframework\Http\Controller;

class MigrationController extends Controller
{
    public function run()
    {
        $allFiles = scandir(dirname(__DIR__, 2) . '/Database/Migration');
        $files = array_diff($allFiles, array('.', '..'));
        try {
            foreach ($files as $file) {
                $name = explode('.', $file)[0];
                $name = str_replace(' ', '', ucwords(str_replace('_', ' ', $name)));
                $class = 'MeuMicroframework\Database\Migration\\' . $name;
                $migration = new $class;
                $migration->up();

            }
            return $this->response('Migration has been executed');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}