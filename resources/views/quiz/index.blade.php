@component('layout')
<x-header href="/quizs" />
@if (session('fail'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
    <strong class="font-bold">Error!</strong>
    <span class="block sm:inline">{{ session('fail') }}</span>
</div>

@endif
<form action="" method="get" id="quizFilterForm">

    <div class="flex justify-between items-center mb-4 mt-10">
        <div>
            <label for="courseSort" class="mr-2 font-medium">Sort by Course:</label>
            <select id="courseSort" name="quizFilterByCourse" class="border border-gray-300 rounded-md p-2" onchange="submitFiltering(false,'quiz')">
                @if ($courses->count() > 0)
                <option value="All">All</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{request('quizFilterByCourse') == $course->id ? 'selected' : ''}}>{{ $course->name }}</option>
                    @endforeach
                @else
                <option value="none" disabled>No Courses Are Associated</option>
                @endif

            </select>
        </div>
        <div>
            <label for="createdSort" class="mr-2 font-medium">Sort by Date:</label>
            <select id="createdSort" name="orderBy" onchange="submitFiltering(false,'quiz')"  class="border border-gray-300 rounded-md p-2">
                <option value="Newest" {{request('orderBy') == 'Newest' ? 'selected' : ''}}>Recent</option>
                <option value="Oldest" {{request('orderBy') == 'Oldest' ? 'selected' : ''}}>Old</option>
                <option value="Attempts">AttemptedBy</option>
            </select>
        </div>
    </div>
</form>
<!-- Custom Delete Confirmation Modal -->
<x-delete-confirmation itemname="Quiz" />



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
                        <td class="px-6 py-4">{{$quiz->attemptedquizzes->count()}}</td>
                        <td class="px-6 py-4">{{count($quiz->questions())}}</td>
                        <td class="px-6 py-4">{{($quiz->mcqs? 1 : 0) + ($quiz->onelines ? 1 : 0) + ($quiz->multians? 1 : 0)+($quiz->truefalse? 1: 0)}}</td>
                        <td class="px-6 py-4">{{App\Helper\Helper::formatDateTime($quiz->created_at)}}</td>
                        <td class="px-6 py-4">{{App\Helper\Helper::formatDateTime($quiz->updated_at)}}</td>

                        <td class="px-6 py-4 flex gap-4 text-purpolis">
                            <a href="/quiz/{{$quiz->id}}">
                                <x-svgs.visit></x-svgs.visit>
                            </a>
                            <a href="/quiz/edit/{{$quiz->id}}">
                                <x-svgs.edit></x-svgs.edit>
                            </a>
                            <form action="/quiz/{{$quiz->id}}" method="post" id="quizDeleteForm{{$quiz->id}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" ><x-svgs.delete /></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="btn mt-5 flex justify-between items-center">
        <a href="/quiz/create" class="border border-primary text-primary py-2 px-4 rounded-md">
            Create Quiz
        </a>
        <div class="paginate-btns">
            {{$quizzes->links()}}
        </div>
    </div>


@endcomponent
