<?php
ob_start();
session_start();
require_once '../../Classes/Database.php';
require_once '../../Classes/Course.php'; // Include the Course class

// Check if the user is logged in and is a teacher (id_role = 2)
if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 2) {
    header('Location: ' . PROJECT_PATH . 'Pages/Auth/Log_in.php');
    exit();
}

// Handle Delete Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_course'])) {
    $courseId = $_POST['id_course'];
    $course = new Course($courseId);
    if ($course->delete()) {
        // Set a session variable to indicate success
        $_SESSION['delete_success'] = true;
    } else {
        $_SESSION['delete_success'] = false;
    }
    // Redirect to the same page to refresh the list after deletion
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Get the logged-in teacher's ID
$teacherId = $_SESSION['user']['id_user'];

// Fetch courses created by the teacher using the Course class
$courses = Course::showByTeacherWithDetails($teacherId);
?>

<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Your Courses</h2>
        <a href="add_course.php" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors flex items-center">
            <i class="fas fa-plus mr-2"></i> Add New Course
        </a>
    </div>

    <?php if (empty($courses)): ?>
        <p class="text-gray-600">No courses found.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($courses as $course): ?>
                <div class="bg-purple-100 p-4 rounded-lg shadow-lg card-hover transition-transform">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-500">Course</span>
                        <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                    </div>
                    <h3 class="text-lg font-bold text-purple-700"><?php echo htmlspecialchars($course['title']); ?></h3>
                    <p class="text-sm text-gray-600 mb-4"><?php echo htmlspecialchars($course['description']); ?></p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="px-2 py-1 bg-purple-200 text-purple-800 rounded-full text-xs">
                                <?php echo htmlspecialchars($course['category_name']); ?>
                            </span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-users text-blue-500 mr-2"></i>
                            <span class="text-sm text-gray-600"><?php echo $course['enrollment_count']; ?> students</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-gray-500 mb-2">Progress</div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                            <div class="bg-purple-700 h-2.5 rounded-full" style="width: <?php echo (($course['enrollment_count'] / 20) * 100); ?>%;"></div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="edit_course.php?id=<?php echo $course['id_course']; ?>" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition-colors flex items-center">
                            <i class="fas fa-edit mr-2"></i> Modify
                        </a>
                       <!-- Delete Button -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="id_course" value="<?php echo $course['id_course']; ?>">
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition-colors flex items-center">
                                <i class="fas fa-trash mr-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    // Check if the delete_success session variable is set
    <?php if (isset($_SESSION['delete_success'])): ?>
        <?php if ($_SESSION['delete_success']): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'The course has been deleted successfully.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        <?php else: ?>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to delete the course.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
        // Unset the session variable to prevent the alert from showing again on page refresh
        <?php unset($_SESSION['delete_success']); ?>
    <?php endif; ?>
</script>

<?php
$content = ob_get_clean();
require_once '../../Includes/Layout_Tutor.php';
?>