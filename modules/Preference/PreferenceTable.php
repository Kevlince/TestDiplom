<?php

namespace App\Preference;

use App\Core\Database;

class PreferencesTable {
    public function __construct(private Database $db) {}

    public function create(array $data): bool {
        $this->db->query(
                "INSERT INTO preferences (student_id, topic_id, priority) VALUES (?, ?, ?)",
                [$data['student_id'], $data['topic_id'], $data['priority']]
        );
        return true;
    }

    public function getById(int $studentId, int $topicId): ?Preference {
        $data = $this->db->query(
                "SELECT * FROM preferences WHERE student_id = ? AND topic_id = ?",
                [$studentId, $topicId]
        );
        return $data ? new Preference(...array_values($data[0])) : null;
    }

    public function update(int $studentId, int $topicId, array $data): bool {
        $this->db->query(
                "UPDATE preferences SET priority = ? 
             WHERE student_id = ? AND topic_id = ?",
                [$data['priority'], $studentId, $topicId]
        );
        return true;
    }

    public function delete(int $studentId, int $topicId): bool {
        $this->db->query(
                "DELETE FROM preferences WHERE student_id = ? AND topic_id = ?",
                [$studentId, $topicId]
        );
        return true;
    }

    public function getAll(): array {
        $data = $this->db->query("SELECT * FROM preferences");
        return array_map(fn($row) => new Preference(...array_values($row)), $data);
    }
}