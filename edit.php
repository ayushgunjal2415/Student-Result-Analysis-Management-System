<?php
include 'db.php';

// Get ID safely
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch student data
$result = $conn->query("SELECT * FROM students WHERE id='$id'");

// Check query
if (!$result) {
    die("Query Error: " . $conn->error);
}

// Check if data exists
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    die("No record found");
}
?>

<?php

include 'db.php';

$id = $_GET['id'];

$result = $conn->query(
    "SELECT * FROM students WHERE id=$id"
);

$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Student</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">

  <!-- ✅ FIXED BACKGROUND BLUR -->
  <style>
  body {
    margin: 0;
    padding: 0;
    height: 100vh;
    background: url('form-bg.jpg') no-repeat center center/cover;
    position: relative;
  }

  /* ONLY DARK OVERLAY (NO BLUR) */
  body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;

    background: rgba(0, 0, 0, 0.5);  /* same as your add page */

    z-index: -1;
  }

  /* CARD */
  .custom-card {
    border-radius: 20px;
    background: rgba(255,255,255,0.95);
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
  }
</style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card p-4 custom-card">

    <h3 class="text-center mb-4">
      <i class="bi bi-pencil-square"></i> Edit Student
    </h3>

    <form action="update.php" method="POST">

      <!-- Hidden ID -->
      <input type="hidden" name="id" 
      value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>">

      <!-- Name -->
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-person"></i></span>
        <input type="text" name="name" class="form-control"
        value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>" required>
      </div>

      <!-- Subject -->
      <div class="input-group mb-3">

  <span class="input-group-text">
    <i class="bi bi-book"></i>
  </span>

  <select name="subject" class="form-control">

    <option value="Java"
    <?php if($row['subject']=="Java") echo "selected"; ?>>
    Java
    </option>

    <option value="DBMS"
    <?php if($row['subject']=="DBMS") echo "selected"; ?>>
    DBMS
    </option>

    <option value="OS"
    <?php if($row['subject']=="OS") echo "selected"; ?>>
    Operating System
    </option>

    <option value="CN"
    <?php if($row['subject']=="CN") echo "selected"; ?>>
    Computer Networks
    </option>

    <option value="DSA"
    <?php if($row['subject']=="DSA") echo "selected"; ?>>
    DSA
    </option>

    <option value="Python"
    <?php if($row['subject']=="Python") echo "selected"; ?>>
    Python
    </option>

  </select>

</div>

      <!-- Marks -->
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-bar-chart"></i></span>
        <input type="number" name="marks" id="marks" class="form-control"
        value="<?php echo isset($data['marks']) ? $data['marks'] : ''; ?>" required>
      </div>

      <!-- Grade -->
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-award"></i></span>
        <input type="text" name="grade" id="grade" class="form-control"
        value="<?php echo isset($data['grade']) ? $data['grade'] : ''; ?>" readonly>
      </div>

      <!-- Button -->
      <button type="submit" class="btn btn-primary update-btn w-100">
        Update Student
      </button>

    </form>

  </div>
</div>

<!-- Auto Grade Script -->
<script>
function calculateGrade(marks) {
    if (marks >= 90) return "A+";
    else if (marks >= 80) return "A";
    else if (marks >= 60) return "B";
    else if (marks >= 50) return "C";
    else if (marks >= 35) return "D";
    else return "F";
}

document.getElementById("marks").addEventListener("input", function() {
    document.getElementById("grade").value = calculateGrade(this.value);
});
</script>

</body>
</html>