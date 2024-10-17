@component('layout')
<div class="flex flex-col pb-5 px-40 mt-10 pt-4 bg-white items-center text-center rounded-lg shadow">

        <img src="https://plus.unsplash.com/premium_photo-1671656349322-41de944d259b?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8cG90cmFpdHxlbnwwfHwwfHx8MA%3D%3D" alt="Admin"
        class="rounded-full p-1 bg-primary-500 h-40 w-40 object-cover bg-purpolis">
    <div class="mt-3">
        <h4 class="text-lg font-semibold gap-4">{{ $user->fullname()==' ' ?  $user->username : $user->fullname()  }}
        </h4>
        <p class="roles">
            @foreach ($user->roles as $role)
                <span class="bg-purpolis text-white px-4 text-xs rounded-lg">{{$role->name}}</span>
            @endforeach
        </p>
        <p class="text-gray-500 mb-1">{{$user->userinfo?->education}}</p>
        <p class="text-gray-400 text-sm mb-5">{{$user->userinfo?->address}}</p>
        <a href="/user/edit/{{$user->id}}" class=" border border-purpolis text-purpolis py-1 px-3 rounded">Edit</a>
        <form action="/user/{{$user->id}}" id="suspendForm" method="POST" hidden>
            @csrf
            @method('PUT')
        </form>
        <button type="submit" form="suspendForm"  class=" border bg-purpolis text-white py-1 px-3 rounded" >{{$user->is_active ? 'Suspend' : 'Reactivate' }}</button>
    </div>

</div>
<div class="container flex flex-wrap gap-9 mx-auto py-8">
    <x-statsbox value="{{$user->courses->count()}}" topic="Enrolled Courses" class="w-64"></x-statsbox>
    <x-statsbox value="{{App\Helper\Helper::secondsToHoursMinutes($user->totalWatchHours())}}" topic="Total WatchHours" class="w-64"></x-statsbox>
    <x-statsbox value="{{$user->attemptedquizzes->count()}}" topic="Attmpted Quiz" class="w-64"></x-statsbox>
    <x-statsbox value="{{$user->comments->count()}}" topic="Total Comments" class="w-64"></x-statsbox>
</div>
<div class="table-rapper bg-white border border-gray-300 rounded-xl shadow-lg">
    <h1 class="p-4 text-center font-bold">Courses List</h1>
    <table class="min-w-full table-auto ">
        <thead class="">
            <tr>
                <th class="px-6 py-3 border-b font-semibold text-left">Name</th>
                <th class="px-6 py-3 border-b font-semibold text-left">Progress</th>
                <th class="px-6 py-3 border-b font-semibold text-left">Enrolled At</th>
                <th class="px-4 py-3 border-b font-semibold text-center">Status</th>
                <th class="px-4 py-3 border-b font-semibold text-center">Rate</th>
                <th class="px-6 py-3 border-b font-semibold text-center"></th>
            </tr>
        </thead>
        <tbody id="userTable">
            @if ($user->courses->count() == 0)
                <tr class="h-20 text-center">
                    <td colspan="8">No Data To Show Here</td>
                </tr>
            @else
            @foreach ($user->courses as $course)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4"><x-course-card img_h=100px img_w=150px
                            img="{{$course->thumbnail_url}}"
                            title="{{$course->name}}"
                            des="Lorem ipsum dolor sit, amet consectetur adipisicing elit.">
                        </x-course-card></td>
                    <td class="px-4 py-4 text-center">{{$course->userCompletedSubModules($user->id)}}%</td>
                    {{-- <td class="px-4 py-4 text-center">{{$course->lectures('f')>1 ? $course->queuedSubModules().' Queued' : $course->lectures('f')}}</td> --}}
                    <td class="px-4 py-4 text-sm">{{App\Helper\Helper::formatDateTime($course?->pivot->enrolled_at)}}</td>


                    <td class="px-4 py-4">{{$course->isUserCompletedCourse($user->id) ? 'Completed' : 'Enrolled'}}</td>
                    <td class="px-4 py-4">
                        @if ($course->averageRating())
                        <x-ratings rating="{{$course->averageRating()}}"></x-ratings>
                        @else
                        --
                        @endif
                    </td>
                    <td class="pl-3 pr-4 py-4 text-purpolis">
                        <div class="div flex gap-2">
                            <form action="/course/{{$course->id}}/user/{{$user->id}}/unenroll" method="POST" onsubmit="return confirm('Are you sure?');" >
                                @csrf
                                @method('PUT')
                                <input type="submit" class="cursor-pointer border border-purpolis rounded-lg p-2 text-sm" value="Un Enroll">
                            </form>
                        </div>

                    </td>
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
<div id="enrollingUserToCourse"  class="fixed inset-0 z-10 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white relative rounded-lg p-6 max-w-md w-full shadow-lg">
        <h2 class="text-lg font-bold mb-4">Enroll {{$user->username}} to a Course</h2>

        <form action="/course/user/{{$user->id}}/enroll" method="POST">
            @csrf
            <select name="course_id" id="" class="block p-2 rounded-lg w-full mb-4">
                @foreach ($existingcourses as $course)
                <option value="{{$course->id}}">{{$course->name}}</option>
                @endforeach
            </select>


            <!-- Submit Button -->
            <button id="submitReview" type="submit"
                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Add User To Course</button>
        </form>

        <!-- Close Button -->
        <button id="closeModal" onclick="closeAddingUserToCourseWindow()"
            class="absolute text-xl top-2 right-4 text-gray-400 hover:text-gray-600">&times;</button>
    </div>
</div>
<div class="btn text-end" >
    <button id="addUserToCourseBtn"  class="bg-purpolis text-white rounded-lg p-2 mt-3 shadow-sm" onclick="openAddingUserToCourseWindow()">Add a Course</button>
</div>
<div class="table-rapper mt-10 bg-white border border-gray-300 rounded-xl shadow-lg">
    <h1 class="p-4 text-center font-bold">Quizzes List</h1>
    <table class="min-w-full table-auto ">
        <thead class="">
            <tr>
                <th class="px-6 py-3 border-b font-semibold text-left">Name</th>
                <th class="px-6 py-3 border-b font-semibold text-left">Score</th>
                <th class="px-6 py-3 border-b font-semibold text-left">Attempted At</th>
                <th class="px-4 py-3 border-b font-semibold text-left">Score</th>
                <th class="px-4 py-3 border-b font-semibold text-left">Result</th>
                {{-- <th class="px-6 py-3 border-b font-semibold text-center"></th> --}}
            </tr>
        </thead>
        <tbody id="userTable">
            @if ($user->attemptedquizzes->count() == 0)
                <tr class="h-20 text-center">
                    <td colspan="8">No Data To Show Here</td>
                </tr>
            @else
            @foreach ($user->attemptedquizzes as $attemptedquiz)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{$attemptedquiz->title}}</td>
                    <td class="px-4 py-4 text-center">{{$attemptedquiz->pivot->marks ? $attemptedquiz->pivot->marks : '-' }}</td>

                    <td class="px-4 py-4">{{$attemptedquiz->parseDateTime($attemptedquiz->pivot->created_at)}}</td>


                    <td class="px-4 py-4">{{$attemptedquiz->scorePercentage($attemptedquiz->pivot->total_correct_ans,$attemptedquiz->pivot->total_attempted_ans)."%"}}</td>
                    <td class="px-4 py-4">{{$attemptedquiz->scorePercentage($attemptedquiz->pivot->total_correct_ans,$attemptedquiz->pivot->total_attempted_ans) > 35 ? 'Passed' : 'Failed'}}</td>

                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>

@endcomponent
