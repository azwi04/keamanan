<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil</title>
</head>
<body>
  <h2>Edit Profil untuk <?= htmlspecialchars($_SESSION['username']) ?></h2>
  <p>Halaman ini masih dalam pengembangan.</p>
  <a href="dashboard.php">← Kembali ke Dashboard</a>
</body>
</html>
