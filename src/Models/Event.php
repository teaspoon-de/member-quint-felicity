<?php

require_once __DIR__ . '/../Database.php';

class Event {

    public static function all(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM events ORDER BY date_begin DESC"); // Zeitspanne Einschränken
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
        $stmt = $pdo->prepare("INSERT INTO events (type, title, date_begin) VALUES (?, ?, ?)");
        $result = $stmt->execute([
            /*$data["type"] ?? null*/ "show",
            $data["title"] ?? null,
            $data["date_begin"] ?? null,
        ]);
        $event_id = $pdo->lastInsertId();
        // Für jeden eine Eventregistration erstellen
        $users = User::all();
        foreach ($users as $user) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("INSERT INTO event_registration (event_id, user_id, status) VALUES (?, ?, ?)");
            $result = $stmt->execute([
                $event_id,
                $user["id"],
                "maybe"
            ]);
        }
        return $result;
    }

    public static function update(int $id, $data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE events SET type=?, title=?, location=?, notes=?, date_begin=?, public_entry=?, deadline=?  WHERE id=?");
        return $stmt->execute([
            $data["type"] ?? null,
            $data["title"] ?? null,
            $data["location"] ?? null,
            $data["notes"] ?? null,
            $data["date_begin"] ?? null,
            $data["public_entry"] ?? null,
            $data["deadline"] ?? null,
            $id
        ]);
    }

    public static function delete(int $id): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM events WHERE id=?");
        return $stmt->execute([$id]);
    }

}