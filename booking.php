<?php
session_start();
include 'config.php';

if(!isset($_SESSION['login'])) {
header('Location: login.php');
}

$user_id = $_SESSION['id'];
$mobil_id = $_GET['id'];

if(isset($_POST['booking'])) {

$tanggal_pinjam = $_POST['tanggal_pinjam'];
$tanggal_kembali = $_POST['tanggal_kembali'];

$mobil = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM mobil WHERE id='$mobil_id'"));

$harga = $mobil['harga_per_hari'];

$hari = (strtotime($tanggal_kembali) - strtotime($tanggal_pinjam)) / 86400;

$total = $hari * $harga;

mysqli_query($conn, "INSERT INTO booking
(user_id,mobil_id,tanggal_pinjam,tanggal_kembali,total_harga)
VALUES
('$user_id','$mobil_id','$tanggal_pinjam','$tanggal_kembali','$total')");

header('Location: my-booking.php');
}
?>

<!DOCTYPE html>
<html>
<head>
<?php include 'includes/head.php'; ?>
</head>
<body>

<div class="container mt-5" style="max-width:600px;">

<div class="card p-4 shadow">

<h2>Booking Mobil</h2>

<form method="POST">

<label>Tanggal Pinjam</label>
<input type="date" name="tanggal_pinjam" class="form-control mb-3" required>

<label>Tanggal Kembali</label>
<input type="date" name="tanggal_kembali" class="form-control mb-3" required>

<button type="submit" name="booking" class="btn btn-dark w-100">Booking</button>

</form>

</div>
</div>

</body>
</html>