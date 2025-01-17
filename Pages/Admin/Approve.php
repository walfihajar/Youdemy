<?php
ob_start();
session_start();
require_once '../../Classes/Database.php';
require_once '../../Classes/Course.php';
require_once '../../Classes/Tutor.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
    header('Location: ' . PROJECT_PATH . 'Pages/Auth/Log_in.php');
    exit();
}

if (isset($_POST['activate_user']) && isset($_POST['id_user'])) {
    $tutor = new Tutor();
    $id_user = $_POST['id_user'];
    if ($tutor->activateTutor($id_user)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_POST['delete_user']) && isset($_POST['id_user'])) {
    $tutor = new Tutor();
    $id_user = $_POST['id_user'];
    if ($tutor->deleteTutor($id_user)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

$tutor = new Tutor();
$users = $tutor->approveTutor(); 
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
                        <td class="py-4 px-6"><?= htmlspecialchars($user['first_name']) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($user['last_name']) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($user['email']) ?></td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $user['status'] === 'activated' ? 'bg-green-100 text-green-700' : ($user['status'] === 'awaiting' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') ?>">
                                <?= htmlspecialchars($user['status']) ?>
                            </span>
                        </td>
                        <td class="py-4 px-6 flex justify-center space-x-4">
                            <!-- Activate Button -->
                            <form action="" method="POST">
                                <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                <button type="submit" name="activate_user" class="text-green-500 hover:text-green-700 transition-colors duration-300" title="Activate">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </button>
                            </form>

                            <!-- Delete Button -->
                            <form action="" method="POST">
                                <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                <button type="submit" name="delete_user" class="text-red-500 hover:text-red-700 transition-colors duration-300" title="Delete">
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
            error: false,
        });
    });
</script>

<?php
$content = ob_get_clean();
require_once '../../Includes/Layout_Admin.php';
?>