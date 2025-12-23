<?php
$backURI = "/blog/images";
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/blog.css">
<link rel="stylesheet" href="/css/edit.css">

<section class="section edit">
    <form id="editForm" action="/blog/images/<?= $image['id'] ?>/edit" method="post" class="imgForm">

        <img src="<?= '/resources/uploads/'.htmlspecialchars($image['uri'] ?? '') ?>" alt="<?= htmlspecialchars($image['alt'] ?? '') ?>">

        <div class="inLong">
            <h3>Titel</h3>
            <input
                type="text" 
                id="title" 
                name="title" 
                value="<?= htmlspecialchars($image['title'] ?? '') ?>"
                required
            >
        </div>

        <div class="inLong">
            <h3>Beschreibung</h3>
            <textarea id="descriptionTa" placeholder="Alex einfach Spagat gemacht bei Bruno Mars böö ..."><?= htmlspecialchars($image['description'] ?? '') ?></textarea>
            <input type="hidden" id="description" name="description">
        </div>

        <div class="inLong">
            <h3>Datum der Aufnahme</h3>
            <input
                type="date"
                id="taken_at"
                name="taken_at"
                value="<?php 
                        $date = new DateTime($image["taken_at"]);
                        echo $date->format('Y-m-d');
                    ?>"
                required
            >
        </div>

        <div class="inLong">
            <h3>alt (Bild-Beschreibung für Roboter)</h3>
            <input 
                type="text" 
                id="alt" 
                name="alt" 
                placeholder="z.B. Alex, Sänger von Quint Felicity spielt Gitarre."
                value="<?= htmlspecialchars($image['alt'] ?? '') ?>"
            >
        </div>

        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <button type="submit" class="null"></button>
    </form>
</section>

<script>
    async function submit() {
        clearErrors();

        // Sinn überprüfen
        if (inputIsEmpty("#taken_at")) return;
        if (inputIsEmpty("#alt")) return;

        document.getElementById("description").value = document.getElementById("descriptionTa").value;
        document.getElementById('editForm').submit();
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