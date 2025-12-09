<?php

require_once __DIR__ . '/../Database.php';

class Blogpost {

    public static function all(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM blogposts ORDER BY created_at DESC");
        $posts = $stmt->fetchAll();
        for ($i = 0; $i < count($posts); $i++) {
            $cover = Image::find($posts[$i]["cover_id"]);
            $posts[$i]["cover_uri"] = $cover["uri"];
        }
        return $posts;
    }

    public static function find(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM blogposts WHERE id = ?");
        $stmt->execute([$id]);
        $blogpost = $stmt->fetch();
        $cover = Image::find($blogpost["cover_id"]);
        $blogpost["cover_uri"] = $cover["uri"];
        return $blogpost ?: null;
    }

    public static function create($data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO blogposts (title, /*cover_id,*/ content) VALUES (?, ?)");
        return $stmt->execute([
            $data["title"] ?? null,
            /*$data["cover_id"] ?? null,*/
            $data["content"] ?? null,
        ]);
    }

    public static function update(int $id, $data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE blogposts SET title=?, /*cover_id=?,*/ content=?, last_edit=NOW()  WHERE id=?");
        return $stmt->execute([
            $data["title"] ?? null,
            /*$data["cover_id"] ?? null,*/
            $data["content"] ?? null,
            $id
        ]);
    }

    public static function delete(int $id): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM blogposts WHERE id=?");
        return $stmt->execute([$id]);
    }

}