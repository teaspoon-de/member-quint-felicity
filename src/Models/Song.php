<?php

require_once __DIR__ . '/../Database.php';

class Song {

    public static function all(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM songs ORDER BY title ASC");
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM songs WHERE id = ?");
        $stmt->execute([$id]);
        $song = $stmt->fetch();
        return $song ?: null;
    }

    public static function create($data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO songs (title, artists, cover_url, duration, spotify_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data["title"] ?? null,
            $data["artists"] ?? null,
            $data["cover_url"] ?? null,
            $data["duration"] ?? null,
            $data["spotify_id"] ?? null
        ]);
    }

    public static function update(int $id, $data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE songs SET original_key=?, transposed_by=?, status=?, notes=?  WHERE id=?");
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
        $stmt = $pdo->prepare("DELETE FROM songs WHERE id=?");
        return $stmt->execute([$id]);
    }

}