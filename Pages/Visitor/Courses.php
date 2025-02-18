<?php

require_once '../../Classes/Database.php';
require_once '../../Classes/Course.php';
require_once '../../Includes/Header.php';


$db = Database::getInstance()->getConnection();

$search = isset($_GET['search']) ? trim($_GET['search']) : '';


$perPage = 6; 
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; 

$courses = Course::showInCatalogue($db, $page, $perPage, $search);

$totalCourses = Course::countCourses($db, $search);
$totalPages = ceil($totalCourses / $perPage); 

$isLoggedIn = isset($_SESSION['user']);
$userRole = $isLoggedIn ? $_SESSION['user']['id_role'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Catalogue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
</head>
<body class="bg-gray-100">

    <header class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-8 md:py-12">
        <div class="container mx-auto text-center px-4">
            <h1 class="text-3xl md:text-5xl font-bold mb-2 md:mb-4">Course Catalogue</h1>
            <p class="text-sm md:text-lg">Explore and enroll in our wide range of courses.</p>
        </div>
    </header>


    <div class="container mx-auto p-4 md:p-8">
        <form action="" method="GET" class="mb-6">
            <div class="flex items-center">
                <input type="text" name="search" placeholder="Search courses..." value="<?= htmlspecialchars($search) ?>" class="w-full px-4 py-2 rounded-l-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600">
                <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-r-lg hover:bg-purple-700 transition-colors">Search</button>
            </div>
        </form>
    </div>

    <div class="container mx-auto p-4 md:p-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <div class="bg-white p-4 md:p-6 rounded-lg shadow-md card-hover transition-transform">

                        <img src="<?= htmlspecialchars($course['picture']) ?>" alt="Course Image" class="w-full h-40 md:h-48 object-cover rounded-lg mb-4">

                        <h3 class="text-lg md:text-xl font-bold text-purple-700 mb-2"><?= htmlspecialchars($course['title']) ?></h3>
                        <p class="text-xs md:text-sm text-gray-600 mb-4">By <?= htmlspecialchars($course['first_name'] . ' ' . $course['last_name']) ?></p>


                        <div class="flex items-center justify-between mb-4">
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs md:text-sm">
                                <?= htmlspecialchars($course['category']) ?>
                            </span>
                            <div class="flex items-center">
                                <i class="fas fa-users text-purple-500 mr-2 text-xs md:text-sm"></i>
                                <span class="text-xs md:text-sm text-gray-600"><?= $course['enrollment_count'] ?? 0 ?> students</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button onclick="handleViewDetails(<?= $course['id_course'] ?>)" class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors text-sm md:text-base">
                                View Details
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-600 col-span-full">
                    <?= empty($search) ? 'No courses available.' : 'No courses found for "' . htmlspecialchars($search) . '".'; ?>
                </p>
            <?php endif; ?>
        </div>
    </div>


    <div class="flex justify-center mt-6 md:mt-8 mb-8 md:mb-12">
        <?php if ($totalPages > 1): ?>
            <div class="flex space-x-2">

                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>" class="pagination-button px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm md:text-base">Previous</a>
                <?php else: ?>
                    <span class="px-4 py-2 bg-purple-300 text-white rounded-lg text-sm md:text-base cursor-not-allowed">Previous</span>
                <?php endif; ?>


                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>" class="pagination-button px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm md:text-base">Next</a>
                <?php else: ?>
                    <span class="px-4 py-2 bg-purple-300 text-white rounded-lg text-sm md:text-base cursor-not-allowed">Next</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function handleViewDetails(courseId) {
        const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false'; ?>;

        if (!isLoggedIn) {
            Swal.fire({
                title: 'You need an account!',
                text: 'Please register or log in to view course details.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Register',
                cancelButtonText: 'Log In'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../Auth/Register.php';
                } else if (result.isDismissed) {
                    window.location.href = '../Auth/Log_in.php';
                }
            });
        } else {
            window.location.href = `../Learner/CourseDetails.php?id=${courseId}`;
        }
    }
    </script>
</body>
</html>