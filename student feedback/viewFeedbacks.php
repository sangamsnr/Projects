<?php
require 'Connection.php';
$checkCols = mysqli_query($conn, "SHOW COLUMNS FROM questions");
$q_id_col = "id"; 
while ($col = mysqli_fetch_assoc($checkCols)) {
    if (in_array($col['Field'], ['id', 'q_id', 'ques_id'])) {
        $q_id_col = $col['Field'];
        break;
    }
}
$query = "SELECT 
            f.id, 
            s.full_name, 
            q.ques_title, 
            f.subject, 
            f.rating, 
            f.comment 
          FROM feedback f
          INNER JOIN students s ON f.student_id = s.id
          INNER JOIN questions q ON f.question_id = q.$q_id_col
          ORDER BY f.id DESC";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Student Feedbacks</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f7f6; margin: 0; }
        .container { width: 90%; margin: 30px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #ff9800; display: inline-block; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #333; color: white; text-transform: uppercase; font-size: 14px; }
        tr:hover { background-color: #f1f1f1; }
        
        .rating-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            color: white;
            font-size: 12px;
        }
        .bg-high { background: #28a745; } /* Green for 4-5 */
        .bg-mid { background: #ffc107; color: #333; } /* Yellow for 3 */
        .bg-low { background: #dc3545; } /* Red for 1-2 */
    </style>
</head>
<body>

<?php if(file_exists('navbar.php')) include 'navbar.php'; ?>

<div class="container">
    <h1>All Student Feedbacks</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Subject</th>
                <th>Question</th>
                <th>Rating</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><strong><?php echo htmlspecialchars($row['full_name']); ?></strong></td>
                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                <td style="font-style: italic; color: #555;">"<?php echo htmlspecialchars($row['ques_title']); ?>"</td>
                <td>
                    <?php 
                        $r = $row['rating'];
                        $class = ($r >= 4) ? 'bg-high' : (($r == 3) ? 'bg-mid' : 'bg-low');
                    ?>
                    <span class="rating-badge <?php echo $class; ?>">
                        <?php echo $r; ?> / 5
                    </span>
                </td>
                <td><?php echo htmlspecialchars($row['comment']); ?></td>
            </tr>
            <?php endwhile; ?>
            
            <?php if(mysqli_num_rows($result) == 0): ?>
                <tr><td colspan="6" style="text-align:center;">No feedback records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>