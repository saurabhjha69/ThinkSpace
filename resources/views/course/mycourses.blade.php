@component('layout')
<x-header href="/mycourses"/>


    <div class="table-rapper mt-10 bg-white border border-gray-300 rounded-xl shadow-lg">

        <table class="min-w-full table-auto ">
            <thead class="">
                <tr>
                    <th class="px-6 py-3 border-b font-semibold text-left">Name</th>
                    <th class="px-6 py-3 border-b font-semibold text-left">Lectures</th>
                    <th class="px-4 py-3 border-b font-semibold text-left">Category</th>
                    <th class="px-4 py-3 border-b font-semibold text-left">Price</th>
                    <th class="px-4 py-3 border-b font-semibold text-center">Status</th>
                    <th class="px-4 py-3 border-b font-semibold text-left">Last edited</th>
                    <th class="px-6 py-3 border-b font-semibold text-center"></th>
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
                        <td class="px-4 py-4 text-center">{{$course->lectures('f')==$course->queuedSubModules() ? $course->lectures('f') : $course->lectures('f').'/'.$course->queuedSubModules().' Uploaded'}}</td>
                        {{-- <td class="px-4 py-4 text-center">{{$course->lectures('f')>1 ? $course->queuedSubModules().' Queued' : $course->lectures('f')}}</td> --}}
                        <td class="px-4 py-4">{{$course->category->name}}</td>
                        <td class="px-4 py-4">{{$course->price}}</td>

                        <td class="px-4 py-4 ">
                            <span class="bg-purpolis py-1 px-4 rounded-full text-white text-xs">{{$course->approvalRequest?->status}}</span>
                        </td>

                        <td class="px-4 py-4">{{$course->updated_at}}</td>
                        <td class="pl-6 pr-4 py-4 text-purpolis">
                            <div class="div flex gap-2">
                                <a href="course/{{$course->id}}">
                                    <x-svgs.visit></x-svgs.visit>
                                </a>
                                <a href="course/edit/{{$course->id}}">
                                    <x-svgs.edit></x-svgs.edit>
                                </a>
                                <a href="course/report/{{$course->id}}">
                                    <x-svgs.report></x-svgs.report>
                                </a>
                                @if (Gate::allows('isAdmin'))
                                <a href="course/delete/{{$course->id}}">
                                    <x-svgs.delete></x-svgs.delete>
                                </a>
                                @endif
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

        <div class="coursec-crud flex justify-end mt-5">
            <x-button class="px-5 py-2 bg-purpolis shadow-sm" href="/course/create">Create</x-button>
        </div>
@endcomponent
