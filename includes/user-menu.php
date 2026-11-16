<?php if (isset($_SESSION['nama'])) : ?>
  <?php $namaDepan = explode(' ', trim($_SESSION['nama']))[0]; ?>
  <div class="profile-dropdown">
    <button class="profile-btn" type="button" id="profileToggle" aria-label="Buka menu profil">
      <img src="assets/img/trainers/trainer-1-2.jpg" alt="Foto profil">
      <span><?= htmlspecialchars($namaDepan); ?></span>
      <i class="bi bi-chevron-down"></i>
    </button>

    <div class="profile-menu" id="profileMenu">
      <a href="dashboard.php" class="profile-menu-item">
        <i class="bi bi-person-circle"></i>
        <span>Dashboard</span>
      </a>

      <a href="logout.php" class="profile-menu-item logout">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
      </a>
    </div>
  </div>
<?php else : ?>
  <a class="btn-getstarted" href="login.php">Masuk</a>
<?php endif; ?>
