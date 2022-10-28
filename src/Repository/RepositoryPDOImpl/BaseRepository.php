<?php

namespace App\Repository\RepositoryPDOImpl;

use App\DTO\BaseDTO;
use App\Repository\Repository;
use App\System\DBConnector;
use Exception;
use PDO;
use PDOException;

abstract class BaseRepository implements Repository
{
    protected ?string $tableName = null;
    protected ?PDO $connection = null;

    private string $statement = "";

    public function __construct() {
        $connector = new DBConnector();
        $this->connection = $connector->getConnection();
    }

    public function find(int $id): ?BaseDTO
    {
        try {
            $statement = "SELECT * FROM $this->tableName WHERE id = ?";
            $statement = $this->connection->prepare($statement);
            $statement->execute([$id]);
            $result = $statement->fetchAll();
            if (count($result) > 0) {
                return $this->transferToDTO($result[0]);
            }
            return null;
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
    }

    public function where($column, $operation, $value)
    {
        $statement = "SELECT * FROM $this->tableName";
        if ($this->statement) {
            $statement = $this->statement;
        }
        $statement = $statement . " WHERE $column $operation '$value'";
        $this->statement = $statement;
        return $this;
    }

    public function andWhere($column, $operation, $value)
    {
        if (!$this->statement) {
            throw new Exception("first use WHERE clause");
        }
        $this->statement = $this->statement . " AND $column $operation '$value'";
        return $this;
    }

    public function first(string $order_by_column = null, bool $order_asc=true): ?BaseDTO
    {
        try {
            $result = $this->get(1, 0, $order_by_column, $order_asc);
            if (count($result?:[]) > 0) {
                return $result[0];
            }
            return null;
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
    }

    public function get(int $limit = 5, int $offset = 0, string $order_by_column = null, bool $order_asc=true): ?array
    {
        try {
            $statement = "SELECT * FROM $this->tableName";
            if ($this->statement) {
                $statement = $this->statement;
                $this->statement = "";
            }
            if ($order_by_column) {
                $order_asc = $order_asc?"ASC":"DESC";
                $statement = $statement . " ORDER BY $order_by_column $order_asc";
            }
            $statement = $statement . " LIMIT $offset, $limit";
            $statement = $this->connection->query($statement);
            $result = $statement->fetchAll();
            if (count($result) > 0) {
                $toDTO = [];
                foreach ($result as $item) {
                    $toDTO[] = $this->transferToDTO($item);
                }
                return $toDTO;
            }
            return null;
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

    protected abstract function transferToDTO(array $data): BaseDTO;
}