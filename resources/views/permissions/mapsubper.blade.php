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
        <form action="/map-subpermissions-to-permissions" method="POST">
            @csrf
            <!-- Role Name -->
            <div class="mb-4">
                <label for="role_name" class="block text-sm font-medium text-gray-700">Permission Name</label>
                <select name="permission_id" id="" class="mt-1 block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach ($permissions as $permission)
                        <option value="{{$permission->id}}">{{$permission->name}}</option>
                    @endforeach
                </select>

                <x-validationError error_name="permission_id"></x-validationError>
            </div>
            <div class="mb-4">
                <label for="subpermissions" class="block text-sm font-medium text-gray-700 mb-2">SubPermissions</label>
                <div class="subpermissions columns-3">
                    @foreach ($subpermissions as $subpermission)
                    <div class="subpermissions flex items-center">
                        <input type="checkbox" name="subpermissions[]" id="" value="{{$subpermission->id}}" class="h-3">
                        <label for="{{$subpermission->id}}" class="text-sm ml-2 font-medium text-gray-700">{{$subpermission->name}}</label>
                    </div>
                @endforeach
                </div>
                <x-validationError error_name="subpermissions[]"></x-validationError>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">Submit</button>
            </div>
        </form>
    </div>

    <!-- JavaScript to Toggle Max Users Field -->


</body>

</html>
