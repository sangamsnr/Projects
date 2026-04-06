<?php
    require 'Connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name     = $_POST['fullname'];
        $contact  = $_POST['contact'];
        $email    = $_POST['email'];
        $year     =$_POST['year']; 
        $faculty  = $_POST['faculty'];
        $semester = $_POST['semester'];
    
        $password = $_POST['password'];
        $sql = "INSERT INTO students (full_name, contact_number, email, year,faculty, semester, password) 
                VALUES (?, ?, ?, ?, ?, ?,?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssisss", $name, $contact, $email,$year, $faculty, $semester, $password);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Studxent registered successfully!');</script>";
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
    <title>Student Registration</title>
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
    <h2>Create Account</h2>
    <form action="" method="POST">
        
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" placeholder="John Doe" required>
        </div>

        <div class="form-group">
            <label for="contact">Contact Number</label>
            <input type="tel" id="contact" name="contact" placeholder="98XXXXXXXX" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="email@university.edu" required>
        </div>


         <div class="form-group">
            <label for="year">Batch :</label>
            <input type="number" id="year" name="year" placeholder="2025" required>
        </div>

        <div class="form-group">
            <label for="faculty">Faculty</label>
            <select id="faculty" name="faculty" required>
                <option value="">Select Faculty</option>
                <option value="Engineering">Engineering</option>
                <option value="Science & IT">Science & IT</option>
                <option value="Management">Management</option>
                <option value="Arts">Arts & Humanities</option>
            </select>
        </div>

        <div class="form-group">
            <label for="semester">Semester</label>
            <select id="semester" name="semester" required>
                <option value="">Select Semester</option>
                <option value="1">1st Semester</option>
                <option value="2">2nd Semester</option>
                <option value="3">3rd Semester</option>
                <option value="4">4th Semester</option>
            </select>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" minlength="8" required>
        </div>

        <button type="submit">Sign Up</button>
    </form>
</div>

</body>
</html>