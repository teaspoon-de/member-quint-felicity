<h1>Songs</h1>

<a href="/songs/add">+ Song hinzufügen</a>

<ul>
    <?php foreach ($songs as $song): ?>
        <li>
            <a href="/songs/<?= $song['id'] ?>">
                <?= htmlspecialchars($song['title'] ?? '') ?> – <?= htmlspecialchars($song['artists'] ?? '') ?>
            </a>
            |
            <a href="/songs/<?= $song['id'] ?>/edit">Bearbeiten</a>
            |
            <form action="/songs/<?= $song['id'] ?>/delete" method="post" style="display:inline;">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit" onclick="return confirm('Sicher löschen?')">Löschen</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
