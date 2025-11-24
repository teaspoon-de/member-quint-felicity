<?php
require_once __DIR__ . '/../src/Database.php';

if (session_status() === PHP_SESSION_NONE) {
    /*$pdo = Database::getConnection();
    $stmt = $pdo->prepare("INSERT INTO users (username, name, email, password, instrument) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([
        "finn",
        null,
        null,
        password_hash("1234", PASSWORD_DEFAULT),
        null
    ]);*/
    session_start();
}
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/../src/Router.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Controllers/SongController.php';
require_once __DIR__ . '/../src/Models/Song.php';
require_once __DIR__ . '/../src/Controllers/UserController.php';
require_once __DIR__ . '/../src/Models/User.php';
require_once __DIR__ . '/../src/Controllers/EventController.php';
require_once __DIR__ . '/../src/Models/Event.php';

$router = new Router();

// Login, User
if (!isset($_SESSION["user_id"]) && $_SERVER['REQUEST_URI'] !== "/login") {
    header("Location: /login");
    exit;
}
$router->get('/login', [UserController::class, 'login']);
$router->post('/login', [UserController::class, 'loginSubmit']);
$router->get('/members', [UserController::class, 'index']);
$router->get('/members/create', [UserController::class, 'create']);
$router->post('/members/create', [UserController::class, 'store']);
$router->get('/account', [UserController::class, 'show']);
$router->get('/account/edit', [UserController::class, 'edit']);
$router->post('/account/edit', [UserController::class, 'update']);
$router->post('/members/{id}/delete', [UserController::class, 'delete']);
// Songs
$router->get('/songs', [SongController::class, 'index']);
$router->get('/songs/create', [SongController::class, 'create']);
$router->post('/songs', [SongController::class, 'store']);
$router->get('/songs/{id}', [SongController::class, 'show']);
$router->get('/songs/{id}/edit', [SongController::class, 'edit']);
$router->post('/songs/{id}/edit', [SongController::class, 'update']);
$router->post('/songs/{id}/delete', [SongController::class, 'delete']);
// Events
$router->get('/events', [EventController::class, 'index']);
$router->get('/events/create', [EventController::class, 'create']);
$router->post('/events', [EventController::class, 'store']);
$router->get('/events/{id}', [EventController::class, 'show']);
$router->get('/events/{id}/edit', [EventController::class, 'edit']);
$router->post('/events/{id}/edit', [EventController::class, 'update']);
$router->post('/events/{id}/delete', [EventController::class, 'delete']);

$router->run();
