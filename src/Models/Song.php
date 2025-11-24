<?php

require_once __DIR__ . '/../Database.php';

class Song {

    public static function all(): array {
        $pdo = Databas::getConnection();
        $stmt = $pdo->query("SELECT * FROM songs ORDER BY title ASC");
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array {
        $pdo = Databas::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM songs WHERE id = ?");
        $stmt->execute([$id]);
        $song = $stmt->fetch();
        return $song ?: null;
    }

    public static function create(string $title, string $artists, string $cover, int $duration, string $spotify): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO songs (title, artist, cover_url, duration, spotify_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $artist, $cover, $duration, $spotify]);
    }

    public static function update(int $id, string $key, int $transposedBy, string $status, string $notes): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE songs SET original_key=?, transposed_by=?, status=?, notes=?  WHERE id=?");
        return $stmt->execute([$key, $transposedBy, $status, $notes, $id]);
    }

    public static function delete(int $id): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM songs WHERE id=?");
        return $stmt->execute([$id]);
    }

}