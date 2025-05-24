<?php
include __DIR__ . '/../../auth.php';
include '../koneksi.php';

// Tambahkan pagination seperti di data_user.php
$search = '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$params = [];
$whereClause = '';

if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $search = trim($_GET['search']);
    $whereClause = "WHERE kd_gejala LIKE :search OR gejala LIKE :search";
    $params[':search'] = "%$search%";
}

// Get total count for pagination
$countSql = "SELECT COUNT(*) FROM tbl_gejala $whereClause";
$countStmt = $conn->prepare($countSql);
$countStmt->execute($params);
$totalGejala = $countStmt->fetchColumn();
$totalPages = ceil($totalGejala / $limit);

// Fetch data with limit and offset
$sql = "SELECT * FROM tbl_gejala $whereClause ORDER BY kd_gejala DESC LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);

// Bind parameters
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value, PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();
?>

<!-- Tambahkan SweetAlert2 CSS dan JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Data Gejala</h1>
                <p class="text-indigo-600">Kelola data gejala penyakit dengan mudah</p>
            </div>
            <a href="?pages=tambah_gejala" class="mt-4 md:mt-0 flex items-center space-x-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>Tambah Gejala Baru</span>
            </a>
        </div>

        <!-- Search and Filter Card -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <form method="get" action="" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                <input type="hidden" name="pages" value="data_gejala" />
                <div class="relative flex-grow w-full md:w-auto">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari berdasarkan kode atau gejala..." class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 transition duration-300" />
                </div>
                <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-full shadow-md transition duration-300 flex items-center space-x-2">
                    <span>Cari</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Data Table Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Kode Gejala</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Gejala</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-indigo-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($data as $row) : ?>
                            <tr class="hover:bg-indigo-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-indigo-100 rounded-full">
                                            <span class="text-indigo-600 font-medium"><?= substr(htmlspecialchars($row['kd_gejala']), 0, 2) ?></span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($row['kd_gejala']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-md"><?= htmlspecialchars($row['gejala']) ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <a href="?pages=edit_gejala&kd_gejala=<?= urlencode($row['kd_gejala']) ?>" class="text-indigo-600 hover:text-indigo-900 flex items-center space-x-1 transition duration-300" data-tooltip="Edit Gejala">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                            <span>Edit</span>
                                        </a>
                                        <a href="?pages=hapus_gejala&kd_gejala=<?= urlencode($row['kd_gejala']) ?>"
                                            class="text-red-600 hover:text-red-900 flex items-center space-x-1 transition duration-300 delete-gejala"
                                            data-kdgejala="<?= htmlspecialchars($row['kd_gejala'], ENT_QUOTES) ?>"
                                            data-gejala="<?= htmlspecialchars($row['gejala'], ENT_QUOTES) ?>"
                                            data-tooltip="Hapus Gejala">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            <span>Hapus</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if ($count === 0) : ?>
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-lg">Tidak ada data gejala ditemukan</p>
                                        <p class="text-sm mt-1">Coba gunakan kata kunci pencarian yang berbeda</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1) : ?>
                <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <a href="?pages=data_gejala&search=<?= urlencode($search) ?>&page=<?= max(1, $page - 1) ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 <?= $page <= 1 ? 'pointer-events-none opacity-50' : '' ?>">
                            Previous
                        </a>
                        <a href="?pages=data_gejala&search=<?= urlencode($search) ?>&page=<?= min($totalPages, $page + 1) ?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 <?= $page >= $totalPages ? 'pointer-events-none opacity-50' : '' ?>">
                            Next
                        </a>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Menampilkan <span class="font-medium"><?= $offset + 1 ?></span> sampai <span class="font-medium"><?= min($offset + $limit, $totalGejala) ?></span> dari <span class="font-medium"><?= $totalGejala ?></span> hasil
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <a href="?pages=data_gejala&search=<?= urlencode($search) ?>&page=<?= max(1, $page - 1) ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 <?= $page <= 1 ? 'pointer-events-none opacity-50' : '' ?>">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                    <a href="?pages=data_gejala&search=<?= urlencode($search) ?>&page=<?= $i ?>" aria-current="<?= $i === $page ? 'page' : '' ?>" class="<?= $i === $page ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50' ?> relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        <?= $i ?>
                                    </a>
                                <?php endfor; ?>
                                <a href="?pages=data_gejala&search=<?= urlencode($search) ?>&page=<?= min($totalPages, $page + 1) ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 <?= $page >= $totalPages ? 'pointer-events-none opacity-50' : '' ?>">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Tooltip functionality
    document.querySelectorAll('[data-tooltip]').forEach(el => {
        el.addEventListener('mouseover', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute z-10 px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg';
            tooltip.textContent = this.getAttribute('data-tooltip');

            const rect = this.getBoundingClientRect();
            tooltip.style.top = `${rect.top - 30}px`;
            tooltip.style.left = `${rect.left + rect.width/2}px`;
            tooltip.style.transform = 'translateX(-50%)';

            tooltip.id = 'current-tooltip';
            document.body.appendChild(tooltip);
        });

        el.addEventListener('mouseout', function() {
            const tooltip = document.getElementById('current-tooltip');
            if (tooltip) tooltip.remove();
        });
    });

    // Delete confirmation with SweetAlert2
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.delete-gejala').forEach(el => {
            el.addEventListener('click', function(event) {
                event.preventDefault();
                const kdGejala = this.getAttribute('data-kdgejala');
                const gejala = this.getAttribute('data-gejala');
                const url = this.getAttribute('href');

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    html: `<div class="text-left">
                          <p class="mb-4">Anda akan menghapus gejala:</p>
                          <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                              <div class="flex">
                                  <div class="flex-shrink-0">
                                      <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                      </svg>
                                  </div>
                                  <div class="ml-3">
                                      <h3 class="text-sm font-medium text-red-800">${kdGejala}</h3>
                                      <div class="mt-2 text-sm text-red-700">
                                          <p>${gejala}</p>
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
                            html: 'Sedang memproses penghapusan gejala',
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