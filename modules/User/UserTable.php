<?php

namespace App\User;

use App\Core\Database;

class UserTable {
    public function __construct(private Database $db) {}

    public function create(array $data): int {
        $this->db->query(
                "INSERT INTO users (name, password, role) VALUES (?, ?, ?)",
                [
                        $data['name'],
                        password_hash($data['password'], PASSWORD_BCRYPT),
                        $data['role']
                ]
        );
        return $this->db->lastInsertId();
    }

    public function getById(int $id): ?User {
        $data = $this->db->query("SELECT * FROM users WHERE id = ?", [$id]);
        return $data ? new User(...array_values($data[0])) : null;
    }

    public function update(int $id, array $data): bool {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $this->db->query(
                "UPDATE users SET name = ?, password = ?, role = ? WHERE id = ?",
                [$data['name'], $data['password'], $data['role'], $id]
        );
        return true;
    }

    public function delete(int $id): bool {
        $this->db->query("DELETE FROM users WHERE id = ?", [$id]);
        return true;
    }

    public function getAll(): array {
        $data = $this->db->query("SELECT * FROM users");
        return array_map(fn($row) => new User(...array_values($row)), $data);
    }
}