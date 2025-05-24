<?php
include __DIR__ . '/../../auth.php';
include '../koneksi.php';

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Fetch penyakit options from tbl_informasi
    $stmtPenyakit = $conn->prepare("SELECT kd_penyakit, nama_penyakit FROM tbl_informasi ORDER BY kd_penyakit");
    $stmtPenyakit->execute();
    $penyakitList = $stmtPenyakit->fetchAll(PDO::FETCH_ASSOC);

    // Fetch gejala options from tbl_gejala
    $stmtGejala = $conn->prepare("SELECT kd_gejala, gejala FROM tbl_gejala ORDER BY gejala");
    $stmtGejala->execute();
    $gejalaList = $stmtGejala->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Aturan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .select-style {
            transition: all 0.3s ease;
            border: 2px solid rgba(102, 126, 234, 0.3);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            appearance: none;
        }

        .select-style:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(107, 114, 128, 0.6);
        }

        .animated-bg {
            animation: gradientBG 15s ease infinite;
            background: linear-gradient(-45deg, #6366f1, #8b5cf6, #ec4899, #f43f5e);
            background-size: 400% 400%;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .form-input {
            transition: all 0.3s ease;
            border: 2px solid rgba(102, 126, 234, 0.3);
        }

        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #custom-confirm-modal {
            animation: fadeIn 0.3s ease-out forwards;
        }

        .backdrop-filter {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .rounded-2xl {
            border-radius: 1rem;
        }

        .from-blue-600 {
            --gradient-from: #2563eb;
            --gradient-to: rgba(37, 99, 235, 0);
            --gradient-stops: var(--gradient-from), var(--gradient-to);
        }

        .to-indigo-600 {
            --gradient-to: #4f46e5;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 p-4">
    <!-- Background elements -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-purple-200/20 blur-3xl"></div>
        <div class="absolute top-1/3 right-1/4 w-80 h-80 rounded-full bg-indigo-200/20 blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/3 w-72 h-72 rounded-full bg-blue-200/20 blur-3xl"></div>
    </div>

    <div class="max-w-md mx-auto my-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah Aturan Baru</h1>
            <p class="text-indigo-600">Buat hubungan antara gejala dan penyakit</p>
        </div>

        <!-- Form Card -->
        <div class="glass-card p-4">
            <form name="add" action="?pages=tambahpro_aturan" method="post">
                <!-- Penyakit Selection -->
                <div class="mb-6">
                    <label for="kd_penyakit" class="block text-gray-700 font-medium mb-2">Penyakit Terkait</label>
                    <div class="relative">
                        <select id="kd_penyakit" name="kd_penyakit" class="select-style w-full py-3 px-4 pr-10 rounded-lg focus:outline-none" required>
                            <option value="">-- Pilih Penyakit --</option>
                            <?php foreach ($penyakitList as $penyakit): ?>
                                <option value="<?= htmlspecialchars($penyakit['kd_penyakit']) ?>">
                                    <?= htmlspecialchars($penyakit['kd_penyakit']) ?> | <?= htmlspecialchars($penyakit['nama_penyakit']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-disease text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Gejala Selection -->
                <div class="mb-6">
                    <label for="kd_gejala" class="block text-gray-700 font-medium mb-2">Gejala</label>
                    <div class="relative">
                        <select id="kd_gejala" name="kd_gejala" class="select-style w-full py-3 px-4 pr-10 rounded-lg focus:outline-none" required>
                            <option value="">-- Pilih Gejala --</option>
                            <?php foreach ($gejalaList as $gejala): ?>
                                <option value="<?= htmlspecialchars($gejala['kd_gejala']) ?>">
                                    <?= htmlspecialchars($gejala['kd_gejala']) ?> | <?= htmlspecialchars($gejala['gejala']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-thermometer-half text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Remove Bobot Selection -->
                <!--
                <div class="mb-8">
                    <label for="bobot" class="block text-gray-700 font-medium mb-2">Tingkat Keparahan</label>
                    <div class="relative">
                        <select id="bobot" name="bobot" class="select-style w-full py-3 px-4 pr-10 rounded-lg focus:outline-none" required>
                            <option value="">-- Pilih Bobot --</option>
                            <option value="5">5 - Gejala Dominan</option>
                            <option value="3">3 - Gejala Sedang</option>
                            <option value="1">1 - Gejala Biasa</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-weight-hanging text-gray-400"></i>
                        </div>
                    </div>
                </div>
                -->

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <button id="submit-button" type="button" name="submit-button" class="btn-primary text-white font-bold py-3 px-6 rounded-lg w-full flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i> SIMPAN ATURAN
                    </button>
                    <a href="?pages=data_aturan" class="btn-secondary text-white font-bold py-3 px-6 rounded-lg w-full flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i> KEMBALI
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div id="custom-confirm-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-75 backdrop-filter backdrop-blur-sm"></div>
            </div>

            <!-- Modal container -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-6 py-5 sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 sm:mx-0 sm:h-14 sm:w-14">
                            <svg class="h-8 w-8 text-blue-600 animate-pulse" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Konfirmasi Penyimpanan
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menyimpan data gejala ini?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl">
                    <button type="button" id="confirm-yes" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-base font-medium text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105">
                        Ya, Simpan
                    </button>
                    <button type="button" id="confirm-no" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 hover:scale-105">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const submitButton = document.getElementById('submit-button');
        const form = document.querySelector('form[name="add"]');
        const modal = document.getElementById('custom-confirm-modal');
        const confirmYes = document.getElementById('confirm-yes');
        const confirmNo = document.getElementById('confirm-no');

        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.remove('hidden');
        });

        confirmYes.addEventListener('click', function() {
            modal.classList.add('hidden');
            // Remove the 'submit' event listener to prevent infinite loop
            form.removeEventListener('submit', arguments.callee);
            // Add a hidden input to indicate confirmation
            const confirmInput = document.createElement('input');
            confirmInput.type = 'hidden';
            confirmInput.name = 'confirmed';
            confirmInput.value = 'true';
            form.appendChild(confirmInput);
            form.submit();
        });

        confirmNo.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
    });
</script>