<?php
include 'db.php';

// Check if form submitted
if(isset($_POST['id'])){

    $id = $_POST['id'];
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];
    $grade = $_POST['grade'];

    // Basic validation
    if(empty($name) || empty($subject) || empty($marks)){
        echo "All fields are required!";
        exit();
    }

    // Prepared statement (SAFE)
    $stmt = $conn->prepare("UPDATE students SET name=?, subject=?, marks=?, grade=? WHERE id=?");
    $stmt->bind_param("ssisi", $name, $subject, $marks, $grade, $id);

    if($stmt->execute()){
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record!";
    }

}
?>