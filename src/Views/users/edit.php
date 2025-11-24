<h1>Konto bearbeiten</h1>

<form action="/account/edit" method="post">
    <input type="hidden" name="_method" value="PUT">

    <p>
        <label for="username">Nutzername</label><br>
        <input 
            type="text" 
            id="username" 
            name="username" 
            value="<?= htmlspecialchars($user['username'] ?? '') ?>"
            required
        >
    </p>

    <p>
        <label for="name">Anzeigename</label><br>
        <input 
            type="text" 
            id="name" 
            name="name" 
            value="<?= htmlspecialchars($user['name'] ?? '') ?>"
            required
        >
    </p>

    <p>
        <label for="email">E-Mail</label><br>
        <input 
            type="text" 
            id="email" 
            name="email" 
            value="<?= htmlspecialchars($user['email'] ?? '') ?>"
        >
    </p>

    <p>
        <label for="password">Passwort</label><br>
        <input 
            type="password" 
            id="password" 
            name="password"
        >
    </p>

    <p>
        <label for="instrument">Instrument</label><br>
        <input 
            type="text" 
            id="instrument" 
            name="instrument" 
            value="<?= htmlspecialchars($user['instrument'] ?? '') ?>"
        >
    </p>

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <button type="submit">Änderungen speichern</button>
</form>

<p><a href="/account">Abbrechen</a></p>
