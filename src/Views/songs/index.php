<!--h1>Songs</h1>

<a href="/songs/add">+ Song hinzufügen</a>

<ul>
    <?php foreach ($songs as $song): ?>
        <li>
            <a href="/songs/<?= $song['id'] ?>">
                 – <?= htmlspecialchars($song['artists'] ?? '') ?>
            </a>
            |
            <a href="/songs/<?= $song['id'] ?>/edit">Bearbeiten</a>
            |
            <form action="/songs/<?= $song['id'] ?>/delete" method="post" style="display:inline;">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit" onclick="return confirm('Sicher löschen?')">Löschen</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul-->
<section id="topbar" class="unselectable">
    <svg id="back" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
    <p><!--backTo--></p>
    <svg id="edit" data-link="edit/" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
</section>
<script>
    var backTo = "<!--backUri-->";
    $("#back").click(()=> {
        back();
    });
    $("#topbar p").click(()=> {
        back();
    });
    $("#edit").click(function() {
        window.location.assign($(this).data("link"));
    })

    function back() {
        window.location.assign(backTo!="null"? backTo: getLastSite());
    }

    function getLastSite() {
        var path = window.location.pathname;
        if (path.substring(path.length-1) == "/")
            path = path.substring(0, path.length-1);
        var pathSplit = path.split("/");
        return path.substring(0,path.length - pathSplit[pathSplit.length-1].length);
    }
</script>
<section id="top" class="unselectable">
    <h1 class="titleBig">Quint Felicity</h1>
    <h2 class="page">Repertoire</h2>
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="play lucide lucide-play-icon lucide-play"><polygon points="6 3 20 12 6 21 6 3"/></svg>
    <!--img data-href="" src="spotifyBlack.png" class="play" alt=""-->
</section>
<?php require __DIR__ . "/../layout/search.php" ?>
<section id="trackList">
    <?php foreach ($songs as $song): ?>
    <song data-link="/songs/<?= $song['id'] ?>" data-duration="<?= htmlspecialchars($song['duration'] ?? '') ?>">
        <img src="<?= htmlspecialchars($song['cover_url'] ?? '') ?>">
        <div class="info">
            <h3><?= htmlspecialchars($song['title'] ?? '') ?></h3>
            <p><?= htmlspecialchars($song['artists'] ?? '') ?></p>
        </div>
        <div class="transpose">
            <p class="by"><?= htmlspecialchars($song['transposed_by'] ?? '') ?></p>
            <p class="key"><?= htmlspecialchars($song['original_key'] ?? '?') ?></p>
        </div>
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
</script>