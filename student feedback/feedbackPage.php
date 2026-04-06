<?php
session_start();
require "Connection.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: userLogin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$student_query = mysqli_query($conn, "SELECT * FROM students WHERE id = '$user_id'");
$student = mysqli_fetch_array($student_query);

if (!$student) {
    die("Student record not found.");
}

$full_name = $student['full_name'];
$email     = $student['email'];
$faculty   = $student['faculty'];
$semester  = $student['semester'];

$checkCols = mysqli_query($conn, "SHOW COLUMNS FROM questions");
$q_col = "id"; // fallback
while ($col = mysqli_fetch_assoc($checkCols)) {
    if (in_array($col['Field'], ['id', 'q_id', 'ques_id', 'question_id'])) {
        $q_col = $col['Field'];
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $subject    = $_POST['subject'];
    $comment    = $_POST['comment'];
    $ratings    = $_POST['ratings']; 

    $stmt = $conn->prepare("INSERT INTO feedback (student_id, question_id, subject, rating, comment) VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {
        foreach ($ratings as $question_id => $rating) {
            $stmt->bind_param("iisds", $student_id, $question_id, $subject, $rating, $comment);
            $stmt->execute();
        }
        $stmt->close();
        echo "<script>alert('Feedback submitted successfully!'); window.location='feedbackPage.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$questions_query = mysqli_query($conn, "SELECT * FROM questions");
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Feedback System</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; text-align: center; }
        #topHeader { background: #333; color: white; padding: 20px; font-weight: bold; }
        .container { width: 70%; margin: 20px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .student-info { background: #eee; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: left; }
        .question-box { margin: 15px 0; padding: 15px; border-bottom: 1px solid #ddd; text-align: left; }
        .question-box label { font-weight: bold; display: block; margin-bottom: 10px; }
        select { padding: 8px; width: 100%; max-width: 300px; border-radius: 4px; border: 1px solid #ccc; }
        input[type="text"], textarea { width: 100%; padding: 10px; box-sizing: border-box; border-radius: 4px; border: 1px solid #ccc; }
        .btn-submit { padding: 12px 30px; background-color: #28a745; color: white; border: none; cursor: pointer; font-weight: bold; border-radius: 5px; }
    </style>
</head>
<body>

<div id="topHeader">STUDENT FEEDBACK SYSTEM</div>

<div class="container">
    <h2>Step IV – Provide Feedback</h2>

    <div class="student-info">
        <strong>Name:</strong> <?php echo htmlspecialchars($full_name); ?> <br>
        <strong>Email:</strong> <?php echo htmlspecialchars($email); ?> <br>
        <strong>Faculty:</strong> <?php echo htmlspecialchars($faculty); ?> | 
        <strong>Semester:</strong> <?php echo htmlspecialchars($semester); ?>
    </div>

    <form method="post" action="">
        <input type="hidden" name="student_id" value="<?php echo $user_id; ?>">

        <div style="text-align: left; margin-bottom: 20px;">
            <label><strong>Enter Subject:</strong></label>
            <input type="text" name="subject" placeholder="e.g. Mathematics" required>
        </div>

        <?php 
        $count = 1;
        while ($row = mysqli_fetch_assoc($questions_query)) { 
            $actual_q_id = $row[$q_col]; 
        ?>
            <div class="question-box">
                <label><?php echo $count . ". " . htmlspecialchars($row['ques_title']); ?></label>
                <select name="ratings[<?php echo $actual_q_id; ?>]" required>
                    <option value="">-- Select Rating --</option>
                    <option value="5">Excellent (5)</option>
                    <option value="4">Very Good (4)</option>
                    <option value="3">Good (3)</option>
                    <option value="2">Fair (2)</option>
                    <option value="1">Poor (1)</option>
                </select>
            </div>
        <?php 
            $count++;
        } 
        ?>

        <div class="question-box">
            <label>Additional Comments</label>
            <textarea name="comment" rows="4" required placeholder="Write your feedback here..."></textarea>
        </div>

        <div style="margin-top: 20px;">
            <input type="button" value="BACK" onclick="window.history.back();" style="padding: 10px 20px; cursor:pointer;">
            <input type="submit" value="SUBMIT FEEDBACK" class="btn-submit">
        </div>
    </form>
</div>

</body>
</html>