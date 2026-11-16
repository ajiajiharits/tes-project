<?php
session_start();
include 'config.php';

$error = "";

if(isset($_POST['login'])) {

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

if(mysqli_num_rows($query) > 0) {

$user = mysqli_fetch_assoc($query);

if(password_verify($password, $user['password'])) {

$_SESSION['login'] = true;
$_SESSION['id'] = $user['id'];
$_SESSION['nama'] = $user['nama'];
$_SESSION['role'] = $user['role'];

if($user['role'] == 'admin') {
header('Location: admin-dashboard.php');
} else {
header('Location: index.php');
}

} else {
$error = "Password salah";
}

} else {
$error = "Email tidak ditemukan";
}
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

<h2 class="text-center mb-4">Login</h2>

<?php if($error != "") : ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">

<input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<button type="submit" name="login" class="btn btn-dark w-100">Login</button>

</form>

</div>
</div>

</body>
</html>