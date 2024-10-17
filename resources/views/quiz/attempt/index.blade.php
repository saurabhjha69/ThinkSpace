@component('layout')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-6">Attempted Quiz</h2>

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
                            <th class="px-6 py-3 border-b font-semibold text-left">Title</th>
                            <th class="px-6 py-3 border-b font-semibold text-left">Status</th>
                            <th class="px-6 py-3 border-b font-semibold text-left">Marks</th>
                            <th class="px-6 py-3 border-b font-semibold text-left">Attempted_At</th>
                            <th class="px-6 py-3 border-b font-semibold text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="userTable">
                       @foreach ($quizzes as $quiz)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{$quiz->quiz->title}}</td>
                                <td class="px-6 py-4">{{$quiz->is_completed == 1 ? 'Passed' : 'Failed'}}</td>
                                <td class="px-6 py-4">{{$quiz->marks}}/{{$quiz->quiz->total_marks}}</td>
                                <td class="px-6 py-4">{{$quiz->created_at}}</td>
                                <td class="px-6 py-4 flex gap-4">
                                    <a href="/attempted/quiz">
                                        <x-svgs.visit></x-svgs.visit>
                                    </a>
                                    <a href="user/id/edit">
                                        <x-svgs.edit></x-svgs.edit>
                                    </a>
                                    <input type="checkbox" class="form-checkbox text-red-700">
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>

        </div>

        @endcomponent
