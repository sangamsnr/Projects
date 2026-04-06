<?php
include ("Connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>

        *{
            margin:0px;
            padding:0px
        }
        nav {
            background-color: #333;
            padding: 10px 0;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 20px;
        }
        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            font-family: Arial, sans-serif;
            transition: 0.3s;
        }
        nav ul li a:hover {
            color: #ff9800;
        }
    </style>

</head>
<body>

<nav>
    <ul>
        <li><a href="viewFeedbacks.php">View Feedbacks</a></li>
        <li><a href="manageForm.php">Manage Content</a></li>
        <li><a href="viewStudents.php">View Students</a></li>
    </ul>
</nav>

</body>
</html>