<?php

namespace MeuMicroframework\Database;

use MeuMicroframework\Debugger;

class Database extends Debugger
{
    private $db;

    public function __construct()
    {
        $this->db = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbport=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection()
    {
        return $this->db;
    }
    public function execute(string $query, array $params = [])
    {
        try {
            $stmt = $this->db->prepare($query);
            return ["success" => $stmt->execute($params)];
        } catch (\PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
    public function select(string $query, array $params = [])
    {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function insert(string $query, array $params = [])
    {
        try {
            $stmt = $this->db->prepare($query);
            foreach ($params[0] as $key => $value) {
                $stmt->bindValue(':'.$key, $value);
            }

            $stmt->execute();
            return ["id" => $this->db->lastInsertId()];
        } catch (\PDOException $e) {
            return ["error" => $e->getMessage()];
        }

    }

    public function update(string $query, array $params = [])
    {
        try {
            $stmt = $this->db->prepare($query);
            $params[0]['id'] = $params[1];
            return ["success" => $stmt->execute($params[0])];
        } catch (\PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function delete(string $query, array $params = [])
    {
        try {
            $stmt = $this->db->prepare($query);
            return  $stmt->execute($params);
        } catch (\PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function arrayToUpdateDatabaseFields(array $array):string
    {
        $values = "";
        foreach ($array as $key => $value) {
            $values .= $key . "=:" . $key . ", ";
        }
        return substr($values, 0, -2);
    }

    public function arrayToDatabaseFields(array $array):string
    {
        $values = "";
        foreach ($array as $key => $value) {
            $values .= '`'.$key . '`, ';
        }
        return substr($values, 0, -2);
    }
    public function arrayToDatabaseKeys(array $array):string
    {
        $values = "";
        foreach ($array as $key => $value) {
            $values .= ':'.$key . ', ';
        }
        return substr($values, 0, -2);
    }
}