<?php

namespace App\Chat;

use App\Core\Database;

class ChatTable {
    public function __construct(private Database $db) {}

    public function create(array $data): int {
        $this->db->query(
                "INSERT INTO chats (title) VALUES (?)",
                [$data['title']]
        );
        return $this->db->lastInsertId();
    }

    public function getById(int $id): ?Chat {
        $data = $this->db->query("SELECT * FROM chats WHERE id = ?", [$id]);
        return $data ? new Chat(...array_values($data[0])) : null;
    }

    public function update(int $id, array $data): bool {
        $this->db->query(
                "UPDATE chats SET title = ? WHERE id = ?",
                [$data['title'], $id]
        );
        return true;
    }

    public function delete(int $id): bool {
        $this->db->query("DELETE FROM chats WHERE id = ?", [$id]);
        return true;
    }

    public function getAll(): array {
        $data = $this->db->query("SELECT * FROM chats");
        return array_map(fn($row) => new Chat(...array_values($row)), $data);
    }
}