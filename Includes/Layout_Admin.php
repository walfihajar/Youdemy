<?php
require_once '../../Classes/Database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
  header('Location: ' . PROJECT_PATH . 'Pages/Auth/Log_in.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Youdemy-dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="../../Assets/css/style.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwind.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwind.min.css">

</head>

<body>
  <div class="flex min-h-screen flex-col md:flex-row">
    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar w-full md:w-1/5 bg-white h-screen shadow-lg p-6 fixed md:relative top-0 left-0 h-screen z-10 md:transform-none sidebar-hidden">
      <div class="mb-8">
        <a href="<?php echo PROJECT_PATH; ?>Pages/Visitor/index.php" class="flex items-center">
          <img src="../../Assets/uploads/logo.gif" class="w-10 h-10 md:w-12 md:h-12 lg:w-14 lg:h-14">
          <span class="text-custom-primary text-xl font-bold ml-2">Youdemy</span>
        </a>
      </div>
      
      <ul class="mb-8">
        <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
          <a href="<?php echo PROJECT_PATH; ?>Pages/Visitor/index.php">
            <i class="fas fa-home mr-2"></i><span>Home</span>
          </a>
        </li>

        <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
          <a href="<?php echo PROJECT_PATH; ?>Pages/Admin/Overview.php">
            <i class="fas fa-chart-bar mr-2"></i><span>Overview</span>
          </a>
        </li>

        <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
          <a href="<?php echo PROJECT_PATH; ?>Pages/Admin/Approve.php">
              <i class="fas fa-check-circle mr-2"></i><span>Approve</span>
          </a>
        </li>

        <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
        <a href="<?php echo PROJECT_PATH; ?>Pages/Admin/Learners.php">
            <i class="fas fa-users mr-2"></i><span>Learners</span>
        </a>
        </li>

        <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
        <a href="<?php echo PROJECT_PATH; ?>Pages/Admin/Tutors.php">
            <i class="fas fa-chalkboard-teacher mr-2"></i><span>Tutors</span>
        </a>
        </li>

        <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
        <a href="<?php echo PROJECT_PATH; ?>Pages/Admin/Courses.php">
            <i class="fas fa-book mr-2"></i><span>Courses</span>
        </a>
        </li>

        <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
        <a href="<?php echo PROJECT_PATH; ?>Pages/Admin/Categories.php">
            <i class="fas fa-layer-group mr-2"></i><span>Categories</span>
        </a>
        </li>

        <li class="mb-4 flex items-center text-gray-700 hover:text-yellow-500 transition-colors">
        <a href="<?php echo PROJECT_PATH; ?>Pages/Admin/Tags.php">
            <i class="fas fa-tag mr-2"></i><span>Tags</span>
        </a>
        </li>


        <li class="mb-4 flex items-center text-red-500 hover:text-red-700 transition-colors">
          <a href="<?php echo PROJECT_PATH; ?>Pages/Auth/Log_out.php">
            <i class="fas fa-sign-out-alt mr-2"></i><span>Logout</span>
          </a>
        </li>
      </ul>

    </nav>

    <!-- Sidebar Toggle Button -->
    <button id="sidebarToggle" class="md:hidden p-4 fixed top-4 left-4 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition-colors z-20">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Main Content -->
    <main class="w-full md:w-3/4 mx-auto pt-6  mt-20 md:mt-0">
      <?php
        echo $content;
      ?>
    </main>
  </div>

  <!-- Sidebar Toggle Script -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('sidebar-hidden');
    });
  </script>
</body>
</html>