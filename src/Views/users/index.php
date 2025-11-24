<h1>Band-Mitglieder</h1>

<a href="/members/create">+ Nutzerkonto hinzufügen</a>

<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <h2>
                <?= htmlspecialchars($user['name'] ?? '') ?>
            </h2>
            <?php if($user['id'] != $_SESSION['user_id']) echo '|
                <form action="/members/'.$user['id'].'/delete" method="post" style="display:inline;">
                    <input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
                    <button type="submit" onclick="return confirm(\'Sicher löschen?\')">Löschen</button>
                </form>
            ';
            else echo ' - Du'?>
        </li>
    <?php endforeach; ?>
</ul>
