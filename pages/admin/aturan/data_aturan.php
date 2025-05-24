<?php
include __DIR__ . '/../../auth.php';
include '../koneksi.php';

// Add pagination similar to data_gejala.php
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$params = [];
$whereClause = '';

if (!empty($search)) {
    $whereClause = "WHERE (g.gejala LIKE :search OR p.nama_penyakit LIKE :search OR a.kd_gejala LIKE :search)";
    $params[':search'] = "%$search%";
}

// Get total count for pagination
$countSql = "SELECT COUNT(*) FROM tbl_aturan a 
             JOIN tbl_informasi p ON a.kd_penyakit = p.kd_penyakit 
             JOIN tbl_gejala g ON a.kd_gejala = g.kd_gejala $whereClause";
$countStmt = $conn->prepare($countSql);
$countStmt->execute($params);
$totalAturan = $countStmt->fetchColumn();
$totalPages = ceil($totalAturan / $limit);

// Fetch data with limit and offset
$query = "SELECT a.kd_penyakit, p.nama_penyakit, a.kd_gejala, g.gejala
          FROM tbl_aturan a
          JOIN tbl_informasi p ON a.kd_penyakit = p.kd_penyakit
          JOIN tbl_gejala g ON a.kd_gejala = g.kd_gejala
          $whereClause
          ORDER BY a.kd_penyakit, a.kd_gejala
          LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($query);

// Bind parameters
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value, PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();

// Group data by kd_penyakit
$groupedData = [];
foreach ($rows as $row) {
    $groupedData[$row['kd_penyakit']]['nama_penyakit'] = $row['nama_penyakit'];
    $groupedData[$row['kd_penyakit']]['gejala'][] = [
        'kd_gejala' => $row['kd_gejala'],
        'gejala' => $row['gejala'],
        // Remove bobot from display as per request
        //'bobot' => $row['bobot']
    ];
}
?>

