<?php

// Function to redirect with an error message
function redirectWithError($errorMessage) {
    header("Location: signup.html?error=" . urlencode($errorMessage));
    exit;
}

// Input validation
if (empty($_POST["name"])) {
    redirectWithError("Name is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    redirectWithError("Valid email is required");
}

if (strlen($_POST["password"]) < 8 || !preg_match("/[a-z]/i", $_POST["password"]) || !preg_match("/[0-9]/", $_POST["password"])) {
    redirectWithError("Password must be at least 8 characters and contain at least one letter and one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    redirectWithError("Passwords must match");
}

// Hashing the password
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Database connection
$mysqli = require __DIR__ . "/database.php";

// SQL statement for insertion
$sql = "INSERT INTO user (name, email, password_hash) VALUES (?, ?, ?)";

// Prepared statement
$stmt = $mysqli->prepare($sql);

// Check for SQL error
if (!$stmt) {
    redirectWithError("SQL error: " . $mysqli->error);
}

// Binding parameters
$stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to signup-success.html on success
    header("Location: signup-success.html");
} else {
    // Handle duplicate email separately
    if ($mysqli->errno === 1062) {
        redirectWithError("Email already exists. Please use a different email address.");
    } else {
        redirectWithError("Database error: " . $mysqli->error);
    }
}

// Close resources
$stmt->close();
$mysqli->close();
exit; // Make sure to exit after closing resources

?>
