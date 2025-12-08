<?php
$backURI = "/members";
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/user.css">
<link rel="stylesheet" href="/css/edit.css">

<section class="section edit">
    <a href="/account/edit/password">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-key-round-icon lucide-key-round"><path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"/><circle cx="16.5" cy="7.5" r=".5" fill="currentColor"/></svg>
        <p>Passwort ändern</p>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
    </a>

    <form id="editForm" action="/account/edit" method="post">
        <div class="inLong">
            <h3>Nutzername (zum Anmelden)</h3>
            <input <?php if ($error) echo 'class="error"'?> 
                type="text" 
                id="username" 
                name="username" 
                value="<?= htmlspecialchars($user['username'] ?? '') ?>"
                required
            >
        </div>
        <?php if ($error) echo '<p class="errorMessage">'. $error .'</p>'?>

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

        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <button type="submit" class="null"></button>
    </form>

    <script>
        async function submit() {
            document.getElementById('editForm').submit();
        }
    </script>
</section>
