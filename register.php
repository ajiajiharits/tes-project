<?php
include 'config.php';

if(isset($_POST['register'])) {

$nama = $_POST['nama'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

mysqli_query($conn, "INSERT INTO users(nama,email,password)
VALUES('$nama','$email','$password')");

header('Location: login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
<?php include 'includes/head.php'; ?>
</head>
<body>

<div class="container mt-5" style="max-width:500px;">

<div class="card p-4 shadow">

<h2 class="text-center mb-4">Register</h2>

<form method="POST">

<input type="text" name="nama" class="form-control mb-3" placeholder="Nama" required>

<input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<button type="submit" name="register" class="btn btn-danger w-100">Register</button>

</form>

</div>
</div>

</body>
</html>