<!DOCTYPE html>
<html lang="de">
    <?php require __DIR__ . "/headers.php";?>
<body>
    <?= $content ?>
    <?php require __DIR__ . "/menu.php";?>
</body>
<script>
  if ("serviceWorker" in navigator) {
    navigator.serviceWorker.register("/sw.js");
  }
</script>

</html>