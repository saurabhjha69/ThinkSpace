@component('layout')
    <x-header href="/user"></x-header>
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-6">Team Management</h2>

        <!-- Sorting Controls -->
        <div class="mb-4">
            <form action="" method="GET" id="userFilterForm" class="mt-5 flex justify-between">

                <div>
                    <label for="roleSort" class="mr-2 font-medium">Filter by Role:</label>
                    <select id="roleFilter" name="filterByRole" onchange="submitFiltering(true)" class="border border-gray-300 rounded-md p-2">
                        <option {{request('filterByRole')=='All' ? 'selected' : ''}}>All</option>
                        <option value="Learner" {{request('filterByRole')=='Learner' ? 'selected' : ''}}>Learner</option>
                        <option value="Instructor" {{request('filterByRole')=='Instructor' ? 'selected' : ''}}>Instructor</option>
                        <option value="Admin" {{request('filterByRole')=='Admin' ? 'selected' : ''}}>Admin</option>
                    </select>
                </div>
                <div>
                    <label for="statusFilter" class="mr-2 font-medium">Filter by Status:</label>
                    <select id="statusFilter" name="filterByStatus" onchange="submitFiltering(true)" class="border border-gray-300 rounded-md p-2">
                        <option value="All" {{request('filterByStatus')=='All' ? 'selected' : ''}}>All</option>
                        <option value="1" {{request('filterByStatus')=='1' ? 'selected' : ''}}>Active</option>
                        <option value="0" {{request('filterByStatus')=='0' ? 'selected' : ''}} >Suspended</option>
                    </select>
                </div>
            </form>
        </div>
        @foreach ($errors->all() as $error)
                <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50  dark:text-red-400 dark:border-red-800" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                      <span class="font-medium">Alert!</span> {{$error}}
                    </div>
                  </div>
                @endforeach
        <!-- User List Table -->
        <div class="relative">
            {{-- <p>Total Results {{count($users)}}</p> --}}
            <div class="table-rapper overflow-x-auto bg-white border border-gray-300 rounded-md">

                <table class="min-w-full table-auto ">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 border-b font-semibold text-left">Username</th>
                            <th class="px-6 py-3 border-b font-semibold text-left">Email</th>
                            <th class="px-6 py-3 border-b font-semibold text-left">Role</th>
                            <th class="px-6 py-3 border-b font-semibold text-left">Status</th>
                            <th class="px-6 py-3 border-b font-semibold text-left">Registered At</th>
                            <th class="px-6 py-3 border-b font-semibold text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="userTable">
                        @foreach ($users as $user)

                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{$user->username}}</td>
                                <td class="px-6 py-4">{{$user->email}}</td>
                                <td class="px-6 py-4">
                                    @if ($user->roles())
                                        <span class="pl-1" > {{$user->roles->first()->name?? 'No Role'}}</span>
                                    @else
                                    <select name="roles" id="">
                                        @foreach ($user->roles as $role)

                                        <option value="">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{$user->is_active == 1 ? 'Active' : 'Suspended '}}</td>
                                <td class="px-6 py-4">2024-08-01</td>
                                <td class="px-6 py-4 flex gap-4">
                                    <a href="/user/{{$user->id}}">
                                        <x-svgs.visit></x-svgs.visit>
                                    </a>
                                    <a href="/user/edit/{{$user->id}}">
                                        <x-svgs.edit></x-svgs.edit>
                                    </a>
                                    <input type="checkbox" class="form-checkbox text-red-700" id="usercheckbox" value="{{$user->id}}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>

            <div class="mb-6 absolute -translate-x-[50%] -translate-y-[50%] top-[50%] left-[50%] shadow-2xl hidden">
                <div class="form border border-gray-300 rounded-md bg-gray-50 px-6 py-6">


                    <form id="addUserForm" class="flex flex-wrap gap-4">
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="flex-grow">
                                    <label for="email" class="block mb-1 font-medium">Email</label>
                                    <input type="email" id="email"
                                        class="w-full border border-gray-300 rounded-md p-2" placeholder="Email" required>
                                </div>
                                <div>
                                    <label for="role" class="block mb-1 font-medium">Role</label>
                                    <select id="role" class="border border-gray-300 rounded-md p-2" required>
                                        <option value="learner">Learner</option>
                                        <option value="instructor">Instructor</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="status" class="block mb-1 font-medium">Status</label>
                                    <select id="status" class="border border-gray-300 rounded-md p-2" required>
                                        <option value="active">Active</option>
                                        <option value="suspended">Suspended</option>
                                    </select>
                                </div>
                            </div>
                            <div class="lower flex gap-4">
                                <div class="change-pwd-btn mt-5 place-content-center">
                                    <span class="changepass text-white px-4 py-2 rounded bg-red-700">Change Password</span>
                                </div>
                                <div class="password-div flex gap-3 hidden">
                                    <div class="flex-grow">
                                        <label for="password" class="block mb-1 font-medium">Old Password</label>
                                        <input type="password" id="password"
                                            class="w-full border border-gray-300 rounded-md p-2" placeholder="Password"
                                            required>
                                    </div>
                                    <div class="flex-grow">
                                        <label for="password" class="block mb-1 font-medium">New Password</label>
                                        <input type="password" id="password"
                                            class="w-full border border-gray-300 rounded-md p-2" placeholder="Password"
                                            required>
                                    </div>
                                    <div class="flex-grow">
                                        <label for="password_confirmation" class="block mb-1 font-medium">Confirm
                                            Password</label>
                                        <input type="password" id="password_confirmation"
                                            class="w-full border border-gray-300 rounded-md p-2"
                                            placeholder="Confirm Password" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="btn place-content-end">
                            {{-- <button type="reset" class="text-red-700 px-4 py-2 rounded border border-red-700">Reset</button> --}}
                            <button type="submit" class="text-red-700 px-4 py-2 rounded border border-red-700">Save
                                User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <x-delete-confirmation itemname="Users" />
        <!-- Action Button -->
        <div class="mt-4 flex justify-between">
            <div class="pagination-btns mt-5">
                {{ $users->links() }}
            </div>
            <div class="user-crud-btn flex gap-5 items-center">
                <form action="/user" method="POST" id='userDeleteForm'>
                    @csrf
                    @method('DELETE')
                    <input type="text" id="user_ids" name="user_ids" value="" hidden>
                    <button id="deleteSelected" type="button" onclick="confirmDelete('userDeleteForm')" class="bg-purpolis text-white py-2 px-4 rounded hover:bg-purpolis/90">Delete Selected
                        Users</button>
                </form>
                <a href="/user/create" id="createUser" class="text-purpolis border border-purpolis py-2 px-4 rounded">Add
                    User</a>
            </div>


        </div>

        </div>
        @endcomponent
