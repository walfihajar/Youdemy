<?php
ob_start();
session_start();
require_once '../../Classes/Database.php';
require_once '../../Classes/Learner.php';

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

// Handle Activate Learner
if (isset($_POST['activate_learner']) && isset($_POST['id_user'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error_message'] = 'CSRF token validation failed.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $id_user = (int)$_POST['id_user'];
    $learner = new Learner($db, $id_user);
    if ($learner->activateLearner()) {
        $_SESSION['success_message'] = 'Learner activated successfully.';
    } else {
        $_SESSION['error_message'] = 'Failed to activate learner.';
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Deactivate Learner
if (isset($_POST['deactivate_learner']) && isset($_POST['id_user'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error_message'] = 'CSRF token validation failed.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $id_user = (int)$_POST['id_user'];
    $learner = new Learner($db, $id_user);
    if ($learner->deactivateLearner()) {
        $_SESSION['success_message'] = 'Learner deactivated successfully.';
    } else {
        $_SESSION['error_message'] = 'Failed to deactivate learner.';
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Delete Learner
if (isset($_POST['delete_learner']) && isset($_POST['id_user'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error_message'] = 'CSRF token validation failed.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    $id_user = (int)$_POST['id_user'];
    $learner = new Learner($db, $id_user);
    if ($learner->deleteLearner()) {
        $_SESSION['success_message'] = 'Learner deleted successfully.';
    } else {
        $_SESSION['error_message'] = 'Failed to delete learner.';
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch all learners
$learners = Learner::showLearners($db);
?>

<div class="p-4">
    <h1 class="text-xl text-center font-bold text-gray-800 mb-6">Manage Learners</h1>

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
                <th class="py-4 px-6 text-left font-semibold">Name</th>
                <th class="py-4 px-6 text-left font-semibold">Email</th>
                <th class="py-4 px-6 text-left font-semibold">Status</th>
                <th class="py-4 px-6 text-center font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php if (!empty($learners)): ?>
                <?php foreach ($learners as $learner): ?>
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="py-4 px-6"><?= htmlspecialchars($learner->getFirstName() . ' ' . $learner->getLastName()) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($learner->getEmail()) ?></td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $learner->getStatus() === 'activated' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                <?= htmlspecialchars(ucfirst($learner->getStatus())) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 flex justify-center space-x-4">
                            <?php if ($learner->getStatus() !== 'activated'): ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                    <input type="hidden" name="id_user" value="<?= $learner->getIdUser() ?>">
                                    <button type="submit" name="activate_learner" class="text-green-500 hover:text-green-700 transition-colors duration-300" title="Activate">
                                        <i class="fas fa-check-circle text-xl"></i>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if ($learner->getStatus() !== 'suspended'): ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                    <input type="hidden" name="id_user" value="<?= $learner->getIdUser() ?>">
                                    <button type="submit" name="deactivate_learner" class="text-yellow-500 hover:text-yellow-700 transition-colors duration-300" title="Deactivate">
                                        <i class="fas fa-pause-circle text-xl"></i>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Delete Button -->
                            <form action="" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <input type="hidden" name="id_user" value="<?= $learner->getIdUser() ?>">
                                <button type="submit" name="delete_learner" class="text-red-500 hover:text-red-700 transition-colors duration-300" title="Delete">
                                    <i class="fas fa-trash-alt text-xl"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="py-4 px-6 text-center">No learners found.</td>
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