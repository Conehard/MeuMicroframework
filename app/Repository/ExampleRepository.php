<?php

namespace MeuMicroframework\Repository;

use MeuMicroframework\Database\Database;
use MeuMicroframework\Interfaces\ExampleInterface;

class ExampleRepository extends Database implements ExampleInterface
{
    public function getAll(){
        return $this->select( "SELECT * FROM example where active = 1" );
    }
    public function getById(int $id){
        return $this->select( "SELECT * FROM example WHERE id = ? and active = 1", [$id]);
    }
    public function store(array $data){
        return $this->insert( "INSERT INTO example (".$this->arrayToDatabaseFields($data).") VALUES (".$this->arrayToDatabaseKeys($data).")", [$data]);
    }
    public function updateById(int $id, array $data){
        return $this->update( "UPDATE example SET ".$this->arrayToUpdateDatabaseFields($data)." WHERE id =:id", [$data, $id]);
    }
    public function patchById(int $id, array $data){
        return $this->update( "UPDATE example SET ".$this->arrayToUpdateDatabaseFields($data)." WHERE id =:id", [$data, $id]);
    }
    public function deleteById(int $id){
        return $this->delete( "UPDATE example SET active=0 WHERE id = ?", [$id]);
    }

}