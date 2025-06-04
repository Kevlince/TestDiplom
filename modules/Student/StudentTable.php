<?php

namespace App\Student;

use App\Core\Database;

class StudentTable {
    public function __construct(private Database $db) {}

    public function create(array $data): int {
        $this->db->query(
                "INSERT INTO students (id, group_name, rating) VALUES (?, ?, ?)",
                [$data['id'], $data['group_name'], $data['rating']]
        );
        return $data['id'];
    }

    public function getById(int $id): ?Student {
        $data = $this->db->query("SELECT * FROM students WHERE id = ?", [$id]);
        return $data ? new Student(...array_values($data[0])) : null;
    }

    public function update(int $id, array $data): bool {
        $this->db->query(
                "UPDATE students SET group_name = ?, rating = ? WHERE id = ?",
                [$data['group_name'], $data['rating'], $id]
        );
        return true;
    }

    public function delete(int $id): bool {
        $this->db->query("DELETE FROM students WHERE id = ?", [$id]);
        return true;
    }

    public function getAll(): array {
        $data = $this->db->query("SELECT * FROM students");
        return array_map(fn($row) => new Student(...array_values($row)), $data);
    }
}