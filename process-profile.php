<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $dob = $_POST["dob"];
        $contact = $_POST["contact"];
        $age = $_POST["age"];
        $userId = $_SESSION["user_id"];

        $updateSql = "UPDATE user
                      SET dob = '$dob', contact = '$contact', age = '$age'
                      WHERE id = $userId";

        if ($mysqli->query($updateSql)) {
            // Redirect to view-profile.html on success
            header("Location: view-profile.php");
            exit;
        } else {
            // Handle update failure if needed
        }
    }

    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);
    $userInfo = $result->fetch_assoc();

    // Replace placeholders in the HTML template (profile.html)
    $html = file_get_contents("profile.html");
    $html = str_replace("{success_message}", "", $html); // Remove success message
    $html = str_replace("{dob}", $userInfo["dob"], $html);
    $html = str_replace("{contact}", $userInfo["contact"], $html);
    $html = str_replace("{age}", $userInfo["age"], $html);
    
    echo $html;
} else {
    header("Location: login.php"); 
    exit;
}
?>
