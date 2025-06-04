<?php

namespace App\Result;

use App\Core\Database;

class ResultTable {
    public function __construct(private Database $db) {}

    public function create(array $data): int {
        $this->db->query(
                "INSERT INTO results (student_id, part_number, server_filename, filename) 
             VALUES (?, ?, ?, ?)",
                [
                        $data['student_id'],
                        $data['part_number'],
                        $data['server_filename'],
                        $data['filename']
                ]
        );
        return $this->db->lastInsertId();
    }

    public function getById(int $id): ?Result {
        $data = $this->db->query("SELECT * FROM results WHERE id = ?", [$id]);
        return $data ? new Result(...array_values($data[0])) : null;
    }

    public function update(int $id, array $data): bool {
        $this->db->query(
                "UPDATE results SET 
                student_id = ?, 
                part_number = ?, 
                server_filename = ?, 
                filename = ? 
             WHERE id = ?",
                [
                        $data['student_id'],
                        $data['part_number'],
                        $data['server_filename'],
                        $data['filename'],
                        $id
                ]
        );
        return true;
    }

    public function delete(int $id): bool {
        $this->db->query("DELETE FROM results WHERE id = ?", [$id]);
        return true;
    }

    public function getAll(): array {
        $data = $this->db->query("SELECT * FROM results");
        return array_map(fn($row) => new Result(...array_values($row)), $data);
    }

    public function getByStudent(int $studentId): array {
        $data = $this->db->query(
                "SELECT * FROM results WHERE student_id = ?",
                [$studentId]
        );
        return array_map(fn($row) => new Result(...array_values($row)), $data);
    }
}