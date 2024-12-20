@component('layout')
<div class="mb-6 p-6 bg-white rounded-lg shadow-md">
    <h3 class="text-2xl font-semibold mb-6">Add New User</h3>
    <form id="addUserForm" class="space-y-6">
        <!-- Name & Email -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block mb-1 font-medium">Full Name</label>
                <input type="text" id="name" class="w-full border border-gray-300 rounded-md p-3"
                    placeholder="Full Name" required>
            </div>
            <div>
                <label for="email" class="block mb-1 font-medium">Email</label>
                <input type="email" id="email" class="w-full border border-gray-300 rounded-md p-3"
                    placeholder="Email" required>
            </div>
        </div>

        <!-- Phone & Expiry Date -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="phone" class="block mb-1 font-medium">Phone Number</label>
                <input type="tel" id="phone" class="w-full border border-gray-300 rounded-md p-3"
                    placeholder="Phone Number" required>
            </div>
            <div>
                <label for="expiry" class="block mb-1 font-medium">Expiry Date</label>
                <input type="date" id="expiry" class="w-full border border-gray-300 rounded-md p-3"
                    placeholder="Expiry Date">
            </div>
        </div>

        <!-- Password & Confirm Password -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block mb-1 font-medium">Password</label>
                <input type="password" id="password" class="w-full border border-gray-300 rounded-md p-3"
                    placeholder="Password" required>
            </div>
            <div>
                <label for="password_confirmation" class="block mb-1 font-medium">Confirm Password</label>
                <input type="password" id="password_confirmation" class="w-full border border-gray-300 rounded-md p-3"
                    placeholder="Confirm Password" required>
            </div>
        </div>

        <!-- Role & Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="role" class="block mb-1 font-medium">Role</label>
                <select id="role" class="w-full border border-gray-300 rounded-md p-3" required>
                    <option value="learner">Learner</option>
                    <option value="instructor">Instructor</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div>
                <label for="status" class="block mb-1 font-medium">Status</label>
                <select id="status" class="w-full border border-gray-300 rounded-md p-3" required>
                    <option value="active">Active</option>
                    <option value="suspended">Suspended</option>
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                Add User
            </button>
        </div>
    </form>
</div>

@endcomponent