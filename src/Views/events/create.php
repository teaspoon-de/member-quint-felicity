<?php
$backURI = "/events";
require __DIR__ . "/../layout/topBarEdit.php";
?>

<form style="margin-top: 100px;" id="createForm" action="/events/create" method="post">
    <p>
        <label for="title">Titel</label><br>
        <input type="text" id="title" name="title" required>
    </p>
<!--Irgendwie type auswählen später (Probe und so)-->
    <p>
        <label for="date_begin">Datum</label><br>
        <input type="datetime-local" id="date_begin" name="date_begin">
    </p>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
</form>

<p><a href="/songs">Abbrechen</a></p>

<script>
    async function submit() {
        document.getElementById('createForm').submit();
    }
</script>