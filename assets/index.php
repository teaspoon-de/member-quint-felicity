<!DOCTYPE html>
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["user"] === "admin" && $_POST["pass"] === "1234") {
    $_SESSION["user"] = "admin";
    echo "Erfolgreich eingeloggt!";
}
?>

<form method="post">
    <input name="user">
    <input name="pass" type="password">
    <button>Login</button>
</form>