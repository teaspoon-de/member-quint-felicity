<?php
$title = "Events";
$add = null;
require __DIR__ . "/../layout/topIndex.php"
?>

<link rel="stylesheet" href="/css/events.css">

<section id="calendar">
    <h2>Auftritte in Kalender einbinden</h2>
    <p>In den meisten Kalendern gibt es irgendwo eine Funktion "Kalender abonnieren", bei der man über eine URL automatisch Termine eintragen kann. Um die Auftritte automatisch in einem externen Kalender synchronisieren zu lassen, also da einfach folgenden Link reinkopieren:</p>
    <div class="copy-field">
        <input
            type="text"
            id="calendarLink"
            value="https://member.quint-felicity.de/calendar/qf.ics?token=<?= getenv('ICS_TOKEN')?>"
            readonly
        >
        <button type="button" id="copyBtn" aria-label="Link kopieren">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-copy-icon lucide-copy"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
        </button>
    </div>

    <small id="copyHint" class="null">Link kopiert!</small>
</section>


<script>
document.getElementById('copyBtn').addEventListener('click', async () => {
    const input = document.getElementById('calendarLink');
    const hint = document.getElementById('copyHint');

    try {
        await navigator.clipboard.writeText(input.value);

        hint.classList.remove('null');
        $('.copy-field button').css('background-color', 'var(--green)');
    } catch (err) {
        // Fallback
        input.select();
        document.execCommand('copy');
        hint.classList.remove('null');
        $('.copy-field button').css('background-color', 'var(--green)');
    }
});
</script>
