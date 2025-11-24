<h1>Songs</h1>

<a href="/songs/create">+ Song hinzufügen</a>

<ul>
    <?php foreach ($songs as $song): ?>
        <li>
            <a href="/songs/<?= $song['id'] ?>">
                <?= htmlspecialchars($song['title']) ?> – <?= htmlspecialchars($song['artist']) ?>
            </a>
            |
            <a href="/songs/<?= $song['id'] ?>/edit">Bearbeiten</a>
            |
            <form action="/songs/<?= $song['id'] ?>/delete" method="post" style="display:inline;">
                <button type="submit" onclick="return confirm('Sicher löschen?')">Löschen</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
