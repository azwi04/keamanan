<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = "HAZIMI";
    $_SESSION['nik'] = "1108062804770001";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Pengisi Data Desa</title>
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f8f9fa;
    }
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 260px;
      height: 100vh;
      background: #fff;
      border-right: 1px solid #ddd;
      padding: 20px 15px;
    }
    .logo img {
      width: 100%;
      max-width: 160px;
      margin: 0 auto 20px;
      display: block;
    }
    .user-info h3 {
      margin: 5px 0 2px;
      font-size: 15px;
      font-weight: bold;
    }
    .user-info p {
      font-size: 12px;
      color: gray;
      margin: 0;
    }
    .menu {
      display: flex;
      flex-direction: column;
      gap: 10px;
      font-family: sans-serif;
    }
    .menu a {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #333;
      font-size: 14px;
      padding: 6px 10px;
      border-radius: 6px;
    }
    .menu a:hover {
      background: #f0f0f0;
    }
    .topbar {
      margin-left: 260px;
      height: 60px;
      background: #0074cc;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 30px;
      font-size: 15px;
      position: relative;
    }
    .content {
      margin-left: 260px;
      padding: 30px;
      display: flex;
      gap: 20px;
    }
    .welcome-card {
      flex: 1;
      background: #cce5ff;
      padding: 20px;
      border-radius: 10px;
      display: flex;
      align-items: center;
    }
    .welcome-card .avatar {
      width: 100px;
      height: 100px;
      background: #b3d7ff;
      border-radius: 10px;
      margin-right: 20px;
    }
    .note {
      flex: 1;
      background: #fff;
      border-left: 6px solid #0074cc;
      padding: 20px;
      border-radius: 8px;
      font-size: 14px;
    }
    .note strong {
      font-weight: bold;
      display: block;
      margin-bottom: 10px;
    }

    /* Dropdown Profil */
    .profile-wrapper {
      position: relative;
      cursor: pointer;
    }

    .profile-icon {
      font-size: 18px;
    }

    .dropdown {
      position: absolute;
      top: 60px;
      right: 30px;
      background: white;
      border: 1px solid #ccc;
      border-radius: 5px;
      display: none;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      z-index: 1000;
    }

    .dropdown a {
      display: block;
      padding: 10px 15px;
      color: #333;
      text-decoration: none;
    }

    .dropdown a:hover {
      background: #f0f0f0;
    }
  </style>

  <script>
    function toggleDropdown() {
      var dropdown = document.getElementById("dropdownMenu");
      dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    window.onclick = function(event) {
      if (!event.target.matches('.profile-icon')) {
        var dropdown = document.getElementById("dropdownMenu");
        if (dropdown && dropdown.style.display === "block") {
          dropdown.style.display = "none";
        }
      }
    }
  </script>
</head>
<body>

<div class="sidebar">
  <div class="logo">
    <img src="Logo SIKS.png" alt="SIKS Logo">
  </div>
  <div class="user-info">
    <h3><?= htmlspecialchars($_SESSION['username']) ?></h3>
    <p>Pengisi Data Desa</p>
  </div>
  <div class="menu">
    <!-- (menu sama seperti sebelumnya, dipersingkat di sini) -->
    <a href="#">DTKS</a>
    <a href="#">Daftar Usulan Dibatalkan</a>
    <a href="#">Unduh</a>
    <a href="#">Perbaikan Data</a>
    <a href="#">PBI JK</a>
    <a href="#">Verifikasi Usulan</a>
  </div>
</div>

<div class="topbar">
  <div>PENGISI DATA DESA</div>
  <div class="profile-wrapper" onclick="toggleDropdown()">
    <span><?= date('d M Y') ?> 🔔 <span class="profile-icon">👤</span></span>
    <div id="dropdownMenu" class="dropdown">
      <a href="edit_profil.php">Edit Profil</a>
      <a href="logout.php">Keluar</a>
    </div>
  </div>
</div>

<div class="content">
  <div class="welcome-card">
    <div class="avatar"></div>
    <div>
      <h3>Selamat Datang, Operator Desa <?= htmlspecialchars($_SESSION['username']) ?></h3>
    </div>
  </div>

  <div class="note">
    <strong>Catatan Penting</strong>
    Sehubungan akan digunakannya DTSEN sebagai sumber data Bantuan dan Jaminan Sosial Triwulan 2 maka fitur Kelayakan dan Usulan akan ditutup sementara.
  </div>
</div>

</body>
</html>
