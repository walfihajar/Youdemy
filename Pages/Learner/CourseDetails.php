<?php
// Include necessary files
require_once '../../Classes/Database.php';
require_once '../../Classes/Course.php';
require_once '../../Includes/Header.php';

// Get database connection
$db = Database::getInstance()->getConnection();

// Check if course ID is provided
if (!isset($_GET['id'])) {
    header('Location: ../Catalogue/Catalogue.php');
    exit();
}

$courseId = (int) $_GET['id'];

// Fetch course details
$course = Course::getCourseDetails($db, $courseId);

if (!$course) {
    echo "<p class='text-center text-gray-600'>Course not found.</p>";
    exit();
}

// Check if the user is logged in and get their role
$isLoggedIn = isset($_SESSION['user']);
$userId = $isLoggedIn ? $_SESSION['user']['id_user'] : null;
$userRole = $isLoggedIn ? $_SESSION['user']['id_role'] : null;

// Check if the user is already enrolled in the course
$isEnrolled = $isLoggedIn ? Course::isUserEnrolled($db, $userId, $courseId) : false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($course['title']) ?> - Course Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-8 md:py-12">
        <div class="container mx-auto text-center px-4">
            <h1 class="text-3xl md:text-5xl font-bold mb-2 md:mb-4"><?= htmlspecialchars($course['title']) ?></h1>
            <p class="text-sm md:text-lg">By <?= htmlspecialchars($course['first_name'] . ' ' . $course['last_name']) ?></p>
        </div>
    </header>

    <!-- Course Details -->
    <div class="container mx-auto p-4 md:p-8">
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
            <!-- Course Image -->
            <img src="<?= htmlspecialchars($course['picture']) ?>" alt="Course Image" class="w-full h-64 md:h-80 object-cover rounded-lg mb-6">

            <!-- Course Description -->
            <div class="mb-6">
                <h3 class="text-xl font-bold text-purple-700 mb-2">Description</h3>
                <p class="text-gray-600"><?= htmlspecialchars($course['description']) ?></p>
            </div>

            <!-- Course Content -->
            <div class="mb-6">
                <h3 class="text-xl font-bold text-purple-700 mb-2">Course Content</h3>
                <p class="text-gray-600"><?= htmlspecialchars($course['content']) ?></p>
            </div>

            <!-- Enroll Now Button -->
            <?php if ($isLoggedIn && $userRole === 3): ?>
                <div class="mt-6">
                    <button onclick="handleEnroll(<?= $courseId ?>)" class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors text-sm md:text-base">
                        <?= $isEnrolled ? 'Go to Dashboard' : 'Enroll Now' ?>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function handleEnroll(courseId) {
            const isEnrolled = <?= $isEnrolled ? 'true' : 'false'; ?>;

            if (isEnrolled) {
                Swal.fire({
                    title: 'Already Enrolled!',
                    text: 'You are already enrolled in this course. Check your dashboard to access it.',
                    icon: 'info',
                    confirmButtonText: 'Go to Dashboard'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../Learner/Dashboard.php';
                    }
                });
            } else {
                Swal.fire({
                    title: 'Enrolled Successfully!',
                    text: 'You have successfully enrolled in the course. Study well!',
                    icon: 'success',
                    confirmButtonText: 'Go to Dashboard',
                    showCancelButton: true,
                    cancelButtonText: 'Close'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../Learner/Dashboard.php';
                    }
                });
            }
        }
    </script>
</body>
</html>