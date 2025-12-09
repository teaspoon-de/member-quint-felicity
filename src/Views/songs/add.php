<?php
$backURI = "/songs";
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/top.css">
<section id="top" class="unselectable" style="margin-top: 120px">
    <h1 class="titleSmall">Song hinzufügen</h1>
</section>

<?php
$placeHolder = "Spotify Suche";
$forTracks = false;
$searchMethod = "spotifySearch()";
require __DIR__ . "/../layout/search.php"
?>

<link rel="stylesheet" href="/css/songs.css">
<section id="trackList"></section>

<form id="saveForm" action="/songs/add" method="POST">
    <input type="hidden" id="title" name="title">
    <input type="hidden" id="artists" name="artists">
    <input type="hidden" id="cover_url" name="cover_url">
    <input type="hidden" id="cover_big_url" name="cover_url">
    <input type="hidden" id="duration_ms" name="duration_ms">
    <input type="hidden" id="spotify_id" name="spotify_id">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
</form>

<script>
    async function spotifySearch() {
        const res = await fetch('/api/spotify_search.php?q=' + encodeURIComponent($('.search input').val()));
        const data = await res.json();

        $('#trackList').empty();

        data.tracks.items.forEach(track => {
            // TODO Render Artists, Rate Limit
            $(`<song><img src="${track.album.images[2].url}">
                <div class="info"><h3>${track.name}</h3><p>${formatArtists(track.artists)}</p></div></song>`)
                .data('title', track.name)
                .data('artists', formatArtists(track.artists))
                .data('cover_url', track.album.images[2].url)
                .data('cover_big_url', track.album.images[0].url)
                .data('duration_ms', track.duration_ms)
                .data('spotify_id', track.id)
                .off().click(function() {
                    $('song').each(function(){
                        $(this).removeClass('selected')
                        $(this).find('svg').remove();
                    });
                    $('<svg style="color=var(--cbg); margin-right: 25px;" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-plus-icon lucide-list-plus"><path d="M16 5H3"/><path d="M11 12H3"/><path d="M16 19H3"/><path d="M18 9v6"/><path d="M21 12h-6"/></svg>')
                    .off().click(function() {submit()}).appendTo(this);
                    $(this).addClass('selected');
                })
                .appendTo('#trackList');
                
        });
    }

    function formatArtists(a) {
        var s = '';
        a.forEach(e => {s += ', ' + e.name;});
        return s.substr(2);
    }

    function submit() {
        $song = $('#trackList .selected');
        if ($song['length'] == 0) return;
        
        document.getElementById('title').value = $song.data('title');
        document.getElementById('artists').value = $song.data('artists');
        document.getElementById('cover_url').value = $song.data('cover_url');
        document.getElementById('cover_big_url').value = $song.data('cover_big_url');
        document.getElementById('duration_ms').value = $song.data('duration_ms');
        document.getElementById('spotify_id').value = $song.data('spotify_id');
        document.getElementById('saveForm').submit();
    }
</script>