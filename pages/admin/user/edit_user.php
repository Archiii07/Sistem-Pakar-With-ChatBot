<?php
include __DIR__ . '/../../auth.php';
include '../koneksi.php';

// Get user ID from URL parameter
$id_user = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_user) {
    die("User ID not specified");
}

// Fetch user data from database
try {
    $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE id_user = :id_user");
    $stmt->bindParam(':id_user', $id_user);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found");
    }
} catch (PDOException $e) {
    die("Error fetching user data: " . $e->getMessage());
}
?>

<style>
    /* Modern Glassmorphism Style */
    .glass-card {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
    }

    .form-input {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(209, 213, 219, 0.3);
    }

    .form-input:focus {
        background: rgba(255, 255, 255, 0.95);
        border-color: rgba(99, 102, 241, 0.5);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    .floating-label {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-input:focus+.floating-label,
    .form-input:not(:placeholder-shown)+.floating-label {
        transform: translateY(-1.5rem) scale(0.85);
        color: #6366f1;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.8));
        padding: 0 8px;
        left: 12px;
    }

    .role-card input:checked+label {
        background: rgba(99, 102, 241, 0.1);
        border-color: #6366f1;
        box-shadow: 0 4px 20px -4px rgba(99, 102, 241, 0.3);
    }

    .password-strength-bar {
        height: 6px;
        border-radius: 3px;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Animated gradient background */
    .animated-gradient {
        background: linear-gradient(-45deg, #6366f1, #8b5cf6, #ec4899, #f43f5e);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
    }

    @keyframes gradient {
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

    /* Floating animation */
    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .floating {
        animation: float 6s ease-in-out infinite;
    }

    /* Custom checkbox */
    .custom-checkbox {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 2px solid #e5e7eb;
        transition: all 0.2s;
    }

    input:checked+.custom-checkbox {
        background-color: #6366f1;
        border-color: #6366f1;
    }

    /* Submit button hover effect */
    .submit-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
    }

    .submit-btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: all 0.5s;
    }

    .submit-btn:hover::after {
        left: 100%;
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

<div class="min-h-screen flex items-center justify-center p-4">
    <!-- Floating decorative elements -->
    <div class="fixed -z-10 w-full h-full overflow-hidden">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-purple-300/20 blur-3xl"></div>
        <div class="absolute top-1/3 right-1/4 w-80 h-80 rounded-full bg-pink-300/20 blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/3 w-72 h-72 rounded-full bg-indigo-300/20 blur-3xl"></div>
    </div>

    <div class="w-full max-w-4xl">
        <!-- Header with animated gradient -->
        <div class="animated-gradient rounded-t-3xl p-8 text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10 backdrop-blur-sm"></div>
            <div class="relative z-10">
                <h1 class="text-3xl md:text-4xl font-bold mb-2 flex items-center justify-center">
                    <i class="fas fa-user-edit mr-3"></i>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-white to-white/80">
                        Edit Data Pengguna
                    </span>
                </h1>
                <p class="text-white/90 font-medium">Perbarui informasi pengguna dalam sistem</p>
            </div>
        </div>

        <!-- Main form container -->
        <div class="glass-card rounded-b-3xl p-8 md:p-10">
            <form id="userForm" action="?pages=editpro_user" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_user" value="<?= htmlspecialchars($user['id_user']) ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left column -->
                    <div class="space-y-6">
                        <!-- Full Name -->
                        <div class="relative">
                            <input type="text" id="nama_lengkap" name="nama_lengkap"
                                class="form-input w-full px-5 py-4 rounded-xl placeholder-transparent"
                                placeholder=" " value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required>
                            <label for="nama_lengkap" class="floating-label absolute left-4 top-4 text-gray-500 pointer-events-none">
                                <i class="fas fa-user mr-2"></i>Nama Lengkap
                            </label>
                            <div class="absolute right-4 top-4 text-green-500" id="name-check">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="relative">
                            <input type="email" id="email" name="email"
                                class="form-input w-full px-5 py-4 rounded-xl placeholder-transparent"
                                placeholder=" " value="<?= htmlspecialchars($user['email']) ?>" required>
                            <label for="email" class="floating-label absolute left-4 top-4 text-gray-500 pointer-events-none">
                                <i class="fas fa-envelope mr-2"></i>Alamat Email
                            </label>
                            <div class="absolute right-4 top-4 text-green-500" id="email-check">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="relative">
                            <input type="text" id="username" name="username"
                                class="form-input w-full px-5 py-4 rounded-xl placeholder-transparent"
                                placeholder=" " value="<?= htmlspecialchars($user['username']) ?>" required>
                            <label for="username" class="floating-label absolute left-4 top-4 text-gray-500 pointer-events-none">
                                <i class="fas fa-at mr-2"></i>Username
                            </label>
                        </div>
                    </div>

                    <!-- Right column -->
                    <div class="space-y-6">
                        <!-- Password (optional for edit) -->
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                class="form-input w-full px-5 py-4 rounded-xl placeholder-transparent"
                                placeholder=" ">
                            <label for="password" class="floating-label absolute left-4 top-4 text-gray-500 pointer-events-none">
                                <i class="fas fa-lock mr-2"></i>Password Baru (kosongkan jika tidak diubah)
                            </label>
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-4 top-4 text-gray-500 hover:text-indigo-500 transition">
                                <i class="fas fa-eye" id="toggle-icon"></i>
                            </button>

                            <div class="mt-3 h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                                <div id="password-strength" class="h-full rounded-full transition-all duration-500"></div>
                            </div>
                            <p class="text-xs mt-1 text-gray-500" id="strength-text">Kekuatan password</p>
                        </div>

                        <!-- Address -->
                        <div class="relative">
                            <textarea id="alamat" name="alamat" rows="2"
                                class="form-input w-full px-5 py-4 rounded-xl placeholder-transparent"
                                placeholder=" " required><?= htmlspecialchars($user['alamat']) ?></textarea>
                            <label for="alamat" class="floating-label absolute left-4 top-4 text-gray-500 pointer-events-none">
                                <i class="fas fa-map-marker-alt mr-2"></i>Alamat Lengkap
                            </label>
                        </div>

                        <!-- Phone Number -->
                        <div class="relative">
                            <div class="absolute left-4 top-4 flex items-center text-gray-500">
                                +62
                            </div>
                            <input type="tel" id="no_hp" name="no_hp"
                                class="form-input w-full px-5 py-4 pl-12 rounded-xl placeholder-transparent"
                                placeholder=" " value="<?= htmlspecialchars($user['no_hp']) ?>" required>
                            <label for="no_hp" class="floating-label absolute left-12 top-4 text-gray-500 pointer-events-none">
                                Nomor Telepon
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="mt-10">
                    <h3 class="text-center text-xl font-semibold text-gray-700 mb-6">
                        <i class="fas fa-user-tag mr-2 text-indigo-500"></i>
                        Perbarui Role Pengguna
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-md mx-auto">
                        <!-- Admin Role -->
                        <div class="role-card">
                            <input type="radio" id="admin" name="title" value="admin" class="hidden peer"
                                <?= $user['title'] === 'admin' ? 'checked' : '' ?> required>
                            <label for="admin" class="block p-6 border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:border-indigo-300 peer-checked:border-indigo-500">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-4">
                                        <i class="fas fa-user-shield text-indigo-600 text-2xl"></i>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-800">Administrator</h4>
                                    <p class="text-sm text-gray-600 mt-2">Akses penuh ke semua fitur sistem</p>
                                    <div class="mt-4 px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full">
                                        Full Access
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- User Role -->
                        <div class="role-card">
                            <input type="radio" id="user" name="title" value="user" class="hidden peer"
                                <?= $user['title'] === 'user' ? 'checked' : '' ?>>
                            <label for="user" class="block p-6 border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:border-blue-300 peer-checked:border-blue-500">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-4">
                                        <i class="fas fa-user text-blue-600 text-2xl"></i>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-800">User</h4>
                                    <p class="text-sm text-gray-600 mt-2">Akses terbatas sesuai kebutuhan</p>
                                    <div class="mt-4 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                        Basic Access
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-12 flex flex-col sm:flex-row justify-center gap-5">
                    <a href="?pages=data_user" class="px-8 py-3.5 bg-white/90 border border-gray-200 rounded-xl font-medium text-gray-700 hover:bg-white hover:shadow-md transition-all flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <button type="button" id="submit-button" class="submit-btn px-8 py-3.5 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl font-bold text-white hover:from-indigo-600 hover:to-purple-700 hover:shadow-lg transition-all flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
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
                                    Apakah Anda yakin ingin menyimpan perubahan data pengguna ini?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl">
                    <button type="button" id="confirm-yes" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-base font-medium text-white hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105">
                        Ya, Simpan
                    </button>
                    <button type="button" id="confirm-no" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 hover:scale-105">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Toggle password visibility
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const icon = document.getElementById('toggle-icon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Password strength checker
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.getElementById('password-strength');
        const strengthText = document.getElementById('strength-text');

        // Reset
        strengthBar.style.width = '0%';
        strengthBar.className = 'h-full rounded-full transition-all duration-500';

        if (password.length === 0) {
            strengthText.textContent = 'Kekuatan password';
            strengthText.className = 'text-xs mt-1 text-gray-500';
            return;
        }

        // Calculate strength
        let strength = 0;
        if (password.length > 7) strength += 1;
        if (password.length > 10) strength += 1;
        if (/\d/.test(password)) strength += 1;
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 1;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 1;

        // Update UI
        let width = 0;
        let color = '';
        let text = '';

        switch (strength) {
            case 0:
            case 1:
                width = 30;
                color = 'bg-red-400';
                text = 'Lemah';
                break;
            case 2:
                width = 60;
                color = 'bg-yellow-400';
                text = 'Cukup';
                break;
            case 3:
                width = 80;
                color = 'bg-blue-400';
                text = 'Kuat';
                break;
            case 4:
            case 5:
                width = 100;
                color = 'bg-green-400';
                text = 'Sangat Kuat';
                break;
        }

        strengthBar.style.width = width + '%';
        strengthBar.classList.add(color);
        strengthText.textContent = 'Kekuatan: ' + text;
        strengthText.className = `text-xs mt-1 font-medium text-${color.replace('bg-', '')}`;
    });

    // Form validation
    function validateForm() {
        const nama = document.getElementById('nama_lengkap').value;
        const email = document.getElementById('email').value;
        const username = document.getElementById('username').value;
        const alamat = document.getElementById('alamat').value;
        const noHp = document.getElementById('no_hp').value;
        const role = document.querySelector('input[name="title"]:checked');

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const noHpPattern = /^[0-9]+$/;

        // Validate name
        if (nama.length < 3) {
            showError('Nama lengkap harus minimal 3 karakter');
            return false;
        }

        // Validate email
        if (!emailPattern.test(email)) {
            showError('Format email tidak valid');
            return false;
        }

        // Validate username
        if (username.length < 4) {
            showError('Username harus minimal 4 karakter');
            return false;
        }

        // Validate address
        if (alamat.length < 10) {
            showError('Alamat terlalu pendek');
            return false;
        }

        // Validate phone number
        if (!noHpPattern.test(noHp) || noHp.length < 9) {
            showError('Nomor telepon harus berupa angka dan minimal 9 digit');
            return false;
        }

        // Validate role
        if (!role) {
            showError('Silakan pilih role pengguna');
            return false;
        }

        return true;
    }

    // Show error message
    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            text: message,
            confirmButtonColor: '#6366f1',
            backdrop: `
                rgba(99, 102, 241, 0.1)
                url("data:image/svg+xml,%3Csvg width='52' height='26' viewBox='0 0 52 26' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%236366f1' fill-opacity='0.2'%3E%3Cpath d='M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E")
                left top
            `
        });
        return false;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const submitButton = document.getElementById('submit-button');
        const form = document.getElementById('userForm');
        const modal = document.getElementById('custom-confirm-modal');
        const confirmYes = document.getElementById('confirm-yes');
        const confirmNo = document.getElementById('confirm-no');

        // Hapus event listener submit yang lama dari form
        form.removeEventListener('submit', form.submit);

        submitButton.addEventListener('click', function(e) {
            e.preventDefault();

            // Validasi form
            if (validateForm()) {
                // Jika validasi berhasil, tampilkan modal konfirmasi
                modal.classList.remove('hidden');
            }
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