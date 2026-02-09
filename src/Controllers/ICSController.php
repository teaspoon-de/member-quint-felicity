<?php

class ICSController {

    public static function bandCalendar() {
        // --- Zugriffsschutz (Token) ---
        /*$token = getenv('ICS_TOKEN');
        if (!isset($_GET['token']) || $_GET['token'] !== $token) {
            http_response_code(403);
            exit('Forbidden');
        }*/

        // --- Header ---
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: inline; filename="qf-veranstaltungskalender.ics"');
        header('Cache-Control: public, max-age=3600');

        // --- ICS Start ---
        echo "BEGIN:VCALENDAR\r\n";
        echo "VERSION:2.0\r\n";
        echo "PRODID:-//Quint Felicity//Interner Veranstaltungs-Kalender//DE\r\n";
        echo "CALSCALE:GREGORIAN\r\n";

        // --- DB ---
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM events ORDER BY date_begin ASC");
        $events = $stmt->fetchAll();

        foreach ($events as $gig) {
            self::renderEvent($gig);
        }

        echo "END:VCALENDAR\r\n";
    }

    public static function renderEvent($gig) {
        $startDate = new DateTime($gig['date_begin']);
        $eventDate = $startDate->format('Ymd'); // 20260315
        $eventEnd  = $startDate->modify('+1 day')->format('Ymd');
        $startTime = $startDate->format('H:i'); // 20:30
        if ($startTime === '00:00') {
            $startTime = null;
        }

        $statusEmoji = $gig['booked']? '[GEBUCHT]' : '[PENDING]';
        $art = $gig['publish'] ? 'Öffentlich' : 'Privat';

        $summary = "$statusEmoji {$gig['title']}";

        $desc = [];
        $desc[] = "Status: " . ($gig['booked'] ? 'Gebucht' : 'Noch nicht nicht fix');
        $desc[] = "Art: $art";
        $desc[] = "";
        
        $desc[] = "⏰ Start: ". (!$startTime? "Noch unbekannt" : $startTime);

        $einlassTime = null;
        if (!empty($gig['public_entry'])) {
            $einlass = new DateTime($gig['public_entry']);
            $einlassTime = $einlass->format('H:i');
            $desc[] = "🚪 Einlass: {$einlassTime}";
        }

        if ($gig['duration']) {
            $desc[] = "🎶 Setlänge: {$gig['duration']}";
        }

        if ($gig['location']) {
            $desc[] = "";
            $desc[] = "📍 Adresse:";
            $desc[] = $gig['location'];
        }
        if ($gig['notes']) {
            $desc[] = "";
            $desc[] = "📝 Notizen:";
            $desc[] = $gig['notes'];
        }

        $description = implode("\\n", $desc);

        echo "BEGIN:VEVENT\r\n";
        echo "UID:event-{$gig['id']}@member.quint-felicity.de\r\n";
        echo "DTSTAMP:" . gmdate('Ymd\THis\Z') . "\r\n";
        echo "DTSTART;VALUE=DATE:$eventDate\r\n";
        echo "DTEND;VALUE=DATE:$eventEnd\r\n";
        echo "SUMMARY:" . addcslashes($summary, ",;\\") . "\r\n";
        if ($gig['location']) echo "LOCATION:" . addcslashes($gig['location'], ",;\\") . "\r\n";
        echo "DESCRIPTION:" . addcslashes($description, ",;\\") . "\r\n";
        echo "END:VEVENT\r\n";
    }
}