<?php
include __DIR__ . '/../../auth.php';
include '../koneksi.php';

if (!isset($_GET['id'])) {
    echo '<div class="text-center mb-4">';
    echo '<p class="text-lg font-bold text-red-600">ID tidak ditemukan!</p>';
    echo '</div>';
    echo "<meta http-equiv='refresh' content='1; url=?pages=data_informasi'>";
    exit;
}

$id = $_GET['id'];

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('SELECT * FROM tbl_informasi WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo '<div class="text-center mb-4">';
        echo '<p class="text-lg font-bold text-red-600">Data tidak ditemukan!</p>';
        echo '</div>';
        echo "<meta http-equiv='refresh' content='1; url=?pages=data_informasi'>";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden mb-8 transform transition-all hover:scale-[1.01]">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white">Edit Informasi Penyakit</h1>
                        <p class="text-indigo-200 mt-1">Perbarui dan kelola detail penyakit</p>
                    </div>
                    <div class="bg-white/10 p-3 rounded-lg backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all hover:shadow-2xl">
            <form name="edit" action="?pages=editpro_informasi" method="post" enctype="multipart/form-data" class="p-6 sm:p-8">
                <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Kode Penyakit -->
                    <div class="space-y-2">
                        <label for="kd_penyakit" class="block text-sm font-medium text-gray-700">Kode Penyakit</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="kd_penyakit" name="kd_penyakit" value="<?= htmlspecialchars($data['kd_penyakit']) ?>" class="pl-10 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                        </div>
                    </div>

                    <!-- Nama Penyakit -->
                    <div class="space-y-2">
                        <label for="nama_penyakit" class="block text-sm font-medium text-gray-700">Nama Penyakit</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <input type="text" id="nama_penyakit" name="nama_penyakit" value="<?= htmlspecialchars($data['nama_penyakit']) ?>" class="pl-10 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                        </div>
                    </div>
                </div>

                <!-- Judul -->
                <div class="mb-6">
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($data['judul']) ?>" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <div class="mt-1">
                        <textarea id="deskripsi" name="deskripsi" rows="5" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                    </div>
                </div>

                <!-- Pencegahan -->
                <div class="mb-6">
                    <label for="pencegahan" class="block text-sm font-medium text-gray-700">Pencegahan</label>
                    <div class="mt-1">
                        <textarea id="pencegahan" name="pencegahan" rows="5" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required><?= htmlspecialchars($data['pencegahan']) ?></textarea>
                    </div>
                </div>

                <!-- Gambar Saat Ini -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Gambar Saat Ini</label>
                    <div class="mt-2 flex items-center">
                        <?php if (!empty($data['img'])): ?>
                            <div class="group relative">
                                <img src="../img/artikel/<?= htmlspecialchars($data['img']) ?>" alt="Gambar Penyakit" class="h-32 w-32 rounded-lg object-cover shadow-md border-2 border-white ring-2 ring-indigo-200 group-hover:ring-indigo-400 transition-all">
                                <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                    <span class="text-white text-sm font-medium">Gambar Saat Ini</span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="h-32 w-32 rounded-lg bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-300">
                                <span class="text-gray-400">Tidak ada gambar</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Unggah Gambar -->
                <div class="mb-8">
                    <label for="img" class="block text-sm font-medium text-gray-700">Ganti Gambar (opsional)</label>
                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="img" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Unggah file</span>
                                    <input id="img" name="img" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF maksimal 10MB</p>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <a href="?pages=data_informasi" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
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