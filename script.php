<?php
// Database connection
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login form handling
if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful
        session_start();
        $_SESSION['email'] = $email;
        header("Location: home.php");
        exit();
    } else {
        echo "Invalid email or password.";
    }
}

// Signup form handling
if(isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Signup successful. Please login.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Redirect if information is accurate
if(isset($_POST['agree'])) {
    session_start();
    $email = $_SESSION['email'];

    // Check if email exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        header("Location: home.php");
        exit();
    } else {
        echo "User not found.";
    }
}

$conn->close();
?>