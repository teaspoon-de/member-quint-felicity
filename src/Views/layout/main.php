<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Band App</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
<header>
    <h1>Band App</h1>
    <nav>
        <a href="/songs">Songs</a>
    </nav>
    <nav>
        <a href="/members">Band Mitglieder</a>
    </nav>
    <nav>
        <a href="/account">Konto</a>
    </nav>
</header>

<main>
    <?= $content ?>
</main>

<section id="menu">
    <menu id="mhome" data-link="/repertoire">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-library-icon lucide-library"><path d="m16 6 4 14"/><path d="M12 6v14"/><path d="M8 8v12"/><path d="M4 4v16"/></svg>
        <h1 class="unselectable">Repertoire</h1>
    </menu>
    <!--<menu id="mvor" data-link="/">
        <svg class="vorschlaege" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles-icon lucide-sparkles"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/></svg>
        <h1 class="unselectable">Vorschläge</h1>
    </menu>-->
    <menu id="msetlists" data-link="/setlists">
        <svg id="setlists" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-copy"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
        <h1 class="unselectable">Setlists</h1>
    </menu>
</section>
<script>
    $("menu").click(function() {
        window.location.assign(getLink($(this).data("link")));
    });

    function getLink(link) {
        var bandId = window.location.pathname.substring(1).split("/")[1];
        return "/bands/" + bandId + link;
    }
</script>

</body>
</html>
