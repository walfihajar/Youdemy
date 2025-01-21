<?php
ob_start();
session_start();
require_once '../../Classes/Database.php';
require_once '../../Classes/Tutor.php';

// Redirect if user is not logged in or is not an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
    header('Location: ' . PROJECT_PATH . 'Pages/Auth/Log_in.php');
    exit();
}

// Get database connection
$db = Database::getInstance()->getConnection();

// Handle Activate/Deactivate Tutor
if (isset($_POST['activate_user']) && isset($_POST['id_user'])) {
    $id_user = (int)$_POST['id_user'];
    $tutor = new Tutor($db, $id_user);
    if ($tutor->activate()) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_POST['deactivate_user']) && isset($_POST['id_user'])) {
    $id_user = (int)$_POST['id_user'];
    $tutor = new Tutor($db, $id_user);
    if ($tutor->deactivate()) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Handle Delete Tutor
if (isset($_POST['delete_user']) && isset($_POST['id_user'])) {
    $id_user = (int)$_POST['id_user'];
    $tutor = new Tutor($db, $id_user);
    if ($tutor->delete()) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch all tutors
$tutor = new Tutor($db);
$users = Tutor::showTutors($db);
?>

<div class="p-4">
    <h1 class="text-xl text-center font-bold text-gray-800 mb-6">Manage Tutors</h1>
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
                        <td class="py-4 px-6"><?= htmlspecialchars($user->getFirstName()) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($user->getLastName()) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($user->getEmail()) ?></td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $user->getStatus() === 'activated' ? 'bg-green-100 text-green-700' : ($user->getStatus() === 'awaiting' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') ?>">
                                <?= htmlspecialchars($user->getStatus()) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 flex justify-center space-x-4">
                            <!-- Activate/Deactivate Button -->
                            <?php if ($user->getStatus() === 'activated'): ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="id_user" value="<?= $user->getIdUser() ?>">
                                    <button type="submit" name="deactivate_user" class="text-yellow-500 hover:text-yellow-700 transition-colors duration-300" title="Suspend">
                                        <i class="fas fa-pause-circle text-xl"></i> <!-- Changed to pause icon -->
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="id_user" value="<?= $user->getIdUser() ?>">
                                    <button type="submit" name="activate_user" class="text-green-500 hover:text-green-700 transition-colors duration-300" title="Activate">
                                        <i class="fas fa-check-circle text-xl"></i>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Delete Button -->
                            <form action="" method="POST">
                                <input type="hidden" name="id_user" value="<?= $user->getIdUser() ?>">
                                <button type="submit" name="delete_user" class="text-red-500 hover:text-red-700 transition-colors duration-300" title="Delete">
                                    <i class="fas fa-trash-alt text-xl"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="py-4 px-6 text-center">No tutors found.</td>
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