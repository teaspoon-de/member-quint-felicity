<?php

require_once __DIR__ . '/../Database.php';

class User {

    public static function all(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM users ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function get(string $username): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function create($data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO users (username, name, email, password, instrument) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['username'],
            $data['name'],
            $data['email'],
            password_hash($data["password"], PASSWORD_DEFAULT),
            $data['instrument']
        ]);
    }

    public static function update(int $id, $data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE users SET username=?, name=?, email=?, password=?, instrument=?  WHERE id=?");
        return $stmt->execute([
            $data['username'],
            $data['name'],
            $data['email'],
            password_hash($data["password"], PASSWORD_DEFAULT),
            $data['instrument'],
            $id
        ]);
    }

    public static function delete(int $id): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
        return $stmt->execute([$id]);
    }

}