<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings - LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for accordion */
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .accordion-open .accordion-content {
            max-height: 600px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
    <div class="container mx-auto px-6 py-12">
        <!-- Page Title -->
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Admin Settings</h1>

        <!-- Settings Sections -->
        <div class="space-y-8">
            <!-- User Settings -->
            <div class="flex gap-4">
                <div class="accordion bg-white rounded-lg shadow-lg flex-grow">
                    <button class="w-full bg-blue-600 text-white text-lg py-4 px-6 rounded-t-lg flex justify-between items-center font-medium focus:outline-none accordion-header">
                        <span>User Settings</span>
                        <span class="transition-transform transform rotate-0 accordion-icon">&#9660;</span>
                    </button>
                    <div class="accordion-content bg-white px-6 py-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">Default Role</label>
                                <select class="block w-full mt-1 bg-gray-100 border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500">
                                    <option>Admin</option>
                                    <option>Instructor</option>
                                    <option>Learner</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">Account Expiry</label>
                                <input type="date" class="block w-full bg-gray-100 border border-gray-300 rounded-md p-3 focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                        </div>
                        <div class="mt-6">
                            <button class="bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 transition duration-300">Save Settings</button>
                        </div>
                    </div>
                </div>

                <!-- Role Settings -->
                <div class="accordion bg-white rounded-lg shadow-lg flex-grow">
                    <button class="w-full bg-green-600 text-white text-lg py-4 px-6 rounded-t-lg flex justify-between items-center font-medium focus:outline-none accordion-header">
                        <span>Role Settings</span>
                        <span class="transition-transform transform rotate-0 accordion-icon">&#9660;</span>
                    </button>
                    <div class="accordion-content bg-white px-6 py-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">Create New Role</label>
                                <input type="text" placeholder="Role Name" class="block w-full bg-gray-100 border border-gray-300 rounded-md p-3 focus:ring-green-500 focus:border-green-500" />
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">Max Users Allowed</label>
                                <input type="number" class="block w-full bg-gray-100 border border-gray-300 rounded-md p-3 focus:ring-green-500 focus:border-green-500" />
                            </div>
                        </div>
                        <div class="mt-6">
                            <button class="bg-green-600 text-white py-3 px-6 rounded-md hover:bg-green-700 transition duration-300">Add Role</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gamification Settings -->
            <div class="accordion bg-white rounded-lg shadow-lg">
                <button class="w-full bg-yellow-500 text-white text-lg py-4 px-6 rounded-t-lg flex justify-between items-center font-medium focus:outline-none accordion-header">
                    <span>Gamification Settings</span>
                    <span class="transition-transform transform rotate-0 accordion-icon">&#9660;</span>
                </button>
                <div class="accordion-content bg-white px-6 py-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">Enable Badges</label>
                            <input type="checkbox" class="h-5 w-5 text-yellow-500" />
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">Points Per Completed Course</label>
                            <input type="number" class="block w-full bg-gray-100 border border-gray-300 rounded-md p-3 focus:ring-yellow-500 focus:border-yellow-500" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <button class="bg-yellow-500 text-white py-3 px-6 rounded-md hover:bg-yellow-600 transition duration-300">Save Settings</button>
                    </div>
                </div>
            </div>

            <!-- Category Settings -->
            <div class="accordion bg-white rounded-lg shadow-lg">
                <button class="w-full bg-purple-600 text-white text-lg py-4 px-6 rounded-t-lg flex justify-between items-center font-medium focus:outline-none accordion-header">
                    <span>Category Settings</span>
                    <span class="transition-transform transform rotate-0 accordion-icon">&#9660;</span>
                </button>
                <div class="accordion-content bg-white px-6 py-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">Add New Category</label>
                            <input type="text" placeholder="Category Name" class="block w-full bg-gray-100 border border-gray-300 rounded-md p-3 focus:ring-purple-500 focus:border-purple-500" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <button class="bg-purple-600 text-white py-3 px-6 rounded-md hover:bg-purple-700 transition duration-300">Add Category</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Accordion functionality
        document.querySelectorAll('.accordion-header').forEach(button => {
            button.addEventListener('click', () => {
                const accordionContent = button.nextElementSibling;
                const accordionIcon = button.querySelector('.accordion-icon');

                button.parentElement.classList.toggle('accordion-open');

                accordionIcon.classList.toggle('rotate-180');
            });
        });
    </script>
</body>
</html>
