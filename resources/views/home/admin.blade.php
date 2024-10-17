@component('layout')
<header class=" p-4 flex items-center justify-between">
    <!-- Logo -->
    <div class="text-purpolis font-bold text-xl">
        LMS
    </div>

    <!-- Profile & Switch Role Dropdown -->
    <div class="relative inline-block text-left">

        <!-- Dropdown Menu -->
        <form action="/switch-role" method="POST" id="switch-role-form">
        @csrf
            <select name="currentSignInRole" onchange="changeSessionRole(this)" id="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                @foreach ($user->roles as $role)
                <option  value="{{ $role->name }}" {{session()->get('user_role') === $role->name ? 'selected' : ' '}} > {{ $role->name }}</option>
                @endforeach
            </select>

        </form>
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
                    <x-statsbox value="{{ $courses->count() }}" topic="Courses"></x-statsbox>
                    <x-statsbox value="{{ $users->count() }}" topic="Active Users"></x-statsbox>
                    <x-statsbox value="${{ $revenue }}" topic="Revenue"></x-statsbox>
                </div>
            </div>
            
            <div class="analytics flex flex-col gap-y-4">
                <h1 class="text-2xl text-black font-semibold">New Courses to Approve</h1>
                <div class="divs space-y-4">
                    @if ($courses->count() > 0)
                        @foreach ($courses as $course)
                           @if ($course->approvalRequest?->status=='pending')
                           <x-coursebox title="{{$course->name}}" image="{{$course->thumbnail_url}}" :isadmin="true" course_id="{{$course->id}}"></x-coursebox>

                           @endif
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
        <div class="right w-[30%]">

            <div class="chart bg-white p-2 rounded-2xl mb-7 shadow-md">
                {!! $monthlyUsersChart->container() !!}
            </div>
            <div class="chart bg-white p-2 rounded-2xl shadow-md">
                {!! $monthlyCourseSalesChart->container() !!}
            </div>
        </div>
    </div>

    {!! $monthlyUsersChart->script() !!}
    {!! $monthlyCourseSalesChart->script() !!}

@endcomponent
