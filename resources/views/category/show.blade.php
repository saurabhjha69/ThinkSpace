@component('layout')
    <div class="container flex flex-wrap gap-20 mx-auto py-8">
        <x-statsbox value="{{$category->courses()->count()}}" topic="Total Courses"></x-statsbox>
        <x-statsbox value="{{$category->totalWatchHours()}}" topic="Total WatchHours"></x-statsbox>
        <x-statsbox value="{{$category->totalLearners()}}" topic="Total Leaners"></x-statsbox>
        <x-statsbox value="{{$category->totalInstructors()}}" topic="Total Instructors"></x-statsbox>
    </div>
    <div class="table-rapper mt-10 bg-white border border-gray-300 rounded-xl shadow-lg">
        <h1 class="p-4 text-center font-bold">Courses List</h1>
        <table class="min-w-full table-auto ">
            <thead class="">
                <tr>
                    <th class="px-6 py-3 border-b font-semibold text-left">Name</th>
                    <th class="px-6 py-3 border-b font-semibold text-left">Lectures</th>
                    <th class="px-6 py-3 border-b font-semibold text-left">Learners</th>
                    <th class="px-4 py-3 border-b font-semibold text-left">Creator</th>
                    <th class="px-4 py-3 border-b font-semibold text-center">Status</th>
                    <th class="px-4 py-3 border-b font-semibold text-left">Price</th>
                    <th class="px-4 py-3 border-b font-semibold text-left">Approval</th>
                    <th class="px-4 py-3 border-b font-semibold text-left">Last edited</th>
                    <th class="px-6 py-3 border-b font-semibold text-center"></th>
                </tr>
            </thead>
            <tbody id="userTable">
                @if ($category->courses->count() == 0)
                    <tr class="h-20 text-center">
                        <td colspan="8">No Data To Show Here</td>
                    </tr>
                @else
                @foreach ($category->courses as $course)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4"><x-course-card img_h=100px img_w=150px
                                img="{{$course->thumbnail_url}}"
                                title="{{$course->name}}"
                                des="Lorem ipsum dolor sit, amet consectetur adipisicing elit.">
                            </x-course-card></td>
                        <td class="px-4 py-4 text-center">{{$course->lectures('f')==$course->queuedSubModules() ? $course->lectures('f') : $course->lectures('f').'/'.$course->queuedSubModules().' Uploaded'}}</td>
                        {{-- <td class="px-4 py-4 text-center">{{$course->lectures('f')>1 ? $course->queuedSubModules().' Queued' : $course->lectures('f')}}</td> --}}
                        <td class="px-4 py-4">{{$course->users->count()}}</td>
                        <td class="px-4 py-4">{{$course->author->username}}</td>
                        <td class="px-4 py-4">{{$course->status}}</td>
                        <td class="px-4 py-4">{{$course->price}}</td>
                        
                        <td class="px-4 py-4 ">
                            <span class="bg-purpolis py-1 px-4 rounded-full text-white text-xs">{{Str::ucFirst($course->isApproved() ? 'approved' : 'pending')}}</span>
                        </td>
                        
                        <td class="px-4 py-4">{{$course->updated_at}}</td>
                        <td class="pl-6 pr-4 py-4 text-purpolis">
                            <div class="div flex gap-2">
                                <a href="/course/{{$course->id}}">
                                    <x-svgs.visit></x-svgs.visit>
                                </a>
                                <a href="/course/edit/{{$course->id}}">
                                    <x-svgs.edit></x-svgs.edit>
                                </a>
                                <a href="/course/id/delete">
                                    <x-svgs.delete></x-svgs.delete>
                                </a>
                            </div>
                            
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    
@endcomponent