<?php
session_start();


// Check if user is logged in
if (!isset($_SESSION['authenticated'])|| $_SESSION['authenticated'] !== TRUE) {
    header("Location: login.php");
    exit;
}

$userProfile = getUserProfile($_SESSION['username']);

// Update user details if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['authenticated'] = TRUE;
    $newUsername = $_POST["username"];
    $newEmail = $_POST["email"];

    if (updateUserDetails($_SESSION['username'], $newUsername, $newEmail)) {
        echo "<script>alert('User details updated successfully');</script>";
        // Update session username if changed
        $_SESSION['username'] = $newUsername;
        // Refresh user profile after update
        $userProfile = getUserProfile($_SESSION['username']);
    } else {
        echo "<script>alert('Failed to update user details');</script>";
    }
}

function getUserProfile($username) {
    $mysqli = new mysqli('localhost', 'bhavansr', '12345', 'waph');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $userProfile = $result->fetch_assoc();
    return $userProfile;
}

function updateUserDetails($username, $newUsername, $newEmail) {
    $mysqli = new mysqli('localhost', 'bhavansr', '12345', 'waph');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        return FALSE;
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newName = $_POST['name'];
        $newEmail = $_POST['email'];

    // Validate 'name' field
     if (empty($newName)) {
        echo "Name field cannot be empty.";
        exit;
    }

    // Update user profile in the database
    $stmt = $mysqli->prepare("UPDATE users SET name = ?, email = ? WHERE username = ?");
    $stmt->bind_param("sss", $newName, $newEmail, $_SESSION['username']);
    $stmt->execute();
    $stmt->close();

    // Redirect to profile page
    header("Location: profile.php");
    } else {
        return FALSE;
    }
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
            margin: 10px auto;
            padding: 80px;
            background-color: #fff;
            border-radius: 10px;
            box-sizing: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: run-in;
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
       <p>Click here to go <a href="new_login.php">Back to profile</a></p>
    </form>
</body>
</html>