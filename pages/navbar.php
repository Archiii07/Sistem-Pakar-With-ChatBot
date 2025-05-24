<!-- Navigation -->
<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-bacteria text-primary-600 text-2xl"></i>
                </div>
                <div class="hidden md:block ml-10 flex items-baseline space-x-8">
                    <?php
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    if (isset($_SESSION['username'])) {
                        if ($_SESSION['status'] == 'user') {
                            $user = $_SESSION['username'];
                            $title = $_SESSION['status'];

                            echo "<a href='?pages=home' class='nav-link text-gray-700 hover:text-primary-600 px-3 py-2 font-medium'>Home</a>";
                            echo "<a href='?pages=informasi' class='nav-link text-gray-700 hover:text-primary-600 px-3 py-2 font-medium'>Informasi</a>";
                            echo "<a href='?pages=profil' class='nav-link text-gray-700 hover:text-primary-600 px-3 py-2 font-medium'>Profil</a>";
                            echo "<a href='?pages=tentang' class='nav-link text-gray-700 hover:text-primary-600 px-3 py-2 font-medium'>Tentang</a>";
                        }
                    } else {
                        echo "<a href='?pages=home' class='nav-link text-gray-700 hover:text-primary-600 px-3 py-2 font-medium'>Home</a>";
                        echo "<a href='?pages=tentang' class='nav-link text-gray-700 hover:text-primary-600 px-3 py-2 font-medium'>Tentang</a>";
                    }
                    ?>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo "<span class='text-gray-700 mr-4'><span class='font-medium'>Hai, </span>$title $user</span>";
                        echo "<a href='pages/logout.php' class='bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md font-medium transition duration-300 flex items-center'><i class='fas fa-sign-out-alt mr-2'></i> Logout</a>";
                    } else {
                        echo "<a href='pages/login.php' class='bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md font-medium transition duration-300 flex items-center'><i class='fas fa-sign-in-alt mr-2'></i> Login</a>";
                    }
                    ?>
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-primary-600 focus:outline-none" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <?php
            if (isset($_SESSION['username'])) {
                if ($_SESSION['status'] == 'user') {
                    echo "<a href='?pages=home' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Home</a>";
                    echo "<a href='?pages=informasi' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Informasi</a>";
                    echo "<a href='?pages=profil' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Profil</a>";
                    echo "<a href='?pages=tentang' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Tentang</a>";
                } elseif ($_SESSION['status'] == 'admin') {
                    echo "<a href='?pages=home' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Home</a>";
                    echo "<a href='?pages=data_informasi' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Data Informasi</a>";
                    echo "<a href='?pages=data_gejala' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Data Gejala</a>";
                    echo "<a href='?pages=data_aturan' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Data Aturan</a>";
                    echo "<a href='?pages=data_user' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Data User</a>";
                    echo "<a href='?pages=tentang' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Tentang</a>";
                }
                echo "<div class='pt-4 border-t border-gray-200'>";
                echo "<p class='px-3 py-2 text-base font-medium text-gray-700'>Logged in as: $title $user</p>";
                echo "<a href='pages/logout.php' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Logout</a>";
                echo "</div>";
            } else {
                echo "<a href='?pages=home' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Home</a>";
                echo "<a href='?pages=tentang' class='block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600'>Tentang</a>";
                echo "<a href='pages/login.php' class='block px-3 py-2 text-base font-medium text-green-600 hover:text-green-700'>Login</a>";
            }
            ?>
        </div>
    </div>
</nav>