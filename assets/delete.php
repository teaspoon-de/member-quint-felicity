<?php

require "config.php";

$stmt = $pdo->prepare("DELETE FROM speisekarte WHERE id = ?");
$stmt->execute([$_GET["id"]]);
header("Location: menu.php");
exit;

?>