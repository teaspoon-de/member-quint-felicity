<?php

require_once __DIR__ . '/../Database.php';

class Event {

    public static function all(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM events ORDER BY date DESC"); // Zeitspanne Einschränken
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->execute([$id]);
        $event = $stmt->fetch();
        return $event ?: null;
    }

    public static function create($data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO events (type, title, description, location, notes, date, deadline) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data["type"] ?? null,
            $data["title"] ?? null,
            $data["description"] ?? null,
            $data["location"] ?? null,
            $data["notes"] ?? null,
            $data["date"] ?? null,
            $data["deadline"] ?? null
        ]);
    }

    public static function update(int $id, $data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE events SET original_key=?, transposed_by=?, status=?, notes=?  WHERE id=?");
        return $stmt->execute([
            $data["title"] ?? null,
            $data["artists"] ?? null,
            $data["cover_url"] ?? null,
            $data["duration"] ?? null,
            $data["spotify_id"] ?? null
        ]);
    }

    public static function delete(int $id): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM events WHERE id=?");
        return $stmt->execute([$id]);
    }

}