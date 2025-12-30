<?php
$backURI = "/setlists";
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/setlists.css">
<link rel="stylesheet" href="/css/edit.css">

<section class="section edit">
    <form id="createForm" action="/setlists/create" method="post">
        <div class="inLong">
            <h3>Titel</h3>
            <input type="text" 
                id="name" 
                name="name"
                required
            >
        </div>

        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        <button type="submit" class="null"></button>
    </form>
</section>

<script>
    async function submit() {
        clearErrors();

        // Sinn überprüfen
        if (inputIsEmpty("#name")) return;

        document.getElementById('createForm').submit();
    }

    function inputIsEmpty(query) {
        var b = !$(query).val() || $(query).val().trim() == "";
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