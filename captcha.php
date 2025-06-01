<?php
session_start();

// Fungsi untuk menghasilkan 4 karakter acak (huruf dan angka)
function generateCaptchaText() {
    $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $captcha_text = '';

    for ($i = 0; $i < 4; $i++) {
        $captcha_text .= $karakter[mt_rand(0, strlen($karakter) - 1)];
    }

    return $captcha_text;
}

// Generate CAPTCHA text
$strtampil = generateCaptchaText();
$_SESSION['captcha'] = $strtampil;

// Buat gambar CAPTCHA
$lebar = 150;
$tinggi = 60;
$gambar = imagecreatetruecolor($lebar, $tinggi);

// Background acak
$bg_red   = mt_rand(200, 255);
$bg_green = mt_rand(200, 255);
$bg_blue  = mt_rand(200, 255);
$bg = imagecolorallocate($gambar, $bg_red, $bg_green, $bg_blue);
imagefill($gambar, 0, 0, $bg);

// Warna teks acak
$warna_teks = imagecolorallocate($gambar, mt_rand(100, 255), mt_rand(100, 255), mt_rand(100, 255));

// Font dan ukuran
$font = 'arial.ttf'; // Pastikan font ini tersedia
$ukuran_font = 28;

// Posisi awal huruf
$startX = 15;
$startY = 42;
$jarak = 28;
$amplitudo = 5;

$panjang = strlen($strtampil);
$mid = ($panjang - 1) / 2;

for ($i = 0; $i < $panjang; $i++) {
    $huruf = $strtampil[$i];
    $offsetX = $startX + $i * $jarak;
    $offsetY = $startY + sin(deg2rad(($i - $mid) * 15)) * $amplitudo;

    imagettftext($gambar, $ukuran_font, mt_rand(-15, 15), $offsetX, $offsetY, $warna_teks, $font, $huruf);
}

// Tambahkan noise
for ($i = 0; $i < 300; $i++) {
    $noise_color = imagecolorallocate($gambar, mt_rand(100, 200), mt_rand(100, 200), mt_rand(100, 200));
    imagesetpixel($gambar, mt_rand(0, $lebar), mt_rand(0, $tinggi), $noise_color);
}

// Header dan output
header("Content-type: image/png");
imagepng($gambar);
imagedestroy($gambar);

// Jika form login disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];

    // Verifikasi CAPTCHA
    if ($captcha != $_SESSION['captcha']) {
        echo "Kode CAPTCHA salah!";
    } else {
        // Cek kredensial username dan password di database
        // Gantilah bagian ini sesuai dengan kebutuhan dan keamanan aplikasi Anda
        $stored_username = "admin";
        $stored_password = "admin123"; // Ini sebaiknya di-hash (MD5, SHA256, atau lainnya)

        if ($username === $stored_username && $password === $stored_password) {
            echo "Login berhasil!";
            // Lakukan proses login lebih lanjut seperti menyimpan sesi atau redirect
        } else {
            echo "Username atau password salah!";
        }
    }
}

?>
