<h1>Song bearbeiten</h1>

<form action="/songs/<?= $song['id'] ?>" method="post">
    <input type="hidden" name="_method" value="PUT">

    <p>
        <label for="title">Titel</label><br>
        <input 
            type="text" 
            id="title" 
            name="title" 
            value="<?= htmlspecialchars($song['title']) ?>"
            required
        >
    </p>

    <p>
        <label for="artist">Interpret</label><br>
        <input 
            type="text" 
            id="artist" 
            name="artist" 
            value="<?= htmlspecialchars($song['artist']) ?>"
            required
        >
    </p>

    <p>
        <label for="cover_url">Cover-Bild URL</label><br>
        <input 
            type="url" 
            id="cover_url" 
            name="cover_url" 
            value="<?= htmlspecialchars($song['cover_url']) ?>"
        >
    </p>

    <button type="submit">Änderungen speichern</button>
</form>

<p><a href="/songs/<?= $song['id'] ?>">Abbrechen</a></p>
