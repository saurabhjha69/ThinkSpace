<div class="sidebar bg-[#925fe2] flex flex-col rounded-2xl shadow px-20 justify-center fixed top-6 left-6 z-10 text-white pl-6">
    <div class="logo">
        <h1 class="flex justify-center items-center gap-4 font-extrabold pb-12 pt-5">
            <x-svgs.book></x-svgs.book>
            Thinkspace
        </h1>
    </div>
    <div class="navs flex flex-col gap-16 h-full  overflow-auto">
        <nav class="list-none space-y-3">
            @can('isLearner')
                <a href="/dash"
                    class="flex items-center gap-2   py-1 {{ request()->is('dash') ? 'text-white' : 'text-gray-300/70' }}  hover:text-white transition-all duration-200 ease-in">
                    <x-svgs.dashboard></x-svgs.dashboard>
                    Dashboard
                </a>
            @endcan
            @can('isInstructor')
                <a href="/instructor"
                    class="flex items-center gap-2   py-1 {{ request()->is('instructor') ? 'text-white' : 'text-gray-300/70' }}  hover:text-white transition-all duration-200 ease-in">
                    <x-svgs.dashboard></x-svgs.dashboard>
                    Dashboard
                </a>
            @endcan
            @can('isAdmin')
                <a href="/admin"
                    class="flex items-center gap-2   py-1 {{ request()->is('admin') ? 'text-white' : 'text-gray-300/70' }}  hover:text-white transition-all duration-200 ease-in">
                    <x-svgs.dashboard></x-svgs.dashboard>
                    Dashboard
                </a>
            @endcan
            @can('view_users')
                <a href="/user"
                    class="flex items-center gap-2   py-1  {{request()->is('user') ? 'text-white' : 'text-gray-300/70' }} hover:text-white transition-all duration-200 ease-in">
                    <x-svgs.group h=24 w=24></x-svgs.group>
                    Users
                </a>
            @endcan
            <a href="/mycourses"
                class="flex items-center gap-2 {{request()->is('mycourses') ? 'text-white' : 'text-gray-300/70' }}  py-1   hover:text-white transition-all duration-200 ease-in">
                <x-svgs.courses></x-svgs.courses>
                My Courses
            </a>
            @can('isLearner')

                <a href="/explore"
                    class="flex items-center gap-2 {{request()->is('explore') ? 'text-white' : 'text-gray-300/70' }}  py-1   hover:text-white transition-all duration-200 ease-in">
                    <x-svgs.search></x-svgs.search>
                    Explore
                </a>
            @endcan
            {{-- <a href="/leaderboard"
                class="flex items-center gap-2 {{request()->is('leaderboard') ? 'text-white' : 'text-gray-300/70' }}  py-1   hover:text-white transition-all duration-200 ease-in">
                <x-svgs.leaderboard></x-svgs.leaderboard>
                Leaderboard
            </a> --}}

            @can('view_quizzes')
                <a href="/quizs"
                    class="flex items-center gap-2 {{request()->is('quizs') ? 'text-white' : 'text-gray-300/70' }}  py-1    hover:text-white transition-all duration-200 ease-in">
                    <x-svgs.quiz></x-svgs.quiz>
                    Quizzes
                </a>
            @endcan
            @can('isAdmin')

            <a href="/categories"
                class="flex items-center gap-2 {{request()->is('categories') ? 'text-white' : 'text-gray-300/70' }}  py-1   hover:text-white transition-all duration-200 ease-in">
                <x-svgs.category ></x-svgs.category>
                Categories
            </a>
            @endcan
            {{-- <a href="/roles_permissions"
                class="flex items-center gap-2 {{request()->is('roles') ? 'text-white' : 'text-gray-300/70' }}  py-1  hover:text-white transition-all duration-200 ease-in">
                <x-svgs.role ></x-svgs.role>
                Roles/Permissions
            </a> --}}
            <a href="/profile"
                class="flex items-center gap-2 {{request()->is('profile') ? 'text-white' : 'text-gray-300/70' }} py-1    hover:text-white transition-all duration-200 ease-in">
                <x-svgs.profile></x-svgs.profile>
                Profile
            </a>
            @can('isAdmin')

                <a href="/settings"
                    class="flex items-center {{request()->is('settings') ? 'text-white' : 'text-gray-300/70' }} gap-2  py-1  hover:text-white transition-all duration-200 ease-in-out">
                    <x-svgs.settings></x-svgs.settings>
                    Settings
                </a>
            @endcan

        </nav>
        <nav class="pb-4">
            <button type="submit" form="logoutForm"
                class="flex w-full items-center {{request()->is('signout') ? 'text-white' : 'text-gray-300/70' }} gap-2  py-1  hover:text-white transition-all duration-200 ease-in-out">
                <x-svgs.signout></x-svgs.signout>
                Signout
            </button>
            <form action="/logout" method="post" id="logoutForm" hidden>
                @csrf
            </form>
        </nav>

    </div>

</div>
