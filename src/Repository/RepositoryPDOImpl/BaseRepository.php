<?php

namespace App\Repository\RepositoryPDOImpl;

use App\Repository\Repository;
use App\System\DBConnector;
use PDOException;

abstract class BaseRepository implements Repository
{
    protected $tableName = null;
    protected $connection = null;

    public function __construct() {
        $connector = new DBConnector();
        $this->connection = $connector->getConnection();
    }

    public function find(int $id)
    {
        try {
            $statement = "SELECT * FROM $this->tableName WHERE id = ?";
            $statement = $this->connection->prepare($statement);
            $statement->execute([$id]);
            return $statement->fetchAll();
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
    }

    protected function all(int $limit = 5, int $offset = 0, string $order_by_column = null, bool $order_asc=true)
    {
        try {
            $statement = "SELECT * FROM $this->tableName";
            if ($order_by_column) {
                $statement = $statement . " ORDER BY :order_by_column :order_asc";
            }
            $statement = $statement . " LIMIT :offset, :limit";
            $statement = $this->connection->prepare($statement);
            $statement->execute([
                "order_by_column" => $order_by_column,
                "order_asc" => $order_asc?"ASC":"DESC",
                "offset" => $offset,
                "limit" => $limit
            ]);
            return $statement->fetchAll();
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $statement = "DELETE FROM $this->tableName WHERE id = ?";
            $statement = $this->connection->prepare($statement);
            $statement->execute([$id]);
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
    }

    protected function insert(array $data)
    {
        try {
            if(array_key_exists('id', $data)){
                unset($data['id']);
            }
            $stmt = $this->connection->prepare("INSERT INTO {$this->tableName} (".implode(",",array_keys($data)).") VALUES (:".implode(", :", array_keys($data)).")");
            $stmt->execute($data);
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
    }

}