<?php
session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $contact = $_POST["contact"];
    $dob = $_POST["dob"];
    $age = $_POST["age"];
    $userId = $_SESSION["user_id"];
    
    
    
    $updateSql = "UPDATE user
                  SET contact = '$contact', dob = '$dob', age = '$age'
                  WHERE id = $userId";
    
    if ($mysqli->query($updateSql)) {
        // Success
        header("Location: profile.php?success=true"); 
        exit;
    } else {
        // Error handling
        echo "Error: " . $mysqli->error;
    }
}
?>
