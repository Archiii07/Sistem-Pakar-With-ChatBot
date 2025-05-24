<?php
include __DIR__ . '/../../auth.php';
include '../koneksi.php';

if (isset($_GET['id_aturan'])) {
    $id_aturan = $_GET['id_aturan'];
    $query = "
        SELECT a.id_aturan, a.kd_penyakit, a.kd_gejala, p.nama_penyakit, g.gejala
        FROM tbl_aturan a
        JOIN tbl_informasi p ON a.kd_penyakit = p.kd_penyakit
        JOIN tbl_gejala g ON a.kd_gejala = g.kd_gejala
        WHERE a.id_aturan = :id_aturan
    ";
    $params = [':id_aturan' => $id_aturan];
} elseif (isset($_GET['kd_penyakit']) && isset($_GET['kd_gejala'])) {
    $kd_penyakit = $_GET['kd_penyakit'];
    $kd_gejala = $_GET['kd_gejala'];
    $query = "
        SELECT a.id_aturan, a.kd_penyakit, a.kd_gejala, p.nama_penyakit, g.gejala
        FROM tbl_aturan a
        JOIN tbl_informasi p ON a.kd_penyakit = p.kd_penyakit
        JOIN tbl_gejala g ON a.kd_gejala = g.kd_gejala
        WHERE a.kd_penyakit = :kd_penyakit AND a.kd_gejala = :kd_gejala
    ";
    $params = [':kd_penyakit' => $kd_penyakit, ':kd_gejala' => $kd_gejala];
} else {
    echo '<div class="text-center mb-4">';
    echo '<p class="text-lg font-bold text-red-600">Data tidak ditemukan!</p>';
    echo '</div>';
    echo "<meta http-equiv='refresh' content='1; url=?pages=data_aturan'>";
    exit;
}

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($query);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo '<div class="text-center mb-4">';
        echo '<p class="text-lg font-bold text-red-600">Data tidak ditemukan!</p>';
        echo '</div>';
        echo "<meta http-equiv='refresh' content='1; url=?pages=data_aturan'>";
        exit;
    }

    // Fetch all penyakit for dropdown
    $stmtPenyakit = $conn->prepare("SELECT kd_penyakit, nama_penyakit FROM tbl_informasi ORDER BY kd_penyakit");
    $stmtPenyakit->execute();
    $penyakitList = $stmtPenyakit->fetchAll(PDO::FETCH_ASSOC);

    // Fetch all gejala for dropdown
    $stmtGejala = $conn->prepare("SELECT kd_gejala, gejala FROM tbl_gejala ORDER BY kd_gejala");
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
    <title>Edit Aturan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
        }

        .gradient-header {
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

        .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }

        .badge-primary {
            color: #fff;
            background-color: #6366f1;
        }

        .badge-secondary {
            color: #fff;
            background-color: #8b5cf6;
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
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 p-4">
    <!-- Background elements -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-purple-200/20 blur-3xl"></div>
        <div class="absolute top-1/3 right-1/4 w-80 h-80 rounded-full bg-indigo-200/20 blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/3 w-72 h-72 rounded-full bg-blue-200/20 blur-3xl"></div>
    </div>

    <div class="max-w-md mx-auto my-8">
        <!-- Header Card -->
        <div class="gradient-header text-white rounded-t-xl p-6 text-center shadow-lg">
            <h1 class="text-2xl font-bold mb-2">Edit Aturan Diagnosa</h1>
            <p class="opacity-90">Memperbarui hubungan gejala dan penyakit</p>
        </div>

        <!-- Form Card -->
        <div class="glass-card p-8 rounded-t-none">
            <form name="edit" action="?pages=editpro_aturan" method="post">
                <input type="hidden" name="id_aturan" value="<?= htmlspecialchars($data['id_aturan']) ?>">
                <input type="hidden" name="old_kd_penyakit" value="<?= htmlspecialchars($data['kd_penyakit']) ?>">
                <input type="hidden" name="old_kd_gejala" value="<?= htmlspecialchars($data['kd_gejala']) ?>">

                <!-- Current Selection Info -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <div class="flex items-center mb-2">
                        <span class="badge badge-primary mr-2">Penyakit</span>
                        <span class="font-medium"><?= htmlspecialchars($data['kd_penyakit']) ?> | <?= htmlspecialchars($data['nama_penyakit']) ?></span>
                    </div>
                    <div class="flex items-center">
                        <span class="badge badge-secondary mr-2">Gejala</span>
                        <span class="font-medium"><?= htmlspecialchars($data['kd_gejala']) ?> | <?= htmlspecialchars($data['gejala']) ?></span>
                    </div>
                </div>

                <!-- Penyakit Selection -->
                <div class="mb-6">
                    <label for="kd_penyakit" class="block text-gray-700 font-medium mb-2">Penyakit Baru</label>
                    <div class="relative">
                        <select id="kd_penyakit" name="kd_penyakit" class="select-style w-full py-3 px-4 pr-10 rounded-lg focus:outline-none" required>
                            <?php foreach ($penyakitList as $penyakit): ?>
                                <option value="<?= htmlspecialchars($penyakit['kd_penyakit']) ?>" <?= $penyakit['kd_penyakit'] == $data['kd_penyakit'] ? 'selected' : '' ?>>
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
                    <label for="kd_gejala" class="block text-gray-700 font-medium mb-2">Gejala Baru</label>
                    <div class="relative">
                        <select id="kd_gejala" name="kd_gejala" class="select-style w-full py-3 px-4 pr-10 rounded-lg focus:outline-none" required>
                            <?php foreach ($gejalaList as $gejala): ?>
                                <option value="<?= htmlspecialchars($gejala['kd_gejala']) ?>" <?= $gejala['kd_gejala'] == $data['kd_gejala'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($gejala['kd_gejala']) ?> | <?= htmlspecialchars($gejala['gejala']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-thermometer-half text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Bobot Selection -->
                <!-- Remove Bobot Selection -->
                <!--
                <div class="mb-8">
                    <label for="bobot" class="block text-gray-700 font-medium mb-2">Tingkat Keparahan</label>
                    <div class="relative">
                        <select id="bobot" name="bobot" class="select-style w-full py-3 px-4 pr-10 rounded-lg focus:outline-none" required>
                            <option value="5" <?= $data['bobot'] == 5 ? 'selected' : '' ?>>5 - Gejala Dominan</option>
                            <option value="3" <?= $data['bobot'] == 3 ? 'selected' : '' ?>>3 - Gejala Sedang</option>
                            <option value="1" <?= $data['bobot'] == 1 ? 'selected' : '' ?>>1 - Gejala Biasa</option>
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
                        <i class="fas fa-save mr-2"></i> SIMPAN PERUBAHAN
                    </button>
                    <a href="?pages=data_aturan" class="btn-secondary text-white font-bold py-3 px-6 rounded-lg w-full flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i> KEMBALI
                    </a>
                </div>
            </form>
        </div>
    </div>
    <!-- Custom Confirm Modal -->
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

<script>
    document.querySelector('form[name="edit"]').addEventListener('submit', function(e) {
        const kdGejala = document.getElementById('kd_gejala').value;
        const gejala = document.getElementById('gejala').value;

        if (!kdGejala || !gejala) {
            e.preventDefault();
            alert('Harap isi semua field yang diperlukan');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const submitButton = document.getElementById('submit-button');
        const form = document.querySelector('form[name="edit"]');
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

</html>