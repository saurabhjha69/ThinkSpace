@component('layout')
<div class="list-role mb-10">
    <h1 class="text-2xl font-bold">List Of All The Available Roles</h1>
   
    @foreach ($roles as $roleIndex => $role)
        <div class="role flex gap-4 border rounded-md border-gray-300 p-2 mt-3">
            <span>{{$roleIndex+1}}</span>
            <p>{{$role->name}}</p>
        </div>
    @endforeach
   
</div>
<h1 class="text-2xl font-bold text-gray-700 mb-6">Create Role & Privileges</h1>
<div class="  flex gap-5 p-5 rounded-lg shadow-lg w-full">

    <!-- Form 1: Role Section -->
    <form class="flex-grow mb-5" action="/role" method="POST">
        @csrf
        <h2 class="text-xl font-semibold text-gray-600 mb-4">Create a Role</h2>
        <div class="mb-4">
            <label for="roleName" class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
            <input type="text" name="roleName" id="roleName" placeholder="Enter role name (e.g., Admin, Instructor)" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-300 focus:border-indigo-500">
        </div>
        @error('roleName')
            <p class="text-red-500 text-sm">{{$message}}</p>
        @enderror
        <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
            Save Role
        </button>
    </form>
    <form class=" flex-grow mb-8" action="/role" method="POST">
        @csrf
        @method('DELETE')
        <h2 class="text-xl font-semibold text-gray-600 mb-4">Delete a Role</h2>
        <div class="mb-4">
            <label for="roleid" class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
            <select name="roleName" id="roleid" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none">
                @if ($roles->count()===0)
                    <option value="">No Roles Available Yet</option>
                @endif
                @foreach ($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
            </select>
            @error('roleid')
                <p class="text-red-500">{{$message}}</p>
            @enderror
            {{-- <input type="text" id="roleName" placeholder="Enter role name (e.g., Admin, Instructor)" > --}}
        </div>
        <button type="submit" class="w-full bg-red-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
            Delete Role
        </button>
    </form>

    <!-- Form 2: Privileges Section -->
    
</div>
    
@endcomponent