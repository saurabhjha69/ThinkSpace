@component('layout')
    <div class="flex justify-between items-center mb-4">
        <div>
            <label for="courseSort" class="mr-2 font-medium">Sort by Course:</label>
            <select id="courseSort" class="border border-gray-300 rounded-md p-2">
                <option value="all">All</option>
                <option value="learner">Web Dev</option>
                <option value="instructor">Java Mastery</option>
                <option value="admin">Python Basics</option>
            </select>
        </div>
        <div>
            <label for="createdSort" class="mr-2 font-medium">Sort by Date:</label>
            <select id="createdSort" class="border border-gray-300 rounded-md p-2">
                <option value="all">All</option>
                <option value="active">Recent</option>
                <option value="suspended">Old</option>
            </select>
        </div>
    </div>

    <div class="table-rapper overflow-x-auto bg-white border border-gray-300 rounded-md">

        <table class="min-w-full table-auto ">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b font-semibold text-left">Title</th>
                    <th class="px-6 py-3 border-b font-semibold text-left">Attempted By</th>
                    <th class="px-6 py-3 border-b font-semibold text-left">Total Questions</th>
                    <th class="px-6 py-3 border-b font-semibold text-left">Question Types</th>
                    <th class="px-6 py-3 border-b font-semibold text-left">Created At</th>
                    <th class="px-6 py-3 border-b font-semibold text-left">Last Updated</th>
                    <th class="px-6 py-3 border-b font-semibold text-center"></th>
                </tr>
            </thead>
            <tbody id="userTable">
                <!-- Example User Row -->
                @foreach ($quizzes as $quiz)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{$quiz->title}}</td>
                        <td class="px-6 py-4">--</td>
                        <td class="px-6 py-4">{{$quiz->mcqs->count()+$quiz->onelines->count()+$quiz->multians->count()+$quiz->truefalse->count()}}</td>
                        <td class="px-6 py-4">{{($quiz->mcqs? 1 : 0) + ($quiz->onelines ? 1 : 0) + ($quiz->multians? 1 : 0)+($quiz->truefalse? 1: 0)}}</td>
                        <td class="px-6 py-4">{{$quiz->created_at}}</td>
                        <td class="px-6 py-4">{{$quiz->updated_at}}</td>

                        <td class="px-6 py-4 flex gap-4">
                            <a href="/user/id">
                                <x-svgs.visit></x-svgs.visit>
                            </a>
                            <a href="/quiz/{{$quiz->id}}">
                                <x-svgs.edit></x-svgs.edit>
                            </a>
                            <input type="checkbox" class="form-checkbox text-red-700">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="btn mt-10">
        <a href="/quiz" class="border border-primary text-primary py-2 px-4 rounded-md">
            Create Quiz
        </a>
    </div>

    
@endcomponent