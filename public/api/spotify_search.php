<?php
require_once __DIR__ . '/../../src/Controllers/SpotifyController.php';

header('Content-Type: application/json');

// Suchbegriff
$q = $_GET['q'] ?? '';

if (!$q) {
    echo json_encode(['error' => 'missing q']);
    exit;
}

$accessToken = SpotifyController::getAccessToken();

$ch = curl_init("https://api.spotify.com/v1/search?type=track&q=" . urlencode($q));

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $accessToken",
    ]
]);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
