<?php
include 'db.php';

$name = $_POST['name'];
$subject = $_POST['subject'];
$marks = $_POST['marks'];
$grade = $_POST['grade'];

$sql = "INSERT INTO students (name, subject, marks, grade)
        VALUES ('$name', '$subject', '$marks', '$grade')";

$conn->query($sql);

// 🔥 redirect to dashboard
header("Location: index.php");
exit();
?>