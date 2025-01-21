<?php
ob_start();
session_start();
require_once '../../Classes/Database.php';
require_once '../../Classes/Course.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
    header('Location: ' . PROJECT_PATH . 'Pages/Auth/Log_in.php');
    exit();
}

// Use the Singleton pattern to get the Database instance
$db = Database::getInstance();
$conn = $db->getConnection();

// Total Number of Courses
$totalCoursesQuery = "SELECT COUNT(*) AS total_courses FROM course";
$totalCoursesStmt = $conn->query($totalCoursesQuery);
$totalCourses = $totalCoursesStmt->fetch(PDO::FETCH_ASSOC)['total_courses'];

// Distribution by Category
$categoriesQuery = "SELECT c.name AS category, COUNT(co.id_course) AS course_count
                    FROM category c
                    LEFT JOIN course co ON c.id_category = co.id_category
                    GROUP BY c.name";
$categoriesStmt = $conn->query($categoriesQuery);
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

// Course with the Most Students
$mostEnrolledCourseQuery = "SELECT co.title, COUNT(e.id_user) AS enrollment_count
                            FROM course co
                            LEFT JOIN enrollement e ON co.id_course = e.id_course
                            GROUP BY co.id_course
                            ORDER BY enrollment_count DESC
                            LIMIT 1";
$mostEnrolledCourseStmt = $conn->query($mostEnrolledCourseQuery);
$mostEnrolledCourse = $mostEnrolledCourseStmt->fetch(PDO::FETCH_ASSOC);

// Top 3 Teachers
$topTeachersQuery = "SELECT u.first_name, u.last_name, COUNT(co.id_course) AS course_count
                     FROM user u
                     LEFT JOIN course co ON u.id_user = co.id_user
                     WHERE u.id_role = 2
                     GROUP BY u.id_user
                     ORDER BY course_count DESC
                     LIMIT 3";
$topTeachersStmt = $conn->query($topTeachersQuery);
$topTeachers = $topTeachersStmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <section class="mb-6">
        <h2 class="text-xl font-bold mb-4">Courses in Progress</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Number of Courses -->
            <div class="bg-purple-100 p-4 rounded-lg shadow-lg card-hover transition-transform">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-500">Total</span>
                    <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                </div>
                <div class="flex items-center mb-4">
                    <i class="fas fa-book text-purple-700 text-2xl mr-2"></i> <!-- Icon for Total Courses -->
                    <h3 class="text-lg font-bold text-purple-700">Total Courses</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4"><?php echo $totalCourses; ?> courses</p>
            </div>

            <!-- Course with Most Students -->
            <div class="bg-orange-100 p-4 rounded-lg shadow-lg card-hover transition-transform">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-500">Most Enrolled</span>
                    <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                </div>
                <div class="flex items-center mb-4">
                    <i class="fas fa-users text-orange-700 text-2xl mr-2"></i> <!-- Icon for Most Enrolled -->
                    <h3 class="text-lg font-bold text-orange-700"><?php echo $mostEnrolledCourse['title'] ?? 'No Data'; ?></h3>
                </div>
                <p class="text-sm text-gray-600 mb-4"><?php echo $mostEnrolledCourse['enrollment_count'] ?? 0; ?> enrollments</p>
            </div>

            <!-- Top Teachers -->
            <div class="bg-blue-100 p-4 rounded-lg shadow-lg card-hover transition-transform">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-500">Top Teachers</span>
                    <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                </div>
                <div class="flex items-center mb-4">
                    <i class="fas fa-chalkboard-teacher text-blue-700 text-2xl mr-2"></i> <!-- Icon for Top Teachers -->
                    <h3 class="text-lg font-bold text-blue-700">Top 3 Teachers</h3>
                </div>
                <ul class="text-sm text-gray-600 mb-4">
                    <?php foreach ($topTeachers as $teacher): ?>
                        <li><?php echo $teacher['first_name'] . ' ' . $teacher['last_name']; ?> - <?php echo $teacher['course_count']; ?> courses</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

<?php
$content = ob_get_clean();
require_once '../../Includes/Layout_Admin.php';
?>