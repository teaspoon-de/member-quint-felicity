<section id="saveBar" class="unselectable">
    <p id="cancle">Abbrechen</p>
    <p id="save">Speichern</p>
</section>
<script>
    var backTo = "<?= $backURI ?>";
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