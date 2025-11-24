<?php
require "config.php";

$stmt = $pdo->query("SELECT * FROM speisekarte");
$menu = $stmt->fetchAll();

while ($row = $stmt->fetch()) {
    echo "<p>" .$row['name'] . ": " . $row['price'] . '€<a href="delete.php?id=' . $row['id'] . '" onclick="return confirm(' ."'Wirklich löschen?'" . ')">Löschen</a></p>';
}

foreach ($menu as $item):
?>
    <p>
        <?= htmlspecialchars($item["name"]) ?> - <?= $item["price"] ?>€
        <a href="edit.php?id=<?= $item["id"] ?>">Bearbeiten</a>
        <a href="delete.php?id=<?= $item["id"] ?>" onclick="return confirm('Möchtest du <?= $item["name"] ?> wirklich Löschen?')">Löschen</a>
    </p>
<?php endforeach; ?>