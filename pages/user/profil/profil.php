<?php
include __DIR__ . '/../../auth.php';
include 'koneksi.php';

$user = $_SESSION['username'];
$ambiluser = $conn->prepare("SELECT * FROM tbl_users WHERE username =:user");
$ambiluser->bindparam(':user', $user);
$ambiluser->execute();
$data = $ambiluser->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Pengguna</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --primary: #4f46e5;
      --secondary: #6366f1;
      --accent: #8b5cf6;
      --light: #f8fafc;
      --dark: #1e293b;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
      min-height: 100vh;
    }

    .profile-card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .profile-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    .profile-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
      color: white;
      padding: 2rem;
      position: relative;
    }

    .profile-avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 4px solid white;
      background-color: #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      font-size: 2.5rem;
      font-weight: bold;
      color: var(--primary);
      position: relative;
      top: -50px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .info-item {
      border-bottom: 1px solid #f1f5f9;
      padding: 1rem 0;
      transition: all 0.2s;
    }

    .info-item:hover {
      background-color: #f8fafc;
    }

    .info-label {
      color: #64748b;
      font-weight: 500;
    }

    .info-value {
      color: #1e293b;
      font-weight: 600;
    }

    .btn-edit {
      background: linear-gradient(to right, var(--primary), var(--secondary));
      transition: all 0.3s;
    }

    .btn-edit:hover {
      background: linear-gradient(to right, var(--secondary), var(--primary));
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
    }

    .btn-back {
      background: linear-gradient(to right, #ef4444, #f87171);
      transition: all 0.3s;
    }

    .btn-back:hover {
      background: linear-gradient(to right, #dc2626, #ef4444);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
    }

    .password-field {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #94a3b8;
    }

    .toggle-password:hover {
      color: var(--primary);
    }
  </style>
</head>

<body class="py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-3xl mx-auto pt-8 pb-8">
    <div class="profile-card">
      <div class="profile-header text-center">
        <h1 class="text-3xl font-bold">Profil Pengguna</h1>
        <p class="text-indigo-100">Detail informasi akun Anda</p>
      </div>

      <div class="profile-avatar">
        <?= strtoupper(substr($data->nama_lengkap, 0, 1)) ?>
      </div>

      <div class="px-6 pb-8 pt-2">
        <div class="grid grid-cols-1 gap-4">
          <div class="info-item flex justify-between items-center">
            <span class="info-label">ID User</span>
            <span class="info-value"><?= $data->id_user ?></span>
          </div>

          <div class="info-item flex justify-between items-center">
            <span class="info-label">Nama Lengkap</span>
            <span class="info-value"><?= $data->nama_lengkap ?></span>
          </div>

          <div class="info-item flex justify-between items-center">
            <span class="info-label">Email</span>
            <span class="info-value"><?= $data->email ?></span>
          </div>

          <div class="info-item flex justify-between items-center">
            <span class="info-label">Alamat</span>
            <span class="info-value"><?= $data->alamat ?></span>
          </div>

          <div class="info-item flex justify-between items-center">
            <span class="info-label">No. HP</span>
            <span class="info-value"><?= $data->no_hp ?></span>
          </div>

          <div class="info-item flex justify-between items-center">
            <span class="info-label">Username</span>
            <span class="info-value"><?= $data->username ?></span>
          </div>

          <div class="info-item flex justify-between items-center">
            <span class="info-label">Password</span>
            <div class="password-field">
              <input type="password" value="<?= $data->password ?>" disabled
                class="info-value bg-transparent border-none focus:outline-none pr-8">
              <span class="toggle-password" onclick="togglePassword(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </span>
            </div>
          </div>
        </div>

        <div class="flex justify-end space-x-4 mt-8">
          <a href="?pages=profil_edit"
            class="btn-edit text-white font-medium py-2 px-6 rounded-full shadow-md">
            Edit Profil
          </a>
          <a href="?pages=home"
            class="btn-back text-white font-medium py-2 px-6 rounded-full shadow-md">
            Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <script>
    function togglePassword(element) {
      const input = element.previousElementSibling;
      if (input.type === "password") {
        input.type = "text";
        element.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                `;
      } else {
        input.type = "password";
        element.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                `;
      }
    }
  </script>
</body>

</html>