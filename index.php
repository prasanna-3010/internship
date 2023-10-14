<?php
session_start();

$content = ''; // Initialize content variable

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    // Generate content for authenticated users
    $content = "
        <p>Hello " . htmlspecialchars($user["name"]) . "</p>
        <p>
            <a href='profile.html'>View Profile</a> | 
            <a href='logout.php'>Log out</a>
        </p>
    ";
} else {
    // Generate content for non-authenticated users
    $content = "<p><a href='login.html'>Log in</a> or <a href='signup.html'>sign up</a></p>";
}

// Include the HTML template and replace {content} with generated content
$html = file_get_contents("index.html");
$html = str_replace("{content}", $content, $html);
echo $html;
?>
