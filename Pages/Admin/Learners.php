<?php
ob_start();
session_start();
require_once '../../Classes/Database.php';
require_once '../../Classes/Course.php';
require_once '../../Classes/Learner.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
    header('Location: ' . PROJECT_PATH . 'Pages/Auth/Log_in.php');
    exit();
}

if (isset($_POST['activate_learner']) && isset($_POST['id_user'])) {
    $learner = new Learner();
    $id_user = $_POST['id_user'];
    if ($learner->activatelearner($id_user)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_POST['deactivate_learner']) && isset($_POST['id_user'])) {
    $learner = new Learner();
    $id_user = $_POST['id_user'];
    if ($learner->deactivateLearner($id_user)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_POST['delete_learner']) && isset($_POST['id_user'])) {
    $learner = new Learner();
    $id_user = $_POST['id_user'];
    if ($learner->deleteLearner($id_user)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

$learner = new Learner();
$users = $learner->showLearners(); 
?>

<div class="p-4">
    <h1 class="text-xl text-center font-bold text-gray-800 mb-6">Manage Learners</h1>
    <table id="datatable" class="min-w-full bg-white rounded-lg shadow p-4 overflow-hidden">
        <thead>
            <tr class="bg-indigo-600 text-white">
                <th class="py-4 px-6 text-left font-semibold">Prénom</th>
                <th class="py-4 px-6 text-left font-semibold">Nom</th>
                <th class="py-4 px-6 text-left font-semibold">Email</th>
                <th class="py-4 px-6 text-left font-semibold">Statut</th>
                <th class="py-4 px-6 text-center font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="py-4 px-6"><?= htmlspecialchars($user['first_name']) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($user['last_name']) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($user['email']) ?></td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $user['status'] === 'activated' ? 'bg-green-100 text-green-700' : ($user['status'] === 'awaiting' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') ?>">
                                <?= htmlspecialchars(ucfirst($user['status'])) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 flex justify-center space-x-4">
                            <?php if ($user['status'] !== 'activated'): ?>
                                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to activate this user?');">
                                    <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                    <button type="submit" name="activate_learner" class="text-green-500 hover:text-green-700 transition-colors duration-300" title="Activate">
                                        <i class="fas fa-check-circle text-xl"></i>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if ($user['status'] !== 'suspended'): ?>
                                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to deactivate this user?');">
                                    <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                    <button type="submit" name="deactivate_learner" class="text-yellow-500 hover:text-yellow-700 transition-colors duration-300" title="Deactivate">
                                        <i class="fas fa-pause-circle text-xl"></i>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Delete Button -->
                            <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                <button type="submit" name="delete_learner" class="text-red-500 hover:text-red-700 transition-colors duration-300" title="Delete">
                                    <i class="fas fa-trash-alt text-xl"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
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