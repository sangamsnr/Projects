<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, full_name, password FROM students WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if ($password == $user['password']) { 
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            header("Location: feedbackPage.php");
        }
    }
}
$checkCols = mysqli_query($conn, "SHOW COLUMNS FROM questions");
$q_col = "id"; 
while ($col = mysqli_fetch_assoc($checkCols)) {
    if (in_array($col['Field'], ['id', 'q_id', 'ques_id'])) {
        $q_col = $col['Field'];
        break;
    }
}

$questions_query = mysqli_query($conn, "SELECT * FROM questions");

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['full_name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['faculty']}</td>
        <td>
            <a href='stdEdit.php?id={$row['id']}'>Edit</a>
            <a href='stdDelete.php?id={$row['id']}'>Delete</a>
        </td>
    </tr>";
}
?>