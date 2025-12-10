<?php
$title = "Blog";
$add = "create";
require __DIR__ . "/../layout/topIndex.php"
?>

<?php
$placeHolder = "Beitrag suchen";
$forTracks = false;
$searchMethod = null;
require __DIR__ . "/../layout/search.php"
?>

<link rel="stylesheet" href="/css/blog.css">
<section id="blogList">
    <?php foreach ($blogposts as $blogpost): ?>
    <entry class="unselectable" data-link="/blog/<?= $blogpost['id'] ?>/edit">
        <div class="title">
            <img src="<?= "/resources/uploads/".htmlspecialchars($blogpost['cover_uri'] ?? '') ?>">
            <div>
                <h3><?= htmlspecialchars($blogpost['title'] ?? '') ?></h3>
                <p><?php 
                        $date = new DateTime($blogpost['date']);
                        echo 'am '.$date->format('d.m.Y');
                    ?></p>
            </div>
        </div>
        <p><?= substr(htmlspecialchars($blogpost['content'] ?? ''), 0, 512) ?></p>
    </entry>
    <?php endforeach; ?>
</section>
<script>

    $("#blogList entry").each(function(index) {
        $(this).click(function() {
            window.location.assign($(this).data("link"));
        });
    });

    function onSearchUpdate(query) {
        $("#blogList entry").each(function(index) {
            if (query != "" && !$(this).text().toLowerCase().includes(query)) {
                $(this).css("display", "none");
            } else if ($(this).css("display") == "none") $(this).css("display", "flex");
        });
    }
</script>