<?php
$backURI = "/blog";
require __DIR__ . "/../layout/topBarEdit.php";
?>

<form style="margin-top: 100px;" id="createForm" action="/blog/<?= $blogpost['id'] ?>/edit" method="post">
    <p>
        <label for="title">Titel</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($blogpost['title'] ?? '') ?>" required>
    </p>
    <p>
        <label for="cover_id">Cover</label><br>
        <input type="text" id="cover_id" name="cover_id" value="<?= htmlspecialchars($blogpost['cover_id'] ?? '') ?>">
    </p>
    <p>
        <label for="content">Content</label><br>
        <input type="text" id="content" name="content" value="<?= htmlspecialchars($blogpost['content'] ?? '') ?>">
    </p>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
</form>

<p><a href="/blog">Abbrechen</a></p>

<script>
    async function submit() {
        document.getElementById('createForm').submit();
    }
</script>