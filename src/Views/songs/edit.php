<h1>Song bearbeiten</h1>

<form action="/songs/<?= $song['id'] ?>/edit" method="post">
    <input type="hidden" name="_method" value="PUT">

    <p>
        <label for="title">Titel</label><br>
        <input 
            type="text" 
            id="title" 
            name="title" 
            value="<?= htmlspecialchars($song['title'] ?? '') ?>"
            required
        >
    </p>

    <p>
        <label for="artists">Interpret</label><br>
        <input 
            type="text" 
            id="artists" 
            name="artists" 
            value="<?= htmlspecialchars($song['artists'] ?? '') ?>"
            required
        >
    </p>

    <p>
        <label for="cover_url">Cover-Bild URL</label><br>
        <input 
            type="url" 
            id="cover_url" 
            name="cover_url" 
            value="<?= htmlspecialchars($song['cover_url'] ?? '') ?>"
        >
    </p>

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <button type="submit">Änderungen speichern</button>
</form>

<p><a href="/songs/<?= $song['id'] ?>">Abbrechen</a></p>
