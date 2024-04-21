<?php
	session_start();
	session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px auto;
            padding: 0;
            text-align: center;
            display: center;
        }


        h2 {
            color: #333;
            margin-top: 0;
        }
        a{
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
		<h2>You are logged out! </h2>
		<a href="login.php"> Login again</a>
</body>
</html>



