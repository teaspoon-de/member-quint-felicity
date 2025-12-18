<?php
$title = "Bilder";
$add = null;
require __DIR__ . "/../layout/topIndex.php"
?>

<?php
$placeHolder = "Bild suchen";
$forTracks = false;
$searchMethod = null;
require __DIR__ . "/../layout/search.php"
?>

<link rel="stylesheet" href="/css/blog.css">
<link rel="stylesheet" href="/css/edit.css">

<form id="fileUploadForm" action="/blog/images/create" method="POST" enctype="multipart/form-data">
    <label for="file-upload" class="custom-file-upload">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload"><path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
        <p>Bild hinzufügen</p>
    </label>
    <span id="file-selected">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-icon lucide-image"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
        <p></p>
    </span>
    <input id="file-upload" type="file" name="bild" accept="image/*"/>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <button type="submit">Hochladen</button>
</form>

<script>
    $('#file-upload').bind('change', function() {
        var fileName = '';
        fileName = $(this).val();
        $('#fileUploadForm label p').html('anderes Bild auswählen');
        $('#file-selected p').html(fileName);
        $('#fileUploadForm').addClass('fileUploadForm');
        $('#file-selected').css('display', 'flex');
        $('#fileUploadForm button').css('display', 'flex');
    });
</script>

<section id="imageList">
    <?php
    $imgs = [];
    foreach ($images as $img) {
        $key = substr($img['taken_at'], 0, 7);
        $imgs[$key][] = $img;
    }
    foreach ($imgs as $imgsi): ?>
        <h2><?php
            $date = new DateTime($imgsi[0]["taken_at"]);
            $months = [
                1 => 'Januar',
                2 => 'Februar',
                3 => 'März',
                4 => 'April',
                5 => 'Mai',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'August',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Dezember',
            ];
            echo $months[(int)$date->format('n')] . ' ' . $date->format('Y');
        ?></h2>
        <div class="imageList"><?php foreach($imgsi as $image): ?>
            <img src="<?= '/resources/uploads/'.htmlspecialchars($image['uri'] ?? '')?>" alt="<?= htmlspecialchars($image['alt'] ?? '')?>" data-title="<?= htmlspecialchars($image['title'] ?? '')?>" data-link="<?= $image['id']?>">
        <?php endforeach; ?></div>
    <?php endforeach; ?>
</section>
<script>

    $("#imageList img").each(function(index) {
        $(this).click(function() {
            window.location.assign("images/" + $(this).data("link"));
        });
    });

    function onSearchUpdate(query) {
        $("#imageList img").each(function(index) {
            if (query != "" && !$(this).text().toLowerCase().includes(query) && !$(this).attr("alt").toLowerCase().includes(query) && !$(this).data("title").toLowerCase().includes(query)) {
                $(this).css("display", "none");
            } else if ($(this).css("display") == "none") $(this).css("display", "flex");
        });
    }
</script>