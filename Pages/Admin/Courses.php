<?php
ob_start();
session_start();
require_once '../../Classes/Database.php';
require_once '../../Classes/Course.php';
require_once '../../Classes/Tutor.php';

// Redirect if user is not logged in or is not an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
    header('Location: ' . PROJECT_PATH . 'Pages/Auth/Log_in.php');
    exit();
}

// Generate CSRF token if not already set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Get database connection
$db = Database::getInstance()->getConnection();

// Handle Activate Course
if (isset($_POST['activate_course']) && isset($_POST['id_course'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error_message'] = 'CSRF token validation failed.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $id_course = (int)$_POST['id_course'];
    $course = new Course($db, $id_course);
    if ($course->activate()) {
        $_SESSION['success_message'] = 'Course activated successfully.';
    } else {
        $_SESSION['error_message'] = 'Failed to activate course.';
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Deactivate Course
if (isset($_POST['deactivate_course']) && isset($_POST['id_course'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error_message'] = 'CSRF token validation failed.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $id_course = (int)$_POST['id_course'];
    $course = new Course($db, $id_course);
    if ($course->deactivate()) {
        $_SESSION['success_message'] = 'Course deactivated successfully.';
    } else {
        $_SESSION['error_message'] = 'Failed to deactivate course.';
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Delete Course
if (isset($_POST['delete_course']) && isset($_POST['id_course'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error_message'] = 'CSRF token validation failed.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $id_course = (int)$_POST['id_course'];
    $course = new Course($db, $id_course);
    if ($course->delete()) {
        $_SESSION['success_message'] = 'Course deleted successfully.';
    } else {
        $_SESSION['error_message'] = 'Failed to delete course.';
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch all courses
$course = new Course($db);
$courses = $course->showAll($db);
?>

<div class="p-4">
    <h1 class="text-xl text-center font-bold text-gray-800 mb-6">Manage Courses</h1>

    <!-- Display success/error messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error_message']) ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <table id="datatable" class="min-w-full bg-white rounded-lg shadow p-4 overflow-hidden">
        <thead>
            <tr class="bg-indigo-600 text-white">
                <th class="py-4 px-6 text-left font-semibold">Title</th>
                <th class="py-4 px-6 text-left font-semibold">Category</th>
                <th class="py-4 px-6 text-left font-semibold">Author</th>
                <th class="py-4 px-6 text-left font-semibold">Created at</th>
                <th class="py-4 px-6 text-left font-semibold">Price</th>
                <th class="py-4 px-6 text-left font-semibold">Status</th>
                <th class="py-4 px-6 text-center font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="py-4 px-6"><?= htmlspecialchars($course['title']) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($course['category']) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($course['first_name'] . ' ' . $course['last_name']) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($course['created_at']) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($course['price']) ?></td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $course['status'] === 'activated' ? 'bg-green-100 text-green-700' : ($course['status'] === 'awaiting' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') ?>">
                                <?= htmlspecialchars(ucfirst($course['status'])) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 flex justify-center space-x-4">
                            <?php if ($course['status'] !== 'activated'): ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                    <input type="hidden" name="id_course" value="<?= $course['id_course'] ?>">
                                    <button type="submit" name="activate_course" class="text-green-500 hover:text-green-700 transition-colors duration-300" title="Activate">
                                        <i class="fas fa-check-circle text-xl"></i>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if ($course['status'] !== 'suspended'): ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                    <input type="hidden" name="id_course" value="<?= $course['id_course'] ?>">
                                    <button type="submit" name="deactivate_course" class="text-yellow-500 hover:text-yellow-700 transition-colors duration-300" title="Deactivate">
                                        <i class="fas fa-pause-circle text-xl"></i>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Delete Button -->
                            <form action="" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <input type="hidden" name="id_course" value="<?= $course['id_course'] ?>">
                                <button type="submit" name="delete_course" class="text-red-500 hover:text-red-700 transition-colors duration-300" title="Delete">
                                    <i class="fas fa-trash-alt text-xl"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="py-4 px-6 text-center">No courses found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            responsive: true,
        });
    });
</script>

<?php
$content = ob_get_clean();
require_once '../../Includes/Layout_Admin.php';
?>