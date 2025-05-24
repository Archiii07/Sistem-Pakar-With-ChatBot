<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar | Sistem Pakar Penyakit Kulit</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #4f6cea 0%, #8a4eb5 100%);
    }

    .auth-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .input-field {
      background: rgba(249, 250, 251, 0.8);
      border: 1px solid #e5e7eb;
      transition: all 0.3s ease;
    }

    .input-field:focus {
      border-color: #4f6cea;
      box-shadow: 0 0 0 3px rgba(79, 108, 234, 0.2);
    }

    .btn-primary {
      background: linear-gradient(135deg, #4f6cea 0%, #8a4eb5 100%);
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(79, 108, 234, 0.4);
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 bg-gray-50">
  <div class="auth-card w-full max-w-md overflow-hidden">
    <div class="p-8">
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800">Buat Akun Baru</h1>
          <p class="text-gray-600">Bergabung dengan sistem pakar kami</p>
        </div>
        <a href="../index.php" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition">
          <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
      </div>

      <form method="post" action="registrasi.php">
        <?php
        include "../koneksi.php";
        session_start();
        ?>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-user text-gray-400"></i>
              </div>
              <input name="nama_lengkap" type="text" class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none" placeholder="Nama lengkap Anda">
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-envelope text-gray-400"></i>
              </div>
              <input name="email" type="email" class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none" placeholder="email@anda.com">
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-at text-gray-400"></i>
              </div>
              <input name="username" type="text" maxlength="8" class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none" placeholder="Username (maks 8 karakter)">
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-key text-gray-400"></i>
                </div>
                <input name="password" type="password" maxlength="8" class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none" placeholder="••••••••">
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-key text-gray-400"></i>
                </div>
                <input name="konfirmasi_password" type="password" class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none" placeholder="••••••••">
              </div>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-phone text-gray-400"></i>
              </div>
              <input name="no_hp" type="text" class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none" placeholder="+62 123 4567 890">
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
            <textarea name="alamat" class="input-field w-full px-4 py-3 rounded-lg focus:outline-none h-24" placeholder="Alamat lengkap Anda"></textarea>
          </div>

          <div class="flex items-center justify-between pt-2">
            <a href="./login.php" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition">
              Sudah punya akun?
            </a>
            <button type="submit" name="submit" class="btn-primary px-6 py-3 rounded-lg font-medium text-white">
              Daftar Sekarang
            </button>
          </div>
        </div>
      </form>

      <?php

      if (isset($_POST['submit'])) {
        $namalengkap = $_POST['nama_lengkap'];
        $email = $_POST['email'];
        $nohp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $konfirmasi_password = $_POST['konfirmasi_password'];
        $status = 'user';

        if (empty($namalengkap) || empty($email) || empty($nohp) || empty($alamat) || empty($username) || empty($password) || empty($konfirmasi_password)) {
          echo '<div class="mt-6 p-4 bg-red-100 border border-red-200 rounded-lg text-center">
                            <p class="text-red-700">Harap isi semua kolom!</p>
                          </div>';
        } elseif ($password != $konfirmasi_password) {
          echo '<div class="mt-6 p-4 bg-red-100 border border-red-200 rounded-lg text-center">
                            <p class="text-red-700">Password tidak cocok!</p>
                          </div>';
        } else {
          try {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo = $conn->prepare('INSERT INTO tbl_users (nama_lengkap, email, username, password, alamat, no_hp, title)
                            values (:nama_lengkap, :email, :username, :password, :alamat, :no_hp, :title)');
            $insertdata = array(':nama_lengkap' => $namalengkap, ':email' => $email, ':username' => $username, ':password' => $password, ':alamat' => $alamat, ':no_hp' => $nohp, ':title' => $status);
            $pdo->execute($insertdata);

            echo '<div class="mt-6 p-4 bg-green-100 border border-green-200 rounded-lg text-center">
                                <p class="text-green-700">Pendaftaran berhasil! Mengalihkan...</p>
                              </div>';
            echo "<meta http-equiv='refresh' content='1; url=./login.php'>";
          } catch (PDOexception $e) {
            echo '<div class="mt-6 p-4 bg-red-100 border border-red-200 rounded-lg text-center">
                                <p class="text-red-700">Pendaftaran gagal: ' . $e->getMessage() . '</p>
                              </div>';
          }
        }
      }
      ?>
    </div>
  </div>
</body>

</html>