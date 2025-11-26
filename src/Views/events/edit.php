<?php
$backURI = "/events/".$event['id'];
require __DIR__ . "/../layout/topBarEdit.php";
?>

<form action="/events/<?= $event['id'] ?>/edit" method="post">
    <input type="hidden" name="_method" value="PUT">
    <p>
        <label for="title">Titel</label><br>
        <input 
            type="text" 
            id="title" 
            name="title" 
            value="<?= htmlspecialchars($event['title'] ?? '') ?>"
            required
        >
    </p>

    <p>
        <label for="date_begin">Beginn</label><br>
        <input 
            type="datetime-local" 
            id="date_begin" 
            name="date_begin" 
            value="<?=$song['date_begin']?>"
            required
        >
    </p>

    <p>
        <label for="public_entry">Public Entry</label><br>
        <input 
            type="datetime" 
            id="public_entry" 
            name="public_entry" 
            value="<?= htmlspecialchars($song['cover_url'] ?? '') ?>"
        >
    </p>

    <p>
        <label for="deadline">Deadline</label><br>
        <input 
            type="datetime" 
            id="deadline" 
            name="deadline" 
            value="<?= htmlspecialchars($song['cover_url'] ?? '') ?>"
        >
    </p>

    <p>
        <label for="deadline">Deadline</label><br>
        <input 
            type="datetime" 
            id="deadline" 
            name="deadline" 
            value="<?= htmlspecialchars($song['cover_url'] ?? '') ?>"
        >
    </p>

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <button type="submit">Änderungen speichern</button>
</form>

<p><a href="/songs/<?= $song['id'] ?>">Abbrechen</a></p>
