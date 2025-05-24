<?php
include __DIR__ . '/../../auth.php';
include '../koneksi.php';

$search = '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$params = [];
$whereClause = '';

if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $search = trim($_GET['search']);
    $whereClause = "WHERE id_user LIKE :search OR nama_lengkap LIKE :search OR username LIKE :search OR title LIKE :search";
    $params[':search'] = "%$search%";
}

// Get total count for pagination
$countSql = "SELECT COUNT(*) FROM tbl_users $whereClause";
$countStmt = $conn->prepare($countSql);
$countStmt->execute($params);
$totalUsers = $countStmt->fetchColumn();
$totalPages = ceil($totalUsers / $limit);

// Fetch users with limit and offset
$sql = "SELECT * FROM tbl_users $whereClause ORDER BY id_user DESC LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);

// Bind parameters
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value, PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Pengguna</h1>
            <p class="text-gray-600">Kelola data pengguna sistem</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <!-- Search Form -->
            <form method="get" action="" class="flex-1 md:flex-none">
                <div class="relative">
                    <input type="hidden" name="pages" value="data_user" />
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                        placeholder="Cari pengguna..."
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </form>

            <!-- Add User Button -->
            <a href="?pages=tambah_user" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center">
                <i class="fas fa-user-plus mr-2"></i> Tambah User
            </a>
        </div>
    </div>

    <!-- User Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <?php if (count($users) > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?= $user['id_user'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?= $user['nama_lengkap'] ?></div>
                                            <div class="text-sm text-gray-500"><?= $user['no_hp'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @<?= $user['username'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $user['email'] ?? '-' ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $user['title'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' ?>">
                                        <?= ucfirst($user['title']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="?pages=edit_user&id=<?= $user['id_user'] ?>"
                                            class="text-blue-600 hover:text-blue-900 transition-colors"
                                            data-tooltip="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?pages=hapus_user&id=<?= $user['id_user'] ?>"
                                            class="text-red-600 hover:text-red-900 transition-colors delete-user"
                                            data-username="<?= htmlspecialchars($user['nama_lengkap'], ENT_QUOTES) ?>"
                                            data-userid="<?= $user['id_user'] ?>"
                                            data-tooltip="Hapus User">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="?pages=data_user&search=<?= urlencode($search) ?>&page=<?= max(1, $page - 1) ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 <?= $page <= 1 ? 'pointer-events-none opacity-50' : '' ?>">
                        Previous
                    </a>
                    <a href="?pages=data_user&search=<?= urlencode($search) ?>&page=<?= min($totalPages, $page + 1) ?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 <?= $page >= $totalPages ? 'pointer-events-none opacity-50' : '' ?>">
                        Next
                    </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Menampilkan <span class="font-medium"><?= $offset + 1 ?></span> sampai <span class="font-medium"><?= min($offset + $limit, $totalUsers) ?></span> dari <span class="font-medium"><?= $totalUsers ?></span> hasil
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="?pages=data_user&search=<?= urlencode($search) ?>&page=<?= max(1, $page - 1) ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 <?= $page <= 1 ? 'pointer-events-none opacity-50' : '' ?>">
                                <span class="sr-only">Previous</span>
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?pages=data_user&search=<?= urlencode($search) ?>&page=<?= $i ?>" aria-current="<?= $i === $page ? 'page' : '' ?>" class="<?= $i === $page ? 'z-10 bg-blue-50 border-blue-500 text-blue-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50' ?> relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                            <a href="?pages=data_user&search=<?= urlencode($search) ?>&page=<?= min($totalPages, $page + 1) ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 <?= $page >= $totalPages ? 'pointer-events-none opacity-50' : '' ?>">
                                <span class="sr-only">Next</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400">
                    <i class="fas fa-users-slash text-5xl"></i>
                </div>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada pengguna</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada data pengguna yang tersedia.</p>
                <div class="mt-6">
                    <a href="?pages=tambah_user" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-plus -ml-1 mr-2"></i> Tambah User Baru
                    </a>
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

    // Remove the confirmDelete function since we will handle confirmation via event listeners

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.delete-user').forEach(el => {
            el.addEventListener('click', function(event) {
                event.preventDefault();
                const userName = this.getAttribute('data-username');
                const userId = this.getAttribute('data-userid');
                const url = this.getAttribute('href');

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    html: `<div class="text-left">
                          <p class="mb-4">Anda akan menghapus user:</p>
                          <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                              <div class="flex">
                                  <div class="flex-shrink-0">
                                      <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                      </svg>
                                  </div>
                                  <div class="ml-3">
                                      <h3 class="text-sm font-medium text-red-800">${userName}</h3>
                                      <div class="mt-2 text-sm text-red-700">
                                          <p>ID User: ${userId}</p>
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
                            html: 'Sedang memproses penghapusan user',
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
    });
</script>