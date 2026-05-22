<?php
include 'db.php';

if(isset($_POST['signup'])){
  $email = $_POST['email'];
  $pass = $_POST['password'];

  $conn->query("INSERT INTO users(email,password) VALUES('$email','$pass')");
  header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Signup</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow" style="width:300px;">
<h3 class="text-center">Signup</h3>

<form method="POST">
<input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
<input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

<button name="signup" class="btn btn-success w-100">Signup</button>
</form>

</div>

</body>
</html>