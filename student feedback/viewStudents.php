<?php
require 'Connection.php';

$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Students</title>

<link rel="stylesheet" href="manageForm.css">

<style>

.head{
    margin-top:80px;
    margin-left:220px;
}

table{
    width:85%;
    border-collapse:collapse;
    margin-top:20px;
    margin-left:220px;
}

table, th, td{
    border:1px solid #333;
}

th, td{
    padding:8px 12px;
    text-align:left;
}

th{
    background-color:#f2f2f2;
}

a{
    margin-right:8px;
}

</style>

</head>
<body>

<?php require('navbar.php'); ?>

<div class="head">
<h1>Student List</h1>
</div>

<table>

<thead>
<tr>
<th>ID</th>
<th>Full Name</th>
<th>Contact Number</th>
<th>Email</th>
<th>Year</th>
<th>Faculty</th>
<th>Semester</th>
<th>Password</th>
<th>Created At</th>
<th>Updated At</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

<?php

if ($result->num_rows > 0) {

while ($row = $result->fetch_assoc()) {

echo "<tr>
<td>{$row['id']}</td>
<td>{$row['full_name']}</td>
<td>{$row['contact_number']}</td>
<td>{$row['email']}</td>
<td>{$row['year']}</td>
<td>{$row['faculty']}</td>
<td>{$row['semester']}</td>
<td>{$row['password']}</td>
<td>{$row['created_at']}</td>
<td>{$row['updated_at']}</td>

<td>
<a href='stdEdit.php?id={$row['id']}'>Edit</a>
<a href='stdDelete.php?id={$row['id']}'>Delete</a>
</td>

</tr>";

}

}
else{

echo "<tr><td colspan='11'>No students found</td></tr>";

}

?>

</tbody>
</table>

</body>
</html>