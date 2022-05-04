<?php

namespace MeuMicroframework\Interfaces;

interface ExampleInterface
{
    public function getAll();
    public function getById(int $id);
    public function store(array $data);
    public function updateById(int $id, array $data);
    public function patchById(int $id, array $data);
    public function deleteById(int $id);
}