<!-- Add SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Data Aturan Diagnosa</h1>
                <p class="text-indigo-600">Kelola hubungan antara gejala dan penyakit</p>
            </div>
            <a href="?pages=tambah_aturan" class="mt-4 md:mt-0 flex items-center space-x-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>Tambah Aturan Baru</span>
            </a>
        </div>

        <!-- Search and Filter Card -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <form method="get" action="" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                <input type="hidden" name="pages" value="data_aturan" />
                <div class="relative flex-grow w-full md:w-auto">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari berdasarkan gejala, penyakit, atau kode..." class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 transition duration-300" />
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
            <?php if (count($groupedData) > 0): ?>
                <div class="space-y-6">
                    <?php $no = ($page - 1) * $limit + 1; ?>
                    <?php foreach ($groupedData as $kd_penyakit => $data): ?>
                        <!-- Disease Card -->
                        <div class="border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                            <!-- Disease Header -->
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-white/20 rounded-full text-white font-bold">
                                        <?= substr(htmlspecialchars($kd_penyakit), 0, 4) ?>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-xl font-semibold text-white">
                                            <?= htmlspecialchars($kd_penyakit) ?> - <?= htmlspecialchars($data['nama_penyakit']) ?>
                                        </h3>
                                    </div>
                                </div>
                                <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    <?= count($data['gejala']) ?> Gejala Terkait
                                </span>
                            </div>

                            <!-- Symptoms Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-indigo-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Kode Gejala</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-700 uppercase tracking-wider">Gejala</th>
                                            <!-- Remove Bobot column header -->
                                            <!-- <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-indigo-700 uppercase tracking-wider">Bobot</th> -->
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-indigo-700 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach ($data['gejala'] as $gejala): ?>
                                            <tr class="hover:bg-indigo-50 transition duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-indigo-600">
                                                        <?= htmlspecialchars($gejala['kd_gejala']) ?>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 max-w-md">
                                                        <?= htmlspecialchars($gejala['gejala']) ?>
                                                    </div>
                                                </td>
                                                <!-- Remove Bobot column data -->
                                                <!-- <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-yellow-100 text-yellow-800 font-medium">
                                                        <?= htmlspecialchars($gejala['bobot']) ?>
                                                    </span>
                                                </td> -->
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex justify-end space-x-3">
                                                        <a href="?pages=edit_aturan&kd_penyakit=<?= urlencode($kd_penyakit) ?>&kd_gejala=<?= urlencode($gejala['kd_gejala']) ?>"
                                                            class="text-indigo-600 hover:text-indigo-900 flex items-center space-x-1 transition duration-300"
                                                            data-tooltip="Edit Aturan">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                            </svg>
                                                            <span>Edit</span>
                                                        </a>
                                                        <a href="?pages=hapus_aturan&kd_penyakit=<?= urlencode($kd_penyakit) ?>&kd_gejala=<?= urlencode($gejala['kd_gejala']) ?>"
                                                            class="text-red-600 hover:text-red-900 flex items-center space-x-1 transition duration-300 delete-aturan"
                                                            data-kdpenyakit="<?= htmlspecialchars($kd_penyakit, ENT_QUOTES) ?>"
                                                            data-kdgejala="<?= htmlspecialchars($gejala['kd_gejala'], ENT_QUOTES) ?>"
                                                            data-gejala="<?= htmlspecialchars($gejala['gejala'], ENT_QUOTES) ?>"
                                                            data-tooltip="Hapus Aturan">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span>Hapus</span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php $no++; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 flex items-center justify-center bg-gray-100 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-700 mb-2">Tidak ada data aturan ditemukan</h3>
                    <p class="text-gray-500">Coba gunakan kata kunci pencarian yang berbeda</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="bg-white px-6 py-4 flex items-center justify-between border-t border-gray-200 rounded-b-xl">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="?pages=data_aturan&search=<?= urlencode($search) ?>&page=<?= max(1, $page - 1) ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 <?= $page <= 1 ? 'pointer-events-none opacity-50' : '' ?>">
                        Previous
                    </a>
                    <a href="?pages=data_aturan&search=<?= urlencode($search) ?>&page=<?= min($totalPages, $page + 1) ?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 <?= $page >= $totalPages ? 'pointer-events-none opacity-50' : '' ?>">
                        Next
                    </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Menampilkan <span class="font-medium"><?= $offset + 1 ?></span> sampai <span class="font-medium"><?= min($offset + $limit, $totalAturan) ?></span> dari <span class="font-medium"><?= $totalAturan ?></span> hasil
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="?pages=data_aturan&search=<?= urlencode($search) ?>&page=<?= max(1, $page - 1) ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 <?= $page <= 1 ? 'pointer-events-none opacity-50' : '' ?>">
                                <span class="sr-only">Previous</span>
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?pages=data_aturan&search=<?= urlencode($search) ?>&page=<?= $i ?>" aria-current="<?= $i === $page ? 'page' : '' ?>" class="<?= $i === $page ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50' ?> relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                            <a href="?pages=data_aturan&search=<?= urlencode($search) ?>&page=<?= min($totalPages, $page + 1) ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 <?= $page >= $totalPages ? 'pointer-events-none opacity-50' : '' ?>">
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
        document.querySelectorAll('.delete-aturan').forEach(el => {
            el.addEventListener('click', function(event) {
                event.preventDefault();
                const kdPenyakit = this.getAttribute('data-kdpenyakit');
                const kdGejala = this.getAttribute('data-kdgejala');
                const gejala = this.getAttribute('data-gejala');
                const url = this.getAttribute('href');

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    html: `<div class="text-left">
                          <p class="mb-4">Anda akan menghapus aturan untuk gejala:</p>
                          <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                              <div class="flex">
                                  <div class="flex-shrink-0">
                                      <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                      </svg>
                                  </div>
                                  <div class="ml-3">
                                      <h3 class="text-sm font-medium text-red-800">${kdPenyakit} - ${kdGejala}</h3>
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
                            html: 'Sedang memproses penghapusan aturan',
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