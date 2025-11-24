<h1>Song hinzufügen</h1>

<form action="/songs" method="post">
    <p>
        <label for="title">Titel</label><br>
        <input type="text" id="title" name="title" required>
    </p>

    <p>
        <label for="artist">Interpret</label><br>
        <input type="text" id="artist" name="artist" required>
    </p>

    <p>
        <label for="cover_url">Cover-Bild URL</label><br>
        <input type="url" id="cover_url" name="cover_url">
    </p>

    <button type="submit">Speichern</button>
</form>

<p><a href="/songs">Abbrechen</a></p>
