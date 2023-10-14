<?php
$is_invalid = false;
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Start the session
    session_start();

    // Include the database connection
    $mysqli = require __DIR__ . "/database.php";

    // SQL query to select user data based on email
    $sql = "SELECT * FROM user WHERE email = ?";
    
    // Prepared statement
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        // Handle SQL error
        $error_message = "SQL error: " . $mysqli->error;
    } else {
        // Bind email parameter
        $stmt->bind_param("s", $_POST["email"]);
        
        // Execute the statement
        $stmt->execute();
        
        // Get the result
        $result = $stmt->get_result();

        // Use fetch_assoc to get an associative array
        $user = $result->fetch_assoc();

        // Check if user exists and password is correct
        if ($user && password_verify($_POST["password"], $user["password_hash"])) {
            // Regenerate session ID for security
            session_regenerate_id();

            // Store user ID in the session
            $_SESSION["user_id"] = $user["id"];

            // Redirect to index.php
            header("Location: index.php");
            exit;
        }

        // Invalid login
        $is_invalid = true;
        $error_message = "Invalid email or password";
    }

    // Close the prepared statement
    $stmt->close();
}

// Include the login form HTML
include "login.html";
?>
