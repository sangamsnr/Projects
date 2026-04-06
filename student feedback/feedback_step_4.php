<?php
session_start();

// 1. Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$student = $result->fetch_assoc();
$full_name = $student['full_name'];
$email     = $student['email'];
$faculty   = $student['faculty'];
$semester  = $student['semester'];
$questions_query = mysqli_query($conn, "SELECT * FROM questions");

while ($row = mysqli_fetch_assoc($questions_query)) {
    $questions[] = $row;
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Feedback System - Step IV</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <style>
        .question-box {
            margin: 15px 0;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .question-box label {
            font-weight: bold;
        }
        select, input[type=text], textarea {
            padding: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        .student-info {
            background: #eee;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: left;
            width: 70%;
        }
    </style>
</head>
<body>
<div id="topHeader">
    <span class="tag">STUDENT FEEDBACK SYSTEM</span>
</div>

<div id="content" align="center">
    <br>
    <span class="SubHead">Step IV – Provide Feedback</span>
    <br><br>
    <div class="student-info">
        <strong>Name:</strong> <?php echo $full_name; ?> <br>
        <strong>Email:</strong> <?php echo $email; ?> <br>
        <strong>Faculty:</strong> <?php echo $faculty; ?> |
        <strong>Semester:</strong> <?php echo $semester; ?>
    </div>

    <form method="post" action="feedback_step_5.php">
        <input type="hidden" name="student_id" value="<?php echo $user_id; ?>">

        <label><strong>Enter Subject:</strong></label><br>
        <input type="text" name="subject" placeholder="Enter subject" required>
        <br><br>

        <div style="width:70%; text-align:left;">
            <!-- Dynamic Questions -->
            <?php foreach($questions as $i => $row): ?>
                <div class="question-box">
                    <label><?php echo ($i+1) . ". " . $row['ques_title']; ?></label><br><br>
                    <select name="rating[<?php echo $row['id']; ?>]" required>
                        <option value="">-- Select Rating --</option>
                        <option value="5">Excellent</option>
                        <option value="4">Very Good</option>
                        <option value="3">Good</option>
                        <option value="2">Fair</option>
                        <option value="1">Poor</option>
                    </select>
                </div>
            <?php endforeach; ?>
            <div class="question-box">
                <label>Comments</label><br><br>
                <textarea name="comment" rows="3" required placeholder="Write your feedback here..."></textarea>
            </div>
        </div><br>
<input type="button" value="BACK" onclick="window.history.back();">
        &nbsp;&nbsp;
        <input type="submit" value="SUBMIT FEEDBACK">
        <br><br>
    </form>
</div>
</body>
</html>