<?php
include __DIR__ . '/../../auth.php';
include '../koneksi.php';

function renderSuccessPage()
{
    echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aturan Dihapus</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            
        .success-animation {
            animation: bounceIn 0.8s ease-out;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(102, 126, 234, 0.5);
        }
        @keyframes bounceIn {
            0% { transform: scale(0.5); opacity: 0; }
            70% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-purple-50 p-4">
    <div class="glass-card p-8 max-w-md w-full text-center success-animation">
        <div class="flex justify-center mb-6">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-3">Aturan Berhasil Dihapus!</h2>
        <p class="text-gray-600 mb-6">Data aturan telah berhasil dihapus dari sistem.</p>
        <div class="flex justify-center">
            <a href="?pages=data_aturan" class="btn-primary px-6 py-3 rounded-lg text-white font-medium inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Aturan
            </a>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "?pages=data_aturan";
        }, 3000);
    </script>
</body>
</html>';
}

function renderErrorPage($message)
{
    echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .btn-error {
            background: linear-gradient(135deg, #f78ca0 0%, #f9748f 100%);
            transition: all 0.3s ease;
        }
        .btn-error:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(247, 140, 160, 0.5);
        }
        .error-animation {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }
        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-purple-50 p-4">
    <div class="glass-card p-8 max-w-md w-full text-center error-animation">
        <div class="flex justify-center mb-6">
            <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-3">Terjadi Kesalahan</h2>
        <p class="text-gray-600 mb-6">' . htmlspecialchars($message) . '</p>
        <div class="flex justify-center space-x-4">
            <a href="?pages=data_aturan" class="btn-error px-6 py-3 rounded-lg text-white font-medium inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
</body>
</html>';
}

// Main logic
if (isset($_GET['id_aturan'])) {
    $id_aturan = $_GET['id_aturan'];
    $query = "DELETE FROM tbl_aturan WHERE id_aturan = :id_aturan";
    $params = [':id_aturan' => $id_aturan];
} elseif (isset($_GET['kd_penyakit']) && isset($_GET['kd_gejala'])) {
    $kd_penyakit = $_GET['kd_penyakit'];
    $kd_gejala = $_GET['kd_gejala'];
    $query = "DELETE FROM tbl_aturan WHERE kd_penyakit = :kd_penyakit AND kd_gejala = :kd_gejala";
    $params = [':kd_penyakit' => $kd_penyakit, ':kd_gejala' => $kd_gejala];
} else {
    renderErrorPage("Parameter untuk menghapus data tidak ditemukan!");
    exit;
}

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($query);

    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }

    if ($stmt->execute()) {
        renderSuccessPage();
    } else {
        renderErrorPage("Gagal menghapus data aturan.");
    }
} catch (PDOException $e) {
    renderErrorPage("Error saat menghapus aturan: " . $e->getMessage());
    exit;
}
