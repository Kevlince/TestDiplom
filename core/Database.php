<?php
namespace App\Core;

use PDO;

class Database {
    private PDO $pdo;

    public function __construct(array $config) {
        $this->pdo = new PDO(
                $config['dsn'],
                $config['user'],
                $config['pass'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public function query(string $sql, array $params = []): false|array {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lastInsertId(): false|string {
        return $this->pdo->lastInsertId();
    }
}