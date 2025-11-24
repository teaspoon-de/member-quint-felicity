<?php

require "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["username"]) && isset($_POST["password"])) {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Ungültiges CSRF-Token");
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST["username"]]);
    $user = $stmt->fetch();

    if (!$user) {
        die("User nicht gefunden.");
    } else if (password_verify($_POST["password"], $user["password"])) {
        session_regenerate_id(true);
        $_SESSION["user"] = $user["username"];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Falscher Benutzername oder Passwort!";
    }
}

?>

<form method="post">
    <input name="username">
    <input type="password" name="password">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    
    <button type="submit">Anmelden</button>
</form>