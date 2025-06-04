<?php

namespace App\Teacher;

use App\Core\Database;

class TeacherTable {
    public function __construct(private Database $db) {}

    public function create(array $data): int {
        $this->db->query(
                "INSERT INTO teachers (id, department, position) VALUES (?, ?, ?)",
                [$data['id'], $data['department'], $data['position']]
        );
        return $data['id'];
    }

    public function getById(int $id): ?Teacher {
        $data = $this->db->query("SELECT * FROM teachers WHERE id = ?", [$id]);
        return $data ? new Teacher(...array_values($data[0])) : null;
    }

    public function update(int $id, array $data): bool {
        $this->db->query(
                "UPDATE teachers SET department = ?, position = ? WHERE id = ?",
                [$data['department'], $data['position'], $id]
        );
        return true;
    }

    public function delete(int $id): bool {
        $this->db->query("DELETE FROM teachers WHERE id = ?", [$id]);
        return true;
    }

    public function getAll(): array {
        $data = $this->db->query("SELECT * FROM teachers");
        return array_map(fn($row) => new Teacher(...array_values($row)), $data);
    }
}