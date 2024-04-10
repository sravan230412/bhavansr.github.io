<?php
// Database configuration
$servername = "localhost";
$username = "bhavansr";
$password = "12345";
$dbname = "waph";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
$username = $_POST['username'];
$email = $_POST['email'];
$name = $_POST['name'];
$password = $_POST['password'];
// Assuming you've hashed the password for security purposes
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user data into the database
$sql = "INSERT INTO users (username, email, name, password)
VALUES ('$username', '$email', '$name', $password, '$hashed_password')";

// Using prepared statement to avoid SQL injection
$stmt = $conn->prepare("INSERT INTO users (username, email, name, password) VALUES (?, ?, ?, md5(?))");

// Bind parameters: 's' specifies the parameter type => 'string'
$stmt->bind_param("ssss", $username, $email, $name, $password);


if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>