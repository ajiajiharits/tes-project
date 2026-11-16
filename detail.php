<?php
session_start();
include 'config.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM mobil WHERE id='$id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
<?php include 'includes/head.php'; ?>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container mt-5">
<div class="row">

<div class="col-md-6">
<img src="uploads/mobil/<?php echo $data['gambar']; ?>" class="img-fluid rounded">
</div>

<div class="col-md-6">
<h2><?php echo $data['nama_mobil']; ?></h2>
<p><?php echo $data['deskripsi']; ?></p>
<h4>Rp <?php echo number_format($data['harga_per_hari']); ?>/hari</h4>

<a href="booking.php?id=<?php echo $data['id']; ?>" class="btn btn-danger">Booking Sekarang</a>

</div>
</div>
</div>

</body>
</html>