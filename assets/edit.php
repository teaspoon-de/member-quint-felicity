<!DOCTYPE html>
<?php

require "config.php";

if (!isset($_GET["id"])) {
    die("Keine ID übergeben");
}

$id = $_GET["id"];

$stmt = $pdo->prepare("SELECT name,price FROM speisekarte WHERE id = ?");
$stmt->execute([$id]);
$gericht = $stmt->fetch();

if (!$gericht) {
    die("Gericht nicht gefunden!");
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["name"]) && isset($_POST["price"])) {
    $stmt = $pdo->prepare("UPDATE speisekarte SET name = ?, price = ? WHERE id = ?");
    $stmt->execute([$_POST["name"], $_POST["price"], $id]);
    header("Location: menu.php");
    exit;
}
?>

<h2>Gericht bearbeiten</h2>
<form method="post">
    <label>Name:</label>
    <input type="text" name="name" value="<?= $gericht["name"] ?>" required><br>
    <label>Preis:</label>
    <input type="number" step="0.01" name="price" value="<?= $gericht["price"] ?>" required><br>
    <button type="submit">Speichern</button>
</form>