<link rel="stylesheet" href="/css/top.css">
<section id="top" class="unselectable">
    <svg class="user" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-cog-icon lucide-user-cog"><path d="M10 15H6a4 4 0 0 0-4 4v2"/><path d="m14.305 16.53.923-.382"/><path d="m15.228 13.852-.923-.383"/><path d="m16.852 12.228-.383-.923"/><path d="m16.852 17.772-.383.924"/><path d="m19.148 12.228.383-.923"/><path d="m19.53 18.696-.382-.924"/><path d="m20.772 13.852.924-.383"/><path d="m20.772 16.148.924.383"/><circle cx="18" cy="15" r="3"/><circle cx="9" cy="7" r="4"/></svg>
    <h1 class="titleBig"><?= $title?></h1>
    <h2 class="page">Quint Felicity</h2>
    <svg id="add" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
</section>

<script>
    if (window.location.pathname == "/members") {
        $(".user").css("opacity", "0");
    }

    $(".user").each(function() {
        $(this).off().click(function() {
            window.location.assign("/members");
        })
    });
    $("#add").each(function() {
        $(this).off().click(function() {
            window.location.assign(window.location.pathname + "/<?= $add?>");
        })
    });
</script>