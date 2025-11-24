<?php
session_start();
session_destroy();
header("Location: dashboard.php"); // TODO eig nur zum Testen
exit;
?>