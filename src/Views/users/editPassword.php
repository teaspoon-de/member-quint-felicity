<?php
$backURI = "/members";
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/user.css">
<link rel="stylesheet" href="/css/edit.css">

<section class="section edit">
    <form id="editForm" action="/account/edit/password" method="post">
        <div class="inLong">
            <h3>Altes Passwort</h3>
            <input <?php if ($error) echo 'class="error"'?> 
                type="password" 
                id="old" 
                name="old"
                required
            >
        </div>
        <?php if ($error) echo '<p class="errorMessage">'. $error .'</p>'?>

        <div class="inLong">
            <h3>Neues Passwort</h3>
            <input 
                type="password" 
                id="password" 
                name="password"
                required
            >
        </div>

        <div class="inLong">
            <h3>Passwort wiederholen</h3>
            <input 
                type="password"
                id="again"
                required
            >
        </div>

        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    </form>

    <script>
        async function submit() {
            clearErrors();
            if (inputIsEmpty("#old") || inputIsEmpty("#password") || inputIsEmpty("#again")) return;
            if ($("#password").val().trim() != $("#again").val().trim()) {
                inputError("#again", "Passwörter stimmen nicht überein, du Dulli");
                return;
            }
            document.getElementById('editForm').submit();
        }

        function inputIsEmpty(query) {
            var b = $(query).val().trim() == "";
            if (b) inputError(query, "Feld darf nicht leer sein.");
            return b;
        }

        function clearErrors() {
            $("input").each(function() {
                $(this).removeClass("error");
            });
            $(".errorMessage").each(function() {
                $(this).remove();
            });
        }

        function inputError(query, message) {
            $(query).addClass("error");
            $('<p class="errorMessage">' + message + '</p>').insertAfter($(query).parent());
        }
    </script>
</section>
