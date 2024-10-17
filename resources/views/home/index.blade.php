@component('layout')
    <header class=" p-4 flex items-center justify-between">
        <!-- Logo -->
        <div class="text-purpolis font-bold text-xl">
            LMS
        </div>

        <!-- Profile & Switch Role Dropdown -->
        <div class="relative inline-block text-left">

            <!-- Dropdown Menu -->
            <x-rolechangeform />
        </div>
    </header>

    <div class="courses-tabs py-6 flex justify-between flex-wrap  ">
        <div class="welcome-user flex w-full rounded-2xl bg-gradient-to-br from-[#925fe2] to-white from-40% shadow-md">
            <div class="welcome-txt w-2/3 flex flex-col justify-around pl-10">
                <p class="text-white/50 text-sm">September 22, 2024</p>
                <div class="txt">
                    <h2 class="text-white text-4xl font-bold">Welcome back, {{ $user->username }}</h2>
                    <p class="text-white/50">Always stay Updated on Your Dashboard</p>
                </div>
            </div>
            <div class="img w-1/3 flex justify-center">
                <img class="h-44 w-40" src="{{ asset('images/dashboardVector.png') }}" alt="">
            </div>
        </div>
    </div>
    <div class="main min-h-screen w-full flex justify-between py-2 ">

        <div class="left w-[66%] space-y-8 ">
            <div class="analytics flex flex-col gap-y-4">
                <h1 class="text-2xl text-black font-semibold">Quick Stats</h1>
                <div class="divs flex flex-wrap justify-between">
                    <x-statsbox value="{{ $user->courses->count() }}" topic="Enrolled Courses"></x-statsbox>
                    <x-statsbox value="{{ $user->attemptedquizzes()->count() }}" topic="Attemped Quiz"></x-statsbox>
                    <x-statsbox value="{{ App\Helper\Helper::secondsToHoursMinutes($user->totalWatchHours()) }}" topic="Watch Hours"></x-statsbox>
                </div>
            </div>
            <div class="analytics flex flex-col gap-y-4">
                <h1 class="text-2xl text-black font-semibold">Enrolled Courses</h1>
                <div class="divs space-y-4">
                    @if ($user->courses->count() > 0)
                        @foreach ($user->courses as $enrolledCourse)
                            <x-coursebox image="{{ $enrolledCourse->thumbnail_url }}"
                                progress="{{ $enrolledCourse->progress() }}" title="{{ $enrolledCourse->name }}"
                                course_id="{{ $enrolledCourse->id }}"></x-coursebox>
                        @endforeach

                        <div class="btn flex justify-end">
                            <button type="button"
                                class=" text-purpolis  hover:text-white border border-purpolis hover:bg-purpolis/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-5 py-2 text-center me-2 mb-2">View
                                All</button>
                        </div>
                    @else
                        <p class="text-black text-center pt-20">You Havent Enrolled In Any Course..</p>
                    @endif
                </div>
            </div>

        </div>
        <div class="right w-[30%] space-y-16">
            <div class="flex flex-col gap-y-4">
                @if ($user?->userinfo == null || $user->userinfo->profile_status == 'incomplete')
                    <div id="toast-interactive" class="w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow "
                        role="alert">
                        <div class="flex">
                            <div
                                class="inline-flex z-10 text-purpolis items-center justify-center flex-shrink-0 w-8 h-8   rounded-lg">
                                <svg fill="currentcolor" width="64px" height="64px" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M2,21H8a1,1,0,0,0,0-2H3.071A7.011,7.011,0,0,1,10,13a5.044,5.044,0,1,0-3.377-1.337A9.01,9.01,0,0,0,1,20,1,1,0,0,0,2,21ZM10,5A3,3,0,1,1,7,8,3,3,0,0,1,10,5ZM20.207,9.293a1,1,0,0,0-1.414,0l-6.25,6.25a1.011,1.011,0,0,0-.241.391l-1.25,3.75A1,1,0,0,0,12,21a1.014,1.014,0,0,0,.316-.051l3.75-1.25a1,1,0,0,0,.391-.242l6.25-6.25a1,1,0,0,0,0-1.414Zm-5,8.583-1.629.543.543-1.629L19.5,11.414,20.586,12.5Z">
                                        </path>
                                    </g>
                                </svg>
                                <span class="sr-only">Refresh icon</span>
                            </div>

                            <div class="ms-3 text-sm font-normal">
                                <div class="mb-2 text-sm font-normal">You havent Completed Your Profile.</div>
                                <div class="">
                                    <div>
                                        <a href="/profile/edit"
                                            class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-purpolis/90 rounded-lg hover:bg-purpolis focus:ring-4 focus:outline-none focus:ring-blue-300 ">Update</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <h1 class="text-2xl text-black font-semibold">Time line</h1>




                <section class="dark:bg-gray-100 dark:text-gray-800">
                    <div class="container max-w-5xl pl-2 mx-auto" bis_skin_checked="1">
                        <div class="grid gap-4 sm:grid-cols-12" bis_skin_checked="1">
                            <div class="relative col-span-12 px-4 space-y-6 " bis_skin_checked="1">
                                <div class="col-span-12 space-y-12 relative px-4  sm:space-y-8 sm:before:absolute sm:before:top-2 sm:before:bottom-0 sm:before:w-0.5 sm:before:-left-3 before:bg-purpolis/20"
                                    bis_skin_checked="1">

                                    <div class="flex flex-col sm:relative sm:before:absolute sm:before:top-2 sm:before:w-4 sm:before:h-4 sm:before:rounded-full sm:before:left-[-35px] sm:before:z-[1] before:dark:bg-violet-600"
                                        bis_skin_checked="1">
                                        <h3 class="text-sm font-semibold tracking-wide">@username:
                                            <span class="text-xs font-normal italic">Just Logged in</span>
                                            <time class="text-xs italic tracking-wide">4:00am</time>
                                        </h3>



                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endcomponent
