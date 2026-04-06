<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_id = $_POST['student_id'];
    $subject    = $_POST['subject'];
    $comment    = $_POST['comment'];

    if (!empty($_POST['rating'])) {

        foreach ($_POST['rating'] as $question_id => $rating) {

            $stmt = $conn->prepare("INSERT INTO feedback (student_id, question_id, subject, rating, comment) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisis", $student_id, $question_id, $subject, $rating, $comment);

            $stmt->execute();
        }

        echo "<h2 style='text-align:center;'>Feedback Submitted Successfully!</h2>";
    } 
    else {
        echo "No ratings submitted.";
    }

} else {
    echo "Invalid Request";
}
?>