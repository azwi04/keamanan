<?php
session_start();
header('Content-Type: application/json');

// Cek apakah session pengguna masih valid
if (!isset($_SESSION['username'])) {
  echo json_encode(['status'=>'error','message'=>'Session tidak valid']); 
  exit;
}

// Generate OTP baru
$otp = random_int(100000,999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiry'] = time() + 180; // OTP berlaku selama 3 menit

// Fungsi untuk mengirim OTP ke Telegram
function sendOtpToTelegram($otp, $chatId) {
  $token = 'YOUR_BOT_API_KEY'; // Ganti dengan API key Telegram bot Anda
  $message = "Kode OTP Anda: $otp";
  $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&text=" . urlencode($message);
  file_get_contents($url); // Kirim request ke Telegram
}

// Kirim OTP ke Telegram
sendOtpToTelegram($otp, '5759754134'); // Ganti dengan chat ID yang sesuai

// Kembalikan respon sukses
echo json_encode([
  'status' => 'ok',
  'message' => 'OTP dikirim ulang',
  'expiry' => $_SESSION['otp_expiry']
]);
?>
