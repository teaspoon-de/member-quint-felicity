<?php
$backURI = "/blog";
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/blog.css">
<link rel="stylesheet" href="/css/edit.css">
<section class="section edit">
    <form id="createForm" action="/blog/<?= $blogpost['id'] ?>/edit" method="post">
        <div id=changeCover>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
            <p>Cover ändern</p>
            <img src="/resources/uploads/<?=$blogpost['cover_uri']?>">
            <input
                type="hidden"
                id="cover_id"
                name="cover_id"
                value="<?= htmlspecialchars($blogpost['cover_id'] ?? '') ?>"
                required
            >
        </div>

        <div class="inLong">
            <h3>Titel</h3>
            <input
                type="text" 
                id="title" 
                name="title" 
                value="<?= htmlspecialchars($blogpost['title'] ?? '') ?>"
                required
            >
        </div>

        <div class="inLong">
            <h3>Angezeigtes Datum</h3>
            <input 
                type="date"
                id="date"
                name="date"
                value="<?php 
                        $date = new DateTime($blogpost["date"]);
                        echo $date->format('Y-m-d');
                    ?>"
                required
            >
        </div>

        <div class="checkBox">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe-icon lucide-globe"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
            <p>Veröffentlichen</p>
            <input
                type="checkbox"
                id="publish"
                name="publish"
            >
            <span class="slider"></span>
        </div>

        <div class="inLong">
            <h3>Inhalt</h3>
            <textarea id="contentTa" placeholder="Lass richtig abgehen woop woop ..."><?= htmlspecialchars($blogpost['content'] ?? '') ?></textarea>
            <input type="hidden" id="content" name="content">
        </div>
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        <button type="submit" class="null"></button>
    </form>
</section>

<section id="imageSelect">
    <p>Such Dir ein Cover aus:</p>
    <div id="imageList"></div>    
</section>

<script>
    $("#publish").prop("checked", <?=$blogpost['publish'] === 1? 'true': 'false'?>);
    
    $('.checkBox').each(function() {$(this).off().click(function() {
        var cb = $(this).find('input[type=checkbox]');
        cb.prop('checked', !cb.prop('checked'));
    });});

    var imagesInitialized = false;
    $('#changeCover').off().click(async function() {
        if (!imagesInitialized) {
            const res = await fetch('/blog/images/select');
            const data = await res.json();
            data.forEach(image => {
                $('<img src="/resources/uploads/' + image.uri + '">')
                    .data('id', image.id)
                    .off().click(function() {
                        $('#imageSelect').css('display', 'none');
                        $('#changeCover img').attr('src', $(this).attr('src'));
                        $('#changeCover input').val($(this).data('id'));
                    })
                    .appendTo('#imageList');
            });
            imagesInitialized = true;
        }
        $('#imageSelect').css('display', 'block');
    });

    async function submit() {
        clearErrors();
        if (inputIsEmpty("#title")) return;
        if (inputIsEmpty("#date")) return;

        document.getElementById("content").value = document.getElementById("contentTa").value;
        document.getElementById('createForm').submit();
    }

    function inputIsEmpty(query) {
        var b = !$(query).val() || $(query).val().trim() == "";
        if (b) inputError(query, "Feld darf nicht leer sein.");
        return b;
    }

    function clearErrors() {
        $("input").each(function() {
            $(this).removeClass("error");
        });
        $(".errorMessage").each(function() {
            $(this).remove();
        });
    }

    function inputError(query, message) {
        $(query).addClass("error");
        $('<p class="errorMessage">' + message + '</p>').insertAfter($(query).parent());
    }
</script>