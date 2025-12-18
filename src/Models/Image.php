<?php

require_once __DIR__ . '/../Database.php';

class Image {

    public static function all(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM images ORDER BY taken_at DESC");
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM images WHERE id = ?");
        $stmt->execute([$id]);
        $image = $stmt->fetch();
        return $image ?: null;
    }

    public static function create($data): bool {

        // Zielordner
        $uploadDir = __DIR__ . "/../../uploads/";
        // Prüfen ob Datei existiert
        if (!isset($data['bild']) || $data['bild']['error'] !== UPLOAD_ERR_OK) {
            die("Fehler beim Upload.");
        }
        $file = $data['bild'];
        // Sicherheitschecks
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5 MB
        // MIME-Type prüfen
        if (!in_array($file['type'], $allowedTypes)) {
            die("Nur JPG, PNG und GIF erlaubt.");
        }
        // Größe prüfen
        if ($file['size'] > $maxSize) {
            die("Datei ist zu groß (max 5 MB).");
        }
        // Sicheren Dateinamen erzeugen
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = uniqid("img_", true) . "." . $extension;
        // Datei verschieben
        $uploadPath = $uploadDir . $newName;
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("INSERT INTO images (uri, taken_at) VALUES (?, NOW())");
            return $stmt->execute([$newName]);

        } else {
            echo "Upload fehlgeschlagen.";
            return false;
        }
    }

    public static function update(int $id, $data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE images SET uri=?, title=?, description=?, alt=?/*, taken_at=?*/ WHERE id=?");
        return $stmt->execute([
            $data["uri"] ?? null,
            $data["title"] ?? null,
            $data["description"] ?? null,
            $data["alt"] ?? null,
            /*$data["taken_at"] ?? null,*/
            $id
        ]);
    }

    public static function delete(int $id): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM images WHERE id=?");
        return $stmt->execute([$id]);
    }

}