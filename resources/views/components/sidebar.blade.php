
<div class="sidebar fixed flex flex-col left-0 top-0 h-[90%] w-64 bg-black rounded-lg my-8 m-2 text-secondary pl-2">
    <div class="logo">
        <h1 class="flex items-center gap-4 font-extrabold pt-4 pb-12">
            <x-svgs.book></x-svgs.book>
            Edu Sparking
        </h1> 
    </div>
    <div class="navs flex flex-col h-[85%] justify-between w-[110%] overflow-hidden">
        <nav class="list-none space-y-3">
            <a href="/dash"
                class="flex items-center gap-2  hover:rounded-l-full py-2 hover:bg-white hover:pl-2  hover:text-primary transition-all duration-200 ease-in">
                <x-svgs.dashboard></x-svgs.dashboard>
                Dashboard
            </a>
            <a href="/user"
                class="flex items-center gap-2 hover:rounded-l-full py-2 hover:bg-white hover:pl-2  hover:text-primary transition-all duration-200 ease-in">
                <x-svgs.group h=24 w=24></x-svgs.group>
                Users
            </a>
            <a href="/mycourses"
                class="flex items-center gap-2 hover:rounded-l-full py-2 hover:bg-white hover:pl-2  hover:text-primary transition-all duration-200 ease-in">
                <x-svgs.courses></x-svgs.courses>
                My Courses
            </a>
            <a href="/explore"
                class="flex items-center gap-2 hover:rounded-l-full py-2 hover:bg-white hover:pl-2  hover:text-primary transition-all duration-200 ease-in">
                <x-svgs.search></x-svgs.search>
                Explore
            </a>
            <a href="/leaderboard"
                class="flex items-center gap-2 hover:rounded-l-full py-2 hover:bg-white hover:pl-2  hover:text-primary transition-all duration-200 ease-in">
                <x-svgs.leaderboard></x-svgs.leaderboard>
                Leaderboard
            </a>
            <a href="/quizs"
                class="flex items-center gap-2 hover:rounded-l-full py-2 hover:bg-white hover:pl-2  hover:text-primary transition-all duration-200 ease-in">
                <x-svgs.quiz></x-svgs.quiz>
                Quizzes
            </a>
            
            <a href="/categories"
                class="flex items-center gap-2 hover:rounded-l-full py-2 hover:bg-white hover:pl-2  hover:text-primary transition-all duration-200 ease-in">
                <x-svgs.category ></x-svgs.category>
                Categories
            </a>
            <a href="/roles_permissions"
                class="flex items-center gap-2 hover:rounded-l-full py-2 hover:bg-white hover:pl-2  hover:text-primary transition-all duration-200 ease-in">
                <x-svgs.role ></x-svgs.role>
                Roles/Permissions
            </a>
        </nav>
        <nav class="list-none space-y-4 ">
            <a href="/profile"
                class="flex items-center gap-2 hover:rounded-l-full py-2 hover:bg-white hover:pl-2  hover:text-primary transition-all duration-200 ease-in">
                <x-svgs.profile></x-svgs.profile>
                Profile
            </a>
            <a href="/settings"
                class="flex items-center gap-2 hover:rounded-l-full py-2 hover:bg-white hover:pl-2  hover:text-primary transition-all duration-200 ease-in-out">
                <x-svgs.settings></x-svgs.settings>
                Settings
            </a>
            <button type="submit" form="logoutForm"
                class="flex w-full items-center gap-2 hover:rounded-l-full py-2 hover:bg-white hover:pl-2  hover:text-primary transition-all duration-200 ease-in-out">
                <x-svgs.signout></x-svgs.signout>
                Signout
            </button>
            <form action="/logout" method="post" id="logoutForm" hidden>
                @csrf
            </form>
        </nav>
    </div>

</div>
