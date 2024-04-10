<?php
session_start();

if(isset($_POST["username"]) and isset($_POST["password"])) {
    if (checklogin_mysql($_POST["username"], $_POST["password"]) || checklogin_email($_POST["username"], $_POST["password"])) {
        $_SESSION["authenticated"] = TRUE;
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
    } else {
        session_destroy();
        echo "<script>alert('Invalid username/password');window.location='login.php';</script>";
        die();
    }
}

if(!$_SESSION["authenticated"] or $_SESSION["authenticated"] != TRUE){
    session_destroy();
    echo "<script>alert('You have not Login. Please login first ');</script>";
    header("Refresh:0; url=login.php");
    die();
}

if($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
    session_destroy();
    echo "<script>alert('Session Hijacking attack is detected!');</script>";
    header("Refresh:0; url=login.php");
    die();
}

function checklogin_mysql($username, $password) {
    $mysqli = new mysqli('localhost','bhavansr','12345','waph');
    if($mysqli->connect_errno){
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $sql = "SELECT * FROM users WHERE username=?  AND password = md5(?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1)
        return TRUE;
    return FALSE;
}

function checklogin_email($email, $password) {
    $mysqli = new mysqli('localhost','bhavansr','12345','waph');
    if($mysqli->connect_errno){
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $sql = "SELECT * FROM users WHERE email=?  AND password = md5(?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1)
        return TRUE;
    return FALSE;
}

// Retrieve user's profile information
function getUserProfile($username) {
    $mysqli = new mysqli('localhost','bhavansr','12345','waph');
    if($mysqli->connect_errno){
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

$userProfile = getUserProfile($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-top: 0;
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
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</h2>
    <a href="profile.php">View My Profile</a>
    <a href="editprofile.php">Edit Profile</a>
    <a href="changepassword.php">Update password</a>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>