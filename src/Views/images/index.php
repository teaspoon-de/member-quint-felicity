<form action="/blog/images/create" method="POST" enctype="multipart/form-data">
    <input type="file" name="bild" accept="image/*">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <button type="submit">Hochladen</button>
</form>