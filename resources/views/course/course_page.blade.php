@component('layout')
    <section>
        <div class="course-thumbnail relative mb-10">
            <img src="{{$course->thumbnail_url}}" class="h-80 w-full" alt="">
            <div class="course-info w-full">
                <h1 class="text-4xl font-semibold">Lorem ipsum dolor sit
                    amet consectetur adipisicing elit.</h1>
                <h6 class="text-lg">Lorem ipsum dolor sit.</h6>
                <div class="ratings-box flex gap-4 items-center">
                    <x-ratings :rating="3.4"></x-ratings>
                    <p class="text-gray-300">(69 ratings)</p>
                    <div class="enrolled flex items-center  gap-2 bg-white text-black text-xs px-1 rounded-md">
                        <x-svgs.group w=20 h=20></x-svgs.group>
                        6.6K students enrolled
                    </div>
                </div>
                <div class="about-instructor pt-6">
                    <p>course by : <span class="underline font-semibold cursor-pointer">Sanathgoanwala</span></p>
                </div>
            </div>
        </div>
    </section>
    <hr class="mb-10">
    <section>
        <div class="modules flex gap-4 flex-wrap">
            @foreach ($course->modules->sortBy('title') as $module)
            <a href="/course/{{$course->id}}/module/{{$module->id}}" class="flex-grow">
                <div class="module p-1 rounded border border-gray-500">
                    @if ($module->file_url)
                        <img src="{{$course->thumbnail_url}}" class=" h-36 w-[240px]" alt="">
                    @else
                        <div class="info h-36 w-[240px] text-center place-content-center">
                            <h1>{{$module->title}}</h1>
                        </div>
                    @endif
                    <div class="btns flex gap-2 bg-blue-400">
                        <button class=" rounded flex-grow ">Start Learning</button>
                        <button class=" rounded  flex-grow">View Details</button>
                        
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>

@endcomponent