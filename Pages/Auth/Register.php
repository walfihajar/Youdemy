<?php

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
            <form class="max-w-lg w-full mx-auto bg-white rounded-lg p-8">
                <h3 class="text-2xl font-bold text-center text-blue-600 mb-6">Create an Account</h3>

                <!-- Full Name and Last Name -->
                <div class="mb-4 flex gap-4">
                    <!-- Full Name -->
                    <div class="w-1/2">
                        <label for="name" class="text-gray-700 text-sm block mb-2">Full Name</label>
                        <div class="relative">
                            <input id="name" name="name" type="text" required 
                                   class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none" 
                                   placeholder="First Name">
                            <!-- User Icon -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <!-- Last Name -->
                    <div class="w-1/2">
                        <label for="last-name" class="text-gray-700 text-sm block mb-2">Last Name</label>
                        <div class="relative">
                            <input id="last-name" name="last-name" type="text" required 
                                   class="w-full bg-gray-50 border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none" 
                                   placeholder="Last Name">
                            <!-- User Icon -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
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
                                placeholder="Enter your email">
                            <!-- Email Icon -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
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
                            <!-- Lock Icon -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
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
                            <option value="tutor">Tutor</option>
                            <option value="student">Student</option>
                        </select>
                        <!-- Role Icon -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <!-- Dropdown Icon -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Upload Image -->
                <div class="mb-4">
                    <label for="image-upload" class="text-gray-700 text-sm block mb-2">Profile Picture</label>
                    <div class="relative">
                        <input id="image-upload" name="image-upload" type="file" 
                            class="w-full bg-gray-50 border border-gray-300 rounded-md text-sm text-gray-700 py-2 pl-10 pr-4 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200"
                            title="">
                        <!-- Upload Icon -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
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