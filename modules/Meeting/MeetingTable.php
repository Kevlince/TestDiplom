<?php

namespace App\Meeting;

use App\Core\Database;

class MeetingTable {
    public function __construct(private Database $db) {}

    public function create(array $data): int {
        $this->db->query(
                "INSERT INTO meetings (student_id, teacher_id, scheduled_at, location, reason) 
             VALUES (?, ?, ?, ?, ?)",
                [$data['student_id'], $data['teacher_id'], $data['scheduled_at'], $data['location'], $data['reason']]
        );
        return $this->db->lastInsertId();
    }

    public function getById(int $id): ?Meeting {
        $data = $this->db->query("SELECT * FROM meetings WHERE id = ?", [$id]);
        return $data ? new Meeting(...array_values($data[0])) : null;
    }

    public function update(int $id, array $data): bool {
        $this->db->query(
                "UPDATE meetings SET student_id = ?, teacher_id = ?, scheduled_at = ?, 
             location = ?, reason = ?, is_happened = ? WHERE id = ?",
                [
                        $data['student_id'], $data['teacher_id'], $data['scheduled_at'],
                        $data['location'], $data['reason'], $data['is_happened'], $id
                ]
        );
        return true;
    }

    public function delete(int $id): bool {
        $this->db->query("DELETE FROM meetings WHERE id = ?", [$id]);
        return true;
    }

    public function getAll(): array {
        $data = $this->db->query("SELECT * FROM meetings");
        return array_map(fn($row) => new Meeting(...array_values($row)), $data);
    }
}