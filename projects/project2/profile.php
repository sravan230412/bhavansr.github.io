<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    //win32_continue_service("profile.php");
    exit;}
//}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Database connection
$servername = "localhost";
$username = "bhavansr"; // Your MySQL username
$password = "12345"; // Your MySQL password
$dbname = "waph"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $error = "No user data found for username: $username";
    }
} else {
    $error = "Error fetching user data: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        p {
            max-width: 600px;
            margin: 0 auto;
            padding: 8px;
            background-color: #fff;
            border-radius: 10px;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-top: 0;
            text-align: center;
        }

        a {
            display: block;
            margin-top: 10px;
            color: #3498db;
            text-decoration: none;
            text-align: center;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Profile</h1>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php elseif (isset($user) && isset($user['username'])): ?>
        <p>Welcome, <?php echo $user['username']; ?>!</p>
        <p>Email: <?php echo $user['email']; ?></p>
        <!-- Display other user profile information here -->
    <?php else: ?>
        <p>Error: User data is not available.</p>
    <?php endif; ?>
    <a href="new_login.php">Back to profile</a> <br>
    <a href="logout.php">Logout</a>
</body>
</html>