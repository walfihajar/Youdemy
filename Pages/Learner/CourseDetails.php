<?php
require_once '../../Classes/Database.php';
require_once '../../Classes/Course.php';
require_once '../../Classes/Enrollement.php'; 
require_once '../../Includes/Header.php';
ob_start();

$db = Database::getInstance()->getConnection();

$courseId = (int) $_GET['id'];
$course = Course::getCourseDetails($db, $courseId);

if (!$course) {
    echo "<p class='text-center text-gray-600'>Course not found.</p>";
    exit();
}

$isLoggedIn = isset($_SESSION['user']);
$userId = $isLoggedIn ? $_SESSION['user']['id_user'] : null;
$userRole = $isLoggedIn ? $_SESSION['user']['id_role'] : null;

$enrollment = new Enrollment($db, $courseId, $userId);
$isEnrolled = $isLoggedIn ? $enrollment->isUserEnrolled() : false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoggedIn && $userRole === 3) {
    $success = $enrollment->enrollUser();

    if ($success) {
        $_SESSION['success_message'] = 'You have successfully enrolled in the course. Study well!';
        header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $courseId);
        exit();
    } else {
        $_SESSION['error_message'] = 'You are already enrolled in this course.';
    }
}
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
                <?php if ($course['type'] === 'video' && !empty($course['url_video'])): ?>
                    <!-- Afficher la vidéo -->
                    <div class="video-container mb-4">
                        <iframe 
                            width="560" 
                            height="315" 
                            src="<?= htmlspecialchars($course['url_video']) ?>" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                <?php elseif ($course['type'] === 'text' && !empty($course['content_text'])): ?>
                    <!-- Afficher le texte -->
                    <div class="text-content bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-600"><?= nl2br(htmlspecialchars($course['content_text'])) ?></p>
                    </div>
                <?php else: ?>
                    <!-- Aucun contenu disponible -->
                    <p class="text-gray-600">No content available for this course.</p>
                <?php endif; ?>
            </div>

            <!-- Enroll Now Button -->
            <?php if ($isLoggedIn && $userRole === 3 && !$isEnrolled): ?>
                <form method="POST" action="">
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors text-sm md:text-base">
                            Enroll Now
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- SweetAlert2 Script -->
    <script>
        <?php if (isset($_SESSION['success_message'])): ?>
            Swal.fire({
                title: 'Enrolled Successfully!',
                text: '<?= $_SESSION['success_message'] ?>',
                icon: 'success',
                confirmButtonText: 'Go to Dashboard',
                showCancelButton: true,
                cancelButtonText: 'Close'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './Dashboard.php';
                }
            });
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            Swal.fire({
                title: 'Already Enrolled!',
                text: '<?= $_SESSION['error_message'] ?>',
                icon: 'info',
                confirmButtonText: 'Go to Dashboard'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './Dashboard.php';
                }
            });
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    </script>
</body>
</html>