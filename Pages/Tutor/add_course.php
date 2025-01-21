<?php
ob_start();
session_start();
require_once '../../Classes/Database.php';
require_once '../../Classes/Course.php'; 
require_once '../../Classes/Content.php';
require_once '../../Classes/ContentText.php';
require_once '../../Classes/ContentVideo.php'; 

// Vérifier si l'utilisateur est connecté et est un tuteur (id_role = 2)
if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 2) {
    header('Location: ' . PROJECT_PATH . 'Pages/Auth/Log_in.php');
    exit();
}

// Créer une instance de Database et obtenir la connexion PDO
$db = Database::getInstance()->getConnection();

// Récupérer les catégories depuis la base de données
$query = "SELECT id_category, name FROM category";
$stmt = $db->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les tags depuis la base de données
$query = "SELECT id_tag, name FROM tag";
$stmt = $db->prepare($query);
$stmt->execute();
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire lorsqu'il est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $title = $_POST['course-title'];
    $description = $_POST['course-description'];
    $price = $_POST['course-price'];
    $id_category = $_POST['course-category'];
    $contentType = $_POST['content-type'];
    $contentData = [];

    // Gérer l'upload de l'image
    if (isset($_FILES['course-image']) && $_FILES['course-image']['error'] === UPLOAD_ERR_OK) {
      $uploadDir = '../../Assets/uploads/';

        // Vérifier si le répertoire existe, sinon le créer
        

        // Générer un nom de fichier unique pour éviter les conflits
        $fileName = uniqid() . '_' . basename($_FILES['course-image']['name']);
        $uploadFile = $uploadDir . $fileName;

        // Déplacer le fichier uploadé
        if (move_uploaded_file($_FILES['course-image']['tmp_name'], $uploadFile)) {
            $picture = $uploadFile;
        } else {
            die("Erreur lors de l'upload de l'image. Vérifiez les permissions du répertoire 'uploads'.");
        }
    } else {
        die("Aucun fichier image n'a été téléchargé.");
    }

    // Créer une instance de ContentText ou ContentVideo en fonction du type de contenu
    if ($contentType === 'video') {
        $content = new ContentVideo($db, null, null, 'video', $_POST['video-url']);
    } elseif ($contentType === 'text') {
        $content = new ContentText($db, null, null, 'text', $_POST['text-content']);
    } else {
        die("Type de contenu non valide.");
    }

    // Définir les propriétés du cours
    $content->setTitle($title);
    $content->setDescription($description);
    $content->setPicture($picture);
    $content->setPrice($price);
    $content->setIdCategory($id_category);
    $content->setIdUser($_SESSION['user']['id_user']);

    // Appeler la méthode add() pour insérer le cours et le contenu
    if ($content->add()) {
        // Rediriger vers une page de succès
        header('Location: add_course.php');
        exit();
    } else {
        die("Erreur lors de l'ajout du cours.");
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un nouveau cours</title>
    <script>
        // Script pour afficher dynamiquement les champs en fonction du type de contenu sélectionné
        document.addEventListener('DOMContentLoaded', function () {
            const contentType = document.getElementById('content-type');
            const videoContent = document.getElementById('video-content');
            const textContent = document.getElementById('text-content');

            if (contentType) {
                contentType.addEventListener('change', function () {
                    if (this.value === 'video') {
                        videoContent.classList.remove('hidden');
                        textContent.classList.add('hidden');
                    } else if (this.value === 'text') {
                        textContent.classList.remove('hidden');
                        videoContent.classList.add('hidden');
                    } else {
                        videoContent.classList.add('hidden');
                        textContent.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</head>
<body>
<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Créer un nouveau cours</h1>
    <form id="course-form" method="POST" enctype="multipart/form-data">
      <!-- Titre -->
      <div class="mb-6">
        <label for="course-title" class="block text-sm font-medium text-gray-700 mb-2">Titre du cours</label>
        <input
          type="text"
          id="course-title"
          name="course-title"
          placeholder="Entrez le titre du cours"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          required
        />
      </div>

      <!-- Description -->
      <div class="mb-6">
        <label for="course-description" class="block text-sm font-medium text-gray-700 mb-2">Description du cours</label>
        <textarea
          id="course-description"
          name="course-description"
          placeholder="Décrivez votre cours"
          rows="4"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          required
        ></textarea>
      </div>

      <!-- Image -->
      <div class="mb-6">
        <label for="course-image" class="block text-sm font-medium text-gray-700 mb-2">Image du cours</label>
        <input
          type="file"
          id="course-image"
          name="course-image"
          accept="image/*"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          required
        />
      </div>

      <!-- Catégorie et prix -->
      <div class="flex gap-6 mb-6">
        <!-- Catégorie -->
        <div class="flex-1">
          <label for="course-category" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
          <select
            id="course-category"
            name="course-category"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            required
          >
            <option value="" disabled selected>Sélectionnez une catégorie</option>
            <?php foreach ($categories as $category): ?>
              <option value="<?= htmlspecialchars($category['id_category']) ?>">
                <?= htmlspecialchars($category['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Prix -->
        <div class="flex-1">
          <label for="course-price" class="block text-sm font-medium text-gray-700 mb-2">Prix (USD)</label>
          <input
            type="number"
            id="course-price"
            name="course-price"
            placeholder="Entrez le prix"
            step="0.01"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            required
          />
        </div>
      </div>

      <!-- Tags -->
      <div class="mb-6">
        <label for="course-tags" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
        <select
          id="course-tags"
          name="course-tags[]"
          multiple
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          required
        >
          <?php foreach ($tags as $tag): ?>
            <option value="<?= htmlspecialchars($tag['id_tag']) ?>">
              <?= htmlspecialchars($tag['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Type de contenu -->
      <div class="mb-6">
        <label for="content-type" class="block text-sm font-medium text-gray-700 mb-2">Type de contenu</label>
        <select
          id="content-type"
          name="content-type"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          required
        >
          <option value="" disabled selected>Sélectionnez le type de contenu</option>
          <option value="video">Vidéo</option>
          <option value="text">Texte</option>
        </select>
      </div>

      <!-- Contenu dynamique -->
      <div id="dynamic-content">
        <!-- URL de la vidéo (masqué par défaut) -->
        <div id="video-content" class="mb-6 hidden">
          <label for="video-url" class="block text-sm font-medium text-gray-700 mb-2">URL de la vidéo</label>
          <input
            type="url"
            id="video-url"
            name="video-url"
            placeholder="Entrez l'URL de la vidéo"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Contenu texte (masqué par défaut) -->
        <div id="text-content" class="mb-6 hidden">
          <label for="text-content" class="block text-sm font-medium text-gray-700 mb-2">Contenu texte</label>
          <textarea
            id="text-content"
            name="text-content"
            placeholder="Entrez votre contenu texte"
            rows="6"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          ></textarea>
        </div>
      </div>

      <!-- Bouton de soumission -->
      <div class="mt-8">
        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          Créer le cours
        </button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
<?php
$content = ob_get_clean();
require_once '../../Includes/Layout_Tutor.php';