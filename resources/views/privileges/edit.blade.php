<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Privileges</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <div class="max-w-lg mx-auto mt-8 bg-white p-6 rounded-lg shadow-md">
    <!-- Privilege Edit Form -->
    <form action="/privileges/edit" method="POST">
      @csrf
      @method('PUT')

      <!-- Privileges Loop -->
      @foreach ($privileges as $privilege)
      <div class="privilege mb-4">
        <h2 class="text-lg font-bold mb-2">{{ $privilege->name }}</h2>
        
        <!-- Existing Subprivileges -->
        <div id="subprivileges-container-{{ $privilege->id }}">
          @foreach ($privilege->subprivileges as $subprivilege)
          <div class="flex items-center space-x-2 mb-2 subprivilege" id="subprivilege-{{ $subprivilege->id }}">
            <input type="checkbox" name="subprivileges[{{ $privilege->id }}][]" id="subprivilege-{{ $subprivilege->id }}" value="{{ $subprivilege->id }}" checked class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
            <label for="subprivilege-{{ $subprivilege->id }}" class="text-sm text-gray-700">{{ $subprivilege->name }}</label>
            <!-- Delete Subprivilege Button -->
            <button type="button" onclick="deleteSubprivilege({{ $subprivilege->id }})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
          </div>
          @endforeach
        </div>

        <!-- Button to Add New Subprivilege -->
        <button type="button" onclick="addSubprivilege({{ $privilege->id }})" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Subprivilege</button>
      </div>
      @endforeach

      <!-- Submit Button -->
      <div class="mt-6">
        <button type="submit" class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">Save Changes</button>
      </div>
    </form>
  </div>

  <!-- JavaScript for Dynamic Add/Delete Subprivileges -->
  <script>
    // Dynamic Subprivilege Counter
    let subprivilegeCount = 0;

    // Add Subprivilege
    function addSubprivilege(privilegeId) {
      subprivilegeCount++;
      const container = document.getElementById(`subprivileges-container-${privilegeId}`);

      // Create new subprivilege element
      const newSubprivilege = document.createElement('div');
      newSubprivilege.classList.add('flex', 'items-center', 'space-x-2', 'mb-2');
      newSubprivilege.id = `new-subprivilege-${subprivilegeCount}`;
      newSubprivilege.innerHTML = `
        <input type="text" name="new_subprivileges[${privilegeId}][]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter new subprivilege">
        <button type="button" onclick="deleteNewSubprivilege(${subprivilegeCount})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
      `;

      container.appendChild(newSubprivilege);
    }

    // Delete Existing Subprivilege
    function deleteSubprivilege(subprivilegeId) {
      const subprivilegeElement = document.getElementById(`subprivilege-${subprivilegeId}`);
      if (subprivilegeElement) {
        subprivilegeElement.remove();
      }
    }

    // Delete Newly Added Subprivilege
    function deleteNewSubprivilege(id) {
      const newSubprivilegeElement = document.getElementById(`new-subprivilege-${id}`);
      if (newSubprivilegeElement) {
        newSubprivilegeElement.remove();
      }
    }
  </script>

</body>
</html>
