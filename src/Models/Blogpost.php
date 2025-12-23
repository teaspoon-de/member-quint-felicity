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
        try {
            $slug = self::generateUniqueSlug($data["title"]);
            $stmt = $pdo->prepare("INSERT INTO blogposts (title, slug, cover_id, date) VALUES (?, ?, ?, ?)");
            return $stmt->execute([
                $data["title"] ?? null,
                $slug,
                $data["cover_id"] ?? null,
                $data["date"] ?? null,
            ]);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] !== 1062) { // Duplicate entry
                throw $e;
            }
        }
    }

    private static function generateUniqueSlug(string $title): string {
        $pdo = Database::getConnection();
        $slug = mb_substr(self::slugify($title), 0, 200);
        $baseSlug = $slug;
        $i = 1;

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM blogposts WHERE slug = ?");
        while (true) {
            $stmt->execute([$slug]);
            if ($stmt->fetchColumn() == 0) {
                return $slug;
            }
            $slug = $baseSlug . '-' . $i++;
        }
    }

    private static function slugify(string $text): string {
        $text = trim($text);
        $text = mb_strtolower($text, 'UTF-8');

        // Umlaute
        $replace = [
            'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss'
        ];
        $text = strtr($text, $replace);

        // Alles außer Buchstaben, Zahlen, Leerzeichen & Bindestriche entfernen
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);

        // Leerzeichen & Mehrfach-Bindestriche ersetzen
        $text = preg_replace('/[\s-]+/', '-', $text);

        return $text !== '' ? trim($text, '-') : 'post';
    }

    public static function update(int $id, $data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE blogposts SET title=?, cover_id=?, content=?, publish=?, date=?, last_edit=NOW()  WHERE id=?");
        return $stmt->execute([
            $data["title"] ?? null,
            $data["cover_id"] ?? null,
            $data["content"] ?? null,
            isset($data["publish"]) && $data["publish"] === 'on'? 1:0,
            $data["date"] ?? null,
            $id
        ]);
    }

    public static function delete(int $id): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM blogposts WHERE id=?");
        return $stmt->execute([$id]);
    }

}