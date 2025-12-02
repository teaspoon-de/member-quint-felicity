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
                id="public_entry" 
                name="public_entry" 
                value="<?= htmlspecialchars($event['public_entry']) ?>"
            >
        </div>

        <div class="inLong">
            <h3>Setlänge</h3>
            <input 
                type="text" 
                id="duration" 
                name="duration" 
                placeholder="z.B. 20 min, oder 1,5 h"
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
                    placeholder="z.B. 10000"
                    value="<?= htmlspecialchars($event['salary'] ?? '') ?>"
                >
            <p>€</p>
            </div>
        </div>

        <div class="inLong">
            <h3>Notizen</h3>
            <input type="hidden" 
                id="notes" 
                name="notes" 
                value="<?= htmlspecialchars($event['title'] ?? '') ?>"
                required
            >
            <textarea placeholder="Lass richtig abgehen woop woop ..."><?= htmlspecialchars($event['notes'] ?? '') ?></textarea>
        </div>

        <div class="inLong">
            <h3>Adresse</h3>
            <input type="hidden" 
                id="location" 
                name="location" 
                value="<?= htmlspecialchars($event['title'] ?? '') ?>"
                required
            >
            <textarea placeholder=
"z.B. Wiedparkhalle
Raiffeisenstraße 9
53577 Neustadt (Wied)"><?= htmlspecialchars($event['location'] ?? '') ?></textarea>
        </div>

        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    </form>
</section>

<script>
    async function submit() {
        document.getElementById('editForm').submit();
    }
</script>

