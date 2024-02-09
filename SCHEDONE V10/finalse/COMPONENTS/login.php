<?php

// Establish a connection to the MySQL database
$connection = mysqli_connect("localhost", "root", "", "tasker");

// Check if the connection was successful; otherwise, display an error message and terminate the script
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get and sanitize the username and password from the POST data
$username = mysqli_real_escape_string($connection, $_POST['username']);
$password = mysqli_real_escape_string($connection, $_POST['password']);

// Construct a query to check if the entered username exists in the 'register' table
$checkUsernameQuery = "SELECT * FROM register WHERE username = '$username'";

// Execute the query
$checkUsernameResult = mysqli_query($connection, $checkUsernameQuery);

// Check if there are rows returned (username exists in the database)
if (mysqli_num_rows($checkUsernameResult) > 0) {

    // Fetch the user data associated with the provided username
    $userData = mysqli_fetch_assoc($checkUsernameResult);

    // Verify if the entered password matches the hashed password stored in the database
    if (password_verify($password, $userData['password'])) {
        // Destroy existing session if it exists
        session_start();
        session_unset();
        session_destroy();
        // Start a new session
        session_start();
        // Store user information in session variables
        $_SESSION['username'] = $userData['username'];
        $_SESSION['name'] = $userData['name'];
        $_SESSION['email'] = $userData['email'];
        $_SESSION['contact'] = $userData['contact_number'];

        // Return 'success' to indicate successful login
        echo "success";

    } else {
        // If the password is incorrect, return an error message
        echo "Invalid username or password";
    }
} else {
    // If the username does not exist, return an error message
    echo "Invalid username or password";
}

// Close the database connection
mysqli_close($connection);
