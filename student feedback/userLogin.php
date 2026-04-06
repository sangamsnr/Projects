<?php
session_start(); 
require 'Connection.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT id, full_name, password FROM students WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        // 2. Verify the hashed password
        if ($password==$user['password']) {
            // Password is correct! Store data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            
        
            header("Location: feedbackPage.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 350px;
        }
        h2 { text-align: center; color: #333; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; margin-bottom: 8px; color: #555; font-weight: 600; }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .error-msg {
            color: #d9534f;
            background: #f2dede;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            text-align: center;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }
        button:hover { background-color: #0056b3; }
        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        .signup-link a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Student Login</h2>

    <?php if($error): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="signup-link">
        Don't have an account? <a href="registration.php">Sign up here</a>
    </div>
</div>




</body>
</html>