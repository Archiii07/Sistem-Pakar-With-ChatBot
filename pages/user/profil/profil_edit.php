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
  <title>Edit Profil</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --primary: #6366f1;
      --secondary: #4f46e5;
      --accent: #8b5cf6;
      --light: #f8fafc;
      --dark: #1e293b;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
      min-height: 100vh;
    }

    .profile-form-container {
      background: white;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      transition: all 0.3s ease;
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
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .form-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      color: white;
      padding: 1.5rem;
    }

    .form-input {
      transition: all 0.3s;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
    }

    .form-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    .btn-submit {
      background: linear-gradient(to right, var(--primary), var(--secondary));
      transition: all 0.3s;
    }

    .btn-submit:hover {
      background: linear-gradient(to right, var(--secondary), var(--primary));
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
    }

    .btn-cancel {
      background: linear-gradient(to right, #ef4444, #f87171);
      transition: all 0.3s;
    }

    .btn-cancel:hover {
      background: linear-gradient(to right, #dc2626, #ef4444);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
    }

    .warning-box {
      background: rgba(254, 240, 138, 0.3);
      border-left: 4px solid #f59e0b;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% {
        background-color: rgba(254, 240, 138, 0.3);
      }

      50% {
        background-color: rgba(254, 240, 138, 0.5);
      }

      100% {
        background-color: rgba(254, 240, 138, 0.3);
      }
    }

    .password-container {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 65%;
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
  <div class="max-w-lg mx-auto pt-8 pb-8">
    <div class="profile-form-container">
      <div class="form-header">
        <h1 class="text-2xl font-bold text-center">Edit Profil</h1>
      </div>

      <form name="edit" action="?pages=profil_editpro" method="post" enctype="multipart/form-data" class="p-6 space-y-6">
        <input type="hidden" name="id_user" value="<?= $data->id_user ?>">

        <div class="profile-avatar">
          <?= strtoupper(substr($data->nama_lengkap, 0, 1)) ?>
        </div>

        <!-- ID User (Disabled) -->
        <div>
          <label for="id_user_display" class="block text-sm font-medium text-gray-700 mb-1">ID User</label>
          <input type="text" id="id_user_display" value="<?= $data->id_user ?>" disabled
            class="w-full p-3 form-input bg-gray-100 text-gray-700">
        </div>

        <!-- Nama Lengkap -->
        <div>
          <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" value="<?= $data->nama_lengkap ?>" required
            class="w-full p-3 form-input">
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input type="email" name="email" value="<?= $data->email ?>" required
            class="w-full p-3 form-input">
        </div>

        <!-- Username -->
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
          <input type="text" name="username" maxlength="6" value="<?= $data->username ?>" required
            class="w-full p-3 form-input">
        </div>

        <!-- Password -->
        <div class="password-container">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input type="password" name="password" maxlength="6" value="<?= $data->password ?>" required
            class="w-full p-3 form-input pr-10" id="passwordInput">
          <span class="toggle-password" onclick="togglePassword()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </span>
        </div>

        <!-- No HP -->
        <div>
          <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
          <input type="tel" name="no_hp" value="<?= $data->no_hp ?>" required
            class="w-full p-3 form-input">
        </div>

        <!-- Alamat -->
        <div>
          <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
          <textarea name="alamat" rows="3" required
            class="w-full p-3 form-input"><?= $data->alamat ?></textarea>
        </div>

        <!-- Warning Box -->
        <div class="warning-box p-4 rounded-md">
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span class="text-sm text-yellow-800">Jika melakukan perubahan data, akun akan otomatis keluar. Silakan masuk kembali setelah perubahan.</span>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-4">
          <button type="submit" name="edit" class="btn-submit text-white font-medium py-2 px-6 rounded-full">
            Simpan Perubahan
          </button>
          <a href="?pages=profil" class="btn-cancel text-white font-medium py-2 px-6 rounded-full">
            Kembali
          </a>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Toggle password visibility
    function togglePassword() {
      const passwordInput = document.getElementById('passwordInput');
      const toggleIcon = document.querySelector('.toggle-password svg');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
      } else {
        passwordInput.type = 'password';
        toggleIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
      }
    }
  </script>
</body>

</html>