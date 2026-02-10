<?php
$backURI = "/events/".$event['id'];
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/events.css">
<link rel="stylesheet" href="/css/edit.css">

<section class="section edit">
    <form id="editForm" action="/events/<?= $event['id'] ?>/edit" method="post">
        <div class="inLong">
            <h3>Titel</h3>
            <input
                type="text" 
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

        <div class="checkBox">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check-icon lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>
            <p>Auftritt zugesagt</p>
            <input
                type="checkbox"
                id="booked"
                name="booked"
            >
            <span class="slider"></span>
        </div>

        <div class="checkBox">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe-icon lucide-globe"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
            <p>Öffentliche Veranstaltung</p>
            <input
                type="checkbox"
                id="publish"
                name="publish"
            >
            <span class="slider"></span>
        </div>

        <script>
            $("#booked").prop("checked", <?=$event['booked'] === 1? 'true': 'false'?>);
            $("#publish").prop("checked", <?=$event['publish'] === 1? 'true': 'false'?>);
    
            $('.checkBox').each(function() {$(this).off().click(function() {
                var cb = $(this).find('input[type=checkbox]');
                cb.prop('checked', !cb.prop('checked'));
            });});
        </script>

        <div class="inLong null">
            <h3>Deadline für Zu-/Absagen</h3>
            <input 
                type="datetime-local" 
                id="deadline" 
                name="deadline" 
                value="<?= htmlspecialchars($event['deadline']) ?>"
            >
        </div>

        <div class="inLong">
            <h3>Einlass</h3>
            <input 
                type="time" 
                id="public_entry_time" 
                name="public_entry_time" 
                value="<?php 
                    if (!$event["public_entry"]) echo "";
                    else {
                        $date = new DateTime($event["public_entry"]);
                        echo $date->format('H:i');
                    }
                ?>"
            >
            <input type="hidden" id="public_entry" name="public_entry">
        </div>

        <div class="inLong">
            <h3>Setlänge</h3>
            <input 
                type="text" 
                id="duration" 
                name="duration" 
                placeholder="z.B. 20 min oder 1,5h oder 17cm"
                value="<?= htmlspecialchars($event['duration'] ?? '') ?>"
            >
        </div>

        <div class="inLong">
            <h3>Gage</h3>
            <div class="inFlex">
                <input
                    type="text" 
                    id="salary" 
                    name="salary" 
                    placeholder="z.B. 500"
                    value="<?= htmlspecialchars($event['salary'] ?? '') ?>"
                >
            <p>€</p>
            </div>
        </div>

        <div class="inLong">
            <h3>Notizen</h3>
            <textarea id="notesTa" placeholder="Lass richtig abgehen woop woop ..."><?= htmlspecialchars($event['notes'] ?? '') ?></textarea>
            <input type="hidden" id="notes" name="notes">
        </div>

        <div class="inLong">
            <h3>Adresse</h3>
            <textarea id="locationTa" placeholder=
"z.B. Wiedparkhalle
Raiffeisenstraße 9
53577 Neustadt (Wied)"><?= htmlspecialchars($event['location'] ?? '') ?></textarea>
            <input type="hidden" id="location" name="location">
        </div>

        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <button type="submit" class="null"></button>
    </form>

    <button onClick="deleteContext()" id="deleteButton">Löschen</button>
</section>

<script>
    async function submit() {
        $("input").each(function() {
            $(this).removeClass("error");
        });
        $(".errorMessage").each(function() {
            $(this).remove();
        });

        const fullDate = document.getElementById("date_begin").value; // z.B. 2025-03-12T11:22
        const time = document.getElementById("public_entry_time").value; // z.B. 14:30
        const output = document.getElementById("public_entry");
        // Falls keine Zeit angegeben -> NULL übergeben
        if (!time) {
            output.value = "";
        } else {
            // Datum extrahieren (YYYY-MM-DD)
            const dateOnly = fullDate.split("T")[0];
            // Neue datetime bauen
            const datetime = `${dateOnly} ${time}:00`;
            output.value = datetime;
        }

        // Sinn überprüfen
        if ($("#title").val().trim() == "") {
            inputError("#title", "Feld darf nicht leer sein.");
            return;
        }
        if (!fullDate) {
            inputError("#date_begin", "Feld darf nicht leer sein.");
            return;
        }
        var begin = new Date($("#date_begin").val());
        if ($("#deadline").val() != "") {
            var deadline = new Date($("#deadline").val());
            if (deadline > begin) {
                inputError("#deadline", "Deadline kann nicht nach Konzertbeginn sein.");
                return;
            }
        }
        if ($("#public_entry").val() != "") {
            var publicEntry = new Date($("#public_entry").val());
            if (publicEntry > begin) {
                inputError("#public_entry", "Einlass kann nicht nach Konzertbeginn sein.");
                return;
            }
        }

        document.getElementById("notes").value = document.getElementById("notesTa").value;
        document.getElementById("location").value = document.getElementById("locationTa").value;
        document.getElementById('editForm').submit();
    }

    function inputError(query, message) {
        $(query).addClass("error");
        $('<p class="errorMessage">' + message + '</p>').insertAfter($(query).parent());
    }
</script>

<section id="deleteContext">
    <div class="container">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert-icon lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
        <h2>Möchtest du <b><?= $event['title']?></b> wirklich löschen?</h2>
        <div>
            <button onClick="cancelDelete()">Abbrechen</button>
            <button class="submit" onClick="submitDelete()">Löschen</button>
        </div>
        <form id="deleteForm" action="/events/<?= $event['id'] ?>/delete" method="POST" style="display: none;">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        </form>
    </div>
    <script>
        function deleteContext() {$("#deleteContext").css("display", "flex");}
        function submitDelete() {document.getElementById('deleteForm').submit();}
        function cancelDelete() {$("#deleteContext").css("display", "none");}
    </script>
</section>