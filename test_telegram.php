<?php
// test_telegram.php
// Hanya untuk debugging koneksi ke Telegram API

$bot_token = '7552945006:AAFJYFtaYBrjdQnKOl7T1VsDYHH9iv6xLvs';
$chat_id   = '5759754134';
$message   = '🚀 Tes pengiriman pesan dari server!';

$url = "https://api.telegram.org/bot$bot_token/sendMessage"
     . "?chat_id=$chat_id"
     . "&text=" . urlencode($message);

// Coba menggunakan file_get_contents
$response1 = @file_get_contents($url);
var_dump('file_get_contents response:', $response1);

// Coba menggunakan cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$response2 = curl_exec($ch);
$error     = curl_error($ch);
curl_close($ch);
var_dump('cURL response:', $response2, 'cURL error:', $error);
