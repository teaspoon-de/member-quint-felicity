<?php
$title = "Blog";
$add = "create";
require __DIR__ . "/../layout/topIndex.php"
?>

<?php
$placeHolder = "Beitrag suchen";
$forTracks = true;
$searchMethod = null;
require __DIR__ . "/../layout/search.php"
?>

<section id="trackList">
    <?php foreach ($blogposts as $blogpost): ?>
    <song class="unselectable" data-link="/blog/<?= $blogpost['id'] ?>/edit">
        <img src="<?= htmlspecialchars($blogpost['cover_id'] ?? '') ?>">
        <div class="info">
            <h3><?= htmlspecialchars($blogpost['title'] ?? '') ?></h3>
            <p><?= htmlspecialchars($blogpost['content'] ?? '') ?></p>
        </div>
    </song>
    <?php endforeach; ?>
</section>
<script>

    $("#trackList song").each(function(index) {
        $(this).click(function() {
            window.location.assign($(this).data("link"));
        });
    });

    function onSearchUpdate(query) {
        $("#trackList song").each(function(index) {
            if (($("#filterNotInWork").hasClass("selected") && $(this).hasClass("inWork")) || ($("#filterInWork").hasClass("selected") && !$(this).hasClass("inWork")) || (query != "" && !$(this).text().toLowerCase().replaceAll("♭", "b").includes(query))) {
                $(this).css("display", "none");
            } else if ($(this).css("display") == "none") $(this).css("display", "flex");
        });
    }
</script>