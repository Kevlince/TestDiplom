<?php

namespace App\Core;

class Migrations {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function runAll(): void {

        $this->createUsersTable();
        $this->createStudentsTable();
        $this->createTeachersTable();
        $this->createTopicsTable();
        $this->createPreferencesTable();
        $this->createTopicDistributionTable();
        $this->createStudentBlockingTable();
        $this->createChatsTable();
        $this->createChatParticipantsTable();
        $this->createMessagesTable();
        $this->createMaterialsTable();
        $this->createResultsTable();
        $this->createMeetingsTable();
        $this->createMeetingLogsTable();
        $this->createNotificationsTable();
        $this->createNotificationsSettingsTable();
        $this->createUploadLogsTable();
    }

    private function createUsersTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(50) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createStudentsTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS students (
                id INT PRIMARY KEY,
                group_name VARCHAR(50) DEFAULT NULL,
                rating INT DEFAULT NULL,
                FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createTeachersTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS teachers (
                id INT PRIMARY KEY,
                department VARCHAR(150) DEFAULT NULL,
                position VARCHAR(100) DEFAULT NULL,
                FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createTopicsTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS topics (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(150) NOT NULL,
                description TEXT DEFAULT NULL,
                teacher_id INT DEFAULT NULL,
                is_active TINYINT(1) DEFAULT 1,
                FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createPreferencesTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS preferences (
                student_id INT NOT NULL,
                topic_id INT NOT NULL,
                priority INT DEFAULT NULL,
                PRIMARY KEY (student_id, topic_id),
                FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
                FOREIGN KEY (topic_id) REFERENCES topics(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createTopicDistributionTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS topic_distribution (
                student_id INT NOT NULL,
                topic_id INT NOT NULL,
                assigned_at DATETIME DEFAULT NULL,
                PRIMARY KEY (student_id, topic_id),
                FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
                FOREIGN KEY (topic_id) REFERENCES topics(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createStudentBlockingTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS student_blocking (
                id INT AUTO_INCREMENT PRIMARY KEY,
                student_id INT DEFAULT NULL,
                topic_id INT DEFAULT NULL,
                FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
                FOREIGN KEY (topic_id) REFERENCES topics(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createChatsTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS chats (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(150) DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createChatParticipantsTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS chat_participants (
                chat_id INT NOT NULL,
                user_id INT NOT NULL,
                joined_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (chat_id, user_id),
                FOREIGN KEY (chat_id) REFERENCES chats(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createMessagesTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                chat_id INT DEFAULT NULL,
                sender_id INT DEFAULT NULL,
                content TEXT DEFAULT NULL,
                sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (chat_id) REFERENCES chats(id) ON DELETE CASCADE,
                FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createMaterialsTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS materials (
                id INT AUTO_INCREMENT PRIMARY KEY,
                server_filename VARCHAR(150) NOT NULL,
                filename VARCHAR(255) NOT NULL,
                uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                uploaded_by INT DEFAULT NULL,
                topic_id INT DEFAULT NULL,
                FOREIGN KEY (uploaded_by) REFERENCES teachers(id) ON DELETE SET NULL,
                FOREIGN KEY (topic_id) REFERENCES topics(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createResultsTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS results (
                id INT AUTO_INCREMENT PRIMARY KEY,
                student_id INT DEFAULT NULL,
                part_number ENUM('Part1','Part2','Part3','Part4') DEFAULT NULL,
                server_filename VARCHAR(150) NOT NULL,
                filename VARCHAR(255) NOT NULL,
                uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createMeetingsTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS meetings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                student_id INT DEFAULT NULL,
                teacher_id INT DEFAULT NULL,
                scheduled_at DATETIME DEFAULT NULL,
                location VARCHAR(255) DEFAULT NULL,
                reason VARCHAR(255) DEFAULT NULL,
                is_happened TINYINT(1) DEFAULT 0,
                FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE SET NULL,
                FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createMeetingLogsTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS meeting_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                meeting_id INT DEFAULT NULL,
                message TEXT DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (meeting_id) REFERENCES meetings(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createNotificationsTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS notifications (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT DEFAULT NULL,
                message TEXT DEFAULT NULL,
                sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                read_at DATETIME DEFAULT NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    private function createUploadLogsTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS upload_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                student_id INT DEFAULT NULL,
                topic_id INT DEFAULT NULL,
                message VARCHAR(255) DEFAULT NULL,
                uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE SET NULL,
                FOREIGN KEY (topic_id) REFERENCES topics(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }
    private function createNotificationsSettingsTable(): void {
        $this->db->execute("
            CREATE TABLE IF NOT EXISTS notification_settings (
              user_id int(11) NOT NULL,
              new_messages tinyint(1) NOT NULL,
              meetings tinyint(1) NOT NULL,
              works_upload tinyint(1) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ");
    }
}