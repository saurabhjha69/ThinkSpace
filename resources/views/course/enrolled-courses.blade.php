@component('layout')
<x-header href="/mycourses"/>


    <div class="table-rapper mt-10 bg-white border border-gray-300 rounded-xl shadow-lg">

        <table class="min-w-full table-auto ">
            <thead class="">
                <tr>
                    <th class="px-6 py-3 border-b font-semibold text-left">Name</th>
                    <th class="px-6 py-3 border-b font-semibold text-left">Lectures</th>
                    <th class="px-4 py-3 border-b font-semibold text-left">Progress</th>
                    <th class="px-4 py-3 border-b font-semibold text-center">Status</th>
                    <th class="px-4 py-3 border-b font-semibold text-left">Purchased At</th>
                    <th class="py-3 border-b font-semibold text-center"></th>

                </tr>
            </thead>
            <tbody id="userTable">
                @foreach ($courses as $course)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4"><x-course-card img_h=100px img_w=150px
                                img="{{$course->thumbnail_url}}"
                                title="{{$course->name}}"
                                des="Lorem ipsum dolor sit, amet consectetur adipisicing elit.">
                            </x-course-card></td>
                        <td class="px-4 py-4 text-center">{{$course->lectures('')}}</td>
                        <td class="px-4 py-4">{{$course->progress()}}%</td>
                        <td class="px-4 py-4">{{$course->pivot->status}}</td>
                        <td class="px-4 py-4 text-xs">{{App\Helper\Helper::formatDateTime($course->pivot->enrolled_at)}}</td>
                        <td class="px-2" colspan="2">
                            <a href="/course/watch/{{$course->id}}" class="bg-purpolis text-xs p-2 rounded-md text-white flex">Watch</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endcomponent
