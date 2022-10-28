<?php
namespace App\System;

use PDO;
use PDOException;

class DBConnector {

    protected ?PDO $connection = null;

    public function __construct() {
        $host = 'localhost';
        $db   = '5rooms';
        $user = 'root';
        $password = '123321!@#';

        $dsn = "mysql:host=$host;dbname=$db";
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => FALSE
        ];
        try {
            $this->connection = new PDO($dsn, $user, $password, $options);
        } catch(PDOException $exception) {
            exit($exception->getMessage());
        }
    }

    public function getConnection(): ?PDO
    {
        return $this->connection;
    }
}
