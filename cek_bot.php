<?php
// Ganti <token> dengan token bot Telegram kamu
$token = '123456789:AAExampleTokenDiSini';
$url = "https://api.telegram.org/bot$token/getMe";

// Coba ambil data dari Telegram API
$response = file_get_contents($url);

// Tampilkan hasilnya
var_dump($response);
