<h1>Song hinzufügen</h1>

<input oninput="search(this.value)" placeholder="Spotify Suche…">

<ul id="results"></ul>

<form id="saveForm" action="/songs/add" method="POST">
    <input type="hidden" id="title" name="title">
    <input type="hidden" id="artists" name="artists">
    <input type="hidden" id="spotify_id" name="spotify_id">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
</form>


<p><a href="/songs">Abbrechen</a></p>

<script>
async function search(q) {
  const res = await fetch('/api/spotify_search.php?q=' + encodeURIComponent(q));
  const data = await res.json();

  const results = document.getElementById("results");
  results.innerHTML = "";

  data.tracks.items.forEach(track => {
    const li = document.createElement("li");
// TODO Render Artists, Rate Limit
    li.innerHTML = `
      <img src="${track.album.images[2].url}">
      ${track.name} – ${track.artists[0].name}: ${track.duration_ms}
      <button onclick="selectTrack('${track.name}', '${track.artists[0].name}', '${track.album.images[0].url}', '${track.duration_ms}', '${track.id}', )">
        übernehmen
      </button>
    `;

    results.appendChild(li);
  });
}

function selectTrack(name, artists, id) {
  document.getElementById('title').value = name;
  document.getElementById('artists').value = artists;
  document.getElementById('spotify_id').value = id;
  document.getElementById('saveForm').submit();
}

</script>