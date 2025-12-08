<?php
$backToString = "Repertoire";
$backToURI = "/songs";
require __DIR__ . "/../layout/topBarItem.php"
?>

<link rel="stylesheet" href="/css/track.css">
<section id="track">
    <div class="container">
        <div class="imgContainer"><img src="<?= $song['cover_url'] ?>" alt=""></img></div>
        <div class="info">
            <svg data-href="https://open.spotify.com/track/<?= htmlspecialchars($song['spotify_id'] ?? '')?>" id="play" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play-icon lucide-play"><polygon points="6 3 20 12 6 21 6 3"/></svg>
            <h1><?= $song['title'] ?></h1>
            <p><?= $song['artists'] ?></p>
        </div>
        <div class="kvRow">
            <div>
                <value><?= $song['transposed_by'] ?></value>
                <p>Transponiert</p>
            </div>
            <div>
                <value><?php
                $key = $song['original_key_maj'];
                if ($key == -1) {
                    echo "?";
                } else {
                    $possibleMaj = array("C", "D♭", "D", "E♭", "E", "F", "F#", "G", "A♭", "A", "B♭", "B");
                    $possibleMin = array("A", "B♭", "B", "C", "C#", "D", "D#", "E", "F", "F#", "G", "G#");
                    $x = $key + $song['transposed_by'];
                    $key = $x % 12;
                    if ($x < 0) $key = 12 + $key;
                    if ($song['is_major']===1) echo $possibleMaj[$key].'<b>/'.$possibleMin[$key].'m</b>';
                    else if ($song['is_major']===0) echo '<b>'.$possibleMaj[$key].'/</b>'.$possibleMin[$key].'m';
                    else echo $possibleMaj[$key].'/'.$possibleMin[$key].'m';
                }
            ?></value>
                <p>Tonart</p>
            </div>
        </div>
        <div class="ampel">
            <span <?= $song['status']==="red"? 'style="background-color: var(--red);"': '' ?>></span>
            <span <?= $song['status']==="orange"? 'style="background-color: var(--orange);"': '' ?>></span>
            <span <?= $song['status']==="green"? 'style="background-color: var(--green);"': '' ?>></span>
        </div>
        <h2 class="unselectable">Notizen</h2>
        <div class="notes">
            <p id="notes"><?= $song['notes'] ?: '-' ?></p>
        </div>
    </div>
</section>

<script>
    function onEdit() {
        window.location.assign("/songs/<?= $song['id'] ?>/edit");
    }

    $("#play").click(function() {
        window.open($(this).data("href"), '_blank').focus();
    });
    
</script>