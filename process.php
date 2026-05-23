<?php
include 'db.php';

$name = $_POST['name'] ?? '';
$subject = $_POST['subject'] ?? '';
$marks = $_POST['marks'] ?? 0;

// Backend grade logic
function getGrade($marks) {
    if ($marks >= 90) {
        return "O";
    } elseif ($marks >= 80) {
        return "A+";
    } elseif ($marks >= 70) {
        return "A";
    } elseif ($marks >= 60) {
        return "B";
    } elseif ($marks >= 50) {
        return "C";
    } elseif ($marks >= 40) {
        return "D";
    } else {
        return "F";
    }
}

$grade = getGrade((float)$marks);

// Basic cleanup
$name = trim($name);
$subject = trim($subject);
$marks = (float)$marks;

// Prepared statement for safe insert
$stmt = $conn->prepare("INSERT INTO students (name, subject, marks, grade) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssds", $name, $subject, $marks, $grade);

if ($stmt->execute()) {
    header("Location: index.php?success=1");
    exit();
} else {
    echo "Error inserting record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>