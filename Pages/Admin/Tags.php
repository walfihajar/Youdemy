<?php
ob_start();
session_start();
require_once '../../Classes/Database.php';
require_once '../../Classes/Tag.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
    header('Location: ' . PROJECT_PATH . 'Pages/Auth/Log_in.php');
    exit();
}
$db = Database::getInstance()->getConnection();

if (isset($_POST['add_tag'])) {
    $tags = explode(',', $_POST['tags']);
    foreach ($tags as $tagName) {
        $tagName = trim($tagName);
        if (!empty($tagName)) {
            try {
                $tag = new Tag($db, null, $tagName);
                $tag->create();
            } catch (Exception $e) {
                $_SESSION['message'] = $e->getMessage();
            }
        }
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}


if (isset($_POST['edit_tag'])) {
    $id_tag = $_POST['id_tag'];
    $name = trim($_POST['name']);
    if (!empty($name)) {
        try {
            $tag = new Tag($db, $id_tag, $name);
            $tag->update();
        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage();
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}


if (isset($_POST['delete_tag'])) {
    $id_tag = $_POST['id_tag'];
    try {
        $tag = new Tag($db, $id_tag); 
        $tag->delete();
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$tags = Tag::showAll($db);

if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);
}
?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-100 p-8">
    <div class="container mx-auto max-w-4xl">
        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl p-8">
            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 mb-6">
                Gestion des Tags
            </h2>

            <!-- Add Tag Form -->
            <form action="" method="POST" class="mb-8">
                <div class="flex items-center space-x-4">
                    <textarea
                        name="tags"
                        placeholder="Entrez des tags, séparés par des virgules"
                        class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        rows="2"
                    ></textarea>
                    <button
                        type="submit"
                        name="add_tag"
                        class="px-6 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg hover:scale-105 transform transition"
                    >
                        Ajouter
                    </button>
                </div>
            </form>

            <!-- Tags Table -->
            <table id="datatable" class="min-w-full bg-white rounded-lg shadow p-4 overflow-hidden">
                <thead>
                    <tr class="bg-indigo-600 text-white">
                        <th class="py-4 px-6 text-left font-semibold">ID</th>
                        <th class="py-4 px-6 text-left font-semibold">Nom</th>
                        <th class="py-4 px-6 text-center font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (!empty($tags)): ?>
                        <?php foreach ($tags as $tag): ?>
                            <tr class="hover:bg-gray-100 transition duration-200">
                                <td class="py-4 px-6"><?= htmlspecialchars($tag->getIdTag()) ?></td>
                                <td class="py-4 px-6"><?= htmlspecialchars($tag->getName()) ?></td>
                                <td class="py-4 px-6 flex justify-center space-x-4">
                                    <!-- Edit Button -->
                                    <button
                                        onclick="openEditModal(<?= $tag->getIdTag() ?>, '<?= htmlspecialchars($tag->getName()) ?>')"
                                        class="text-blue-500 hover:text-blue-700 transition-colors duration-300"
                                        title="Edit"
                                    >
                                        <i class="fas fa-edit text-xl"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce tag ?');">
                                        <input type="hidden" name="id_tag" value="<?= $tag->getIdTag() ?>">
                                        <button
                                            type="submit"
                                            name="delete_tag"
                                            class="text-red-500 hover:text-red-700 transition-colors duration-300"
                                            title="Delete"
                                        >
                                            <i class="fas fa-trash-alt text-xl"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="py-4 px-6 text-center">Aucun tag trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Tag Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Modifier le Tag</h2>
        <form action="" method="POST">
            <input type="hidden" id="edit_id_tag" name="id_tag">
            <input
                type="text"
                id="edit_name"
                name="name"
                placeholder="Nom du tag"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
                required
            >
            <div class="flex justify-end space-x-4">
                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-300"
                >
                    Annuler
                </button>
                <button
                    type="submit"
                    name="edit_tag"
                    class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg hover:scale-105 transform transition"
                >
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// JavaScript to handle the edit modal
function openEditModal(id, name) {
    document.getElementById('edit_id_tag').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>

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