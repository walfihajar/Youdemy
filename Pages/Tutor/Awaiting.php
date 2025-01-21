<?php
session_start();

require_once '../../Classes/User.php';
require_once '../../Classes/Database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['id_role'] != 2) {
    header('Location: ' . PROJECT_PATH . 'Pages/Auth/Log_in.php');
    exit();
}

// Ensure the teacher's status is "awaiting"
if ($_SESSION['user']['status'] != STATUS::awaiting->value) {
    header('Location: ' . PROJECT_PATH . 'Pages/Tutor/Overview.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awaiting Approval</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-[sans-serif] h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-2xl font-bold text-blue-600 mb-4">Awaiting Approval</h1>
        <p class="text-gray-700 mb-4">Your account is currently awaiting approval. Please wait until an administrator activates your account.</p>
        <a href="../Auth/Logout.php" class="text-blue-600 hover:underline">Logout</a>
    </div>
</body>
</html>