<h1><?= htmlspecialchars($user['username'] ?? '') ?></h1>
<p><strong>Anzeigename:</strong> <?= htmlspecialchars($user['name'] ?? '') ?></p>

<p>
    <a href="/members">Alle Bandmitglieder anzeigen</a>
</p>
<p>
    <a href="/account/edit">Bearbeiten</a>
</p>
