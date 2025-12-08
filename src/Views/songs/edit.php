<?php
$backURI = "/songs/".$song['id'];
require __DIR__ . "/../layout/topBarEdit.php";
?>

<link rel="stylesheet" href="/css/trackEdit.css">
<section id="track">
    <div class="info unselectable">
        <h1><?= htmlspecialchars($song['title'] ?? '') ?></h1>
        <p><?= htmlspecialchars($song['artists'] ?? '') ?></p>
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
    <div id="statusAmpel" class="unselectable">
        <p>Wie gut läuft der Song?</p>
        <div class="ampel">
            <span <?= $song['status']==="red"? 'style="background-color: var(--red);"': '' ?>></span>
            <span <?= $song['status']==="orange"? 'style="background-color: var(--orange);"': '' ?>></span>
            <span <?= $song['status']==="green"? 'style="background-color: var(--green);"': '' ?>></span>
        </div>
    </div>
    <h2 class="unselectable">Notizen (für alle sichtbar)</h2>
    <div class="notes" id="global">
        <textarea placeholder="Killer Song, schwöre baba ..."><?= htmlspecialchars($song['notes'] ?? '') ?></textarea>
    </div>
</section>

<form id="saveForm" action="/songs/<?= $song['id'] ?>/edit" method="POST">
    <input type="hidden" id="original_key_maj" name="original_key_maj">
    <input type="hidden" id="is_major" name="is_major">
    <input type="hidden" id="transposed_by" name="transposed_by">
    <input type="hidden" id="status" name="status">
    <input type="hidden" id="notes" name="notes">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
</form>

<script>

    var by = <?= htmlspecialchars($song['transposed_by'] ?? '0') ?>;
    var or_key = <?= htmlspecialchars($song['original_key_maj'] ?? '-1') ?>;
    var key = "<?= htmlspecialchars($song['original_key_maj'] ?? '') ?>";
    var dur = <?= $song['is_major']?? -1 ?>;
    dur = dur==-1? null: dur!=0;
    

    function mod(a, b) {
        x = a;
        i = Math.abs(x) % (b);
        if (x < 0) i = b-i;
        return i;
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

    var possibleMaj = ["C", "Db", "D", "Eb", "E", "F",
        "F#", "G", "Ab", "A", "Bb", "B"];
    var possibleMin = ["A", "Bb", "B", "C", "C#", "D",
    "D#", "E", "F", "F#", "G", "G#"];
    var keyAlias = ["Gb", "A#", "Cb", "B#", "Fb", "E#"];
    var keyAlias2 = ["F#", "Bb", "B", "C", "E", "F"];

    updateKeySection();
    function updateKeySection() {
        $(".by").val(by > 0? "+" + by: by);
        if (or_key < 0 || or_key > 11) {
            keyUnset();
            return;
        }
        var i = mod(or_key + by, possibleMaj.length)
        $("#maj").val(possibleMaj[i]);
        $("#min").val(possibleMin[i]);
    }
    function keyUnset() {
        by = 0;
        or_key = -1;
        $(".by").val(0);
        $("#maj").val("");
        $("#min").val("");
    }

    $("#minus").click(()=>{
        by = mod(by + 5, 12)-6;
        updateKeySection();
    });
    $("#plus").click(()=>{
        by = mod(by + 7, 12)-6;
        updateKeySection();
    });

    function recreateOrKey() {
        var val = $("#maj").val();
        if (!contains(possibleMaj, val)) return;
        or_key = mod(comp(val, possibleMaj)-by, possibleMaj.length);
        console.log("recreateOrKey1: "+or_key);
        console.log("recreateOrKey2: "+val);
        
    }

    function onBy() {
        q = ".by";
        if ($(q).val() == "") return;
        if (!($(q).val().substring(0,1)=="0" || $(q).val().substring(1)=="0") && $(q).val().substring(0,1)!="-" && $(q).val().substring(0,1).toLowerCase()!="+") {
            $(q).val("+" + $(q).val().substring(0,1));
        }
        var x = parseInt($(q).val())
        if (!isNaN(x) && x >= -6 && x <= 5) {
            by = x;
            recreateOrKey();
        }
    }

    function contains(array, element) {
        for (var i = 0; i < array.length; i++) {
            if (array[i] == element) return true;
        }
        return false;
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
            recreateOrKey();
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
    });
    $("#moll").click(function() {
        dur = $(this).hasClass("selected")? null: false;
        updateTonart();
    });

    var statusArray = ["red", "orange", "green"];
    var status = '<?= $song['status']?>';
    var statusIndex = getStatusIndex();
    console.log(status);
    function getStatusIndex() {
        for (var i = 0; i < 3; i++) if (statusArray[i] == status) return i;
    }
    function updateAmpel() {
        statusIndex = (statusIndex +1) %3;
        status = statusArray[statusIndex];
        $("#statusAmpel span").each(function(index) {
            if (index == statusIndex) $(this).css("background-color", "var(--" + status + ")");
            else $(this).css("background-color", "var(--cbgc)");
        });
        console.log(status);
        
    }
    $("#statusAmpel").click(function() {
        updateAmpel();
    });

    async function submit() {
        console.log("Key: " + or_key);
        console.log("Dur: " + (dur == null ? "null": (dur? 1: 0)));
        console.log("tb: " + by);
        document.getElementById('original_key_maj').value = or_key;
        document.getElementById('is_major').value = dur == null ? "null": (dur? 1: 0);
        document.getElementById('transposed_by').value = by;
        document.getElementById('status').value = status;
        document.getElementById('notes').value = $("#global textarea").val();
        document.getElementById('saveForm').submit();
    }
</script>