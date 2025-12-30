<?php
require_once __DIR__ . '/../src/ini.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Controllers/SpotifyController.php';
SpotifyController::getAccessToken();

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
require_once __DIR__ . '/../src/Controllers/SetlistController.php';
require_once __DIR__ . '/../src/Models/Setlist.php';
require_once __DIR__ . '/../src/Controllers/EventController.php';
require_once __DIR__ . '/../src/Models/Event.php';
require_once __DIR__ . '/../src/Controllers/BlogpostController.php';
require_once __DIR__ . '/../src/Models/Blogpost.php';
require_once __DIR__ . '/../src/Controllers/ImageController.php';
require_once __DIR__ . '/../src/Models/Image.php';

$router = new Router();

// Login, User
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    $tokenHash = hash('sha256', $_COOKIE['remember_me']);
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT user_id FROM auth_tokens WHERE token_hash=? AND expires_at > NOW()");
    $stmt->execute([$tokenHash]);
    if ($row = $stmt->fetch()) {
        $_SESSION['user_id'] = $row['user_id'];
    }
}
if (!isset($_SESSION["user_id"]) && $_SERVER['REQUEST_URI'] !== "/login") {
    header("Location: /login");
    exit;
}
$router->get('/login', [UserController::class, 'login']);
$router->post('/login', [UserController::class, 'loginSubmit']);
$router->get('/', [UserController::class, 'root']);
$router->get('/members', [UserController::class, 'index']);
$router->get('/members/create', [UserController::class, 'create']);
$router->post('/members/create', [UserController::class, 'store']);
//$router->get('/account', [UserController::class, 'show']);
$router->get('/account/edit', [UserController::class, 'edit']);
$router->post('/account/edit', [UserController::class, 'update']);
$router->get('/account/edit/password', [UserController::class, 'editPassword']);
$router->post('/account/edit/password', [UserController::class, 'updatePassword']);
//$router->post('/members/{id}/delete', [UserController::class, 'delete']);
// Songs
$router->get('/songs', [SongController::class, 'index']);
$router->get('/songs/select', [SongController::class, 'select']);
$router->get('/songs/add', [SongController::class, 'add']);
$router->post('/songs/add', [SongController::class, 'store']);
$router->get('/songs/{id}', [SongController::class, 'show']);
$router->get('/songs/{id}/edit', [SongController::class, 'edit']);
$router->post('/songs/{id}/edit', [SongController::class, 'update']);
$router->post('/songs/{id}/delete', [SongController::class, 'delete']);
// Setlists
$router->get('/setlists', [SetlistController::class, 'index']);
$router->get('/setlists/create', [SetlistController::class, 'create']);
$router->post('/setlists/create', [SetlistController::class, 'store']);
$router->get('/setlists/{id}', [SetlistController::class, 'show']);
$router->get('/setlists/{id}/edit', [SetlistController::class, 'edit']);
$router->post('/setlists/{id}/edit', [SetlistController::class, 'update']);
$router->post('/setlists/{id}/delete', [SetlistController::class, 'delete']);
// Events
/*$router->get('/events', [EventController::class, 'index']);
$router->get('/events/create', [EventController::class, 'create']);
$router->post('/events/create', [EventController::class, 'store']);
$router->get('/events/{id}', [EventController::class, 'show']);
$router->get('/events/{id}/edit', [EventController::class, 'edit']);
$router->post('/events/{id}/edit', [EventController::class, 'update']);
$router->post('/events/{id}/register', [EventController::class, 'register']);
$router->post('/events/{id}/delete', [EventController::class, 'delete']);*/
// Blogposts
$router->get('/blog', [BlogpostController::class, 'index']);
$router->get('/blog/create', [BlogpostController::class, 'create']);
$router->post('/blog/create', [BlogpostController::class, 'store']);
$router->get('/blog/{id}/edit', [BlogpostController::class, 'edit']);
$router->post('/blog/{id}/edit', [BlogpostController::class, 'update']);
$router->post('/blog/{id}/delete', [BlogpostController::class, 'delete']);
// Blog Images
$router->get('/blog/images', [ImageController::class, 'index']);
$router->get('/blog/images/select', [ImageController::class, 'select']);
$router->get('/blog/images/create', [ImageController::class, 'create']);
$router->post('/blog/images/create', [ImageController::class, 'store']);
$router->get('/blog/images/{id}/edit', [ImageController::class, 'edit']);
$router->post('/blog/images/{id}/edit', [ImageController::class, 'update']);
$router->post('/blog/images/{id}/delete', [ImageController::class, 'delete']);

$router->run();
