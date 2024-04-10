<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['authenticated'])|| $_SESSION['authenticated'] !== TRUE) {
    header("Location: login.php");
    exit;
}

$mysqli = new mysqli('localhost', 'bhavansr', '12345', 'waph');
if($mysqli->connect_errno){
    printf("Database connection failed: %s\n", $mysqli->connect_error);
    exit();
}

$username= $_SESSION['username'];
global $mysqli;
// Fetch user data from the database
$stmt = $mysqli->prepare("SELECT name, email FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();

// Handle form submission for profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];

    // Update user profile in the database
    $stmt = $mysqli->prepare("UPDATE users SET name = ?, email = ? where username=?");
    $stmt->bind_param("sss", $newName, $newEmail, $username);
    $stmt->execute();
    $stmt->close();

    // Redirect to profile page
    header("Location: profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        }

        a:hover {
            text-decoration: underline;
        }
        button[type="submit"] {
          width: 10%;
          padding: 0px;
          color: black;
          text-align: center;
          background-color: white;
    }
    </style>
</head>
<body>
    <h1>Update your Profile Here!!</h1>
    <form  method="post">
        <div>
            <label for="name">New Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <div>
            <label for="email">New Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <button type="submit">Update</button>
    </form>
</body>
</html>