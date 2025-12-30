<?php

require_once __DIR__ . '/../Database.php';

class Setlist {

    public static function all(): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM setlists ORDER BY created_at DESC");
        return $stmt->fetchAll() ?: null;
    }

    public static function find(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM setlists WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function getItems(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM setlist_items WHERE setlist_id=$id ORDER BY position ASC");
        $items = $stmt->fetchAll();
        $songCount = -1;
        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i]['type'] === 'song') {
                $songCount++;
                $item = Song::find($items[$i]["song_id"]);
                $item['count'] = $songCount;
                $items[$i]["item"] = $item;
            }
        }
        return $items ?: null;
    }

    public static function create($data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO setlists (name) VALUES (?)");
        $result = $stmt->execute([$data["name"] ?? null]);
        return $result;
    }

    public static function update(int $id, $data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE setlists SET name=? WHERE id=?");
        $result = $stmt->execute([
            $data["name"] ?? null,
            $id
        ]);
        $stmt = $pdo->prepare("DELETE FROM setlist_items WHERE setlist_id=?");
        $result = $result && $stmt->execute([$id]);
        foreach ($data['items'] as $item) {
            switch ($item['type']) {
                case 'song':
                    $stmt = $pdo->prepare("INSERT INTO setlist_items (type, setlist_id, position, song_id) VALUES (?, ?, ?, ?)");
                    $result = $result && $stmt->execute([
                        'song',
                        $id,
                        $item["position"] ?? null,
                        $item["song_id"] ?? null
                    ]);
                    break;
                case 'transition':
                    $stmt = $pdo->prepare("INSERT INTO setlist_items (type, setlist_id, position) VALUES (?, ?, ?)");
                    $result = $result && $stmt->execute([
                        'transition',
                        $id,
                        $item["position"] ?? null
                    ]);
                    break;
                case 'note':
                    $stmt = $pdo->prepare("INSERT INTO setlist_items (type, setlist_id, position, text) VALUES (?, ?, ?)");
                    $result = $result && $stmt->execute([
                        'note',
                        $id,
                        $item["position"] ?? null,
                        $item["text"] ?? null
                    ]);
                    break;
            }
        }
        return $result;
    }

    public static function delete(int $id): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM setlists WHERE id=?");
        return $stmt->execute([$id]);
    }

}