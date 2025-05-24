<?php
include __DIR__ . '/../auth.php';
include 'koneksi.php';

$query = $conn->prepare("SELECT * FROM tbl_informasi");
$query->execute();
$data = $query->fetchAll();
$count = $query->rowCount();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Penyakit</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7ff;
        }

        .card {
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-overlay {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            animation: modalFadeIn 0.4s ease-out;
            max-height: 80vh;
            overflow-y: auto;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-out {
            animation: modalFadeOut 0.3s ease-in;
        }

        @keyframes modalFadeOut {
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        .desc-modal {
            background: linear-gradient(135deg, #fdfcfb 0%, #e2d1c3 100%);
        }

        .prev-modal {
            background: linear-gradient(135deg, #f3f9fb 0%, #d1e7f2 100%);
        }

        .btn-desc {
            background: linear-gradient(to right, #4361ee, #3f37c9);
            transition: all 0.3s;
        }

        .btn-desc:hover {
            background: linear-gradient(to right, #3f37c9, #4361ee);
        }

        .btn-prev {
            background: linear-gradient(to right, #4cc9f0, #4895ef);
            transition: all 0.3s;
        }

        .btn-prev:hover {
            background: linear-gradient(to right, #4895ef, #4cc9f0);
        }

        .no-data-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
    </style>
</head>

<body class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto pb-8 pt-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Informasi Penyakit</h1>

        <?php if ($count > 0) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($data as $row) : ?>
                    <div class="card group">
                        <div class="relative overflow-hidden h-48">
                            <img src="img/artikel/<?= $row['img'] ?>" alt="<?= $row['nama_penyakit'] ?>" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-4">
                                <span class="inline-block px-3 py-1 text-xs font-semibold tracking-wider text-white bg-amber-500 rounded-full">Penyakit</span>
                                <h3 class="mt-2 text-xl font-bold text-white"><?= $row['nama_penyakit'] ?></h3>
                            </div>
                        </div>

                        <div class="p-5">
                            <h2 class="text-xl font-bold text-gray-800 mb-3"><?= $row['judul'] ?></h2>

                            <div class="flex space-x-3 mt-4">
                                <button onclick="openModal('desc-<?= $row['id'] ?>')" class="btn-desc text-white px-4 py-2 rounded-lg font-medium flex-1 text-center">
                                    Deskripsi
                                </button>
                                <button onclick="openModal('prev-<?= $row['id'] ?>')" class="btn-prev text-white px-4 py-2 rounded-lg font-medium flex-1 text-center">
                                    Pencegahan
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Deskripsi -->
                    <div id="desc-<?= $row['id'] ?>" class="fixed inset-0 z-50 flex items-center justify-center hidden">
                        <div class="modal-overlay absolute inset-0"></div>
                        <div class="modal-content desc-modal relative max-w-4xl w-full mx-4 rounded-xl overflow-hidden shadow-2xl">
                            <button onclick="closeModal('desc-<?= $row['id'] ?>')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <div class="p-6 sm:p-8">
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">Deskripsi <?= $row['nama_penyakit'] ?></h2>
                                <div class="prose max-w-none text-gray-700 mt-4">
                                    <?= nl2br($row['deskripsi']) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Pencegahan -->
                    <div id="prev-<?= $row['id'] ?>" class="fixed inset-0 z-50 flex items-center justify-center hidden">
                        <div class="modal-overlay absolute inset-0"></div>
                        <div class="modal-content prev-modal relative max-w-4xl w-full mx-4 rounded-xl overflow-hidden shadow-2xl">
                            <button onclick="closeModal('prev-<?= $row['id'] ?>')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <div class="p-6 sm:p-8">
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">Pencegahan <?= $row['nama_penyakit'] ?></h2>
                                <div class="prose max-w-none text-gray-700 mt-4">
                                    <?= nl2br($row['pencegahan']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="no-data-card max-w-md mx-auto rounded-xl shadow-md overflow-hidden p-8 text-center">
                <div class="text-gray-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada data</h3>
                <p class="text-gray-500">Data penyakit belum tersedia saat ini.</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('modal-out');
            document.body.style.overflow = 'auto';

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('modal-out');
            }, 300);
        }

        // Close modal when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-overlay')) {
                const modal = e.target.parentElement;
                modal.classList.add('modal-out');
                document.body.style.overflow = 'auto';

                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('modal-out');
                }, 300);
            }
        });
    </script>
</body>

</html>