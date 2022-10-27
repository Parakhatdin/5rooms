<?php
namespace App\System;

use PDO;
use PDOException;

class DBConnector {
    protected $connection = null;

    public function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host=localhost;port=3306;dbname=5rooms",
                "root",
                "123321!@#"
            );
        } catch(PDOException $exception) {
            exit($exception->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
