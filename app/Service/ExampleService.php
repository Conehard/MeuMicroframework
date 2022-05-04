<?php

namespace MeuMicroframework\Service;

use MeuMicroframework\Repository\ExampleRepository;

class ExampleService
{
    private $exampleRepository;

    public function __construct(ExampleRepository $exampleRepo)
    {
        $this->exampleRepository = $exampleRepo;
    }

    public function getAll()
    {
        return $this->exampleRepository->getAll();
    }
    public function getById(int $id){
        return $this->exampleRepository->getById($id);
    }
    public function store(array $data){
        return $this->exampleRepository->store($data);
    }
    public function updateById(int $id, array $data){
        return $this->exampleRepository->updateById($id, $data);
    }
    public function patchById(int $id, array $data){
        return $this->exampleRepository->patchById($id, $data);
    }
    public function deleteById(int $id){
        return $this->exampleRepository->deleteById($id);
    }

}