<form method="post">
    <input name="name">
    <input name="price">
    <button>Hinzufügen</button>
</form>

<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("INSERT INTO speisekarte (name, price) VALUES (?,?)");
    $stmt->execute([$_POST["name"], $_POST["price"]]);
    header('Location: menu.php');
    exit;
}

?>