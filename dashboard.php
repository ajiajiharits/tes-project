<?php
session_start();
include "config.php";

if (!isset($_SESSION["id"])) {
  header("Location: login.php");
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

$totalCourses = mysqli_num_rows(
  mysqli_query($conn, "SELECT * FROM courses")
);

if (
    $fotoUser != "default-user.svg" &&
    !file_exists("assets/uploads/" . $fotoUser)
  ) {
    $fotoUser = "default-user.svg";
}

$stmt = mysqli_prepare($conn, "
  SELECT t.*, c.nama_kursus, c.kategori, c.gambar
  FROM transactions t
  JOIN courses c ON t.course_id = c.id
  WHERE t.user_id = ?
  ORDER BY t.tanggal DESC
");

mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);

$transactions = mysqli_stmt_get_result($stmt);
$totalSubscribed = mysqli_num_rows($transactions);
// Ambil jadwal terdekat
$querySchedule = mysqli_query($conn, "
  SELECT s.*
  FROM schedules s
  JOIN transactions t ON s.course_id = t.course_id
  WHERE t.user_id = $userId
  ORDER BY s.tanggal ASC
  LIMIT 3
");

$queryJam = mysqli_query($conn, "
  SELECT SUM(c.durasi_jam) AS total_jam
  FROM transactions t
  JOIN courses c ON t.course_id = c.id
  WHERE t.user_id = $userId
");

$dataJam = mysqli_fetch_assoc($queryJam);

$totalJam = $dataJam['total_jam'];

if (!$totalJam) {
  $totalJam = 0;
}
?>

<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Dashboard - KursusKu</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="stylesheet" href="css/profile-dropdown.css">
</head>

<body class="dashboard-page">

  <div class="dashboard-wrapper">

    <aside class="dashboard-sidebar" id="sidebar">

      <div class="sidebar-brand">
        <a href="index.html">KURSUSKU</a>
        <span>Panel Pengguna</span>
      </div>

      <nav class="sidebar-menu">

        <a href="dashboard.php" class="active">
          <i class="bi bi-grid-1x2-fill"></i>
          <span>Dashboard</span>
        </a>

        <a href="profile.php">
          <i class="bi bi-person-circle"></i>
          <span>Profil</span>
        </a>

        <a href="courses.php">
          <i class="bi bi-journal-bookmark-fill"></i>
          <span>Kursus</span>
        </a>

        <a href="index.php">
          <i class="bi bi-house-door-fill"></i>
          <span>Beranda</span>
        </a>

        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") : ?>
          <a href="admin-dashboard.php">
            <i class="bi bi-speedometer2"></i>
            <span>Admin Panel</span>
          </a>
        <?php endif; ?>

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
          <h1>Dashboard</h1>
          <p>Kelola aktivitas belajar kamu di KursusKu.</p>
        </div>

        <div class="topbar-user">
          <div class="user-avatar">
            <img
              src="assets/uploads/<?php echo $fotoUser; ?>"
              alt="Foto Profil">
          </div>

          <div class="user-info">
            <strong><?php echo htmlspecialchars($nama); ?></strong>
            <span>Peserta Kursus</span>
          </div>
        </div>

      </header>

      <section class="welcome-card">
        <div>
          <span class="welcome-label">
            Selamat datang kembali
          </span>

          <h2>
            Halo, <?php echo htmlspecialchars($nama); ?> 👋
          </h2>

          <p>
            Lanjutkan pembelajaranmu hari ini dan pantau perkembangan kursus yang sedang kamu ikuti.
          </p>
        </div>

        <a href="courses.php" class="welcome-button">
          Lihat Kursus
          <i class="bi bi-arrow-right"></i>
        </a>
      </section>

      <section class="row g-4 stats-section">

        <div class="col-xl-3 col-md-6">
          <div class="stat-card">
            <div class="stat-icon green">
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
            <div class="stat-icon blue">
              <i class="bi bi-cart-check"></i>
            </div>

            <div>
              <h3><?php echo $totalSubscribed; ?></h3>
              <p>Kursus Diikuti</p>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="stat-card">
            <div class="stat-icon orange">
              <i class="bi bi-clock-history"></i>
            </div>

            <div>
              <h3><?php echo $totalJam; ?></h3>
              <p>Jam Belajar</p>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="stat-card">
            <div class="stat-icon purple">
              <i class="bi bi-award"></i>
            </div>

            <div>
              <h3><?php echo $totalSubscribed; ?></h3>
              <p>Sertifikat</p>
            </div>
          </div>
        </div>

      </section>

      <section class="row g-4 mt-1">

        <div class="col-lg-8">
          <div class="dashboard-card">

            <div class="card-heading">
              <div>
                <h3>Riwayat Langganan Kursus</h3>
                <p>Daftar kursus yang sudah kamu beli atau ikuti.</p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table align-middle dashboard-table">

                <thead>
                  <tr>
                    <th>Nama Kursus</th>
                    <th>Kategori</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>

                <tbody>
                  <?php if (mysqli_num_rows($transactions) > 0) : ?>

                    <?php mysqli_data_seek($transactions, 0); ?>

                    <?php while ($row = mysqli_fetch_assoc($transactions)) : ?>
                      <tr>
                        <td><?php echo htmlspecialchars($row["nama_kursus"]); ?></td>
                        <td><?php echo htmlspecialchars($row["kategori"]); ?></td>
                        <td>Rp<?php echo number_format($row["total_harga"], 0, ',', '.'); ?></td>
                        <td>
                          <span class="badge text-bg-success">
                            <?php echo htmlspecialchars($row["status"]); ?>
                          </span>
                        </td>
                        <td>
                          <?php echo date("d M Y", strtotime($row["tanggal"])); ?>
                        </td>
                      </tr>
                    <?php endwhile; ?>

                  <?php else : ?>

                    <tr>
                      <td colspan="5" class="text-center">
                        Belum ada transaksi. Silakan pilih kursus terlebih dahulu.
                      </td>
                    </tr>

                  <?php endif; ?>
                </tbody>

              </table>
            </div>

          </div>
        </div>

        <div class="col-lg-4">
          <div class="dashboard-card" id="jadwal">

            <div class="card-heading mb-3">
              <div>
                <h3>Jadwal Terdekat</h3>
                <p>Kegiatan belajar minggu ini.</p>
              </div>
            </div>

            <?php if(mysqli_num_rows($querySchedule) > 0) : ?>

              <?php while($schedule = mysqli_fetch_assoc($querySchedule)) : ?>

                <div class="schedule-item">

                  <div class="schedule-date">
                    <strong>
                      <?php echo date('d', strtotime($schedule['tanggal'])); ?>
                    </strong>

                    <span>
                      <?php echo date('M', strtotime($schedule['tanggal'])); ?>
                    </span>
                  </div>

                  <div>
                    <h4>
                      <?php echo htmlspecialchars($schedule['judul']); ?>
                    </h4>

                    <p>
                      <?php echo htmlspecialchars($schedule['jam']); ?>
                    </p>
                  </div>

                </div>

              <?php endwhile; ?>

            <?php else : ?>

              <p>Belum ada jadwal tersedia.</p>

            <?php endif; ?>

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
