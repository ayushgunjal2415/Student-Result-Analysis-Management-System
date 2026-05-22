<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){
  $email = $_POST['email'];
  $pass = $_POST['password'];

  $res = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$pass'");

  if($res->num_rows > 0){
    $_SESSION['user'] = $email;
    header("Location: index.php");
  } else {
    echo "<script>alert('Invalid Login');</script>";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
  background:url('bg.jpg') no-repeat center/cover;
}
</style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow" style="width:300px;">
<h3 class="text-center">Login</h3>

<form method="POST">
<input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
<input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

<button name="login" class="btn btn-primary w-100">Login</button>

<a href="signup.php" class="text-center d-block mt-2">Create Account</a>
</form>

</div>

</body>
</html>