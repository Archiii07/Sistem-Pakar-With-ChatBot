<?php
include __DIR__ . '/../../auth.php';
include '../koneksi.php';

$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $query = $conn->prepare("SELECT * FROM tbl_informasi WHERE id LIKE :search OR kd_penyakit LIKE :search OR nama_penyakit LIKE :search OR judul LIKE :search");
    $query->execute([':search' => "%$search%"]);
} else {
    $query = $conn->prepare("SELECT * FROM tbl_informasi");
    $query->execute();
}
$data = $query->fetchAll();
$count = $query->rowCount();

?>
<!-- Add SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Informasi Penyakit</h1>
                <p class="text-gray-600">Kelola data informasi penyakit dengan mudah</p>
            </div>
            <a href="?pages=tambah_informasi" class="mt-4 md:mt-0 flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Data
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <form method="get" action="" class="flex flex-col md:flex-row gap-4">
                <input type="hidden" name="pages" value="data_informasi" />
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari ID, Kode Penyakit, Nama Penyakit, atau Judul..." class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" />
                </div>
                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    Cari
                </button>
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-500 to-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Kode</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama Penyakit</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Judul</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Deskripsi</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Pencegahan</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($data as $index => $row) : ?>
                            <tr class="<?= $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' ?> hover:bg-blue-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $row['id'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $row['kd_penyakit'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><?= $row['nama_penyakit'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate"><?= $row['judul'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate"><?= $row['deskripsi'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate"><?= $row['pencegahan'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="?pages=edit_informasi&id=<?= $row['id'] ?>" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <a href="?pages=hapus_informasi&id=<?= $row['id'] ?>"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 delete-informasi"
                                            data-id="<?= htmlspecialchars($row['id'], ENT_QUOTES) ?>"
                                            data-judul="<?= htmlspecialchars($row['judul'], ENT_QUOTES) ?>"
                                            data-namapenyakit="<?= htmlspecialchars($row['nama_penyakit'], ENT_QUOTES) ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination or Count -->
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    Menampilkan <span class="font-medium"><?= count($data) ?></span> dari <span class="font-medium"><?= $count ?></span> hasil
                </div>
                <!-- Pagination would go here -->
            </div>
        </div>
    </div>
</div>

<script>
    // Delete confirmation with SweetAlert2
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.delete-informasi').forEach(el => {
            el.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.getAttribute('data-id');
                const judul = this.getAttribute('data-judul');
                const namaPenyakit = this.getAttribute('data-namapenyakit');
                const url = this.getAttribute('href');

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    html: `<div class="text-left">
                          <p class="mb-4">Anda akan menghapus informasi penyakit:</p>
                          <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                              <div class="flex">
                                  <div class="flex-shrink-0">
                                      <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                      </svg>
                                  </div>
                                  <div class="ml-3">
                                      <h3 class="text-sm font-medium text-red-800">${namaPenyakit}</h3>
                                      <div class="mt-2 text-sm text-red-700">
                                          <p>${judul}</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <p class="text-red-600 font-medium">Aksi ini tidak dapat dibatalkan!</p>
                      </div>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    focusCancel: true,
                    customClass: {
                        popup: 'rounded-xl',
                        title: 'text-xl font-bold text-gray-800',
                        htmlContainer: 'text-gray-600',
                        confirmButton: 'px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all',
                        cancelButton: 'px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all'
                    },
                    buttonsStyling: false,
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to delete URL if confirmed
                        window.location.href = url;

                        // Show loading indicator while redirecting
                        Swal.fire({
                            title: 'Menghapus...',
                            html: 'Sedang memproses penghapusan informasi',
                            timer: 1500,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                // Auto-closed by timer
                            }
                        });
                    }
                });
            });
        });
    });
</script>