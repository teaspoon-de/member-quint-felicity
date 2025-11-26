<?php
$backToActive = true;
$backToString = "Events";
$backToURI = "/events";
require __DIR__ . "/../layout/topBar.php"
?>

<?php
$title = $event["title"];
$page = "Auftritt";
require __DIR__ . "/../layout/topMenu.php"
?>

<link rel="stylesheet" href="/css/events.css">

<section id="registrations" class="section">
    <div class="container">
        <div class="kvRow">
            <div>
                <value>20.03.26</value>
                <p>Datum</p>
            </div>
            <div>
                <value>20:00</value>
                <p>Uhrzeit</p>
            </div>
        </div>
        <div id="regArea">
            <input type="checkbox" id="regYesI">
            <div class="option" id="regYes">
                <svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-thumbs-up-icon lucide-thumbs-up"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z"/></svg>
            </div>
            <input type="checkbox" id="regMaybeI">
            <div class="option" id="regMaybe">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-question-mark-icon lucide-circle-question-mark"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
            </div>
            <input type="checkbox" id="regNoI">
            <div class="option" id="regNo">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-thumbs-down-icon lucide-thumbs-down"><path d="M17 14V2"/><path d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z"/></svg>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock-icon lucide-lock"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <svg style="display: none;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock-keyhole-open-icon lucide-lock-keyhole-open"><circle cx="12" cy="16" r="1"/><rect width="18" height="12" x="3" y="10" rx="2"/><path d="M7 10V7a5 5 0 0 1 9.33-2.5"/></svg>
            </div>
        </div>
        <li>
            <ul>
                <svg class="regMaybe" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-question-mark-icon lucide-circle-question-mark"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                <div>
                    <h4>Ceddy</h4>
                    <p>Muss gucken wie Mond steht ...</p>
                </div>
            </ul>
            <ul>
                <svg class="regMaybe" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-question-mark-icon lucide-circle-question-mark"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                <div>
                    <h4>Manu</h4>
                </div>
            </ul>
            <ul>
                <svg class="regMaybe" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-thumbs-down-icon lucide-thumbs-down"><path d="M17 14V2"/><path d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22a3.13 3.13 0 0 1-3-3.88Z"/></svg>
                <div>
                    <h4>Kjell</h4>
                    <p>Schlagzeug in Usbekistan, verraten von Amerika, durch den Dschungel im Kongo, Bäume rauf und runter, erklomm ich die Berge deiner Mama ...</p>
                </div>
            </ul>
        </li>
    </div>
</section>

<section id="infos" class="section">
    <h3>Infos</h3>
    <div class="container">
        <div class="kvRow">
            <div>
                <value>19:30</value>
                <p>Einlass</p>
            </div>
            <div>
                <value>2,5h</value>
                <p>Setlänge</p>
            </div>
            <div>
                <value>300€</value>
                <p>Gage</p>
            </div>
        </div>
        <div class="kvLong">
            <value>Jungs bei dem Auftritt wird richtig abgerissen schwöre. Müssen da richtig einen raushauen sonst knallts. Also muss eben bei uns knallen so. Checkt nicht jeder weißt.So ist so nicht jedermans dings. Ein Pferd.</value>
        </div>
    </div>
</section>

<section id="setlist" class="section">
    <h3>Setlist</h3>
    <div class="container">
    </div>
</section>