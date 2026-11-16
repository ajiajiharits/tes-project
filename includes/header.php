<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include "config.php";
?>

<header id="header" class="header d-flex align-items-center sticky-top">

  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    <a href="index.php" class="logo d-flex align-items-center me-auto">
      <h1 class="sitename">KURSUSKU</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>

        <li>
          <a href="index.php">Beranda</a>
        </li>

        <li>
          <a href="about.php">Tentang</a>
        </li>

        <li>
          <a href="courses.php">Kursus</a>
        </li>

        <li>
          <a href="trainers.php">Pengajar</a>
        </li>

        <li>
          <a href="pricing.php">Langganan</a>
        </li>

        <li>
          <a href="contact.php">Kontak</a>
        </li>

      </ul>

      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <?php if (isset($_SESSION['nama'])) : ?>

  <?php
  $queryFoto = mysqli_query($conn, "
    SELECT foto FROM users
    WHERE id=" . $_SESSION['id']
  );

  $dataFoto = mysqli_fetch_assoc($queryFoto);

  $fotoUser = "profile-default.png";

  if ($dataFoto && !empty($dataFoto['foto'])) {
    $fotoUser = $dataFoto['foto'];
  }

  if (
    $fotoUser != "default-user.svg" &&
    !file_exists("assets/uploads/" . $fotoUser)
  ) {
    $fotoUser = "default-user.svg";
}
  ?>

  <div class="profile-dropdown">

    <button class="profile-btn" type="button" id="profileBtn">

      <div class="profile-image-wrapper">
        <img
          src="assets/uploads/<?php echo $fotoUser; ?>"
          alt="Profil">
      </div>

      <span>
        <?php echo explode(' ', $_SESSION['nama'])[0]; ?>
      </span>

      <i class="bi bi-chevron-down"></i>

    </button>

    <div class="profile-menu" id="profileMenu">

      <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") : ?>

        <a href="admin-dashboard.php" class="profile-menu-item">
          <i class="bi bi-speedometer2"></i>
          <span>Dashboard Admin</span>
        </a>

      <?php else : ?>

        <a href="dashboard.php" class="profile-menu-item">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>

      <?php endif; ?>

      <a href="logout.php" class="profile-menu-item logout">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
      </a>

    </div>

  </div>

<?php else : ?>

  <a class="btn-getstarted" href="login.php">
    Masuk
  </a>

<?php endif; ?>

  </div>
<!-- Backsound -->
<audio id="bgMusic" loop>
  <source src="assets/music/backsound.mp3" type="audio/mp3">
</audio>

<!-- Tombol Music -->
<button id="musicToggle" class="music-btn">
  <i class="bi bi-volume-mute-fill"></i>
</button>

</header>