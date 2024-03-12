<?php
// register.php
session_start();
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the username and password (add more validation if needed)
    if (strlen($password) < 5) {
        echo "Password should be at least 5 characters long.";
        exit();
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username is already taken
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    
    // Check if the prepare statement was successful
    if (!$stmt) {
        die("Error in prepare statement: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();
    
    // Check for errors in execution
    if ($stmt->error) {
        die("Error in execute statement: " . $stmt->error);
    }

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Username already taken. Choose a different one.";
        exit();
    }

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    
    // Check if the prepare statement was successful
    if (!$stmt) {
        die("Error in prepare statement: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("ss", $username, $hashed_password);

    // Execute the statement
    $stmt->execute();
    
    // Check for errors in execution
    if ($stmt->error) {
        die("Error in execute statement: " . $stmt->error);
    }

    echo "Registration successful. You can now <a href='login.php'>login</a>.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Registration</h1>
    <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Sign in</a></p>
</body>
</html>


