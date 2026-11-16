<?php
session_start();
include "config.php";

if (!isset($_SESSION["id"])) {
  header("Location: login.php");
  exit();
}

if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
  header("Location: dashboard.php");
  exit();
}

$nama = $_SESSION["nama"];

$userId = (int) $_SESSION["id"];

$queryFoto = mysqli_query($conn, "
  SELECT foto FROM users
  WHERE id=$userId
");

$dataFoto = mysqli_fetch_assoc($queryFoto);

$fotoUser = "profile-default.png";

if ($dataFoto && !empty($dataFoto["foto"])) {
  $fotoUser = $dataFoto["foto"];
}

if (!file_exists("assets/uploads/" . $fotoUser)) {
  $fotoUser = "profile-default.png";
}

if (
    $fotoUser != "default-user.svg" &&
    !file_exists("assets/uploads/" . $fotoUser)
  ) {
    $fotoUser = "default-user.svg";
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama_kursus = $_POST["nama_kursus"];
  $kategori = $_POST["kategori"];
  $harga = $_POST["harga"];
  $deskripsi = $_POST["deskripsi"];
  $gambar = $_POST["gambar"];

  $query = "INSERT INTO courses (nama_kursus, kategori, harga, deskripsi, gambar)
            VALUES ('$nama_kursus', '$kategori', '$harga', '$deskripsi', '$gambar')";

  if (mysqli_query($conn, $query)) {
    $message = "Kursus berhasil ditambahkan!";
  } else {
    $message = "Gagal menambahkan kursus: " . mysqli_error($conn);
  }
}

$totalUsers = mysqli_num_rows(
  mysqli_query($conn, "SELECT * FROM users WHERE role = 'user'")
);

$totalCourses = mysqli_num_rows(
  mysqli_query($conn, "SELECT * FROM courses")
);

$totalTransactions = mysqli_num_rows(
  mysqli_query($conn, "SELECT * FROM transactions")
);

$queryPendapatan = mysqli_query($conn, "
  SELECT SUM(total_harga) AS total_pendapatan
  FROM transactions
");

$dataPendapatan = mysqli_fetch_assoc($queryPendapatan);
$totalPendapatan = $dataPendapatan["total_pendapatan"] ? $dataPendapatan["total_pendapatan"] : 0;

$courses = mysqli_query($conn, "
  SELECT * FROM courses
  ORDER BY id DESC
");

$transactions = mysqli_query($conn, "
  SELECT 
    transactions.*,
    users.nama,
    users.email,
    courses.nama_kursus
  FROM transactions
  JOIN users ON transactions.user_id = users.id
  JOIN courses ON transactions.course_id = courses.id
  ORDER BY transactions.tanggal DESC
");
?>

<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Admin Dashboard - KursusKu</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body class="dashboard-page">

  <div class="dashboard-wrapper">

    <aside class="dashboard-sidebar" id="sidebar">

      <div class="sidebar-brand">
        <a href="index.php">KURSUSKU</a>
        <span>Panel Admin</span>
      </div>

      <nav class="sidebar-menu">

        <a href="admin-dashboard.php" class="active">
          <i class="bi bi-speedometer2"></i>
          <span>Dashboard Admin</span>
        </a>

        <a href="#data-kursus">
          <i class="bi bi-journal-bookmark-fill"></i>
          <span>Kelola Kursus</span>
        </a>

        <a href="#data-transaksi">
          <i class="bi bi-receipt"></i>
          <span>Transaksi</span>
        </a>

        <a href="index.php">
          <i class="bi bi-house-door-fill"></i>
          <span>Beranda</span>
        </a>

        <a href="logout.php" class="logout-link">
          <i class="bi bi-box-arrow-right"></i>
          <span>Keluar</span>
        </a>

      </nav>

    </aside>

    <div class="dashboard-main">

      <header class="dashboard-topbar">

        <button class="sidebar-toggle" type="button" id="sidebarToggle">
          <i class="bi bi-list"></i>
        </button>

        <div>
          <h1>Dashboard Admin</h1>
          <p>Kelola kursus, transaksi, dan aktivitas pengguna KursusKu.</p>
        </div>

        <div class="topbar-user">
          <div class="user-avatar">
            <img
              src="assets/uploads/<?php echo $fotoUser; ?>"
              alt="Foto Profil">
          </div>

          <div class="user-info">
            <strong><?php echo htmlspecialchars($nama); ?></strong>
            <span>Administrator</span>
          </div>
        </div>

      </header>

      <section class="welcome-card">
        <div>
          <span class="welcome-label">
            Selamat datang admin
          </span>

          <h2>
            Halo, <?php echo htmlspecialchars($nama); ?> 👋
          </h2>

          <p>
            Pantau data kursus, transaksi pengguna, dan aktivitas platform KursusKu dari halaman ini.
          </p>
        </div>

        <a href="#data-kursus" class="welcome-button">
          Kelola Kursus
          <i class="bi bi-arrow-right"></i>
        </a>
      </section>

      <section class="row g-4 stats-section">

        <div class="col-xl-3 col-md-6">
          <div class="stat-card">
            <div class="stat-icon green">
              <i class="bi bi-people"></i>
            </div>

            <div>
              <h3><?php echo $totalUsers; ?></h3>
              <p>Total User</p>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="stat-card">
            <div class="stat-icon blue">
              <i class="bi bi-book"></i>
            </div>

            <div>
              <h3><?php echo $totalCourses; ?></h3>
              <p>Total Kursus</p>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="stat-card">
            <div class="stat-icon orange">
              <i class="bi bi-cart-check"></i>
            </div>

            <div>
              <h3><?php echo $totalTransactions; ?></h3>
              <p>Total Transaksi</p>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="stat-card">
            <div class="stat-icon purple">
              <i class="bi bi-cash-stack"></i>
            </div>

            <div>
              <h3>Rp<?php echo number_format($totalPendapatan, 0, ',', '.'); ?></h3>
              <p>Pendapatan</p>
            </div>
          </div>
        </div>

      </section>

      <section class="row g-4 mt-1">

        <div class="col-lg-12">
            <?php if ($message != "") : ?>
                <div class="alert alert-info">
                    <?php echo $message; ?>
                </div>
                <?php endif; ?>

                <div class="dashboard-card mb-4" id="tambah-kursus">
                <div class="card-heading">
                    <div>
                    <h3>Tambah Kursus</h3>
                    <p>Tambahkan kursus baru ke dalam website KursusKu.</p>
                    </div>
                </div>

                <form method="POST">
                    <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Kursus</label>
                        <input type="text" name="nama_kursus" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Gambar</label>
                        <input type="text" name="gambar" class="form-control" placeholder="course-1.jpg" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                    </div>

                    </div>

                    <button type="submit" class="btn btn-success rounded-pill">
                    Tambah Kursus
                    </button>
                </form>
            </div>
          <div class="dashboard-card" id="data-kursus">

            <div class="card-heading">
              <div>
                <h3>Data Kursus</h3>
                <p>Daftar kursus yang tersedia di KursusKu.</p>
              </div>
            </div>

            <div class="table-responsive">

              <table class="table align-middle dashboard-table">

                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama Kursus</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                  </tr>
                </thead>

                <tbody>
                  <?php if (mysqli_num_rows($courses) > 0) : ?>

                    <?php while ($course = mysqli_fetch_assoc($courses)) : ?>
                      <tr>
                        <td><?php echo $course["id"]; ?></td>

                        <td><?php echo htmlspecialchars($course["nama_kursus"]); ?></td>

                        <td><?php echo htmlspecialchars($course["kategori"]); ?></td>

                        <td>
                          Rp<?php echo number_format($course["harga"], 0, ',', '.'); ?>
                        </td>

                        <td><?php echo htmlspecialchars($course["gambar"]); ?></td>

                        <td>
                          <a
                            href="admin-delete-course.php?id=<?php echo $course['id']; ?>"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Yakin ingin menghapus kursus ini?')">
                            Hapus
                          </a>
                        </td>
                      </tr>
                    <?php endwhile; ?>

                  <?php else : ?>

                    <tr>
                      <td colspan="6" class="text-center">
                        Belum ada data kursus.
                      </td>
                    </tr>

                  <?php endif; ?>
                </tbody>

              </table>

            </div>

          </div>

        </div>

        <div class="col-lg-12">

          <div class="dashboard-card" id="data-transaksi">

            <div class="card-heading">
              <div>
                <h3>Data Transaksi</h3>
                <p>Riwayat pembelian kursus oleh pengguna.</p>
              </div>
            </div>

            <div class="table-responsive">

              <table class="table align-middle dashboard-table">

                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Kursus</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>

                <tbody>
                  <?php if (mysqli_num_rows($transactions) > 0) : ?>

                    <?php while ($trx = mysqli_fetch_assoc($transactions)) : ?>
                      <tr>
                        <td><?php echo $trx["id"]; ?></td>

                        <td><?php echo htmlspecialchars($trx["nama"]); ?></td>

                        <td><?php echo htmlspecialchars($trx["email"]); ?></td>

                        <td><?php echo htmlspecialchars($trx["nama_kursus"]); ?></td>

                        <td>
                          Rp<?php echo number_format($trx["total_harga"], 0, ',', '.'); ?>
                        </td>

                        <td>
                          <span class="badge text-bg-success">
                            <?php echo htmlspecialchars($trx["status"]); ?>
                          </span>
                        </td>

                        <td>
                          <?php echo date("d M Y", strtotime($trx["tanggal"])); ?>
                        </td>
                      </tr>
                    <?php endwhile; ?>

                  <?php else : ?>

                    <tr>
                      <td colspan="7" class="text-center">
                        Belum ada transaksi.
                      </td>
                    </tr>

                  <?php endif; ?>
                </tbody>

              </table>

            </div>

          </div>

        </div>

      </section>

    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");

    if (sidebarToggle) {
      sidebarToggle.addEventListener("click", function () {
        sidebar.classList.toggle("active");
      });
    }
  </script>

</body>
</html>