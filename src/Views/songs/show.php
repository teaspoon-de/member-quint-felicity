<h1><?= htmlspecialchars($song['title']) ?></h1>
<p><strong>Artist:</strong> <?= htmlspecialchars($song['artist']) ?></p>

<?php if (!empty($song['cover_url'])): ?>
    <img src="<?= htmlspecialchars($song['cover_url']) ?>" width="200">
<?php endif; ?>

<p>
    <a href="/songs">← Zurück zur Übersicht</a>
</p>
<p>
    <a href="/songs/<?= $song['id'] ?>/edit">Bearbeiten</a>
</p>
<form action="/songs/<?= $song['id'] ?>/delete" method="post">
    <button type="submit" onclick="return confirm('Wirklich löschen?')">Löschen</button>
</form>
