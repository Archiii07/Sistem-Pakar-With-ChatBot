<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistem Pakar Diagnosa Penyakit Kulit</title>
  <link href="./src/output.css" rel="stylesheet" />
  <link href="./src/input1.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            poppins: ['Poppins', 'sans-serif'],
          },
          colors: {
            primary: {
              600: '#dc2626',
              700: '#b91c1c',
              800: '#991b1b',
            },
            secondary: {
              100: '#f3f4f6',
              200: '#e5e7eb',
              700: '#374151',
            }
          }
        }
      }
    }
  </script>
  <style>
    .hero-bg {
      background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('img/skin-bg.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .nav-link {
      position: relative;
    }

    .nav-link:after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 0;
      background-color: #dc2626;
      transition: width 0.3s ease;
    }

    .nav-link:hover:after {
      width: 100%;
    }

    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body class="font-poppins bg-gray-50 min-h-screen flex flex-col">
  <?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  include 'koneksi.php';
  ?>
  <?php
  if (isset($_SESSION['username'])) {
    if ($_SESSION['status'] == 'user') {
      $user = $_SESSION['username'];
      $title = $_SESSION['status'];
      if (!isset($_GET['pages']) || $_GET['pages'] !== 'cs_ai') {
        // Include popup_cs only if not on popup_cs page to avoid duplicate display
        include './pages/cs_ai/popup_cs.php';
      }
    }
  }
  if (isset($_GET['pages']) && $_GET['pages'] === 'cs_ai') {
    // If cs_ai page is requested, include only cs_ai.php without header, navbar, footer, content
    include './pages/cs_ai/cs_ai.php';
  } elseif (!isset($_GET['pages']) || $_GET['pages'] !== 'popup_cs') {
  ?>
    <?php include './pages/navbar.php'; ?>
    <?php include './content.php'; ?>
    <?php include './pages/footer.php'; ?>
  <?php
  }
  ?>

</body>
<script>
  // Mobile menu toggle
  document.querySelector('button[aria-controls="mobile-menu"]').addEventListener('click', function() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
  });
</script>

</html>