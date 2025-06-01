<?php
session_start();

if ($_POST['captcha'] != $_SESSION['captcha']) {
    die("Captcha salah, silakan coba lagi.");
}

// Lanjut proses login...
?>
