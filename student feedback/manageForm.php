<?php
require 'Connection.php';
$checkCols = mysqli_query($conn, "SHOW COLUMNS FROM questions");
$colName = ""; 
while ($col = mysqli_fetch_assoc($checkCols)) {
    // Adding 'question_id' to the check just in case
    if (in_array($col['Field'], ['id', 'q_id', 'ques_id', 'question_id'])) {
        $colName = $col['Field'];
        break;
    }
}

// Fallback if detection fails
if($colName == "") { $colName = "id"; }
$currentFile = basename($_SERVER['PHP_SELF']);
if (isset($_GET['delete_id'])) {
    $id_to_delete = $_GET['delete_id'];
    
    try {
        $del_stmt = $conn->prepare("DELETE FROM questions WHERE $colName = ?");
        $del_stmt->bind_param("i", $id_to_delete);

        if ($del_stmt->execute()) {
            echo "<script>alert('Question deleted!'); window.location='$currentFile';</script>";
        } else {
            echo "<script>alert('Error: Could not delete.'); window.location='$currentFile';</script>";
        }
        $del_stmt->close();
    } catch (mysqli_sql_exception $e) {
        // This triggers if there is feedback linked to the question
        echo "<script>alert('CANNOT DELETE: This question has feedback linked to it. Delete the feedback first.'); window.location='$currentFile';</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_question'])) {
    $ques_title = trim($_POST['ques_title']);
    if (!empty($ques_title)) {
        $add_stmt = $conn->prepare("INSERT INTO questions (ques_title) VALUES (?)");
        $add_stmt->bind_param("s", $ques_title);
        $add_stmt->execute();
        $add_stmt->close();
        header("Location: $currentFile"); // Refresh to clear POST data
        exit();
    }
}

$questions_query = mysqli_query($conn, "SELECT * FROM questions ORDER BY $colName DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <nav class="main-nav">
        <ul>
            <li><a href="viewFeedbacks.php">View Feedbacks</a></li>
            <li><a href="manageForm.php">Manage Content</a></li>
            <li><a href="viewStudents.php">View Students</a></li>
        </ul>
    </nav>
    <meta charset="UTF-8">
    <title>Manage Questions</title>
    <style>
        body { font-family: sans-serif; background: #f8f9fa; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-box { background: #e9ecef; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #333; color: #fff; }
        .btn-delete { color: #d9534f; text-decoration: none; border: 1px solid #d9534f; padding: 5px 10px; border-radius: 4px; }
        .btn-delete:hover { background: #d9534f; color: #fff; }
    </style>
</head>
<body>



<div class="container">
    <h1>Manage Questions</h1>

    <div class="form-box">
        <form method="POST">
            <input type="text" name="ques_title" style="width: 70%; padding: 10px;" placeholder="Add new question..." required>
            <input type="submit" name="add_question" value="Add" style="padding: 10px 20px; cursor:pointer;">
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Question Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($questions_query)): ?>
            <tr>
                <td><?php echo $row[$colName]; ?></td>
                <td><?php echo htmlspecialchars($row['ques_title']); ?></td>
                <td>
                    <a href="<?php echo $currentFile; ?>?delete_id=<?php echo $row[$colName]; ?>" 
                       class="btn-delete" 
                       onclick="return confirm('Delete this question?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


<style>
    .main-nav {
        background-color: #333;
        padding: 15px 0;
        margin-bottom: 20px;
        width: 100%;
    }

    .main-nav ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
    }

    .main-nav ul li {
        margin: 0 20px;
    }

    .main-nav ul li a {
        text-decoration: none;
        color: white;
        font-size: 18px;
        font-family: Arial, sans-serif;
        transition: 0.3s;
    }

    .main-nav ul li a:hover {
        color: #ff9800;
    }
    </style>
    


</body>
</html>