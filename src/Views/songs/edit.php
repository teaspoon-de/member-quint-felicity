<section id="saveBar" class="unselectable">
    <p id="cancle">Abbrechen</p>
    <p id="save">Speichern</p>
</section>
<script>
    var backTo = "<!--backUri-->";
    $("#cancle").click(()=>{
        window.location.assign(backTo!="null"? backTo: getLastSite());
    });
    $("#save").click(()=>{
        submit();
    });

    function getLastSite() {
        var path = window.location.pathname;
        if (path.substring(path.length-1) == "/")
            path = path.substring(0, path.length-1);
        var pathSplit = path.split("/");
        return path.substring(0,path.length - pathSplit[pathSplit.length-1].length);
    }
</script>

<p><a href="/songs/<?= $song['id'] ?>">Abbrechen</a></p>

<link rel="stylesheet" href="/css/trackEdit.css">
<section id="track">
    <div class="info unselectable">
        <h1><?= htmlspecialchars($song['title'] ?? '') ?></h1>
        <h3><?= htmlspecialchars($song['artists'] ?? '') ?></h3>
    </div>
    <div id="warn" class="unselectable">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-traffic-cone-icon lucide-traffic-cone"><path d="M16.05 10.966a5 2.5 0 0 1-8.1 0"/><path d="m16.923 14.049 4.48 2.04a1 1 0 0 1 .001 1.831l-8.574 3.9a2 2 0 0 1-1.66 0l-8.574-3.91a1 1 0 0 1 0-1.83l4.484-2.04"/><path d="M16.949 14.14a5 2.5 0 1 1-9.9 0L10.063 3.5a2 2 0 0 1 3.874 0z"/><path d="M9.194 6.57a5 2.5 0 0 0 5.61 0"/></svg>
        <p>Übungsbedarf</p>
        <input type="checkbox">
        <span class="slider"></span>
    </div>
    <h2 class="unselectable">Transponieren</h2>
    <div class="transpose">
        <div class="tr unselectable" id="minus">-</div>
        <div class="input">
            <input type="text" class="by" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13)? null: (event.charCode >= 48 && event.charCode <= 54) || event.charCode == 43 || event.charCode == 45" maxlength="2" onkeyup="onBy()">
            <div id="key">
                <input type="text" id="maj" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13)? null: (event.charCode >= 65 && event.charCode <= 72) || (event.charCode >= 97 && event.charCode <= 104) || event.charCode == 35" maxlength="2" onkeyup="onMaj(true)">
                <p>/</p>
                <input type="text" id="min" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13)? null: (event.charCode >= 65 && event.charCode <= 72) || (event.charCode >= 97 && event.charCode <= 104) || event.charCode == 35" maxlength="2" onkeyup="onMaj(false)">
                <p>m</p>
            </div>
        </div>
        <div class="tr unselectable" id="plus">+</div>
    </div>
    <h2 class="unselectable">Tonart</h2>
    <div id="tonart" class="unselectable">
        <p id="dur">Dur</p>
        <p id="moll">Moll</p>
    </div>
    <h2 class="unselectable">Notizen (für alle sichtbar)</h2>
    <div class="notes" id="global">
        <textarea placeholder="Killer Song, schwöre baba ..."><?= htmlspecialchars($song['notes'] ?? '') ?></textarea>
    </div>
</section>

<form id="saveForm" action="/songs/<?= $song['id'] ?>/edit" method="POST">
    <input type="hidden" id="original_key" name="original_key">
    <input type="hidden" id="transposed_by" name="transposed_by">
    <input type="hidden" id="status" name="status">
    <input type="hidden" id="notes" name="notes">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
</form>

