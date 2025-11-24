<h1>Neues Nutzerkonto erstellen</h1>

<form action="/members/create" method="post">
    <p>
        <label for="username">Nutzername</label><br>
        <input type="text" id="username" name="username"
        <?php if(isset($data["username"])) echo 'value="'.$data["username"].'"'?>
        required>
    </p>

    <p>
        <label for="name">Anzeigename</label><br>
        <input type="text" id="name" name="name"
        <?php if(isset($data["name"])) echo 'value="'.$data["name"].'"'?>
        required>
    </p>

    <p>
        <label for="email">E-Mail</label><br>
        <input type="text" id="email" name="email"
        <?php if(isset($data["email"])) echo 'value="'.$data["email"].'"'?>>
    </p>

    <p>
        <label for="password">Passwort</label><br>
        <input type="text" id="password" name="password">
    </p>

    <p>
        <label for="instrument">Instrument</label><br>
        <input type="text" id="instrument" name="instrument"
        <?php if(isset($data["instrument"])) echo 'value="'.$data["instrument"].'"'?>>
    </p>

    <?php if(isset($error)) echo '<p>'.$error.'</p>'?>

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <button type="submit">Erstellen</button>
</form>

<p><a href="/members">Abbrechen</a></p>