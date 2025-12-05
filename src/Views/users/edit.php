<?php
$backURI = "/members";
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/user.css">
<link rel="stylesheet" href="/css/edit.css">

<section class="section edit">
    <form action="/account/edit" method="post">
        <input type="hidden" name="_method" value="PUT">
        <div class="inLong">
            <h3>Nutzername (zum Anmelden)</h3>
            <input 
                type="text" 
                id="username" 
                name="username" 
                value="<?= htmlspecialchars($user['username'] ?? '') ?>"
                required
            >
        </div>

        <div class="inLong">
            <h3>Anzeigename</h3>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                required
            >
        </div>

        <div class="inLong">
            <h3>E-Mail</h3>
            <input 
                type="text" 
                id="email" 
                name="email" 
                value="<?= htmlspecialchars($user['email'] ?? '') ?>"
            >
        </div>

        <div class="inLong">
            <h3>Instrument</h3>
            <input 
                type="text" 
                id="instrument" 
                name="instrument" 
                value="<?= htmlspecialchars($user['instrument'] ?? '') ?>"
            >
        </div>

        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    </form>
</section>