<script src="request.js"></script>
<script>

    var by = "<?= htmlspecialchars($song['transposed_by'] ?? '') ?>"
    $(".by").val(by);
    function onBy() {
        q = ".by";
        if ($(q).val() == "") return;
        if ($(q).val().substring(0,1)=="0" || $(q).val().substring(1)=="0") {
            $(q).val("0");
            by = "0";
            return;
        }
        if ($(q).val().substring(0,1)!="-" && $(q).val().substring(0,1).toLowerCase()!="+") {
            $(q).val("+" + $(q).val().substring(0,1));
        }
        if ($(q).val().length == 2) by = $(q).val();
    }

    var key = "<?= htmlspecialchars($song['original_key'] ?? '') ?>";
    function buildKey() {
        var m = $("#maj").val();
        var n = $("#min").val();
        var mp = dur != null && dur? "*": "";
        var np = dur != null && !dur? "*": "";
        if (contains(possibleMaj, m) && contains(possibleMin, n)) {
            key = mp + m + "/" + np + n + "m";
        }
    }
    function contains(array, element) {
        for (var i = 0; i < array.length; i++) {
            if (array[i] == element) return true;
        }
        return false;
    }
    var possibleMaj = ["C", "Db", "D", "Eb", "E", "F",
        "F#", "G", "Ab", "A", "Bb", "B"];
    var possibleMin = ["A", "Bb", "B", "C", "C#", "D",
    "D#", "E", "F", "F#", "G", "G#"];
    var possibleBy = ["-6", "-5", "-4", "-3", "-2", "-1", "0", "+1", "+2", "+3", "+4", "+5", "+6"];
    var keyAlias = ["Gb", "A#"];
    var keyAlias2 = ["F#", "Bb"];
    updateKeys();
    function updateKeys() {
        var keySplit = key.replace("*", "").replace("m", "").split("/");
        var keyMaj = keySplit.length == 1? "": keySplit[0];
        var keyMin = keySplit.length == 1? "": keySplit[1];
        $("#maj").val(keyMaj);
        $("#min").val(keyMin);
    }
    function onMaj(maj) {
        a = maj? possibleMaj: possibleMin;
        b = !maj? possibleMaj: possibleMin;
        q = maj? "#maj": "#min";
        q2 = !maj? "#maj": "#min";
        if ($(q).val().substring(0,1)=="#") {
            $(q).val($(q).val().substring(1));
        }
        if ($(q).val().substring(1)!="#" && $(q).val().substring(1).toLowerCase()!="b") {
            $(q).val($(q).val().substring(0,1));
        }
        i = comp($(q).val(), a);
        succ = i!=null;
        if (succ) {
            $(q).val(a[i]);
            $(q2).val(b[i]);
            buildKey();
            return;
        }
        i = comp($(q).val(), b);
        succ = i!=null;
        if (succ) {
            $(q).val(a[maj? i-3: i+3]);
            onMaj(maj);
            return;
        }
        i = comp($(q).val(), keyAlias);
        succ = i!=null;
        if (succ) {
            $(q).val(keyAlias2[i]);
            onMaj(maj);
            return;
        }
    }
    function comp(qu, arr) {
        for (var i = 0; i < arr.length; i++) {
            var element = arr[i];
            if (qu.toLowerCase() == element.toLowerCase()) {
                return i;
            } 
        }
        return null;
    }

    $("#minus").click(()=>{
        transpose(false);
    });
    $("#plus").click(()=>{
        transpose(true);
    });
    function transpose(up) {
        var keySplit = key.replace("*", "").replace("m", "").split("/");
        x = -1;
        if (up) x *= x;
        i = (comp(by, possibleBy) + x) % (possibleBy.length-1);
        $(".by").val(possibleBy[i==-1?11:i]);
        j = (comp(keySplit[0], possibleMaj) + x) % possibleMaj.length; 
        $("#maj").val(possibleMaj[j==-1?possibleMaj.length-1:j]);
        $("#min").val(possibleMin[j==-1?possibleMin.length-1:j]);
        by = $(".by").val();
        buildKey();
    }

    var inWork = "<!--inWork-->"=="true";
    updateInWork();
    function updateInWork() {
        $("#warn input").prop("checked", inWork);
        $("#warn").css("background-color", inWork? "var(--inWorkc)": "var(--cbgc)");
    }
    $("#warn").click(function() {
        inWork = !inWork;
        updateInWork();
    });


    var dur = key.split("/")[0].substring(0,1) == "*";
    
    if (!dur && (key.split("/").length == 1 || key.split("/")[1].substring(0,1) != "*")) dur = null;
    updateTonart();
    function updateTonart() {
        if (dur == null) {
            $("#dur").removeClass("selected");
            $("#moll").removeClass("selected");
            return;
        }
        if (dur) {
            $("#dur").addClass("selected");
            $("#moll").removeClass("selected");
        } else {
            $("#dur").removeClass("selected");
            $("#moll").addClass("selected");
        }
    }
    $("#dur").click(function() {
        dur = $(this).hasClass("selected")? null: true;
        updateTonart();
        buildKey();
    });
    $("#moll").click(function() {
        dur = $(this).hasClass("selected")? null: false;
        updateTonart();
        buildKey();
    });

    async function submit() {
        document.getElementById('original_key').value = key;
        document.getElementById('transposed_by').value = by;
        document.getElementById('status').value = "green";
        document.getElementById('notes').value = $("#global textarea").val();
        document.getElementById('saveForm').submit();
    }
</script>