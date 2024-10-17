<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Privilege Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <div class="max-w-lg mx-auto mt-8 bg-white p-6 rounded-lg shadow-md">
    <!-- Privilege Form -->
    <form action="/process_privileges" method="POST">
      @csrf
      <!-- Privilege Name -->
      <div class="mb-4">
        <label for="privilege_name" class="block text-sm font-medium text-gray-700">Privilege Name</label>
        <input type="text" name="privilege_name" id="privilege_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter privilege name">
        <x-validationError error_name="privilege_name"></x-validationError>
      </div>

      <!-- Role Dropdown -->
      <div class="mb-4">
        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
        <select name="role_id" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          @foreach ($roles as $role)
            <option value="{{$role->id}}">{{$role->name}}</option>            
          @endforeach
        </select>
        <x-validationError error_name="role_id"></x-validationError>
      </div>

      <!-- Dynamic Subprivileges -->
      <div id="subprivileges-container" class="mb-4">
        <label for="subprivileges" class="block text-sm font-medium text-gray-700">Subprivileges</label>
        <div class="flex space-x-2 mb-2">
          <input type="text" name="subprivileges[]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter subprivilege">
          <button type="button" class="delete-subprivilege bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
        </div>
        <x-validationError error_name="subprivileges[]"></x-validationError>
      </div>

      <!-- Add Subprivilege Button -->
      <button type="button" id="add-subprivilege" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4">Add Subprivilege</button>

      <!-- Submit Button -->
      <div class="mt-6">
        <button type="submit" class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">Submit</button>
      </div>
    </form>
  </div>

  <!-- JavaScript for Dynamic Subprivileges -->
  <script>
    // Add new subprivilege input
    document.getElementById('add-subprivilege').addEventListener('click', function() {
      const container = document.getElementById('subprivileges-container');
      const newSubprivilege = document.createElement('div');
      newSubprivilege.classList.add('flex', 'space-x-2', 'mb-2');
      
      newSubprivilege.innerHTML = `
        <input type="text" name="subprivileges[]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter subprivilege">
        <button type="button" class="delete-subprivilege bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
      `;
      
      container.appendChild(newSubprivilege);
      
      // Add event listener to delete button
      newSubprivilege.querySelector('.delete-subprivilege').addEventListener('click', function() {
        newSubprivilege.remove();
      });
    });

    // Delete existing subprivilege input
    document.querySelectorAll('.delete-subprivilege').forEach(button => {
      button.addEventListener('click', function() {
        this.parentElement.remove();
      });
    });
  </script>

</body>
</html>
