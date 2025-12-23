<?php
$backURI = "/blog";
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/blog.css">
<link rel="stylesheet" href="/css/edit.css">
<section class="section edit">
    <form id="createForm" action="/blog/<?= $blogpost['id'] ?>/edit" method="post">
        <div id="changeCover" class="editContextButton">
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

        <div id="changeContent" class="editContextButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
            <p>Inhalt bearbeiten</p>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-initial-icon lucide-text-initial"><path d="M15 5h6"/><path d="M15 12h6"/><path d="M3 19h18"/><path d="m3 12 3.553-7.724a.5.5 0 0 1 .894 0L11 12"/><path d="M3.92 10h6.16"/></svg>
            <input
                type="hidden"
                id="content"
                name="content"
                value="<?= htmlspecialchars($blogpost['content'] ?? '') ?>"
                required
            >
        </div>

        <!--div class="inLong">
            <h3>Inhalt</h3>
            <textarea id="contentTa" placeholder="Lass richtig abgehen woop woop ..."><?= htmlspecialchars($blogpost['content'] ?? '') ?></textarea>
            <input type="hidden" id="content" name="content">
        </div-->
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        <button type="submit" class="null"></button>
    </form>
</section>

<section id="contentEdit" style="display: none;">
    <div class="paragraph">
        <article class="textarea" role="textbox" contenteditable><div>Hier Text bearbeiten ...</div></article>
    </div>
    <div id="contentNewPar" class="paragraph" style="display: none;">
        <h3 role="textbox" onkeyup="checkEmpty()" contenteditable>Überschrift</h3>
        <article role="textbox" onkeyup="checkEmpty()" contenteditable>Text</article>
    </div>
    <div id="contentAddPar" class="editContextButton">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        <p>Abschnitt hinzufügen</p>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heading2-icon lucide-heading-2"><path d="M4 12h8"/><path d="M4 18V6"/><path d="M12 18V6"/><path d="M21 18h-4c0-4 4-3 4-6 0-1.5-2-2.5-4-1"/></svg>
    </div>
</section>

<script>
    iniContent();
    function iniContent() {
        if ($('#content').val() == '') return;
        var iniCont = $('<div>' + $('#content').val() + '</div>');
        var pArray = getArray(iniCont, 'article');
        var hArray = getArray(iniCont, 'h2');
        $('#contentEdit .paragraph:first-child article').html(changeTags(pArray[0], 'p', 'div'));
        for (var i = 0; i < hArray.length; i++) {
            var e = getNewParagraph();
            e.find('h3').html(hArray[i].html());
            e.find('article').html(changeTags(pArray[i+1], 'p', 'div'));
        }
    }
    function getArray(v, q) {
        var a = new Array();
        v.find(q).each(function() {a.push($(this))});
        return a;
    }
    function changeTags(article, old, ne) {
        var divs = getArray(article, old);
        if (divs.length == 0) return article.html();
        var art = $('<div></div>');
        for (var i = 0; i < divs.length; i++)
            art.append('<'+ne+'>'+ divs[i].html() +'</'+ne+'>');
        if (article.html().substring(0, old.length+2) != '<'+old+'>') {
            return '<'+ne+'>'+ article.html().split('<'+old+'>')[0] +'</'+ne+'>' + art.html();
        }
        return art.html();
    }

    $('#changeContent').off().click(function() {
        $('#contentEdit .errorMessage').each(function() {$(this).remove()});
        $('#contentEdit .paragraph').each(function() {$(this).removeClass('error')});
        $('#contentEdit').css('display', 'block');
        $('#cancel').off().click(function() {
            $('#contentEdit').css('display', 'none');
            defaultTopBar();
        });
        $("#save").off().click(()=>{
            var content = '';
            if ($('#contentEdit .paragraph').first().text().trim() == '') {
                $('#contentEdit .paragraph').first().addClass('error').append('<p class="errorMessage">Die Einleitung darf nicht leer sein</p>');
                return;
            }
            $('#contentEdit .paragraph').each(function(index) {
                if ($(this).attr('id') == 'contentNewPar') return;
                if (index != 0) content += '<h2>' + $(this).find('h3').html() + '</h2>';
                content += '<article>' + changeTags($(this).find('article'), 'div', 'p') + '</article>';
            });
            $('#content').val(content);
            $('#contentEdit').css('display', 'none');
            defaultTopBar();            
        });
        function defaultTopBar() {
            $("#cancel").off().click(()=>{window.location.assign('/blog');});
            $("#save").off().click(()=>{submit();});
        }
    });

    $('#contentAddPar').off().click(function() {
        getNewParagraph();
    });
    function getNewParagraph() {
        return $('#contentNewPar').clone().attr('id', '').attr('style', '').insertBefore('#contentAddPar');
    }

    function checkEmpty() {
        $('#contentEdit .paragraph').each(function(index) {
            if ($(this).attr('id') != 'contentNewPar' && $(this).find('article').html() == '<br>' && $(this).find('h3').html() == '<br>') $(this).remove();
        });
    }
</script>

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
        if ($('#content').val().trim() == "") {
            $('#content').addClass("error");
            $('<p class="errorMessage">Bitte füge einen Inhalt hinzu</p>').insertAfter($('#changeContent'));
            return;
        }
        if (inputIsEmpty("#title")) return;
        if (inputIsEmpty("#date")) return;

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