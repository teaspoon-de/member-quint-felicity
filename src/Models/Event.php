<?php

require_once __DIR__ . '/../Database.php';

class Event {

    public static function all(): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM events WHERE date_begin > NOW() ORDER BY date_begin ASC"); // Zeitspanne Einschränken
        $events = $stmt->fetchAll();
        if (count($events) === 0) return $events;
        for ($i = 0; $i < count($events); $i++) {
            $ur = $pdo->prepare("SELECT * FROM event_registrations WHERE event_id=? AND user_id=?");
            $ur->execute([$events[$i]["id"], $_SESSION["user_id"]]);
            $ureg = $ur->fetch();
            $events[$i]["user_reg"] = $ureg["status"];
            $ur = $pdo->prepare("SELECT COUNT(*) FROM event_registrations WHERE event_id=? AND status='yes'");
            $ur->execute([$events[$i]["id"]]);
            $events[$i]["yes_count"] = $ur->fetchColumn();
        }
        return $events ?: null;
    }

    public static function find(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->execute([$id]);
        $event = $stmt->fetch();
        $ur = $pdo->prepare("SELECT * FROM event_registrations WHERE event_id=? AND user_id=?");
        $ur->execute([$id, $_SESSION["user_id"]]);
        $ureg = $ur->fetch();
        $event["user_reg"] = $ureg["status"];
        return $event ?: null;
    }

    public static function getRegistrations(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM event_registrations WHERE event_id=$id ORDER BY status ASC");
        $regs = $stmt->fetchAll();
        for ($i = 0; $i < count($regs); $i++) {
            $user = User::find($regs[$i]["user_id"]);
            $regs[$i]["username"] = $user["username"];
        }
        return $regs ?: null;
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
            $stmt = $pdo->prepare("INSERT INTO event_registrations (event_id, user_id, status) VALUES (?, ?, ?)");
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
        $stmt = $pdo->prepare("UPDATE events SET type=?, title=?, location=?, duration=?, salary=?, notes=?, date_begin=?, public_entry=?, deadline=?  WHERE id=?");
        return $stmt->execute([
            /*$data["type"] ?? null*/ "show",
            $data["title"] ?? null,
            $data["location"] !=""? $data["location"]: null,
            $data["duration"] !=""? $data["duration"]: null,
            $data["salary"] !=""? $data["salary"]: null,
            $data["notes"] !=""? $data["notes"]: null,
            $data["date_begin"] ?? null,
            $data["public_entry"] !=""? $data["public_entry"]: null,
            $data["deadline"] !=""? $data["deadline"]: null,
            $id
        ]);
    }

    public static function register(int $id, $data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id FROM event_registrations WHERE event_id = ? AND user_id = ? LIMIT 1");
        $stmt->execute([$id, $_SESSION["user_id"]]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($existing) {
            $update = $pdo->prepare("UPDATE event_registrations SET status=?, message=?, last_edit=NOW() WHERE id=?");
            return $update->execute([
                $data["status"],
                $data["message"] !=""? $data["message"]: null,
                $existing['id']
            ]);
        } else {
            $insert = $pdo->prepare("INSERT INTO event_registrations (event_id, user_id status, message, last_edit, created_at) VALUES (?,?,?,?, NOW(), NOW())");
            return $insert->execute([
                $id,
                $_SESSION["user_id"],
                $data["status"],
                $data["message"] !=""? $data["message"]: null
            ]);
        }
    }

    public static function delete(int $id): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM events WHERE id=?");
        return $stmt->execute([$id]);
    }

}