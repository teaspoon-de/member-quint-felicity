<section id="topbar" class="unselectable">
    <svg <?php if (!$backToActive) echo 'style="display: none;"' ?> id="back" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>
    <p><?= $backToString?></p>
    <svg class="editIcon" data-link="edit/" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
    <!--svg style="display: none;" class="editIcon" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg-->
    <svg style="display: none;" class="editIcon" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-check-big-icon lucide-square-check-big"><path d="M21 10.656V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.344"/><path d="m9 11 3 3L22 4"/></svg>

</section>
<script><?php
    if ($backToActive) echo
    'var backToURI = "'.$backToURI.'";
    $("#back").click(()=> {
        back();
    });
    $("#topbar p").click(()=> {
        back();
    });

    function back() {
        window.location.assign(backToURI!="null"? backToURI: getLastSite());
    }'?>

    $(".editIcon").each(function() {
        $(this).off().click(function() {
            //window.location.assign($(this).data("link"));
            onEdit();
        })
    });

    function getLastSite() {
        var path = window.location.pathname;
        if (path.substring(path.length-1) == "/")
            path = path.substring(0, path.length-1);
        var pathSplit = path.split("/");
        return path.substring(0,path.length - pathSplit[pathSplit.length-1].length);
    }
</script>
