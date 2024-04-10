<?php
session_set_cookie_params(15*60, "/", "sravan230412.waph.io", TRUE, TRUE);
session_start();

// Check if user is not logged in
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== TRUE) {
    echo "<script>alert('Not authorized. Please login first.'); window.location='login.php';</script>";
    exit; // Stop further execution
}

if(isset($_POST["current_password"]) && isset($_POST["new_password"]) && isset($_POST["confirm_password"])) {
    $username = $_SESSION["username"];
    $currentPassword = $_POST["current_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    if($newPassword != $confirmPassword) {
        echo "<script>alert('New password and confirm password do not match');</script>";
    } else {
        if(changePassword($username, $currentPassword, $newPassword)) {
            echo "<script>alert('Password changed successfully');</script>";
        } else {
            echo "<script>alert('Failed to change password');</script>";
        }
    }
}

function changePassword($username, $currentPassword, $newPassword) {
    $mysqli = new mysqli('localhost', 'bhavansr', '12345', 'waph');
    if($mysqli->connect_errno){
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        return FALSE;
    }

    $sql = "UPDATE users SET password = MD5(?) WHERE username = ? AND password = MD5(?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $newPassword, $username, $currentPassword);
    if($stmt->execute() && $stmt->affected_rows > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    h2, label {
      text-align: center;
    }
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    button[type="submit"] {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #GFA876;
      color: black;
      text-align: center;
      text-decoration: none;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    button[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Change Password</h2>
    <form action="" method="POST" onsubmit="return validateForm()">
      <label for="current_password">Current Password:</label>
      <input type="password" id="current_password" name="current_password" required><br>
      <input type="hidden" class="text_field" name="nocsrftoken" value="<?php echo $rand; ?>"/>
      
      <label for="new_password">New Password:</label>
      <input type="password" id="new_password" name="new_password" required
             pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
             title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE"
             onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');"><br>

      <label for="confirm_password">Confirm Password:</label>
      <input type="password" id="confirm_password" name="confirm_password" required
             onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Password does not match' : '');"><br>

      <button type="submit">Change Password</button>
    </form>
  </div>

  <script type="text/javascript">
    function validateForm() {
      var newPassword = document.getElementById("new_password").value;
      var confirmPassword = document.getElementById("confirm_password").value;

      if (newPassword !== confirmPassword) {
        alert("New password and confirm password do not match");
        return false;
      }

      return true;
    }
  </script>
</body>
</html>
