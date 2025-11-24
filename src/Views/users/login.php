<h1>Login</h1>

<form action="/login" method="post">
    <p>
        <label for="username">Nutzername</label><br>
        <input type="text"
        id="username"
        name="username"
        <?php if(isset($data["username"])) echo 'value="'.$data["username"].'"'?>
        required>
    </p>

    <p>
        <label for="password">Anzeigename</label><br>
        <input type="password" id="password" name="password" required>
        <?php if(isset($error)) echo '<p>'.$error.'</p>'?>
    </p>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <button type="submit">Anmelden</button>
</form>
