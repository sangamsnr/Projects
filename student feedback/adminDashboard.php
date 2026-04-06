<?php

require 'Connection.php';
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Student Feedback System</title>
<link rel="stylesheet" href="style.css" />

</head>
<br> <br> <br> <br> <br> <br>
<body>
<div class="bracket bracket-primary" style="max-width: 600px; margin: 0 auto;">
    <h2 style="text-align: center; margin-bottom: 70px;">Welcome to Admin Page</h3>
    
    <div class="button-container">
        <a href="feeds.php" class="btn students">
            <span style="font-size: 40px;"></span>
            View Feedbacks
        </a>
        <a href="manageForm.php" class="btn add">
            <span style="font-size: 40px;"></span>
            Manage Form
        </a>
        <a href="changePass.php" class="btn all">
            <span style="font-size: 40px;"></span>
            Change Password
        </a>
        <a href="logout.php" class="btn fail">
            <span style="font-size: 40px;"></span>
            Logout
        </a>
    </div>
</div>

</div>
</body>
</html>