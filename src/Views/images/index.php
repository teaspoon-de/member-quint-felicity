<?php
$title = "Bilder";
$add = null;
require __DIR__ . "/../layout/topIndex.php"
?>

<?php
$placeHolder = "Bild suchen";
$forTracks = false;
$searchMethod = null;
require __DIR__ . "/../layout/search.php"
?>

<link rel="stylesheet" href="/css/blog.css">

<form action="/blog/images/create" method="POST" enctype="multipart/form-data">
    <input type="file" name="bild" accept="image/*">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <button type="submit">Hochladen</button>
</form>

<section id="imageList">
    <?php foreach ($images as $image): ?>
    <img src="<?= '/resources/uploads/'.htmlspecialchars($image['uri'] ?? '')?>" alt="<?= htmlspecialchars($image['alt'] ?? '')?>" data-title="<?= htmlspecialchars($image['title'] ?? '')?>" data-link="<?= $image['id']?>">
    <?php endforeach; ?>
</section>
<script>

    $("#imageList img").each(function(index) {
        $(this).click(function() {
            window.location.assign("images/" + $(this).data("link"));
        });
    });

    function onSearchUpdate(query) {
        $("#imageList img").each(function(index) {
            if (query != "" && !$(this).text().toLowerCase().includes(query) && !$(this).attr("alt").toLowerCase().includes(query) && !$(this).data("title").toLowerCase().includes(query)) {
                $(this).css("display", "none");
            } else if ($(this).css("display") == "none") $(this).css("display", "flex");
        });
    }
</script>