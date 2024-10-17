<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleFields() {
            var role = document.getElementById("role").value;
            document.getElementById("admin-fields").style.display = (role === "Admin") ? "block" : "none";
            document.getElementById("learner-fields").style.display = (role === "Learner") ? "block" : "none";
            document.getElementById("instructor-fields").style.display = (role === "Instructor") ? "block" : "none";
        }
    </script>
    <style>
        :root {
            --primary-color: #990011;
            --secondary-color: #FCF6F5;
        }
    </style>
</head>
<body class="bg-[var(--secondary-color)] min-h-screen flex items-center justify-center">
    <form action="/submit_user_info" method="POST" class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <!-- Form Header -->
        <h1 class="text-2xl font-bold text-center mb-6 text-[var(--primary-color)]">User Information Form</h1>

        <!-- Common Fields -->
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-[var(--primary-color)]">Common Information</h3>
        </div>

        <div class="mb-4">
            <label for="phone_no" class="block text-gray-700 font-medium mb-1">Phone Number:</label>
            <input type="text" id="phone_no" name="phone_no" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700 font-medium mb-1">Address:</label>
            <input type="text" id="address" name="address" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
        </div>

        <div class="mb-4">
            <label for="country" class="block text-gray-700 font-medium mb-1">Country:</label>
            <input type="text" id="country" name="country" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
        </div>

        <div class="mb-4">
            <label for="profile_picture" class="block text-gray-700 font-medium mb-1">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
        </div>

        <div class="mb-4">
            <label for="date_of_birth" class="block text-gray-700 font-medium mb-1">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
        </div>

        <div class="mb-4">
            <label for="gender" class="block text-gray-700 font-medium mb-1">Gender:</label>
            <select id="gender" name="gender" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="social_links" class="block text-gray-700 font-medium mb-1">Social Links:</label>
            <input type="text" id="social_links" name="social_links" placeholder="Add your LinkedIn, Twitter, etc." class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
        </div>

        <div class="mb-4">
            <label for="timezone" class="block text-gray-700 font-medium mb-1">Timezone:</label>
            <input type="text" id="timezone" name="timezone" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
        </div>

        <div class="mb-4">
            <label for="language_preference" class="block text-gray-700 font-medium mb-1">Language Preference:</label>
            <input type="text" id="language_preference" name="language_preference" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
        </div>

        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-medium mb-1">Role:</label>
            <select id="role" name="role" onchange="toggleFields()" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
                <option value="">Select Role</option>
                <option value="Admin">Admin</option>
                <option value="Learner">Learner</option>
                <option value="Instructor">Instructor</option>
            </select>
        </div>

        <!-- Admin-Specific Fields -->
        <div id="admin-fields" class="mb-4 hidden">
            <h3 class="text-lg font-semibold text-[var(--primary-color)]">Admin Information</h3>
            <label for="admin_privileges" class="block text-gray-700 font-medium mb-1">Admin Privileges:</label>
            <input type="text" id="admin_privileges" name="admin_privileges" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
        </div>

        <!-- Learner-Specific Fields -->
        <div id="learner-fields" class="mb-4 hidden">
            <h3 class="text-lg font-semibold text-[var(--primary-color)]">Learner Information</h3>
            <label for="education" class="block text-gray-700 font-medium mb-1">Education:</label>
            <input type="text" id="education" name="education" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">

            <label for="learning_goals" class="block text-gray-700 font-medium mb-1">Learning Goals:</label>
            <input type="text" id="learning_goals" name="learning_goals" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">

            <label for="learning_style" class="block text-gray-700 font-medium mb-1">Learning Style:</label>
            <input type="text" id="learning_style" name="learning_style" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
        </div>

        <!-- Instructor-Specific Fields -->
        <div id="instructor-fields" class="mb-4 hidden">
            <h3 class="text-lg font-semibold text-[var(--primary-color)]">Instructor Information</h3>
            <label for="specialization" class="block text-gray-700 font-medium mb-1">Specialization:</label>
            <input type="text" id="specialization" name="specialization" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">

            <label for="bio" class="block text-gray-700 font-medium mb-1">Bio:</label>
            <textarea id="bio" name="bio" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]" placeholder="Write a short bio"></textarea>

            <label for="work_experience" class="block text-gray-700 font-medium mb-1">Work Experience:</label>
            <input type="text" id="work_experience" name="work_experience" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">

            <label for="certifications" class="block text-gray-700 font-medium mb-1">Certifications:</label>
            <input type="text" id="certifications" name="certifications" class="w-full p-2 border rounded-lg focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
        </div>

        <!-- Submit Button -->
        <div class="text-center mt-6">
            <button type="submit" class="bg-[var(--primary-color)] text-white px-4 py-2 rounded-lg hover:bg-red-800">Submit</button>
        </div>
    </form>
</body>
</html>
