<?php
require 'Connection.php';

if (!isset($_GET['id'])) {
    die("No student ID provided.");
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
    die("Student not found.");
}
if (isset($_POST['update'])) {
    $full_name = $_POST['full_name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $year = $_POST['year'];
    $faculty = $_POST['faculty'];
    $semester = $_POST['semester'];

    $stmt = $conn->prepare("UPDATE students SET full_name=?, contact_number=?, email=?, year=?, faculty=?, semester=? WHERE id=?");
    $stmt->bind_param("ssisiii", $full_name, $contact_number, $email, $year, $faculty, $semester, $id);

    if ($stmt->execute()) {
        header("Location: manageForm.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
<h1>Edit Student</h1>
<form action="" method="post">
    <label>Full Name:</label><br>
    <input type="text" name="full_name" value="<?php echo htmlspecialchars($student['full_name']); ?>" required><br><br>

    <label>Contact Number:</label><br>
    <input type="text" name="contact_number" value="<?php echo htmlspecialchars($student['contact_number']); ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br><br>

    <label>Year:</label><br>
    <input type="number" name="year" value="<?php echo $student['year']; ?>" required><br><br>

    <label>Faculty:</label><br>
    <input type="text" name="faculty" value="<?php echo htmlspecialchars($student['faculty']); ?>" required><br><br>

    <label>Semester:</label><br>
    <input type="number" name="semester" value="<?php echo $student['semester']; ?>" required><br><br>

    <button type="submit" name="update">Update Student</button>
</form>
</body>
</html>