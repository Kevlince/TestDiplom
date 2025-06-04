<?php

namespace App\TopicDistribution;

use App\Core\Database;

class TopicDistributionTable {
    public function __construct(private Database $db) {}

    public function create(array $data): bool {
        $this->db->query(
                "INSERT INTO topic_distribution (student_id, topic_id, assigned_at) 
             VALUES (?, ?, ?)",
                [$data['student_id'], $data['topic_id'], date('Y-m-d H:i:s')]
        );
        return true;
    }

    public function getById(int $studentId, int $topicId): ?TopicDistribution {
        $data = $this->db->query(
                "SELECT * FROM topic_distribution 
             WHERE student_id = ? AND topic_id = ?",
                [$studentId, $topicId]
        );
        return $data ? new TopicDistribution(...array_values($data[0])) : null;
    }

    public function update(int $studentId, int $topicId, array $data): bool {
        $this->db->query(
                "UPDATE topic_distribution SET assigned_at = ? 
             WHERE student_id = ? AND topic_id = ?",
                [$data['assigned_at'], $studentId, $topicId]
        );
        return true;
    }

    public function delete(int $studentId, int $topicId): bool {
        $this->db->query(
                "DELETE FROM topic_distribution 
             WHERE student_id = ? AND topic_id = ?",
                [$studentId, $topicId]
        );
        return true;
    }

    public function getAll(): array {
        $data = $this->db->query("SELECT * FROM topic_distribution");
        return array_map(fn($row) => new TopicDistribution(...array_values($row)), $data);
    }
}