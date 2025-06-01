<?php
session_start();

// Fungsi kirim OTP ke Telegram
function sendOtpToTelegram($otp, $chat_id) {
    $bot_token = '7552945006:AAFJYFtaYBrjdQnKOl7T1VsDYHH9iv6xLvs'; // Ganti dengan token bot Telegram Anda
    $message   = "🔐 *Kode OTP Anda:* `$otp`\n⚠️ Berlaku selama 3 menit.";
    $url       = "https://api.telegram.org/bot$bot_token/sendMessage"
               . "?chat_id=$chat_id"
               . "&parse_mode=Markdown"
               . "&text=" . urlencode($message);
    file_get_contents($url);  // Kirim pesan ke Telegram
}


// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "siksng");

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Sesuaikan dengan hash di database
    $captcha = $_POST['captcha'];

    // Verifikasi CAPTCHA
    if (!isset($_SESSION['captcha']) || $_SESSION['captcha'] !== $captcha) {
        echo "<script>alert('Kode keamanan salah!');history.back();</script>";
        exit;
    }

    // Cek username & password di database
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $koneksi->query($query);

    if ($result->num_rows === 1) {
        // Login berhasil, generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = time() + (3 * 60); // OTP berlaku 3 menit
        $_SESSION['username'] = $username;

        // Chat ID Telegram kamu (ganti dengan chat_id yang benar)
        $user_chat_id = '5759754134';  // Ganti dengan chat_id yang valid

        // Kirim OTP ke Telegram
        sendOtpToTelegram($otp, $user_chat_id);

        // Redirect ke halaman verifikasi OTP
        header('Location: otp.php');
        exit;
    } else {
        echo "<script>alert('Username atau password salah!');history.back();</script>";
        exit;
    }
}
?>
