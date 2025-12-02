<?php
$backURI = "/events";
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/events.css">

<section class="section edit">
    <form id="createForm" action="/events/create" method="post">
        <input type="hidden" name="_method" value="PUT">
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

        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    </form>
</section>

<script>
    async function submit() {
        document.getElementById('createForm').submit();
    }
</script>