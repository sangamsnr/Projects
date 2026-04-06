<?php
    require 'Connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
       $admin_email = $_POST['admin_email'];
    
        $admin_password = $_POST['admin_password'];

       $sql = "INSERT INTO admin (admin_email, admin_password) 
                VALUES (?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $admin_email,$admin_password);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Admin registered successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign-up Page</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            margin: 20px;
        }
        h2 { text-align: center; color: #333; margin-top: 0; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 5px; color: #666; font-size: 0.9rem; }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 1rem;
        }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Admin Creation</h2>
    <form action="" method="POST">
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="admin_email" placeholder="admin@gmail.com" required>
        </div>

        <div class="form-group">
            <label for="contact">Password</label>
            <input type="password" id="admin_password" name="admin_password" placeholder="password" required>
        </div>

      
        <button type="submit">Sign Up</button>
    </form>
</div>

</body>
</html>