<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["username"]) && isset($_POST["password"])) {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Ungültiges CSRF-Token");
    }

    $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username,password) VALUES (?,?)");
    $stmt->execute([$_POST["username"], $hash]);
}
?>

<form method="post">
    <input name="username">
    <input type="password" name="password">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <button type="submit">Konto erstellen</button>
</form>