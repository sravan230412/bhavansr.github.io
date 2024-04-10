<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH-Login page</title>
  <script type="text/javascript">
      function displayTime() {
        document.getElementById('digit-clock').innerHTML = "Current time:" + new Date();
      }
      setInterval(displayTime,500);
  </script>
  <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-top: 0;
        }

        button[type="submit"] {
          display: block;
          width: 100%;
          padding: 10px;
          background-color: #FFFFFF;
          color: black;
          text-align: center;
          text-decoration: none;
          border: none;
          border-radius: 4px;
          cursor: pointer;
    }
    </style>
</head>
<body>
  <h1>Sign Up for new content</h1>
  <div id="digit-clock"></div>  
<?php
  //some code here
  echo "Visited time: " . date("Y-m-d h:i:sa")
?>
    <form action="register.php" method="POST" class ="register">
        Username: <input type="text" name="username" required><br>
        Email: <input type="email" name="email" required><br>
        Name: <input type="text" name="name" required><br>
        Password: <input type="password" name="password" required><br>
    <button class="button" type="submit">Register</button>
  </form>
</body>
</html>
