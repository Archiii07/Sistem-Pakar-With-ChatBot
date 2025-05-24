<?php
include __DIR__ . '../auth.php';
include_once("../koneksi.php");

$username = "";
if (isset($_SESSION['username'])) {
    $user_session = $_SESSION['username'];
    try {
        $stmt = $conn->prepare("SELECT username FROM tbl_users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $user_session);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $username = $row['username'];
        } else {
            $username = "Admin";
        }
    } catch (Exception $e) {
        $username = "Admin";
    }
} else {
    $username = "Admin";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sistem Pakar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="../src/input1.css" rel="stylesheet" />
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --dark: #1b263b;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }

        .sidebar {
            transition: all 0.3s ease;
            background: linear-gradient(180deg, var(--dark), var(--secondary));
        }

        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--accent);
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .table-row:hover {
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="sidebar w-64 text-white flex-shrink-0 hidden md:block">
        <div class="p-4 flex items-center justify-center border-b border-gray-700">
            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-500 rounded-full flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-robot text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold">Sistem Pakar</h2>
                <p class="text-sm text-gray-300">Admin Dashboard</p>
            </div>
        </div>
        <nav class="mt-6">
            <div class="px-4 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Main Menu
            </div>
            <a href="?pages=dashboard_home" class="flex items-center nav-item px-6 py-3 text-gray-200 hover:text-white">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
            <a href="?pages=data_user" class="flex items-center nav-item px-6 py-3 text-gray-200 hover:text-white">
                <i class="fas fa-users mr-3"></i>
                Manajemen User
            </a>
            <div class="px-4 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-4">
                Knowledge Base
            </div>
            <a href="?pages=data_gejala" class="flex items-center nav-item px-6 py-3 text-gray-200 hover:text-white">
                <i class="fas fa-clipboard-list mr-3"></i>
                Data Gejala
            </a>
            <a href="?pages=data_informasi" class="flex items-center nav-item px-6 py-3 text-gray-200 hover:text-white">
                <i class="fas fa-disease mr-3"></i>
                Data Penyakit
            </a>
            <a href="?pages=data_aturan" class="flex items-center nav-item px-6 py-3 text-gray-200 hover:text-white">
                <i class="fas fa-project-diagram mr-3"></i>
                Basis Aturan
            </a>
            <div class="px-4 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-4">
                Laporan
            </div>
            <a href="?pages=laporan" class="flex items-center nav-item px-6 py-3 text-gray-200 hover:text-white">
                <i class="fas fa-chart-bar mr-3"></i>
                Statistik
            </a>
        </nav>
        <div class="relative w-full p-4 border-t border-gray-700">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center">
                    <i class="fas fa-user"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium"><?php echo htmlspecialchars($username); ?></p>
                    <p class="text-xs text-gray-400">Super Admin</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm z-10">
            <div class="flex items-center justify-between px-6 py-3">
                <div class="flex items-center">
                    <button class="md:hidden text-gray-500 focus:outline-none mr-4">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-800">
                        <?php
                        $pages = isset($_GET['pages']) ? $_GET['pages'] : 'dashboard';
                        echo ucwords(str_replace('_', ' ', $pages));
                        ?>
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="text-gray-500 focus:outline-none">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </button>
                    </div>
                    <div class="relative" id="userDropdownContainer">
                        <button id="userDropdownButton" class="flex items-center focus:outline-none" type="button">
                            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="ml-2 text-gray-700 hidden md:inline"><?php echo htmlspecialchars($username); ?></span>
                            <i class="fas fa-chevron-down ml-1 text-gray-500 text-xs hidden md:inline"></i>
                        </button>
                        <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-20">
                            <a href="logout.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            <?php
            if (isset($_GET['pages'])) $pages = $_GET['pages'];
            else $pages = "dashboard_home";

            if ($pages == "dashboard_home") include("./admin/dashboard_home.php");
            elseif ($pages == "data_informasi") include("./admin/informasi/data_informasi.php");
            elseif ($pages == "tambah_informasi") include("./admin/informasi/tambah_informasi.php");
            elseif ($pages == "tambahpro_informasi") include("./admin/informasi/tambahpro_informasi.php");
            elseif ($pages == "edit_informasi") include("./admin/informasi/edit_informasi.php");
            elseif ($pages == "editpro_informasi") include("./admin/informasi/editpro_informasi.php");
            elseif ($pages == "hapus_informasi") include("./admin/informasi/hapus_informasi.php");
            elseif ($pages == "data_user") include("./admin/user/data_user.php");
            elseif ($pages == "tambah_user") include("./admin/user/tambah_user.php");
            elseif ($pages == "tambahpro_user") include("./admin/user/tambahpro_user.php");
            elseif ($pages == "edit_user") include("./admin/user/edit_user.php");
            elseif ($pages == "editpro_user") include("./admin/user/editpro_user.php");
            elseif ($pages == "hapus_user") include("./admin/user/hapus_user.php");
            elseif ($pages == "data_gejala") include("./admin/gejala/data_gejala.php");
            elseif ($pages == "tambah_gejala") include("./admin/gejala/tambah_gejala.php");
            elseif ($pages == "tambahpro_gejala") include("./admin/gejala/tambahpro_gejala.php");
            elseif ($pages == "edit_gejala") include("./admin/gejala/edit_gejala.php");
            elseif ($pages == "editpro_gejala") include("./admin/gejala/editpro_gejala.php");
            elseif ($pages == "hapus_gejala") include("./admin/gejala/hapus_gejala.php");
            elseif ($pages == "data_aturan") include("./admin/aturan/data_aturan.php");
            elseif ($pages == "tambah_aturan") include("./admin/aturan/tambah_aturan.php");
            elseif ($pages == "tambahpro_aturan") include("./admin/aturan/tambahpro_aturan.php");
            elseif ($pages == "edit_aturan") include("./admin/aturan/edit_aturan.php");
            elseif ($pages == "editpro_aturan") include("./admin/aturan/editpro_aturan.php");
            elseif ($pages == "hapus_aturan") include("./admin/aturan/hapus_aturan.php");
            else {
                echo '<div class="bg-white rounded-lg shadow p-6">';
                echo '<h2 class="text-xl font-semibold text-gray-800 mb-4">Halaman Tidak Ditemukan</h2>';
                echo '<p class="text-gray-600">Halaman yang Anda cari tidak tersedia.</p>';
                echo '</div>';
            }
            ?>
        </main>
    </div>

    <script>
        // Mobile sidebar toggle
        document.querySelector('.md\\:hidden').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('hidden');
        });

        // Confirm before delete
        document.querySelectorAll('a[onclick^="return confirm"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (!confirm(this.getAttribute('data-confirm') || 'Apakah Anda yakin ingin menghapus data ini?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
    <script>
        // Dropdown toggle for user menu
        document.getElementById('userDropdownButton').addEventListener('click', function() {
            var menu = document.getElementById('userDropdownMenu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', function(e) {
            var container = document.getElementById('userDropdownContainer');
            var menu = document.getElementById('userDropdownMenu');
            var button = document.getElementById('userDropdownButton');
            if (!container.contains(e.target)) {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            }
        });
    </script>
</body>

</html>