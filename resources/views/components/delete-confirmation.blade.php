@props(['itemname'=> 'item'])
<div id="deleteConfirmationModal" class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-gray-800 bg-opacity-50">
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
        <p id="deleteMessage" class="mb-6">This Will Delete All The Dependent Data Records..</p>
        <p id="deleteMessage" class="mb-6">Are you sure you want to delete this {{$itemname}}?</p>
        <div class="flex justify-end gap-4">
            <button id="cancelDelete" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
            <button id="confirmDelete" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
        </div>
    </div>
</div>


