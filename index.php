<?php
session_start();
if(!isset($_SESSION['user'])){
  header("Location: login.php");
}

include 'db.php';

// Dashboard data
$total = $conn->query("SELECT COUNT(*) as t FROM students")->fetch_assoc()['t'];
$avg = $conn->query("SELECT AVG(marks) as a FROM students")->fetch_assoc()['a'];
$top = $conn->query("SELECT name, marks FROM students ORDER BY marks DESC LIMIT 1")->fetch_assoc();

// Table data
$result = $conn->query("SELECT * FROM students ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
  background:url('bg.jpg') no-repeat center/cover;
}

.overlay{
  background:rgba(0,0,0,0.7);
  min-height:100vh;
  padding:20px;
}

.card{
  border-radius:15px;
}

.table-container{
  background:white;
  border-radius:15px;
  padding:15px;
}
</style>

</head>

<body>

<div class="overlay">

<!-- Header -->
<div class="d-flex justify-content-between text-white mb-4">
  <h2>📊 Dashboard</h2>

  <div>
    <a href="form.html" class="btn btn-warning">➕ Add Result</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</div>

<!-- Cards -->
<div class="row mb-4">

  <div class="col-md-4">
    <div class="card bg-primary text-white p-3 text-center shadow">
      <h5>Total Students</h5>
      <h2><?php echo $total; ?></h2>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-success text-white p-3 text-center shadow">
      <h5>Average</h5>
      <h2><?php echo round($avg,2); ?></h2>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-danger text-white p-3 text-center shadow">
      <h5>Topper</h5>
      <h4><?php echo $top['name'] ?? 'N/A'; ?></h4>
      <p><?php echo $top['marks'] ?? 0; ?></p>
    </div>
  </div>

</div>

<!-- Table -->
<div class="table-container shadow">

  <h4 class="mb-3">📋 Student Results</h4>

  <table class="table table-hover text-center">

    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Subject</th>
        <th>Marks</th>
        <th>Grade</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>

    <?php if($result->num_rows > 0){ ?>
    
      <?php while($row = $result->fetch_assoc()){ ?>

      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['subject']; ?></td>
        <td><?php echo $row['marks']; ?></td>

        <!-- Grade Badge -->
        <td>
          <?php 
            $grade = $row['grade'];
            $badge = "bg-secondary";

            if($grade == "A+" || $grade == "A") $badge = "bg-success";
            elseif($grade == "B") $badge = "bg-primary";
            elseif($grade == "C") $badge = "bg-warning text-dark";
            else $badge = "bg-danger";
          ?>
          <span class="badge <?php echo $badge; ?>">
            <?php echo $grade; ?>
          </span>
        </td>

        <!-- Actions -->
        <td>
          <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">
            Edit
          </a>

          <a href="delete.php?id=<?php echo $row['id']; ?>" 
             class="btn btn-danger btn-sm"
             onclick="return confirm('Delete this record?')">
            Delete
          </a>
        </td>

      </tr>

      <?php } ?>

    <?php } else { ?>

      <tr>
        <td colspan="6">No Data Available</td>
      </tr>

    <?php } ?>

    </tbody>

  </table>

</div>

</div>

</body>
</html>