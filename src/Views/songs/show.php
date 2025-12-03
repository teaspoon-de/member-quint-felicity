<?php
$backToString = "Repertoire";
$backToURI = "/songs";
require __DIR__ . "/../layout/topBarItem.php"
?>

<link rel="stylesheet" href="/css/track.css">
<section id="track">
    <img src="<?= $song['cover_url'] ?>" alt=""></img>
    <div class="info">
        <svg data-href="<!--sfhref-->" id="play" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play-icon lucide-play"><polygon points="6 3 20 12 6 21 6 3"/></svg>
        <h1><?= $song['title'] ?></h1>
        <h3><?= $song['artists'] ?></h3>
    </div>
    <div class="transposeContainer">
        <div class="transpose">
            <p class="by"><?= $song['transposed_by'] ?></p>
            <p class="key"><?php
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
    </div>
    <h2 class="unselectable">Notizen</h2>
    <div class="notes">
        <p id="notes"><?= $song['notes'] ?></p>
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