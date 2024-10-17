<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Creation Form</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <div class="max-w-lg mx-auto mt-8 bg-white p-6 rounded-lg shadow-md">

        <!-- Role Creation Form -->
        <form action="/process_role" method="POST">
            @csrf
            <!-- Role Name -->
            <div class="mb-4">
                <label for="role_name" class="block text-sm font-medium text-gray-700">Role Name</label>
                <input type="text" name="role_name" id="role_name"
                    class="mt-1 block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Enter role name" required>
                <x-validationError error_name="role_name"></x-validationError>
            </div>
            <div class="mb-4">
                <label for="permissions" class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                <div class="permissions columns-3">
                    @foreach ($permissions as $permission)
                    <div class="permission flex items-center">
                        <input type="checkbox" name="permissions[]" id="" value="{{$permission->id}}" class="h-3">
                        <label for="{{$permission->id}}" class="text-sm ml-2 font-medium text-gray-700">{{$permission->name}}</label>
                    </div>
                @endforeach
                </div>
            </div>

            <!-- Expiry Date -->
            <div class="mb-4">
                <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                <input type="date" name="expiry_date" id="expiry_date"
                    class="mt-1 block w-full rounded-md p-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    required>
                <x-validationError error_name="expiry_date"></x-validationError>
            </div>

            <!-- Checkbox for Max Users -->
            <div class="flex items-center mb-4">
                <input type="checkbox" id="max_users_checkbox"
                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label for="max_users_checkbox" class="ml-2 block text-sm font-medium text-gray-700">Add Max Users
                    Allowed</label>

            </div>

            <!-- Max Users Allowed (Hidden by Default) -->
            <div id="max_users_container" class="mb-4 hidden">
                <label for="max_users_allowed" class="block text-sm font-medium text-gray-700">Max Users Allowed</label>
                <input type="number" name="max_users_allowed" id="max_users_allowed"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Enter max users">
                <x-validationError error_name="max_users_allowed"></x-validationError>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">Submit</button>
            </div>
        </form>
    </div>

    <!-- JavaScript to Toggle Max Users Field -->
    <script>
        document.getElementById('max_users_checkbox').addEventListener('change', function() {
            const maxUsersContainer = document.getElementById('max_users_container');
            if (this.checked) {
                maxUsersContainer.classList.remove('hidden');
            } else {
                maxUsersContainer.classList.add('hidden');
            }
        });
    </script>

</body>

</html>
