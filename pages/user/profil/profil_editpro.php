<?php
include __DIR__ . '/../../auth.php';

include 'koneksi.php';

$id = $_POST['id_user'];
$nama_lengkap = $_POST['nama_lengkap'];
$email = $_POST['email'];
$alamat = $_POST['alamat'];
$nohp = $_POST['no_hp'];
$username = $_POST['username'];
$pass = $_POST['password'];

try {
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $pdo = $conn->prepare('UPDATE tbl_users SET
                            nama_lengkap = :nama_lengkap,
                            email = :email,
                            username = :username,
                            password = :password,
                            alamat = :alamat,
                            no_hp = :no_hp
                            WHERE id_user = :id_user');

  $updatedata = array(
    ':nama_lengkap' => $nama_lengkap,
    ':email' => $email,
    ':username' => $username,
    ':password' => $pass,
    ':alamat' => $alamat,
    ':no_hp' => $nohp,
    ':id_user' => $id
  );
  $pdo->execute($updatedata);
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil Berhasil Diubah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      :root {
        --primary: #10b981;
        --secondary: #059669;
      }

      body {
        font-family: 'Poppins ', sans-serif;
        background-color: #f8fafc;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .success-container {
        max-width: 400px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        text-align: center;
        animation: fadeInUp 0.6s ease-out;
      }

      .checkmark-animation {
        width: 100px;
        height: 100px;
        margin: 0 auto 1.5rem;
        position: relative;
      }

      .checkmark-circle {
        position: absolute;
        width: 100%;
        height: 100%;
        border: 5px solid #d1fae5;
        border-radius: 50%;
        animation: circleExpand 0.6s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
      }

      .checkmark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
      }

      .checkmark-path {
        stroke-dasharray: 100;
        stroke-dashoffset: 100;
        animation: drawCheckmark 0.6s cubic-bezier(0.65, 0, 0.45, 1) 0.3s forwards;
        stroke: var(--primary);
        stroke-width: 6;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
      }

      .countdown {
        width: 100%;
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        margin-top: 2rem;
        overflow: hidden;
      }

      .countdown-bar {
        height: 100%;
        width: 0;
        background: linear-gradient(to right, var(--primary), var(--secondary));
        animation: countdown 1s linear forwards;
      }

      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(20px);
        }

        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @keyframes circleExpand {
        0% {
          transform: scale(0);
          opacity: 0;
        }

        50% {
          opacity: 1;
        }

        100% {
          transform: scale(1);
          opacity: 1;
        }
      }

      @keyframes drawCheckmark {
        to {
          stroke-dashoffset: 0;
        }
      }

      @keyframes countdown {
        to {
          width: 100%;
        }
      }

      .redirect-text {
        color: #64748b;
        margin-top: 1rem;
        font-size: 0.875rem;
      }
    </style>
  </head>

  <body>
    <div class="success-container">
      <div class="checkmark-animation">
        <div class="checkmark-circle"></div>
        <div class="checkmark">
          <svg viewBox="0 0 52 52">
            <path class="checkmark-path" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
          </svg>
        </div>
      </div>

      <h2 class="text-2xl font-bold text-gray-800 mb-2">Profil Berhasil Diubah!</h2>
      <p class="text-gray-600 mb-6">Perubahan pada profil Anda telah disimpan dengan sukses.</p>

      <div class="countdown">
        <div class="countdown-bar"></div>
      </div>

      <p class="redirect-text">Anda akan keluar otomatis dalam 1 detik...</p>
    </div>

    <meta http-equiv="refresh" content="1; url=pages/logout.php" />
  </body>

  </html>
<?php
} catch (PDOException $e) {
  print "Insert data gagal: " . $e->getMessage() . "<br/>";
  die();
}
?>