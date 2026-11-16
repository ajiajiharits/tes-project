<?php
session_start();
include 'config.php';
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

<?php
$query = mysqli_query($conn, "SELECT * FROM mobil");

while($data = mysqli_fetch_assoc($query)) :
?>

<div class="col-md-4 mb-4">
<div class="card shadow">

<img src="uploads/mobil/<?php echo $data['gambar']; ?>" class="card-img-top">

<div class="card-body">
<h5><?php echo $data['nama_mobil']; ?></h5>
<p><?php echo $data['merk']; ?></p>
<p>Rp <?php echo number_format($data['harga_per_hari']); ?>/hari</p>

<a href="detail.php?id=<?php echo $data['id']; ?>" class="btn btn-dark w-100">Detail</a>

</div>
</div>
</div>

<?php endwhile; ?>

</div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>