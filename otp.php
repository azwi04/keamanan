<?php
session_start();

// Jika belum generate OTP, kembali ke login
if (!isset($_SESSION['otp'])) {
    header('Location: login.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['otp']);
    if (time() > $_SESSION['otp_expiry']) {
        $error = 'Kode OTP sudah kadaluarsa.';
    } elseif ($input !== (string)$_SESSION['otp']) {
        $error = 'Kode OTP salah.';
    } else {
        unset($_SESSION['otp'], $_SESSION['otp_expiry']);
        header('Location: dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Verifikasi OTP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f2f5;
    }
    .modal {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
      background-color: #fff;
      padding: 30px 25px;
      border-radius: 16px;
      width: 90%;
      max-width: 420px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      text-align: center;
    }
    .modal-content h3 {
      margin: 0;
      font-size: 18px;
      font-weight: bold;
    }
    .modal-content p.desc {
      margin-top: 10px;
      font-size: 14px;
      color: #333;
    }
    .otp-input {
      display: flex;
      justify-content: space-between;
      margin: 20px 0;
    }
    .otp-input input {
      width: 38px;
      height: 46px;
      text-align: center;
      font-size: 20px;
      border: none;
      border-bottom: 2px dashed #999;
      outline: none;
    }
    .submit-btn {
      background-color: #007bff;
      color: white;
      padding: 10px 18px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      margin-top: 10px;
    }
    .error {
      color: red;
      font-size: 13px;
      margin-top: 8px;
    }
    #otp-countdown {
      color: red;
      font-size: 13px;
      margin-top: 16px;
    }
    .resend-text {
      color: #888;
      font-size: 13px;
      margin-top: 4px;
      cursor: pointer;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="modal">
    <div class="modal-content">
      <h3>Silahkan Masukkan Kode OTP untuk<br>Proses Verifikasi</h3>
      <p class="desc">Kode OTP sudah dikirim ke akun telegram</p>

      <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="otp-input">
          <?php for ($i = 0; $i < 6; $i++): ?>
            <input type="text" name="otp_digit[]" maxlength="1" inputmode="numeric" pattern="[0-9]*" required />
          <?php endfor; ?>
        </div>
        <input type="hidden" name="otp" id="fullOtp">
        <button type="submit" class="submit-btn">Proses Validasi</button>
      </form>

      <div id="otp-countdown"></div>
      <div class="resend-text" onclick="resendOTP()">Kirim ulang OTP</div>
    </div>
  </div>

  <script>
    // Fokus dan auto-advance input OTP
    document.addEventListener("DOMContentLoaded", function () {
      const inputs = document.querySelectorAll(".otp-input input");
      inputs[0].focus();
      inputs.forEach((input, idx) => {
        input.addEventListener("input", () => {
          if (input.value.length === 1 && idx < inputs.length - 1) {
            inputs[idx + 1].focus();
          }
        });
      });
      startCountdown(<?= $_SESSION['otp_expiry'] ?> * 1000);
    });

    // Gabungkan digit sebelum submit
    document.querySelector("form").addEventListener("submit", function () {
      const digits = document.querySelectorAll("input[name='otp_digit[]']");
      document.getElementById("fullOtp").value = Array.from(digits).map(i => i.value).join('');
    });

    // Countdown timer (expiryTime dalam ms)
    function startCountdown(expiryTime) {
      const countdownEl = document.getElementById("otp-countdown");
      let remaining = expiryTime - Date.now();
      function update() {
        if (remaining <= 0) {
          countdownEl.textContent = "Kode OTP sudah kadaluarsa.";
          return;
        }
        const minutes = String(Math.floor(remaining / 60000)).padStart(2, '0');
        const seconds = String(Math.floor((remaining % 60000) / 1000)).padStart(2, '0');
        countdownEl.textContent = `Masa Aktif OTP: ${minutes}:${seconds}`;
        remaining -= 1000;
        setTimeout(update, 1000);
      }
      update();
    }

    // Resend OTP via AJAX
    function resendOTP() {
      fetch('resend_otp.php')
        .then(res => res.json())
        .then(data => {
          if (data.status === 'ok') {
            alert("OTP baru telah dikirim ulang ke Telegram Anda.");
            startCountdown(data.expiry * 1000);
          } else {
            alert("Gagal mengirim ulang OTP: " + data.message);
          }
        })
        .catch(() => {
          alert("Terjadi kesalahan jaringan saat mengirim ulang OTP.");
        });
    }
  </script>
</body>
</html>
