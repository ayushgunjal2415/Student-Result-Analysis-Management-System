<?php
session_start();

if(!isset($_SESSION['user'])){
  header("Location: login.php");
}

include 'db.php';

// Grade helper
function getGrade($marks){
    if($marks >= 90){
        return "O";
    }
    elseif($marks >= 80){
        return "A+";
    }
    elseif($marks >= 70){
        return "A";
    }
    elseif($marks >= 60){
        return "B";
    }
    elseif($marks >= 50){
        return "C";
    }
    elseif($marks >= 40){
        return "D";
    }
    else{
        return "F";
    }
}

// Dashboard data
$total = $conn->query(
    "SELECT COUNT(*) as t FROM students"
)->fetch_assoc()['t'];

$avg = $conn->query(
    "SELECT AVG(marks) as a FROM students"
)->fetch_assoc()['a'];

$top = $conn->query(
    "SELECT name, marks FROM students 
     ORDER BY marks DESC LIMIT 1"
)->fetch_assoc();

// Chart data - subject average
$subjectData = $conn->query("
    SELECT subject, AVG(marks) as avg_marks
    FROM students
    GROUP BY subject
");

$subjects = [];
$averages = [];

while($row = $subjectData->fetch_assoc()){
    $subjects[] = $row['subject'];
    $averages[] = round($row['avg_marks'], 2);
}

// Chart data - grade distribution from marks
$gradeData = $conn->query("
    SELECT grade_label, COUNT(*) as total
    FROM (
        SELECT CASE
            WHEN marks >= 90 THEN 'O'
            WHEN marks >= 80 THEN 'A+'
            WHEN marks >= 70 THEN 'A'
            WHEN marks >= 60 THEN 'B'
            WHEN marks >= 50 THEN 'C'
            WHEN marks >= 40 THEN 'D'
            ELSE 'F'
        END AS grade_label
        FROM students
    ) AS g
    GROUP BY grade_label
");

$grades = [];
$totals = [];

while($row = $gradeData->fetch_assoc()){
    $grades[] = $row['grade_label'];
    $totals[] = $row['total'];
}

// Table data
$subject = "";
$search = "";
$sort = "";

if(isset($_GET['subject'])){
    $subject = $_GET['subject'];
}

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

if(isset($_GET['sort'])){
    $sort = $_GET['sort'];
}

$sql = "SELECT * FROM students WHERE 1";

if($subject != ""){
    $sql .= " AND subject='$subject'";
}

if($search != ""){
    $sql .= " AND (
        name LIKE '%$search%'
        OR subject LIKE '%$search%'
    )";
}

if($sort == "high"){
    $sql .= " ORDER BY marks DESC";
}
elseif($sort == "low"){
    $sql .= " ORDER BY marks ASC";
}
else{
    $sql .= " ORDER BY id ASC";
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

    .table td,
    .table th{
      vertical-align: middle;
    }

    .badge{
      font-size: 14px;
      padding: 6px 12px;
      border-radius: 10px;
    }

    .chart-card{
      background: white;
      border-radius: 15px;
      padding: 15px;
    }

    .chart-card{
  background: white;
  border-radius: 15px;
  padding: 15px;
  height: 420px;
}

.chart-box{
  position: relative;
  height: 340px;
}
  </style>
</head>

<body>

<div class="overlay">

  <!-- Header -->
  <div class="d-flex justify-content-between text-white mb-4">

    <h2>📊 Dashboard</h2>

    <div>
      <a href="form.html" class="btn btn-warning">
        ➕ Add Result
      </a>

      <a href="export_pdf.php" class="btn btn-info">
  📄 Export PDF
</a>

      <a href="logout.php" class="btn btn-danger">
        Logout
      </a>
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

  <?php if(isset($_GET['success'])){ ?>

<div class="alert alert-success alert-dismissible fade show shadow" role="alert">

  ✅ Student record added successfully!

  <button type="button"
          class="btn-close"
          data-bs-dismiss="alert">
  </button>

</div>

<?php } ?>

  <!-- Table -->
  <div class="table-container shadow">

    <h4 class="mb-3">📋 Student Results</h4>

    <form method="GET" class="mb-3">
      <div class="row g-2">

        <!-- SEARCH -->
        <div class="col-md-4">
          <input type="text"
                 name="search"
                 class="form-control"
                 placeholder="Search by name or subject"
                 value="<?php echo $search; ?>">
        </div>

        <!-- SUBJECT FILTER -->
        <div class="col-md-3">
          <select name="subject" class="form-select">
            <option value="">All Subjects</option>

            <option value="Java" <?php if($subject=="Java") echo "selected"; ?>>Java</option>
            <option value="DBMS" <?php if($subject=="DBMS") echo "selected"; ?>>DBMS</option>
            <option value="OS" <?php if($subject=="OS") echo "selected"; ?>>OS</option>
            <option value="CN" <?php if($subject=="CN") echo "selected"; ?>>CN</option>
            <option value="DSA" <?php if($subject=="DSA") echo "selected"; ?>>DSA</option>
            <option value="Python" <?php if($subject=="Python") echo "selected"; ?>>Python</option>
          </select>
        </div>

        <!-- SORT -->
        <div class="col-md-3">
          <select name="sort" class="form-select">
            <option value="">Sort By Marks</option>
            <option value="high" <?php if($sort=="high") echo "selected"; ?>>Highest Marks</option>
            <option value="low" <?php if($sort=="low") echo "selected"; ?>>Lowest Marks</option>
          </select>
        </div>

        <!-- BUTTON -->
        <div class="col-md-2 d-grid">
          <button type="submit" class="btn btn-primary">
            Search / Filter
          </button>
        </div>

      </div>
    </form>

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
              <td class="align-middle">
                <?php
                  $grade = getGrade((float)$row['marks']);

                  $badge = "bg-secondary";

                  if($grade == "O"){
                      $badge = "bg-dark";
                  }
                  elseif($grade == "A+"){
                      $badge = "bg-success";
                  }
                  elseif($grade == "A"){
                      $badge = "bg-primary";
                  }
                  elseif($grade == "B"){
                      $badge = "bg-info text-dark";
                  }
                  elseif($grade == "C"){
                      $badge = "bg-warning text-dark";
                  }
                  elseif($grade == "D"){
                      $badge = "bg-secondary";
                  }
                  else{
                      $badge = "bg-danger";
                  }
                ?>

                <span class="badge <?php echo $badge; ?> px-3 py-2">
                  <?php echo $grade; ?>
                </span>
              </td>

              <!-- Action Buttons -->
              <td class="align-middle">
                <a href="edit.php?id=<?php echo $row['id']; ?>"
                   class="btn btn-success btn-sm">
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

  <!-- Charts Section -->
  <!-- Charts Section -->
<div class="row mt-4">

  <div class="col-md-6 mb-3">
    <div class="chart-card shadow">
      <h4 class="text-center mb-3">📊 Subject Wise Average</h4>
      <div class="chart-box">
        <canvas id="subjectChart"></canvas>
      </div>
    </div>
  </div>

  <div class="col-md-6 mb-3">
    <div class="chart-card shadow">
      <h4 class="text-center mb-3">🎯 Grade Distribution</h4>
      <div class="chart-box">
        <canvas id="gradeChart"></canvas>
      </div>
    </div>
  </div>

</div>

<script>
const subjectCtx = document.getElementById('subjectChart').getContext('2d');

new Chart(subjectCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($subjects); ?>,
        datasets: [{
            label: 'Average Marks',
            data: <?php echo json_encode($averages); ?>,
            backgroundColor: [
                '#667eea',
                '#764ba2',
                '#49a09d',
                '#ff6b6b',
                '#feca57',
                '#1dd1a1'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});

const gradeCtx = document.getElementById('gradeChart').getContext('2d');

new Chart(gradeCtx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($grades); ?>,
        datasets: [{
            data: <?php echo json_encode($totals); ?>,
            backgroundColor: [
                '#222f3e',
                '#10ac84',
                '#2e86de',
                '#feca57',
                '#ff9f43',
                '#ee5253'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>