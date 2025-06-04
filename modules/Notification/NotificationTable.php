<?php

namespace App\Notification;

use App\Core\Database;

class NotificationTable {
    public function __construct(private Database $db) {}

    public function create(array $data): int {
        $this->db->query(
                "INSERT INTO notifications (user_id, message) VALUES (?, ?)",
                [$data['user_id'], $data['message']]
        );
        return $this->db->lastInsertId();
    }

    public function getById(int $id): ?Notification {
        $data = $this->db->query("SELECT * FROM notifications WHERE id = ?", [$id]);
        return $data ? new Notification(...array_values($data[0])) : null;
    }

    public function update(int $id, array $data): bool {
        $this->db->query(
                "UPDATE notifications SET user_id = ?, message = ?, read_at = ? WHERE id = ?",
                [$data['user_id'], $data['message'], $data['read_at'], $id]
        );
        return true;
    }

    public function delete(int $id): bool {
        $this->db->query("DELETE FROM notifications WHERE id = ?", [$id]);
        return true;
    }

    public function getAll(): array {
        $data = $this->db->query("SELECT * FROM notifications");
        return array_map(fn($row) => new Notification(...array_values($row)), $data);
    }
}