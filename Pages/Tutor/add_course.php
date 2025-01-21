<?php
ob_start();
session_start();
require_once '../../Classes/Database.php';
require_once '../../Classes/Course.php'; // Include the Course class

// Check if the user is logged in and is a teacher (id_role = 2)
if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 2) {
    header('Location: ' . PROJECT_PATH . 'Pages/Auth/Log_in.php');
    exit();
}

// Create a Database instance and get the PDO connection
$db = Database::getInstance()->getConnection();

// Fetch categories from the database
$query = "SELECT id_category, name FROM category";
$stmt = $db->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch tags from the database
$query = "SELECT id_tag, name FROM tag";
$stmt = $db->prepare($query);
$stmt->execute();
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Create a New Course</h1>
    <form id="course-form" action="process_course.php" method="POST" enctype="multipart/form-data">
      <!-- Title -->
      <div class="mb-6">
        <label for="course-title" class="block text-sm font-medium text-gray-700 mb-2">Course Title</label>
        <input
          type="text"
          id="course-title"
          name="course-title"
          placeholder="Enter course title"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          required
        />
      </div>

      <!-- Description -->
      <div class="mb-6">
        <label for="course-description" class="block text-sm font-medium text-gray-700 mb-2">Course Description</label>
        <textarea
          id="course-description"
          name="course-description"
          placeholder="Describe your course"
          rows="4"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          required
        ></textarea>
      </div>

      <!-- Image Upload -->
      <div class="mb-6">
        <label for="course-image" class="block text-sm font-medium text-gray-700 mb-2">Course Image</label>
        <input
          type="file"
          id="course-image"
          name="course-image"
          accept="image/*"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          required
        />
      </div>

      <!-- Category and Price in the same row -->
      <div class="flex gap-6 mb-6">
        <!-- Category Selection -->
        <div class="flex-1">
          <label for="course-category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
          <select
            id="course-category"
            name="course-category"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            required
          >
            <option value="" disabled selected>Select a category</option>
            <?php foreach ($categories as $category): ?>
              <option value="<?= htmlspecialchars($category['id_category']) ?>">
                <?= htmlspecialchars($category['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Price Input -->
        <div class="flex-1">
          <label for="course-price" class="block text-sm font-medium text-gray-700 mb-2">Price (USD)</label>
          <input
            type="number"
            id="course-price"
            name="course-price"
            placeholder="Enter price"
            step="0.01"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            required
          />
        </div>
      </div>

      <!-- Tags Selection -->
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

      <!-- Content Type Selection -->
      <div class="mb-6">
        <label for="content-type" class="block text-sm font-medium text-gray-700 mb-2">Content Type</label>
        <select
          id="content-type"
          name="content-type"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          required
        >
          <option value="" disabled selected>Select content type</option>
          <option value="video">Video</option>
          <option value="text">Text</option>
        </select>
      </div>

      <!-- Dynamic Content Section -->
      <div id="dynamic-content">
        <!-- Video URL Input (Hidden by Default) -->
        <div id="video-content" class="mb-6 hidden">
          <label for="video-url" class="block text-sm font-medium text-gray-700 mb-2">Video URL</label>
          <input
            type="url"
            id="video-url"
            name="video-url"
            placeholder="Enter video URL"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <!-- Text Content Input (Hidden by Default) -->
        <div id="text-content" class="mb-6 hidden">
          <label for="text-content" class="block text-sm font-medium text-gray-700 mb-2">Text Content</label>
          <textarea
            id="text-content"
            name="text-content"
            placeholder="Enter your text content"
            rows="6"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          ></textarea>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="mt-8">
        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          Create Course
        </button>
      </div>
    </form>
  </div>
</div>
<script>
  document.getElementById('content-type').addEventListener('change', function () {
    const videoContent = document.getElementById('video-content');
    const textContent = document.getElementById('text-content');

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
</script>
<?php
$content = ob_get_clean();
require_once '../../Includes/Layout_Tutor.php';