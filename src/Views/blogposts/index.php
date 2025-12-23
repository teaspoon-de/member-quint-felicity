<?php
$title = "Blog";
$add = "create";
require __DIR__ . "/../layout/topIndex.php"
?>

<div id="imageLink" class="unselectable">
    <ichoutplayeflex style="display: block; width: 50px"></ichoutplayeflex>
    <div>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-images-icon lucide-images"><path d="m22 11-1.296-1.296a2.4 2.4 0 0 0-3.408 0L11 16"/><path d="M4 8a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2"/><circle cx="13" cy="7" r="1" fill="currentColor"/><rect x="8" y="2" width="14" height="14" rx="2"/></svg>
        <p>Bilder</p>
    </div>
    <svg class="linkIcon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right-icon lucide-arrow-up-right"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
</div>
<script>
    $('#imageLink').off().click(()=>{
        window.location.assign('/blog/images');
    });
</script>

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
        <p><?= $blogpost['content']? substr(htmlspecialchars(substr(explode('</p>', $blogpost['content'])[0], strlen('<article><p>')) ?? ''), 0, 512): '' ?></p>
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