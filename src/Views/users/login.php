<!DOCTYPE html>
<html lang="de">
    <?php require __DIR__ . "/../layout/headers.php";?>
<body>

<?php
$title = "Mitglieder Bereich";
$add = null;
require __DIR__ . "/../layout/topIndex.php"
?>

<link rel="stylesheet" href="/css/edit.css">

<section class="section edit" style="margin-top: 0px">
    <form action="/login" method="post">
        <div class="inLong">
            <h3>Nutzername</h3>
            <input <?php if($error) echo 'class="error"'?>
                type="text"
                id="username"
                name="username"
                autocomplete="username"
                <?php if(isset($data["username"])) echo 'value="'.$data["username"].'"'?>
                required
                <?php if(!$error || $error['field'] === 0) echo 'autofocus'?>
            >
        </div>
        <?php if($error && $error['field'] === 0) echo '<p class="errorMessage">'. $error['message'] .'</p>'?>
        <div class="inLong">
            <h3>Passwort</h3>
            <input <?php if($error && $error['field'] === 1) echo 'class="error"'?>
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
                <?php if($error && $error['field'] === 1) echo 'autofocus'?>
            >
        </div>
        <?php if($error && $error['field'] === 1) echo '<p class="errorMessage">'. $error['message'] .'</p>'?>
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

        <button type="submit">
            <p>Anmelden</p>
        </button>
    </form>
</section>

</body>
</html>