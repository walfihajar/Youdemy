<?php
ob_start();
session_start();
require_once '../../Classes/Database.php';
require_once '../../Classes/Category.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 1) {
    header('Location: ' . PROJECT_PATH . 'Pages/Auth/Log_in.php');
    exit();
}

// Récupérer la connexion à la base de données
$db = Database::getInstance()->getConnection();

// Handle Add Category
if (isset($_POST['add_category'])) {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        try {
            $category = new Category($db, null, $name); // Créer un objet Category
            if ($category->create()) {
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage(); // Capturer les erreurs
        }
    }
}

// Handle Edit Category
if (isset($_POST['edit_category'])) {
    $id_category = $_POST['id_category'];
    $name = trim($_POST['name']);
    if (!empty($name)) {
        try {
            $category = new Category($db, $id_category, $name); // Créer un objet Category
            if ($category->update()) {
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage(); // Capturer les erreurs
        }
    }
}

// Handle Delete Category
if (isset($_POST['delete_category'])) {
    $id_category = $_POST['id_category'];
    try {
        $category = new Category($db, $id_category); // Créer un objet Category
        if ($category->delete()) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage(); // Capturer les erreurs
    }
}

// Fetch all categories
$categories = Category::showAll($db); // Utiliser la méthode statique

// Afficher les messages d'erreur
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . addslashes($_SESSION['message']) . "');</script>";
    unset($_SESSION['message']);
}
?>

<div class="p-4">
    <h1 class="text-xl text-center font-bold text-gray-800 mb-6">Manage Categories</h1>

    <!-- Add Category Form -->
    <form action="" method="POST" class="mb-6">
        <div class="flex items-center space-x-4">
            <input type="text" name="name" placeholder="Category Name" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            <button type="submit" name="add_category" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-300">
                Add Category
            </button>
        </div>
    </form>

    <!-- Categories Table -->
    <table id="datatable" class="min-w-full bg-white rounded-lg shadow p-4 overflow-hidden">
        <thead>
            <tr class="bg-indigo-600 text-white">
                <th class="py-4 px-6 text-left font-semibold">ID</th>
                <th class="py-4 px-6 text-left font-semibold">Name</th>
                <th class="py-4 px-6 text-center font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="py-4 px-6"><?= htmlspecialchars($category->getIdCategory()) ?></td>
                        <td class="py-4 px-6"><?= htmlspecialchars($category->getName()) ?></td>
                        <td class="py-4 px-6 flex justify-center space-x-4">
                            <!-- Edit Button -->
                            <button onclick="openEditModal(<?= $category->getIdCategory() ?>, '<?= htmlspecialchars($category->getName()) ?>')" class="text-blue-500 hover:text-blue-700 transition-colors duration-300" title="Edit">
                                <i class="fas fa-edit text-xl"></i>
                            </button>

                            <!-- Delete Button -->
                            <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                <input type="hidden" name="id_category" value="<?= $category->getIdCategory() ?>">
                                <button type="submit" name="delete_category" class="text-red-500 hover:text-red-700 transition-colors duration-300" title="Delete">
                                    <i class="fas fa-trash-alt text-xl"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="py-4 px-6 text-center">No categories found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Edit Category Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Edit Category</h2>
        <form action="" method="POST">
            <input type="hidden" id="edit_id_category" name="id_category">
            <input type="text" id="edit_name" name="name" placeholder="Category Name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-4" required>
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-300">
                    Cancel
                </button>
                <button type="submit" name="edit_category" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-300">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // JavaScript to handle the edit modal
    function openEditModal(id, name) {
        document.getElementById('edit_id_category').value = id;
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