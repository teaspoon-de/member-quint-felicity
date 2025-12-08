<?php
$backURI = "/events";
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/events.css">
<link rel="stylesheet" href="/css/edit.css">

<section class="section edit">
    <form id="createForm" action="/events/create" method="post">
        <div class="inLong">
            <h3>Titel</h3>
            <input type="text" 
                id="title" 
                name="title" 
                value="<?= htmlspecialchars($event['title'] ?? '') ?>"
                required
            >
        </div>
        <div class="inLong">
            <h3>Datum & Uhrzeit</h3>
            <input 
                type="datetime-local" 
                id="date_begin" 
                name="date_begin" 
                value="<?= htmlspecialchars($event['date_begin']) ?>"
                required
            >
        </div>

        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        <button type="submit" class="null"></button>
    </form>
</section>

<script>
    async function submit() {
        $("input").each(function() {
            $(this).removeClass("error");
        });
        $(".errorMessage").each(function() {
            $(this).remove();
        });

        // Sinn überprüfen
        if ($("#title").val().trim() == "") {
            inputError("#title", "Feld darf nicht leer sein.");
            return;
        }
        if (!$("#date_begin").val()) {
            inputError("#date_begin", "Feld darf nicht leer sein.");
            return;
        }

        document.getElementById('createForm').submit();
    }

    function inputError(query, message) {
        $(query).addClass("error");
        $('<p class="errorMessage">' + message + '</p>').insertAfter($(query).parent());
    }
</script>