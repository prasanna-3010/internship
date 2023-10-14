<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";

    $userId = $_SESSION["user_id"];

    $sql = "SELECT id, name, contact, dob, age FROM user WHERE id = $userId";
    $result = $mysqli->query($sql);
    $userData = $result->fetch_assoc();

    include "view-profile.html";
} else {
    header("Location: profile.php");
    exit;
}
?>
