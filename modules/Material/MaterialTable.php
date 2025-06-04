<?php
namespace App\Material;

use App\Core\Database;

class MaterialTable {
    public function __construct(private Database $db) {}

    public function create(array $data): int {
        $this->db->query(
                "INSERT INTO materials (server_filename, filename, uploaded_by, topic_id) 
             VALUES (?, ?, ?, ?)",
                [$data['server_filename'], $data['filename'], $data['uploaded_by'], $data['topic_id']]
        );
        return $this->db->lastInsertId();
    }

    public function getById(int $id): ?Material {
        $data = $this->db->query("SELECT * FROM materials WHERE id = ?", [$id]);
        return $data ? new Material(...array_values($data[0])) : null;
    }

    public function update(int $id, array $data): bool {
        $this->db->query(
                "UPDATE materials SET server_filename = ?, filename = ?, uploaded_by = ?, topic_id = ? 
             WHERE id = ?",
                [$data['server_filename'], $data['filename'], $data['uploaded_by'], $data['topic_id'], $id]
        );
        return true;
    }

    public function delete(int $id): bool {
        $this->db->query("DELETE FROM materials WHERE id = ?", [$id]);
        return true;
    }

    public function getAll(): array {
        $data = $this->db->query("SELECT * FROM materials");
        return array_map(fn($row) => new Material(...array_values($row)), $data);
    }
}