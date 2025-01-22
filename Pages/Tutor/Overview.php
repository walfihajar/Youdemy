<?php
session_start();

require_once '../../Classes/Database.php';
require_once '../../Classes/User.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 2) {
    header('Location: ' . PROJECT_PATH . 'Pages/Auth/Login.php');
    exit();
}

if ($_SESSION['user']['status'] != STATUS::activated->value) {
    header('Location: ../Tutor/Awaiting.php');
    exit();
}
$id_teacher = $_SESSION['user']['id_user'];
$db = Database::getInstance()->getConnection();


$stmtCourses = $db->prepare("SELECT COUNT(*) as course_number FROM course WHERE id_user = :id_teacher");
$stmtCourses->bindParam(':id_teacher', $id_teacher, PDO::PARAM_INT);
$stmtCourses->execute();
$course_number= $stmtCourses->fetch(PDO::FETCH_ASSOC)['course_number'];

$stmtStudents = $db->prepare("
    SELECT 
        COUNT(DISTINCT e.id_user) as learners_number 
    FROM 
        enrollement e 
    INNER JOIN 
        course c ON e.id_course = c.id_course 
    WHERE 
        c.id_user = :id_teacher
        
");
$stmtStudents->bindParam(':id_teacher', $id_teacher, PDO::PARAM_INT);
$stmtStudents->execute();
$studentCount = $stmtStudents->fetch(PDO::FETCH_ASSOC)['learners_number'];


$stmtBestSeller = $db->prepare("SELECT c.title, COUNT(e.id_user) as enrollment_count FROM course c LEFT JOIN enrollement e ON c.id_course = e.id_course 
                                WHERE c.id_user = :id_teacher GROUP BY c.id_course ORDER BY enrollment_count DESC LIMIT 1");
                    
$stmtBestSeller->bindParam(':id_teacher', $id_teacher, PDO::PARAM_INT);
$stmtBestSeller->execute();
$bestSellerCourse = $stmtBestSeller->fetch(PDO::FETCH_ASSOC);

ob_start();
?>
    
    <section class="mb-6">
        <h2 class="text-xl font-bold mb-4">Courses in Progress</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-purple-100 p-4 rounded-lg shadow-lg card-hover transition-transform">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-500">Total</span>
                    <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                </div>
                <h3 class="text-lg font-bold text-purple-700">Your Courses</h3>
                <p class="text-sm text-gray-600 mb-4"><?php echo $course_number; ?> courses</p>
            </div>

            
            <div class="bg-orange-100 p-4 rounded-lg shadow-lg card-hover transition-transform">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-500">Total</span>
                    <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                </div>
                <h3 class="text-lg font-bold text-orange-700">Enrolled Students</h3>
                <p class="text-sm text-gray-600 mb-4"><?php echo $studentCount; ?> students</p>
            </div>

            
            <div class="bg-blue-100 p-4 rounded-lg shadow-lg card-hover transition-transform">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-500">Best Seller</span>
                    <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer"></i>
                </div>
                <h3 class="text-lg font-bold text-blue-700"><?php echo $bestSellerCourse['title'] ?? 'No Data'; ?></h3>
                <p class="text-sm text-gray-600 mb-4"><?php echo $bestSellerCourse['enrollment_count'] ?? 0; ?> enrollments</p>
            </div>
        </div>
    </section>

    
<?php
$content = ob_get_clean();
require_once '../../Includes/Layout_Tutor.php';
?>