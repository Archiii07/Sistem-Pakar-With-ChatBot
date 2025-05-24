<?php
include __DIR__ . '/../auth.php';
include '../koneksi.php';
?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="card bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 flex items-center">
            <div class="rounded-full bg-blue-100 p-4 text-blue-600">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Total Users</h3>
                <p class="text-2xl font-semibold text-gray-800">
                    <?php
                    $stmt = $conn->query("SELECT COUNT(*) FROM tbl_users");
                    echo $stmt->fetchColumn();
                    ?>
                </p>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 flex items-center">
            <div class="rounded-full bg-green-100 p-4 text-green-600">
                <i class="fas fa-disease text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Total Penyakit</h3>
                <p class="text-2xl font-semibold text-gray-800">
                    <?php
                    $stmt = $conn->query("SELECT COUNT(*) FROM tbl_informasi");
                    echo $stmt->fetchColumn();
                    ?>
                </p>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 flex items-center">
            <div class="rounded-full bg-purple-100 p-4 text-purple-600">
                <i class="fas fa-clipboard-list text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Total Gejala</h3>
                <p class="text-2xl font-semibold text-gray-800">
                    <?php
                    $stmt = $conn->query("SELECT COUNT(*) FROM tbl_gejala");
                    echo $stmt->fetchColumn();
                    ?>
                </p>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 flex items-center">
            <div class="rounded-full bg-yellow-100 p-4 text-yellow-600">
                <i class="fas fa-project-diagram text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Total Aturan</h3>
                <p class="text-2xl font-semibold text-gray-800">
                    <?php
                    $stmt = $conn->query("SELECT COUNT(*) FROM tbl_aturan");
                    echo $stmt->fetchColumn();
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="card bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="bg-blue-100 p-2 rounded-full text-blue-600">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">User baru ditambahkan</p>
                    <p class="text-xs text-gray-500">2 menit yang lalu</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="bg-green-100 p-2 rounded-full text-green-600">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">Aturan diperbarui</p>
                    <p class="text-xs text-gray-500">15 menit yang lalu</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="bg-purple-100 p-2 rounded-full text-purple-600">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">Gejala dihapus</p>
                    <p class="text-xs text-gray-500">1 jam yang lalu</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Sistem</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-xs font-semibold text-gray-500 uppercase">Diagnosa Hari Ini</h4>
                <p class="text-xl font-bold text-gray-800">12</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-xs font-semibold text-gray-500 uppercase">Diagnosa Bulan Ini</h4>
                <p class="text-xl font-bold text-gray-800">142</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-xs font-semibold text-gray-500 uppercase">User Aktif</h4>
                <p class="text-xl font-bold text-gray-800">8</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-xs font-semibold text-gray-500 uppercase">Penyakit Umum</h4>
                <p class="text-xl font-bold text-gray-800">Kudis</p>
            </div>
        </div>
    </div>
</div>

<div class="card bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Penyakit Terbaru</h3>
        <a href="?pages=data_informasi" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penyakit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $stmt = $conn->query("SELECT * FROM tbl_informasi ORDER BY id DESC LIMIT 5");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $row['kd_penyakit'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $row['nama_penyakit'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= substr($row['judul'], 0, 30) ?>...</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date('d M Y') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>