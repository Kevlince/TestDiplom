<?php

namespace App\Topic;

use App\Core\Database;

class TopicTable {
    public function __construct(private Database $db) {}

    public function create(array $data): int {
        $this->db->query(
                "INSERT INTO topics (title, description, teacher_id, is_active) 
             VALUES (?, ?, ?, ?)",
                [$data['title'], $data['description'], $data['teacher_id'], $data['is_active']]
        );
        return $this->db->lastInsertId();
    }

    public function getById(int $id): ?Topic {
        $data = $this->db->query("SELECT * FROM topics WHERE id = ?", [$id]);
        return $data ? new Topic(...array_values($data[0])) : null;
    }

    public function update(int $id, array $data): bool {
        $this->db->query(
                "UPDATE topics SET title = ?, description = ?, teacher_id = ?, is_active = ? 
             WHERE id = ?",
                [
                        $data['title'], $data['description'],
                        $data['teacher_id'], $data['is_active'], $id
                ]
        );
        return true;
    }

    public function delete(int $id): bool {
        $this->db->query("DELETE FROM topics WHERE id = ?", [$id]);
        return true;
    }

    public function getAll(): array {
        $data = $this->db->query("SELECT * FROM topics");
        return array_map(fn($row) => new Topic(...array_values($row)), $data);
    }
}