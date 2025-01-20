<?php 
require_once '../../Classes/Database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="../Assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex space-x-7">
                    <a href="#" class="flex items-center">
                        <img src="../../Assets/uploads/logo.gif" class="w-10 h-10 md:w-12 md:h-12 lg:w-14 lg:h-14">
                        <span class="text-custom-primary text-xl font-bold ml-2">Youdemy</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="<?php echo PROJECT_PATH; ?>Pages/Visitor/index.php" class="text-gray-700 hover:text-custom-primary transition duration-300">Home</a>
                    <a href="<?php echo PROJECT_PATH; ?>Pages/Visitor/Courses.php" class="text-gray-700 hover:text-custom-primary transition duration-300">Courses</a>
                    <a href="#" class="text-gray-700 hover:text-custom-primary transition duration-300">Services</a>
                    <a href="#" class="text-gray-700 hover:text-custom-primary transition duration-300">About</a>
                    <a href="#" class="text-gray-700 hover:text-custom-primary transition duration-300">Contact</a>

                    <!-- Check if the user is logged in -->
                    <?php
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }
                        if (isset($_SESSION['user'])) {
                            $user = $_SESSION['user'];
                            if ($user['id_role'] == 1) {
                                echo '<a href="' . PROJECT_PATH . 'Pages/Admin/Overview.php" class="bg-purple-700 text-white rounded-full py-1 px-3 hover:bg-purple-700-dark transition duration-300">Dashboard</a>';
                            } else if ($user['id_role'] == 2) {
                                echo '<a href="' . PROJECT_PATH . 'Pages/Tutor/Overview.php" class="bg-purple-700 text-white rounded-full py-1 px-3 hover:bg-purple-700-dark transition duration-300">Profile</a>';
                            } else if ($user['id_role'] == 3) {
                                echo '<a href="' . PROJECT_PATH . 'Pages/Learner/Courses.php" class="bg-purple-700 text-white rounded-full py-1 px-3 hover:bg-purple-700-dark transition duration-300">Profile</a>';
                            }

                            echo '<a href="' . PROJECT_PATH . 'Pages/Auth/Log_out.php" class="bg-purple-700 text-white rounded-full py-1 px-3 hover:bg-purple-700-dark transition duration-300">Logout</a>';
                        } else {
                            echo '<a href="' . PROJECT_PATH . 'Pages/Auth/Log_in.php" class="bg-purple-700 text-white rounded-full py-1 px-3 hover:bg-purple-700-dark transition duration-300">Login</a>';
                            echo '<a href="' . PROJECT_PATH . 'Pages/Auth/Register.php" class="bg-purple-700 text-white rounded-full py-1 px-3 hover:bg-purple-700-dark transition duration-300">Register</a>';
                        }
                    ?>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="outline-none mobile-menu-button">
                        <svg class="w-6 h-6 text-gray-500 hover:stroke-custom-primary"
                            x-show="!showMenu"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="hidden mobile-menu">
            <ul>
                <li><a href="<?php echo PROJECT_PATH; ?>Pages/Visitor/index.php" class="block text-sm px-2 py-2 text-gray-700 ">Home</a></li>
                <li><a href="<?php echo PROJECT_PATH; ?>Pages/Visitor/Courses.php" class="block text-sm px-2 py-2 text-gray-700 ">Courses</a></li>
                <li><a href="<?php echo PROJECT_PATH; ?>Pages/Visitor/themes.php" class="block text-sm px-2 py-2 text-gray-700 ">Blog</a></li>
                <li><a href="#" class="block text-sm px-2 py-2 text-gray-700 ">Services</a></li>
                <li><a href="#" class="block text-sm px-2 py-2 text-gray-700 ">About</a></li>
                <li><a href="#" class="block text-sm px-2 py-2 text-gray-700 ">Contact</a></li>
                <?php
                    if (isset($_SESSION['email'])) {
                        if ($_SESSION['id_role'] == 1) {
                            echo '<li><a href="' . PROJECT_PATH . 'Pages/Admin/Overview.php" class="block text-sm px-2 py-2 text-gray-700 ">Dashboard</a></li>';
                        } else if ($_SESSION['id_role'] == 2) {
                            echo '<li><a href="' . PROJECT_PATH . 'Pages/Tutor/Overview.php" class="block text-sm px-2 py-2 text-gray-700 ">Profile</a></li>';
                        } else if ($_SESSION['id_role'] == 3) {
                            echo '<li><a href="' . PROJECT_PATH . 'Pages/Learner/Courses.php" class="block text-sm px-2 py-2 text-gray-700 ">Profile</a></li>';
                        }
                        echo '<li><a href="' . PROJECT_PATH . 'Pages/Auth/Log_out.php" class="block text-sm px-2 py-2 text-gray-700 ">Logout</a></li>';
                    } else {
                        echo '<li><a href="' . PROJECT_PATH . 'Pages/Auth/Log_in.php" class="block text-sm px-2 py-2 text-gray-700 ">Login</a></li>';
                        echo '<li><a href="' . PROJECT_PATH . 'Pages/Auth/Register.php" class="block text-sm px-2 py-2 text-gray-700 ">Register</a></li>';
                    }
                ?>
            </ul>
        </div>
    </nav>

    <script src='../Assets/js/main.js'></script>
</body>
</html>