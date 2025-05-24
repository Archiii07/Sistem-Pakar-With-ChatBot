<?php
include __DIR__ . '/../../auth.php';
include '../koneksi.php';

function renderPage($content, $isSuccess = false)
{
    echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 12px 48px 0 rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            max-width: 480px;
            margin: 40px auto;
            padding: 32px;
            border-radius: 24px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .glass-card:hover {
            box-shadow: 0 16px 56px 0 rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }
            
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(102, 126, 234, 0.5);
        }
        .btn-error {
            background: linear-gradient(135deg, #f78ca0 0%, #f9748f 100%);
            transition: all 0.3s ease;
        }
        .btn-error:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(247, 140, 160, 0.5);
        }
        .animated-bg {
            animation: gradientBG 15s ease infinite;
            background: linear-gradient(-45deg, #667eea, #764ba2, #6B46C1, #9F7AEA);
            background-size: 400% 400%;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .checkmark-circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .checkmark {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            stroke: #4bb71b;
            stroke-miterlimit: 10;
            margin: 0 auto;
            box-shadow: inset 0px 0px 0px #4bb71b;
            animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        }
        .checkmark-check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }
        @keyframes stroke {
            100% { stroke-dashoffset: 0; }
        }
        @keyframes scale {
            0%, 100% { transform: none; }
            50% { transform: scale3d(1.1, 1.1, 1); }
        }
        @keyframes fill {
            100% { box-shadow: inset 0px 0px 0px 40px #4bb71b; }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-purple-300/20 blur-3xl"></div>
        <div class="absolute top-1/3 right-1/4 w-80 h-80 rounded-full bg-pink-300/20 blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/3 w-72 h-72 rounded-full bg-indigo-300/20 blur-3xl"></div>
    </div>
    
    <div class="glass-card rounded-3xl p-8 max-w-md w-full text-center transform transition-all duration-500">
        ' . $content . '
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "?pages=data_user";
        }, 3000);
    </script>
</body>
</html>';
}

if (isset($_POST['submit']) || isset($_POST['confirmed'])) {
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $title = htmlspecialchars($_POST['title']);

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare('INSERT INTO tbl_users (nama_lengkap, email, username, password, alamat, no_hp, title) 
                                VALUES (:nama_lengkap, :email, :username, :password, :alamat, :no_hp, :title)');

        $params = array(
            ':nama_lengkap' => $nama_lengkap,
            ':email' => $email,
            ':username' => $username,
            ':password' => $password,
            ':alamat' => $alamat,
            ':no_hp' => $no_hp,
            ':title' => $title
        );

        if ($stmt->execute($params)) {
            $content = '
                <svg class="checkmark mb-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
                <h1 class="text-2xl font-bold text-gray-800 mb-4">User Berhasil Ditambahkan!</h1>
                <p class="text-gray-600 mb-6">Data pengguna baru telah berhasil disimpan ke dalam sistem.</p>
                <a href="?pages=data_user" class="inline-block px-6 py-3 rounded-xl font-semibold text-white btn-primary">
                    <i class="fas fa-users mr-2"></i> Kembali ke Data User
                </a>
            ';
            renderPage($content, true);
        } else {
            $content = '
                <div class="mb-6 text-red-500">
                    <i class="fas fa-times-circle text-6xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Gagal Menyimpan Data</h1>
                <p class="text-gray-600 mb-6">Terjadi kesalahan saat menyimpan data pengguna. Silakan coba lagi.</p>
                <a href="?pages=tambah_user" class="inline-block px-6 py-3 rounded-xl font-semibold text-white btn-error">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Form
                </a>
            ';
            renderPage($content);
        }
    } catch (PDOException $e) {
        $content = '
            <div class="mb-6 text-red-500">
                <i class="fas fa-exclamation-triangle text-6xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Tambah User Gagal</h1>
            <p class="text-gray-600 mb-6">' . htmlspecialchars($e->getMessage()) . '</p>
            <a href="?pages=tambah_user" class="inline-block px-6 py-3 rounded-xl font-semibold text-white btn-error">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Form
            </a>
        ';
        renderPage($content);
    }
} else {
    $content = '
        <div class="mb-6 text-yellow-500">
            <i class="fas fa-exclamation-circle text-6xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Form Tidak Valid</h1>
        <p class="text-gray-600 mb-6">Silakan isi form dengan benar sebelum mengirimkan data.</p>
        <a href="?pages=tambah_user" class="inline-block px-6 py-3 rounded-xl font-semibold text-white btn-error">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Form
        </a>
    ';
    renderPage($content);
}
