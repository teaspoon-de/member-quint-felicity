<link rel="stylesheet" href="/css/search.css">
<section id="search">
    <div class="stats">
        <p id="count"></p>
        <p id="duration"></p>
    </div>
    <div class="search">
        <svg class="goggle" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" placeholder="<?= $placeHolder?>" onkeyup="<?= $searchMethod ?? 'suche()'?>">
    </div>
</section>
<section id="filter" class="unselectable">
    <p id="filterNotInWork">Sicher</p>
    <p id="filterInWork">Unsicher</p>
</section>
<script>
    var forTracks = <?= $forTracks ?>;
    if (!forTracks) {
        $("#filter").css("display", "none")
        $(".stats").css("display", "none");
        $("#search").css("padding-bottom", "20px");
    }
    function songCount() {
        var count = 0;
        var dur = 0;
        $("song").each(function(index) {
            if ($(this).css("display") != "none") {
                count++;
                dur += $(this).data("duration");
            }
        });
        $("#count").text(formatCount(count));
        $("#duration").text(whatTimeIsIt(dur));

        function formatCount(c) {
            return c + (c==1? " Lied": " Lieder");
        }
        function whatTimeIsIt(ms) {
            ms = Math.floor(ms / 1000);
            var min = Math.floor(ms / 60);
            if (min <= 0) return "0 Min.";
            var std = Math.floor(min / 60);
            min %= 60;
            var time = min + " Min.";
            if (std > 0) time = std + " Std. " + time;
            return time;
        }
    }

    $("#filterNotInWork").click(function() {
        if ($(this).hasClass("selected")) {
            $(this).removeClass("selected");
        } else {
            $(this).addClass("selected");
            if ($("#filterInWork").hasClass("selected")) $("#filterInWork").removeClass("selected");
        }
        updateElements();
    });

    $("#filterInWork").click(function() {
        if ($(this).hasClass("selected")) {
            $(this).removeClass("selected");
        } else {
            $(this).addClass("selected");
            if ($("#filterNotInWork").hasClass("selected")) $("#filterNotInWork").removeClass("selected");
        }
        updateElements();
    });

    function suche() { //TODO scroll buggt hoch und runter
        $("html, body").scrollTop($("#search").offset().top);
        //window.location.assign("#search");
        //$(".search  input").focus();
        updateElements();
    }    

    function updateElements() {
        onSearchUpdate($(".search input").val().toLowerCase());
        songCount();
    }
</script>