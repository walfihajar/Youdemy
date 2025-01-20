<?php
// Include necessary files
require_once '../../Classes/Database.php';
require_once '../../Classes/Course.php';
require_once '../../Includes/Header.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: ../Auth/Log_in.php');
    exit();
}

// Get database connection
$db = Database::getInstance()->getConnection();

// Get the logged-in user's ID
$userId = $_SESSION['user']['id_user'];

// Fetch enrolled courses for the student
$enrolledCourses = Course::getEnrolledCourses($db, $userId);

// Fetch total number of enrolled courses
$totalEnrolledCourses = Course::countEnrolledCourses($db, $userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-8 md:py-12">
        <div class="container mx-auto text-center px-4">
            <h1 class="text-3xl md:text-5xl font-bold mb-2 md:mb-4">My Dashboard</h1>
            <p class="text-sm md:text-lg">View all the courses you have enrolled in.</p>
        </div>
    </header>

    <!-- Summary Card -->
    <div class="container mx-auto p-4 md:p-8">
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-xl font-bold text-purple-700 mb-4">Summary</h2>
            <div class="flex items-center space-x-4">
                <div class="bg-purple-100 p-4 rounded-lg">
                    <i class="fas fa-book-open text-purple-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-600">Total Courses Enrolled</p>
                    <p class="text-2xl font-bold text-purple-700"><?= $totalEnrolledCourses ?></p>
                </div>
            </div>
        </div>

        <!-- Enrolled Courses Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8">
            <?php if (!empty($enrolledCourses)): ?>
                <?php foreach ($enrolledCourses as $course): ?>
                    <div class="bg-white p-4 md:p-6 rounded-lg shadow-md transition-transform hover:shadow-lg">
                        <!-- Course Image -->
                        <img src="<?= htmlspecialchars($course['picture']) ?>" alt="Course Image" class="w-full h-40 md:h-48 object-cover rounded-lg mb-4">

                        <!-- Course Title -->
                        <h3 class="text-lg md:text-xl font-bold text-purple-700 mb-2">
                            <?= htmlspecialchars($course['title']) ?>
                        </h3>

                        <!-- Tutor Name -->
                        <p class="text-xs md:text-sm text-gray-600 mb-2">
                            Tutor: <?= htmlspecialchars($course['tutor_first_name'] . ' ' . $course['tutor_last_name']) ?>
                        </p>

                        <!-- Course Created At -->
                        <p class="text-xs md:text-sm text-gray-600 mb-2">
                            Course Created: <?= date('F j, Y', strtotime($course['course_created_at'])) ?>
                        </p>

                        <!-- Enrollment Date -->
                        <p class="text-xs md:text-sm text-gray-600 mb-4">
                            Enrolled On: <?= date('F j, Y', strtotime($course['enrolled_in'])) ?>
                        </p>

                        <!-- View Course Button -->
                        <div class="mt-4">
                            <a href="./CourseDetails.php?id=<?= $course['id_course'] ?>" class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors text-sm md:text-base text-center block">
                                View Course
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-600 col-span-full">You have not enrolled in any courses yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>