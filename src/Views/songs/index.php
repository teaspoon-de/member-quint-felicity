<?php
$title = "Songs";
$add = "add";
require __DIR__ . "/../layout/topIndex.php"
?>

<?php
$placeHolder = "Songs suchen";
$forTracks = true;
$searchMethod = null;
require __DIR__ . "/../layout/search.php"
?>

<link rel="stylesheet" href="/css/songs.css">

<section id="trackList">
    <?php foreach ($songs as $song): ?>
    <song class="unselectable" data-link="/songs/<?= $song['id'] ?>" data-duration="<?= htmlspecialchars($song['duration'] ?? '') ?>">
        <img src="<?= htmlspecialchars($song['cover_url'] ?? '') ?>">
        <div class="info">
            <h3><?= htmlspecialchars($song['title'] ?? '') ?></h3>
            <p><?= htmlspecialchars($song['artists'] ?? '') ?></p>
        </div>
        <div class="transpose">
            <p class="by"><?= htmlspecialchars($song['transposed_by'] ?? '') ?></p>
            <p class="key">
            <span style="background-color: var(--<?= $song['status']?>)"></span><?php
                $key = $song['original_key_maj'];
                if ($key == -1) {
                    echo "<b>?</b>";
                } else {
                    $possibleMaj = array("C", "D♭", "D", "E♭", "E", "F", "F#", "G", "A♭", "A", "B♭", "B");
                    $possibleMin = array("A", "B♭", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#");
                    $maj = $song['is_major']===1? ' class="bold"': "";
                    $min = $song['is_major']===0? ' class="bold"': "";
                    echo '<major'.$maj.'>'.$possibleMaj[$key].'</major><minor'.$min.'>'.$possibleMin[$key].'m</minor>';
                }
            ?></p>
        </div>
        <form action="/songs/<?= $song['id'] ?>/delete" method="post" style="display:none;">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit" onclick="return confirm('Sicher löschen?')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
            </button>
        </form>
    </song>
    <?php endforeach; ?>
</section>
<script>
    $("#top .play").click(function() {
        window.open($(this).data("href"), '_blank').focus();
    });

    songCount();

    // delete transpose block if not tranposed
    $(".by").each(function(index) {
        if ($(this).text() == "0") {
            $(this).css("display", "none");
        }
    });

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

    function onEdit() {
        var a, b = "none";
        $(".editIcon").each(function(index) {
            if (index == 0) {
                a = $(this).css("display")=="none"? "block": "none";
                if (a == "none") b = "block";
                $(this).css("display", a);
            } else $(this).css("display", b);
        });
        $(".transpose").each(function() {
            $(this).css("display", a == "block"? "flex": a)
        });
        $("song form").each(function() {
            $(this).css("display", b)
        });
    }
</script>