<?php
$backURI = "/events/".$event['id'];
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/events.css">

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

        <div class="inLong">
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
        </div>
        <input type="hidden" id="public_entry" name="public_entry">

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
    </form>
</section>

<script>
    async function submit() {
        console.log("hallo");
        
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
        document.getElementById("notes").value = document.getElementById("notesTa").value;
        document.getElementById("location").value = document.getElementById("locationTa").value;
        document.getElementById('editForm').submit();
    }
</script>