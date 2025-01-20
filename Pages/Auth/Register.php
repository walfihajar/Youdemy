<?php
require_once '../../Classes/User.php';
require_once '../../Classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $first_name = htmlspecialchars($_POST['first_name']);
        $last_name = htmlspecialchars($_POST['last_name']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $id_role = (int)$_POST['role'];
        
        // Validation
        if(empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires");
        }

        // Détermination automatique du statut
        $status = ($id_role === 3) ? STATUS::activated->value : STATUS::awaiting->value;

        $user = new User(
            null,
            $first_name,
            $last_name,
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            $id_role,
            $status // Passer la valeur directement
        );
        $user->save();
        if ($id_role === 2) { // Tutor
            header("Location: ../../../Tutor/Awaiting.php");
        } else { // Student
            header("Location: ../../../Visitor/Courses.php");
        }
        exit();

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-[sans-serif] h-screen">
    <div class="grid md:grid-cols-2 items-center h-full">
        <!-- Image Section -->
        <div class="hidden md:block h-full">
            <img src="../../Assets/uploads/register.jpg" class="max-w-[80%] w-full h-full aspect-square object-contain block mx-auto" alt="Illustration" />
        </div>

        <!-- Form Section -->
        <div class="flex items-center justify-center w-full h-full">
            <form method="POST" class="max-w-lg w-full mx-auto bg-white rounded-lg p-8">
                <h3 class="text-2xl font-bold text-center text-blue-600 mb-6">Create an Account</h3>

                <?php if(isset($error)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <!-- Full Name and Last Name -->
                <div class="mb-4 flex gap-4">
                    <!-- First Name -->
                    <div class="w-1/2">
                        <label for="first_name" class="text-gray-700 text-sm block mb-2">First Name</label>
                        <div class="relative">
                            <input id="first_name" name="first_name" type="text" required 
                                   class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none" 
                                   placeholder="First Name"
                                   value="<?= $_POST['first_name'] ?? '' ?>">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="w-1/2">
                        <label for="last_name" class="text-gray-700 text-sm block mb-2">Last Name</label>
                        <div class="relative">
                            <input id="last_name" name="last_name" type="text" required 
                                   class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none" 
                                   placeholder="Last Name"
                                   value="<?= $_POST['last_name'] ?? '' ?>">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email and Password -->
                <div class="mb-4 flex gap-4">
                    <!-- Email -->
                    <div class="w-1/2">
                        <label for="email" class="text-gray-700 text-sm block mb-2">Email</label>
                        <div class="relative">
                            <input id="email" name="email" type="email" required 
                                class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none" 
                                placeholder="Enter your email"
                                value="<?= $_POST['email'] ?? '' ?>">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="w-1/2">
                        <label for="password" class="text-gray-700 text-sm block mb-2">Password</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required 
                                class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none" 
                                placeholder="Enter your password">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="mb-4">
                    <label for="role" class="text-gray-700 text-sm block mb-2">Role</label>
                    <div class="relative">
                        <select id="role" name="role" required
                                class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-10 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none appearance-none">
                            <option value="" disabled selected>Select your role</option>
                            <option value="2" <?= isset($_POST['role']) && $_POST['role'] == 2 ? 'selected' : '' ?>>Tutor</option>
                            <option value="3" <?= isset($_POST['role']) && $_POST['role'] == 3 ? 'selected' : '' ?>>Student</option>
                        </select>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-2.5 px-4 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring focus:ring-blue-200">
                    Create an Account
                </button>

                <!-- Login Link -->
                <p class="text-sm text-center text-gray-700 mt-4">
                    Already have an account? <a href="./Log_in.php" class="text-blue-600 hover:underline">Login here</a>.
                </p>
            </form>
        </div>
    </div>
</body>
</html>