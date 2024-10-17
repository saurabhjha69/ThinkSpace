<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User-Create</title>
    @vite('resources/css/app.css')
</head>
<body>
    <x-sessions.success></x-sessions.success>
    <x-sessions.fail></x-sessions.fail>
    <div class="mb-6 p-6 bg-white rounded-lg shadow-md">
        <h3 class="text-2xl font-semibold mb-6">Edir User</h3>
        <form id="addUserForm" class="space-y-6" action="/user/edit/{{$user->id}}" method="POST">
            @csrf
            @method('PUT')
            <!-- Name & Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="username" class="block mb-1 font-medium">UserName</label>
                    <input type="text" id="username" name="username" class="w-full border border-gray-300 rounded-md p-3"
                        placeholder="UserName" value="{{$user->username}}" required>
                    <x-validationError error_name="username"></x-validationError>
                </div>
                <div>
                    <label for="email" class="block mb-1 font-medium">Email</label>
                    <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-md p-3"
                        placeholder="Email" value="{{$user->email}}" required>
                    <x-validationError error_name="email"></x-validationError>
                </div>
            </div>

            {{-- <!-- Phone & Expiry Date -->
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
            </div> --}}

            <!-- Password & Confirm Password -->
            {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block mb-1 font-medium">Password</label>
                    <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-md p-3"
                        placeholder="Password" required>
                    <x-validationError error_name="password"></x-validationError>
                </div>
                <div>
                    <label for="password_confirmation" class="block mb-1 font-medium">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-md p-3"
                        placeholder="Confirm Password" required>
                </div>
            </div> --}}

            <!-- Role & Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="role" class="block mb-1 font-medium">Role</label>
                    <div class="roles-div w-full border border-gray-300 rounded-md p-3">
                        @foreach ($roles as $index =>  $role)
                            <div class="checkbox flex items-center gap-4">
                                <input type="checkbox" id="{{$role->id}}" name="role[{{$index+1}}]" value="{{$role->id}}"
                                {{$user->hasRole($role->name) ? 'checked' : ''}}>
                                <label for="{{$role->id}}">{{$role->name}}</label>
                            </div>
                        @endforeach
                        <x-validationError error_name="role[1]"></x-validationError>
                        <x-validationError error_name="role[2]"></x-validationError>
                        <x-validationError error_name="role[3]"></x-validationError>
                        <x-validationError error_name="role[4]"></x-validationError>
                    </div>

                </div>

                <div>
                    <label for="status" class="block mb-1 font-medium">Status</label>
                    <select id="status" name="is_active" class="w-full border border-gray-300 rounded-md p-3" required>
                        <option value="true" {{$user->is_active == 1 ? 'selected' : ''}}>Active</option>
                        <option value="false" {{$user->is_active == 0 ? 'selected' : ''}}>Suspended</option>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <input type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
            </div>
        </form>
    </div>

</body>
</html>
