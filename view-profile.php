<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: process-view-profile.php");
    exit;
}

header("Location: profile.php");
?>
