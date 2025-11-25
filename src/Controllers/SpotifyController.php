<?php

require_once __DIR__ . '/../Database.php';

class SpotifyController {

    public static function getAccessToken(): string {
        $token = self::checkDB();
        if ($token && intval($token['expired']) === 0) {
            return $token['value_text'];
        }
        $new = self::requestNewToken();
        self::storeToken($new, !$token);
        return $new;
    }

    private static function checkDB() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT *,
                (updated_at < NOW() - INTERVAL 1 HOUR) AS expired
            FROM site_meta
            WHERE key_name='sf_access_token'");
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
    }
    
    private static function storeToken(string $token, bool $create): bool {
        $pdo = Database::getConnection();

        if ($create) {
            $stmt = $pdo->prepare("INSERT INTO site_meta
                    (key_name, value_text)
                VALUES ('sf_access_token', ?)");
            return $stmt->execute([$token]);
        } else {
            $stmt = $pdo->prepare("UPDATE site_meta
                SET value_text=?, updated_at = NOW()
                WHERE key_name = 'sf_access_token'");
            return $stmt->execute([$token]);
        }
    }

    private static function requestNewToken(): string {
        $clientId = getenv('SPOTIFY_CLIENT_ID');
        $clientSecret = getenv('SPOTIFY_CLIENT_SECRET');

        $auth = base64_encode("$clientId:$clientSecret");

        $ch = curl_init("https://accounts.spotify.com/api/token");

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'grant_type' => 'client_credentials'
            ]),
            CURLOPT_HTTPHEADER => [
                "Authorization: Basic $auth",
                "Content-Type: application/x-www-form-urlencoded"
            ]
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        if (!$result) {
            throw new Exception("Spotify API returned no response");
        }

        $data = json_decode($result, true);

        if (!isset($data['access_token'])) {
            throw new Exception("Spotify token error: " . $result);
        }

        return $data['access_token'];
    }

}