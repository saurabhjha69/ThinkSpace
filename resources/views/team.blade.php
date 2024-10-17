@component('layout')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-6">Team Management</h2>

        <!-- Sorting Controls -->
        <div class="flex justify-between items-center mb-4">
            <form action="/user/sort" method="POST" id="sortingForm">
            @csrf
                <div>
                    <label for="roleSort" class="mr-2 font-medium">Sort by Role:</label>
                    <select id="roleSort" name="sortingOption" class="border border-gray-300 rounded-md p-2">
                        <option value="all">All</option>
                        <option value="learner">Learner</option>
                        <option value="instructor">Instructor</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </form>
            <div>
                <label for="statusSort" class="mr-2 font-medium">Sort by Status:</label>
                <select id="statusSort" class="border border-gray-300 rounded-md p-2">
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="suspended">Suspended</option>
                </select>
            </div>
        </div>

        <!-- User List Table -->
        <div class="relative">
            <div class="table-rapper overflow-x-auto bg-white border border-gray-300 rounded-md">
                @foreach ($errors->all() as $error)
                    <li class="text-red-500 text-2xl">{{ $error }}</li>
                @endforeach
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
                                <td class="px-6 py-4">{{$user->rolename}}</td>
                                <td class="px-6 py-4">Active</td>
                                <td class="px-6 py-4">2024-08-01</td>
                                <td class="px-6 py-4 flex gap-4">
                                    <a href="/user/{{$user->id}}">
                                        <x-svgs.visit></x-svgs.visit>
                                    </a>
                                    <a href="/user/edit/{{$user->id}}">
                                        <x-svgs.edit></x-svgs.edit>
                                    </a>
                                    <input type="checkbox" class="form-checkbox text-red-700" value="{{$user->user_id}}">
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

        <!-- Action Button -->
        <div class="mt-4 flex justify-between">
            <form action="/user" method="POST">
                @csrf
                @method('DELETE')
                <input type="text" id="user_ids" name="user_ids" value="" hidden>
                <button id="deleteSelected" class="bg-red-700 text-white py-2 px-4 rounded hover:bg-red-600">Delete Selected
                    Users</button>
            </form>
            <a href="/user/create" id="createUser" class="text-red-600 border border-red-600 py-2 px-4 rounded">Add
                User</a>

        </div>

        </div>

        <script>
            const sortingForm = document.getElementById('sortingForm');
            const roleSort = document.getElementById('roleSort');
            const statusSort = document.getElementById('statusSort');
            const user_ids = []
            const checkbox  = document.querySelectorAll('.form-checkbox')
            checkbox.forEach((elem)=> {
                elem.addEventListener('change', function() {
                    if(this.checked){
                        user_ids.push(this.value);
                    } else {
                        user_ids.splice(user_ids.indexOf(this.value), 1);
                    }
                    document.querySelector('#user_ids').value = user_ids;
                })
            })
            // roleSort.addEventListener('change',function(){
            //     sortingForm.submit();
            // });
        </script>
            {{-- <script>
                document.querySelector('.changepass').addEventListener('click', function() {
                    document.querySelector('.password-div').classList.toggle('hidden');
                    this.classList.toggle('hidden');
                })

                const users = [{
                        username: 'user1',
                        email: 'user1@example.com',
                        role: 'learner',
                        status: 'active',
                        createdAt: '2024-08-01'
                    },
                    {
                        username: 'user2',
                        email: 'user2@example.com',
                        role: 'instructor',
                        status: 'suspended',
                        createdAt: '2024-08-13'
                    },
                    {
                        username: 'user3',
                        email: 'user3@example.com',
                        role: 'admin',
                        status: 'active',
                        createdAt: '2022-08-01'
                    },
                    {
                        username: 'user4',
                        email: 'user4@example.com',
                        role: 'learner',
                        status: 'suspended',
                        createdAt: '2024-09-13'
                    }
                ];

                const userTable = document.getElementById('userTable');

                function displayUsers(userList) {
                    userTable.innerHTML = '';
                    userList.forEach((user, index) => {
                        const row = document.createElement('tr');
                        row.classList.add('border-b', 'hover:bg-gray-50');
                        row.innerHTML = `
            <td class="px-6 py-4">${user.username}</td>
            <td class="px-6 py-4">${user.email}</td>
            <td class="px-6 py-4">${user.role}</td>
            <td class="px-6 py-4">${user.status}</td>
            <td class="px-6 py-4">${user.createdAt}</td>
            <td class="px-6 py-4 flex gap-4">
                <a href="/user/id">
                                    <svg width="18px" height="18px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width=""></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M14 15.6569V10M14 10H8.34315M14 10L5.63604 18.364M10.2432 20.8278C13.0904 21.3917 16.1575 20.5704 18.364 18.364C21.8787 14.8492 21.8787 9.15076 18.364 5.63604C14.8492 2.12132 9.15076 2.12132 5.63604 5.63604C3.42957 7.84251 2.60828 10.9096 3.17216 13.7568" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                                    </svg>
                </a>
                <a href="user/id/edit">
                                    <svg  width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M18.9445 9.1875L14.9445 5.1875M18.9445 9.1875L13.946 14.1859C13.2873 14.8446 12.4878 15.3646 11.5699 15.5229C10.6431 15.6828 9.49294 15.736 8.94444 15.1875C8.39595 14.639 8.44915 13.4888 8.609 12.562C8.76731 11.6441 9.28735 10.8446 9.946 10.1859L14.9445 5.1875M18.9445 9.1875C18.9445 9.1875 21.9444 6.1875 19.9444 4.1875C17.9444 2.1875 14.9445 5.1875 14.9445 5.1875M20.5 12C20.5 18.5 18.5 20.5 12 20.5C5.5 20.5 3.5 18.5 3.5 12C3.5 5.5 5.5 3.5 12 3.5"
                                                stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                </a>
                <input type="checkbox" class="delete-checkbox" data-index="${index}">
            </td>
        `;
                        userTable.appendChild(row);
                    });
                }

                displayUsers(users);

                document.getElementById('roleSort').addEventListener('change', function() {
                    const selectedRole = this.value;
                    const filteredUsers = selectedRole === 'all' ? users : users.filter(user => user.role === selectedRole);
                    displayUsers(filteredUsers);
                });

                document.getElementById('statusSort').addEventListener('change', function() {
                    const selectedStatus = this.value;
                    const filteredUsers = selectedStatus === 'all' ? users : users.filter(user => user.status ===
                        selectedStatus);
                    displayUsers(filteredUsers);
                });

                document.getElementById('deleteSelected').addEventListener('click', function() {
                    const checkboxes = document.querySelectorAll('.delete-checkbox:checked');
                    checkboxes.forEach(checkbox => {
                        const index = parseInt(checkbox.getAttribute('data-index'));
                        users.splice(index, 1);
                    });
                    displayUsers(users);
                });
            </script> --}}
        @endcomponent
