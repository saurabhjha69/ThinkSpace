<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Course</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/coupon.js')
</head>

<body class="relative">
    <div class="main w-full bg-white text-black">

        <div class="course-info relative w-full h-80 bg-black px-52 flex items-center">
            <div class="banner text-white w-full space-y-2">
                <h1 class="text-4xl text-white font-semibold">{{ $course->name }}</h1>
                <h6 class="text-lg">{{ $course->description }}</h6>
                <div class="ratings-box flex gap-4 items-center">
                    @if ($course->averageRating() != null)
                        <x-ratings :rating="$course->averageRating()"></x-ratings>
                    @endif
                    <p class="text-gray-300">({{ $course->ratings->count() == 0 ? 'No Ratings Yet..' : $course->ratings->count() }})</p>
                    <div class="enrolled flex items-center gap-2 bg-white text-black text-xs px-1 rounded-md">
                        <x-svgs.group h=24 w=24></x-svgs.group>
                        {{ $course->users->count() }}{{ $course->users->count() > 1 ? ' students' : ' student' }}
                        enrolled
                    </div>
                </div>
                <div class="about-instructor pt-6">
                    <p>Course by : <span
                            class="underline font-semibold cursor-pointer">{{ Str::ucfirst($course->author->username) }}</span>
                    </p>
                </div>
            </div>

            <div
                class="course-card absolute z-10 top-16 right-[13%] h-[37rem] w-[28rem] rounded-xl bg-white overflow-hidden shadow-xl space-y-7">
                <div class="img w-full">
                    <img class="object-cover h-56 w-full" src="{{ $course->thumbnail_url }}" alt>
                </div>

                @if ($course->isApproved())
                    <div class="">
                        <div class="price-btn px-6 space-y-4">

                            @if(Gate::allows('isAdmin') || Auth::user()->isEnrolled($course->id) || Gate::allows('isCourseInstructor', $course->author->id))
                                @if (Carbon\Carbon::parse($course->start_date)->isPast())

                                    <div class="resume flex flex-col">
                                        <h1 class="text-2xl font-bold text-gray-900">Continue Learning</h1>
                                        <a href="/course/watch/{{ $course->id }}"
                                            class="bg-black text-white py-2 rounded-md text-center text-xl hover:translate-y-1 transition duration-200 ease-in">Resume
                                            Course</a>
                                    </div>
                                @else
                                <div class="resume flex flex-col">
                                    <h1 class="text-2xl font-bold text-gray-900">Starts In: <small>
                                        {{App\Helper\Helper::timeLeft($course->start_date)}}
                                    </small></h1>
                                    <button disabled
                                        class="bg-black/45 cursor-not-allowed text-white py-2 rounded-md text-center text-xl">Resume
                                        Course</button>
                                </div>
                                @endif

                            @else
                                @if ($course->modules->count() <= 0)
                                    <p class="text-red-500 bg-red-200 p-2 w-full">This Course is Empty</p>
                                @else
                                @if (!Carbon\Carbon::parse($course->start_date)->isPast())
                                <h1 class="text-2xl font-bold text-gray-900">Starts In: <small>
                                    {{App\Helper\Helper::timeLeft($course->start_date)}}
                                </small></h1>
                                @endif
                                <div>
                                    <span
                                        class=" rounded-full bg-yellow-400 px-2 text-center text-sm font-medium text-black">{{ $course->calcDiscount($course) }}%
                                        OFF</span>
                                    <h1 class="text-4xl flex gap-4 font-bold text-gray-900">${{ $course->price }}</h1>
                                </div>
                                <form action="/create-checkout-session/{{$coupon?->id}}" method="POST" class="flex">
                                    @csrf
                                    <input type="hidden" value="{{ $course->id }}" name="course_id">
                                    {{-- <input type="hidden" value="{{ $isCouponValid ? $coupon : 0 }}" name="discount"> --}}
                                    <button type="submit"
                                        class="bg-black w-full text-white py-2 rounded-md text-center text-xl hover:translate-y-1 transition duration-200 ease-in">Enroll
                                        Now</button>
                                </form>
                                <div class="coupon-div flex gap-5">
                                    <button class="border border-gray-600 px-2 py-1 rounded cursor-pointer" onclick="alertCouponWindow(this)">Apply coupon</button>
                                @if (request()->has('coupon'))

                                @if ($isCouponValid)
                                <span class="flex gap-2 border bg-green-50 border-green-500 text-green-700 px-2 py-1 w-fit rounded-md items-center" >
                                    {{request('coupon')}} applied
                                    <x-svgs.tickmark/>
                                </span>

                                @endif
                                </div>
                                @endif
                                @endif

                            @endif

                        </div>
                    </div>
                @else
                    @if ($course->isRejected())
                    <div class="bg-red-100 text-red-800 p-4 shadow-md flex items-center justify-between">
                        <div class="content">
                            <p class="text-lg font-semibold">Course Was Rejected <small>by {{$course->approvalRequest->approvedBy->username == Auth::user()->username ? 'you' : $course->approvalRequest->approvedBy->username}}</small></p>
                        <p class="text-sm">Reason: <b class="text-red-700">{{$course->approvalRequest->reason ?? 'no reason specified'}}</b></p>
                        </div>
                        @can('update', $course)
                        <a href="/course/edit/{{$course->id}}" class="bg-red-500 text-white text-xs rounded-md shadow-sm p-2 ">Edit Course</a>
                        @endcan
                    </div>
                    @else
                    <h1
                        class="text-2xl flex items-center justify-center gap-2 font-extrabold py-2 text-center text-red-500">
                        <x-svgs.approval/>
                        Waiting For Approval!
                    </h1>
                    @endif

                    @can('approve_courses')
                        <div class="btn flex justify-center">

                            <a href="/approve-course/{{ $course->id }}"
                                class="cursor-pointer text-white px-4 py-2 rounded-md bg-purpolis">Review</a>
                        </div>
                    @endcan


                @endif

                <div class="course-dets px-6 font-poppins">
                    @if (session()->has('flash_notification'))
                        <div class="alert alert-success">
                            {{ session('flash_notification.message') }}
                        </div>
                    @endif

                    <h1 class="text-2xl font-bold mb-2  ">What's In this
                        course?</h1>
                    <ol class="text-[#656565]">

                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                width="24px" fill="#4e4e4e">
                                <path
                                    d="M160-80q-33 0-56.5-23.5T80-160v-400q0-33 23.5-56.5T160-640h640q33 0 56.5 23.5T880-560v400q0 33-23.5 56.5T800-80H160Zm0-80h640v-400H160v400Zm240-40 240-160-240-160v320ZM160-680v-80h640v80H160Zm120-120v-80h400v80H280ZM160-160v-400 400Z" />
                            </svg>
                            {{ $course->lectures('video') }} video lectures
                        </li>

                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                width="24px" fill="#4e4e4e">
                                <path
                                    d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 27-3 53t-10 51q-14-16-32.5-27T794-418q3-15 4.5-30.5T800-480q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93q51 0 97.5-15t85.5-42q12 17 29.5 30t37.5 20q-51 41-114.5 64T480-80Zm290-160q-21 0-35.5-14.5T720-290q0-21 14.5-35.5T770-340q21 0 35.5 14.5T820-290q0 21-14.5 35.5T770-240Zm-158-52L440-464v-216h80v184l148 148-56 56Z" />
                            </svg>
                            {{ App\Helper\Helper::secondsToMinutes($course->totalCourseDuration()) }}{{ App\Helper\Helper::secondsToMinutes($course->totalCourseDuration()) > 60 ? ' hrs' : ' mins' }}
                            of content
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960"
                                width="24px" fill="#4e4e4e">
                                <path
                                    d="M480-432q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM263-48v-280q-43-37-69-99t-26-125q0-130 91-221t221-91q130 0 221 91t91 221q0 64-24 125.5t-72 99.43V-48L480-96 263-48Zm217-264q100 0 170-70t70-170q0-100-70-170t-170-70q-100 0-170 70t-70 170q0 100 70 170t170 70ZM335-138l145-32 144 32v-138q-33 18-69.5 27t-74.5 9q-38 0-75-8.5T335-276v138Zm145-70Z" />
                            </svg>
                            Certificate on completion
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>

    <div class="course-contents pt-10 w-full px-52 space-y-12">
        <div class="des w-3/5">
            <h1 class="text-3xl font-bold mb-2">About Course</h1>
            <p class="text-[19px]">{{ $course->about }}</p>
        </div>

        <div class="module-container w-3/5">
            <h1 class="text-3xl font-bold mb-5">Course Structure</h1>
            <p class="mb-5 text-sm font-semibold">{{ $course->lectures('l') }} lectures -
                {{ App\Helper\Helper::secondsToMinutes($course->totalCourseDuration()) }} min duration</p>
            @foreach ($course->modules->sortBy('order') as $key => $module)
                <div class="modules w-full border border-black/15">
                    <x-model title="{{ $module->title }}" :duration="App\Helper\Helper::secondsToMinutes($module->totalDuration())" target="module1">
                        <button onclick="toggleSubModule('.sub-modules{{ $key + 1 }}')">
                            <x-svgs.downarrow></x-svgs.downarrow>
                        </button>
                    </x-model>

                    <div class="sub-modules{{ $key + 1 }} w-full border-t-2 border-black/15 pt-6 pb-4 transition-all duration-150 ease-in-out {{ $module->order === 1 ? ' ' : 'hidden' }}"
                        id="module1">
                        @foreach ($module->submodules as $submodule)
                            <x-submodel title="{{ $submodule->title }}"
                                duration="{{ $submodule->videoduration() }}"></x-submodel>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>


        @if ($course->averageRating() > 0)

            <div class="avg-rating">
                <div class="flex items-center mb-2">
                    <x-ratings rating="{{$course->averageRating()}}"/>
                    <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">{{$course->averageRating() }}</p>
                    <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">out of</p>
                    <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">5</p>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">{{$course->ratings->count()}} user ratings</p>

                    @for ($i=5; $i > 0 ; $i--)
                        <div class="flex items-center">
                            <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline mb-1">{{$i}} star</a>
                            <div class="w-2/4 h-2 mx-4 bg-gray-200 rounded dark:bg-gray-700">
                                <div class="h-2 bg-yellow-300 rounded" style="width: {{$course->ratedStarAvg($i)}}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{$course->ratedStarAvg($i)}}%</span>
                        </div>

                    @endfor

            </div>
            <div class="flex flex-wrap gap-8 w-full" >
                @foreach ($ratings as $rating)

                    <x-userratingbox src="{{$rating->user?->userinfo?->profile_picture}}" username="{{$rating->user->username}}" rating="{{$rating->stars}}" day="4" comment="{{$rating->comment}}"/>
                @endforeach


            </div>
            <div class="showall">
                <a href="/course/{{$course->id}}/ratings" class="bg-purpolis text-white px-4 py-2 rounded-md">Show All</a>
            </div>
        @else
        <p class="pt-5 px-4 text-black ">No Ratings Yet</p>
        @endif






        <div class="instructor-dets w-3/5">
            <p class="text-2xl font-bold font-poppins mt-5" id="creator">Course
                Instructor</p>
            <div class="mt-4 flex items-center gap-4">
                <img src="{{$course->author->userinfo?->profile_picture}}"
                    alt="" class="w-36 h-40 object-cover rounded-md" />
                <div class="flex flex-col text-sm text-gray-800">
                    <a class="text-primary-800 text-lg font-bold underline"
                        href="/instructor-profile/{{$course->author->id}}">{{ Str::Ucfirst($course->author->username) }}</a>
                    <div class="text-gray-600 mt-1">{{$course->author->userinfo?->specialization}}</div>

                    <div class="instructor-dets space-y-1 mt-4">
                        <div class="flex items-center">
                            @include('components.svgs.star')
                            <span class="font-medium mr-1">{{$course->author->instructorRating()}}</span>
                            Instructor rating
                        </div>
                        <div class="flex items-center">
                            @include('components.svgs.badge')
                            <span class="font-medium mr-1">{{$course->author->totalRatings()}}</span>
                            Ratings
                        </div>
                        <div class="flex items-center">
                            @include('components.svgs.group2')
                            <span class="font-medium mr-1">{{$course->author->totalEnrolledStudents()}}</span>
                            Students
                        </div>
                        <div class="flex items-center">
                            @include('components.svgs.courses')
                            <span class="font-medium mr-1 pl-1">0{{ $course->author->createdCourses->count() }}</span>
                            Courses
                        </div>
                    </div>
                </div>
            </div>
            <p class="mt-4 leading-relaxed text-gray-800">
                {{$course->author?->userinfo?->bio}}
                <a class="ml-1 text-sm font-medium underline" href="/instructor-profile/{{$course->author->id}}">View profile</a>
            </p>
            <div class="social-icons flex justify-between mt-3 w-36">
                <x-svgs.facebook></x-svgs.facebook>


                <x-svgs.twitter></x-svgs.twitter>
                <x-svgs.linkedin></x-svgs.linkedin>
                <x-svgs.insta></x-svgs.insta>
            </div>

        </div>


    </div>
    <script>
        function toggleSubModule(selector) {
            const submodule = document.querySelector(selector);
            submodule.classList.toggle('hidden');
        }
    </script>

</body>

</html>
