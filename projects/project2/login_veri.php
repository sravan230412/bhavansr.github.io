<?php
session_set_cookie_params(15*60, "/", "sravan230412.waph.io", TRUE, TRUE);
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

function checklogin_mysql($username, $password) {
    $mysqli = new mysqli('localhost', 'bhavansr', '12345', 'waph');
    if($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $sql = "SELECT username, password FROM users WHERE username=? AND password= md5(?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $username,$password);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];
        if (password_verify($password, $hashedPassword)) {
            return true;
        }
    }
    return false;
}
if(isset($_POST["username"]) && isset($_POST["password"])) {
    if (checklogin_mysql($_POST["username"], $_POST["password"])) {
        $_SESSION["authenticated"] = true;
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
        header("Location: profile.php");
        exit;
    } else {
        echo "<script>alert('Invalid username/password');window.location='login.php';</script>";
        exit;
    }
}


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
            margin: 0 auto;
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
    <a href="changepasswordform.php">Change Password</a>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>