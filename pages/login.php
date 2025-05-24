<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk | Sistem Pakar Penyakit Kulit</title>
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
          <h1 class="text-3xl font-bold text-gray-800">Selamat Datang</h1>
          <p class="text-gray-600">Masuk ke akun Anda</p>
        </div>
        <a href="../index.php" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition">
          <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
      </div>

      <form method="post" action="login.php">
        <div class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-user text-gray-400"></i>
              </div>
              <input name="username" type="text" class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none" placeholder="Masukkan username">
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-lock text-gray-400"></i>
              </div>
              <input name="password" type="password" class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none" placeholder="••••••••">
            </div>
          </div>

          <div class="flex items-center justify-between">
            <a href="./registrasi.php" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition">
              Buat akun baru
            </a>
            <button type="submit" name="submit" class="btn-primary px-6 py-3 rounded-lg font-medium text-white">
              Masuk
            </button>
          </div>
        </div>
      </form>

      <?php
      include "../koneksi.php";
      session_start();

      if (isset($_POST['submit'])) {
        $user = $_POST['username'];
        $pwd = $_POST['password'];

        $pdo = $conn->prepare("SELECT * FROM tbl_users WHERE username=:a AND password=:b");
        $pdo->execute(array(':a' => $user, ':b' => $pwd));
        $count = $pdo->rowCount();
        $row = $pdo->fetch(PDO::FETCH_OBJ);

        if ($count == 0) {
          echo '<div class="mt-6 p-4 bg-red-100 border border-red-200 rounded-lg text-center">
                            <p class="text-red-700">Login gagal. Periksa kembali username dan password Anda.</p>
                          </div>';
        } else {
          $_SESSION['username'] = $user;
          $_SESSION['password'] = $pwd;
          $_SESSION['status'] = $row->title;

          echo '<div class="mt-6 p-4 bg-green-100 border border-green-200 rounded-lg text-center">
                            <p class="text-green-700">Login berhasil! Mengalihkan...</p>
                          </div>';
          if ($row->title === 'admin') {
            echo "<meta http-equiv='refresh' content='1; url=navbar_admin.php'>";
          } else {
            echo "<meta http-equiv='refresh' content='1; url=../index.php'>";
          }
        }
      }
      ?>
    </div>
  </div>
</body>

</html>