<?php
include __DIR__ . '/../../auth.php';
include '../koneksi.php';

if (!isset($_GET['kd_gejala'])) {
    echo '<div class="text-center mb-4">';
    echo '<p class="text-lg font-bold text-red-600">Kode Gejala tidak ditemukan!</p>';
    echo '</div>';
    echo "<meta http-equiv='refresh' content='1; url=?pages=data_gejala'>";
    exit;
}

$kd_gejala = $_GET['kd_gejala'];

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('SELECT * FROM tbl_gejala WHERE kd_gejala = :kd_gejala');
    $stmt->bindParam(':kd_gejala', $kd_gejala, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo '<div class="text-center mb-4">';
        echo '<p class="text-lg font-bold text-red-600">Data tidak ditemukan!</p>';
        echo '</div>';
        echo "<meta http-equiv='refresh' content='1; url=?pages=data_gejala'>";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4">
    <div class="max-w-3xl mx-auto">
        <!-- Header with animated gradient -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-extrabold mb-2 bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                Edit Gejala
            </h1>
            <p class="text-gray-600">Perbarui detail gejala dengan formulir di bawah ini</p>
        </div>

        <!-- Card with glass morphism effect -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-white/30">
            <!-- Card header with gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6">
                <h2 class="text-xl font-semibold text-white">Gejala Informasi</h2>
                <p class="text-indigo-100 text-sm">Edit detail di bawah ini</p>
            </div>

            <!-- Form container -->
            <div class="p-6 space-y-6">
                <form name="edit" action="?pages=editpro_gejala" method="post" class="space-y-6">
                    <input type="hidden" name="old_kd_gejala" value="<?= htmlspecialchars($data['kd_gejala']) ?>">

                    <!-- Kode Gejala Field -->
                    <div class="space-y-2">
                        <label for="kd_gejala" class="block text-sm font-medium text-gray-700">
                            Kode Gejala
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="kd_gejala" name="kd_gejala" value="<?= htmlspecialchars($data['kd_gejala']) ?>"
                                class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 border transition duration-300 ease-in-out hover:border-indigo-400" required>
                        </div>
                    </div>

                    <!-- Gejala Field -->
                    <div class="space-y-2">
                        <label for="gejala" class="block text-sm font-medium text-gray-700">
                            Deskripsi Gejala
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="gejala" name="gejala" value="<?= htmlspecialchars($data['gejala']) ?>"
                                class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 border transition duration-300 ease-in-out hover:border-indigo-400" required>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3 pt-4">
                        <a href="?pages=data_gejala" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Kembali
                        </a>
                        <button type="button" id="submit-button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Simpan Perubahan
                        </button>
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

        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 -z-10">
            <div class="bg-purple-300 opacity-20 rounded-full h-64 w-64 mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        </div>
        <div class="absolute bottom-0 left-0 -z-10">
            <div class="bg-indigo-300 opacity-20 rounded-full h-64 w-64 mix-blend-multiply filter blur-3xl animate-blob"></div>
        </div>
    </div>
</div>

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

<style>
    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }

        33% {
            transform: translate(30px, -50px) scale(1.1);
        }

        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }

        100% {
            transform: translate(0px, 0px) scale(1);
        }
    }

    .animate-blob {
        animation: blob 7s infinite;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
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