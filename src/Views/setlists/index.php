<?php
$title = "Setlists";
$add = "create";
require __DIR__ . "/../layout/topIndex.php"
?>

<link rel="stylesheet" href="/css/setlists.css">

<?php
$placeHolder = "Setlist suchen";
$forTracks = false;
$searchMethod = null;
require __DIR__ . "/../layout/search.php"
?>

<div id="setlistList">
    <?php foreach ($setlists as $setlist): ?>
        <setlist class="unselectable" data-link="/setlists/<?= $setlist['id'] ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-chart-gantt-icon lucide-square-chart-gantt"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 8h7"/><path d="M8 12h6"/><path d="M11 16h5"/></svg>
            <h2><?= htmlspecialchars($setlist['name'] ?: '') ?></h2>
        </setlist>
    <?php endforeach; ?>
</div>

<script>
    $("setlist").each(function(index) {
        $(this).off().click(function() {
            window.location.assign($(this).data("link"));
        });
    });

    function onSearchUpdate(query) {
        $("#setlistList setlist").each(function(index) {
            if (query != "" && !$(this).text().toLowerCase().includes(query)) {
                $(this).css("display", "none");
            } else if ($(this).css("display") == "none") $(this).css("display", "flex");
        });
    }
</script>