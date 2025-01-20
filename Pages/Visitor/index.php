<?php 
require_once '../../Includes/Header.php';
require_once '../../Classes/Database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <main>
        <section class="bg-gradient-to-b from-purple-100 via-purple-50 to-purple-200 py-20 md:py-32">
            <div class="container mx-auto flex flex-col md:flex-row items-center">
                <div class="text-center md:text-left md:w-1/2 space-y-8">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-800">Develop your skills in a new and unique way</h1>
                    <p class="text-gray-600 text-lg">Learn from the best instructors with our online platform. Achieve your goals faster and more efficiently.</p>
                    <button class="bg-purple-600 text-white px-8 py-4 rounded-md hover:bg-purple-700 transition-colors duration-300 shadow-lg">Get Started</button>
                </div>
                <div class="md:w-1/2 mt-10 md:mt-0 flex justify-center">
                    <img src="../../Assets/uploads/home.png" alt="Hero Image" class="rounded-lg shadow-lg">
                </div>
            </div>
        </section>

        <section class="container mx-auto py-20">
            <h2 class="text-center text-3xl font-bold text-gray-800 mb-12">Search Courses</h2>
            <div class="flex justify-center">
                <input type="text" placeholder="Search for a course" class="w-full max-w-md px-4 py-3 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <button class="bg-purple-600 text-white px-6 py-3 rounded-r-md hover:bg-purple-700 transition-colors duration-300">Search</button>
            </div>
        </section>

        <section class="bg-purple-50 py-20">
            <div class="container mx-auto">
                <h2 class="text-center text-3xl font-bold text-gray-800 mb-12">Benefits From Our Online Learning</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <h3 class="text-xl font-bold text-purple-700 mb-4">Expert Instructors</h3>
                        <p class="text-gray-600 text-lg">Learn from professionals with years of experience.</p>
                    </div>
                    <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <h3 class="text-xl font-bold text-purple-700 mb-4">Flexible Schedule</h3>
                        <p class="text-gray-600 text-lg">Learn at your own pace, on your own time.</p>
                    </div>
                    <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <h3 class="text-xl font-bold text-purple-700 mb-4">Affordable Prices</h3>
                        <p class="text-gray-600 text-lg">High-quality education that fits your budget.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="container mx-auto py-20">
            <h2 class="text-center text-3xl font-bold text-gray-800 mb-12">Our Popular Courses</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <img src="https://via.placeholder.com/300" alt="Course 1" class="mb-4 rounded-md">
                    <h3 class="text-xl font-bold text-gray-800">Web Development</h3>
                    <p class="text-gray-600 text-lg">Build modern and responsive websites.</p>
                    <p class="text-purple-700 font-bold text-lg mt-2">$49.99</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <img src="https://via.placeholder.com/300" alt="Course 2" class="mb-4 rounded-md">
                    <h3 class="text-xl font-bold text-gray-800">Graphic Design</h3>
                    <p class="text-gray-600 text-lg">Master the art of visual storytelling.</p>
                    <p class="text-purple-700 font-bold text-lg mt-2">$39.99</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <img src="https://via.placeholder.com/300" alt="Course 3" class="mb-4 rounded-md">
                    <h3 class="text-xl font-bold text-gray-800">Data Analysis</h3>
                    <p class="text-gray-600 text-lg">Transform data into actionable insights.</p>
                    <p class="text-purple-700 font-bold text-lg mt-2">$59.99</p>
                </div>
            </div>
        </section>

        <section class="bg-purple-100 py-20">
            <div class="container mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Are You a Certified Teacher?</h2>
                <p class="text-gray-600 text-lg mb-8">Join our platform and share your expertise with learners worldwide.</p>
                <button class="bg-purple-600 text-white px-8 py-4 rounded-md hover:bg-purple-700 transition-colors duration-300 shadow-lg">Become an Instructor</button>
            </div>
        </section>

        <section class="container mx-auto py-20">
            <h2 class="text-center text-3xl font-bold text-gray-800 mb-12">Students' Testimonials</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <p class="text-gray-600 italic text-lg">"This platform transformed the way I learn. The courses are well-structured and easy to follow."</p>
                    <p class="text-gray-800 font-bold text-lg mt-4">- Jane Doe</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <p class="text-gray-600 italic text-lg">"The instructors are amazing. Their expertise and passion for teaching are evident."</p>
                    <p class="text-gray-800 font-bold text-lg mt-4">- John Smith</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <p class="text-gray-600 italic text-lg">"Highly recommend this platform for anyone looking to improve their skills."</p>
                    <p class="text-gray-800 font-bold text-lg mt-4">- Sarah Lee</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Elech. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
