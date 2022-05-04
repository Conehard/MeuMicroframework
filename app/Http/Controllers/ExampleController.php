<?php

namespace MeuMicroframework\Http\Controllers;

use MeuMicroframework\Http\Controller;
use MeuMicroframework\Service\ExampleService;

class ExampleController extends Controller
{
    private $example;

    public function __construct(ExampleService $example)
    {
        $this->example = $example;
    }

    public function index()
    {
        try {
            $examples = $this->example->getAll();
            return $this->response($examples);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 400);
        }
    }
    public function show($params){
        try {
            $example = $this->example->getById($params['id']);
            return $this->response($example);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 400);
        }
    }
    public function store($params){
        try {
            $example = $this->example->store($params['body']);
            return $this->response($example);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 400);
        }
    }
    public function update($params){
        try {
            $example = $this->example->updateById($params['id'], $params['body']);
            return $this->response($example);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 400);
        }
    }
    public function patch($params){
        try {
            if(count($params['body']) > 1){
                throw new \Exception('You can only update one field at a time');
            }
            $example = $this->example->patchById($params['id'], $params['body']);
            return $this->response($example);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 400);
        }
    }
    public function delete($params){
        try {
            $example = $this->example->deleteById($params['id']);
            return $this->response($example);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 400);
        }
    }
}